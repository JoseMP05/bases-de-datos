<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Búsqueda 2</h1>

<div>
    <h2 class="mt-5">INGRESAR</h2>
    <p>El código de una biblioteca.</p>
</div>
<div>
    <h2>OBTIENE</h2>
    <p>Se debe mostrar, para el lector de mayor puntuacion adscrito a esa biblioteca, todos los datos de todos los alquileres que ese lector devolvió (en caso de empates, usted decide cómo proceder).</p>
</div>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <!-- En esta caso, el Action va a esta mismo archivo -->
    <form action="busqueda2.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <select name="codigo" id="codigo" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                // Importar el código del otro archivo
                require("../biblioteca/biblioteca_select.php");
                
                if($resultadoBiblioteca):
                    foreach ($resultadoBiblioteca as $fila):
                ?>

                <!-- Opción que se genera -->
                <option value="<?= $fila["codigo"]; ?>">#<?= $fila["codigo"]; ?> <?= $fila["nombre"]; ?></option>

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

    $codigo = $_POST["codigo"];

    // Query SQL a la BD -> Crearla acá (No está completada, cambiarla a su contexto y a su analogía)
    $query = "SELECT alquiler.*
            FROM alquiler inner join (
                SELECT cedula, MAX(puntuacion) as mayor
                FROM lector INNER JOIN biblioteca
                ON cod_biblioteca = '$codigo'
            ) as maxLector
            ON alquiler.ced_lector_devuelve = cedula;";

    // Ejecutar la consulta
    $resultadoB2 = mysqli_query($conn, $query) or die(mysqli_error($conn));

    mysqli_close($conn);

    // Verificar si llegan datos
    if($resultadoB2 and $resultadoB2->num_rows > 0):
?>

<!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
<div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

    <table class="table table-striped table-bordered">

        <!-- Títulos de la tabla, cambiarlos -->
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Código</th>
                <th scope="col" class="text-center">Fecha de creación</th>
                <th scope="col" class="text-center">Precio</th>
                <th scope="col" class="text-center">Lector que solicita</th>
                <th scope="col" class="text-center">Lector que devuelve</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoB2 as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_alquiler"]; ?></td>
                <td class="text-center"><?= $fila["precio"]; ?> COP</td>
                <td class="text-center">C.C. <?= $fila["ced_lector_solicita"]; ?></td>
                <td class="text-center">C.C. <?= $fila["ced_lector_devuelve"]; ?></td>
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

    <div class="alert alert-danger text-center mt-5">
        <div>No se encontraron resultados para la busqueda:</div>
        <div>
            <span><strong>Código: </strong><?= $codigo ?></span>
        </div>
    </div>

<?php
    endif;
endif;

include "../includes/footer.php";
?>