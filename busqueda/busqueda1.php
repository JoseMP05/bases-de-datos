<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 1</h1>

<h2 class="mt-5">INGRESAR</h2>
<p>
    La cédula de un lector y un rango de fechas (es decir, dos fechas f1 y f2
    (cada fecha con día, mes y año) y f2 >= f1).
</p>
<h2>OBTIENE</h2>
<p>
    Se debe mostrar el total recaudado por el lector a raíz de los alquileres que él devolvió junto con el nombre del lector.
</p>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda1.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="fecha1" class="form-label">Fecha 1</label>
            <input type="date" class="form-control" id="fecha1" name="fecha1" required>
        </div>

        <div class="mb-3">
            <label for="fecha2" class="form-label">Fecha 2</label>
            <input type="date" class="form-control" id="fecha2" name="fecha2" required>
        </div>

        <div class="mb-3">
            <label for="cedula" class="form-label">Cédula</label>
            <select name="cedula" id="cedula" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../lector/lector_select.php");
                
                if($resultadoLector):
                    foreach ($resultadoLector as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["cedula"]; ?>"><?= $fila["nombre"]; ?> - C.C. <?= $fila["cedula"]; ?></option>

                <?php
                        // Cerrar los estructuras de control
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Buscar</button>

    </form>
    
</div>

<?php
// Dado que el action apunta a este mismo archivo, hay que hacer eata verificación antes
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

    // Crear conexión con la BD
    require('../config/conexion.php');

    $fecha1 = $_POST["fecha1"];
    $fecha2 = $_POST["fecha2"];
    $cedula = $_POST["cedula"];

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    $query = "SELECT SUM(precio) as total_recaudado, nombre
          FROM lector INNER JOIN alquiler
          ON lector.cedula = alquiler.ced_lector_devuelve
          WHERE (lector.cedula = '$cedula') AND (fecha_alquiler BETWEEN '$fecha1' AND '$fecha2')
          GROUP BY lector.cedula;";

    // Ejecutar la consulta
    $resultadoB1 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB1 and $resultadoB1->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Total recaudado</th>
                <th scope="col" class="text-center">Cédula</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB1 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["total_recaudado"]; ?></td>
                <td class="text-center"><?= $fila["nombre"]; ?></td>
            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<!-- Mensaje de error si no hay resultados -->
<?php
else:
?>
    <?php
        if($fecha1 > $fecha2):
    ?>
        <div class="alert alert-danger text-center mt-5">
            <strong>La fecha 1 debe ser menor o igual a la fecha 2</strong>
        </div>
    <?php
        endif;
    ?>
    <div class="alert alert-danger text-center mt-5">
        <div>No se encontraron resultados para la busqueda:</div>
        <div>
            <span><strong>Fecha 1: </strong><?= $fecha1 ?>,</span>
            <span><strong>Fecha 2: </strong><?= $fecha2 ?>,</span>
            <span><strong>Cedúla: </strong><?= $cedula ?></span>
        </div>
    </div>

<?php
    endif;
endif;

include "../includes/footer.php";
?>