<?php
include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Alquiler (Entidad análoga a PROYECTO/REVISION)</h1>
<?php
 $test = 'hola'
?>
<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="alquiler_insert.php" method="post" class="form-group">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="number" class="form-control" id="codigo" name="codigo" required>
        </div>

        <div class="mb-3">
            <label for="fechaAlquiler" class="form-label">Fecha del alquiler</label>
            <input type="date" class="form-control" id="fechaAlquiler" name="fechaAlquiler" required>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" required>
        </div>
        
        <!-- Consultar la lista de lectores y desplegarlos -->
        <?php
        require("../lector/lector_select.php");
        ?>
        <div class="mb-3">
            <label for="lectorSolicita" class="form-label">Lector que solicita</label>
            <select name="lectorSolicita" id="lectorSolicita" class="form-select">
                
                <!-- Option por defecto -->
                <option value="" selected disabled hidden></option>

                <?php
                if($resultadoLector):
                    foreach ($resultadoLector as $fila):
                ?>
                <!-- Opción que se genera -->
                <option value="<?= $fila["cedula"]; ?>"><?= $fila["nombre"]; ?> - C.C. <?= $fila["cedula"]; ?></option>

                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="lectorDevuelve" class="form-label">Lector que devuelve</label>
            <select name="lectorDevuelve" id="lectorDevuelve" class="form-select">
                
                <!-- Option por defecto -->
                <option value=""   selected disabled hidden></option>
                
                <?php
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
        <button type="submit" class="btn btn-primary">Agregar</button>

    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("alquiler_select.php");
            
// Verificar si llegan datos
if($resultadoAlquiler and $resultadoAlquiler->num_rows > 0):
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
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php
            // Iterar sobre los registros que llegaron
            foreach ($resultadoAlquiler as $fila):
            ?>

            <!-- Fila que se generará -->
            <tr>
                <!-- Cada una de las columnas, con su valor correspondiente -->
                <td class="text-center"><?= $fila["codigo"]; ?></td>
                <td class="text-center"><?= $fila["fecha_alquiler"]; ?></td>
                <td class="text-center"><?= $fila["precio"]; ?> COP</td>
                <td class="text-center">C.C. <?= $fila["ced_lector_solicita"]; ?></td>
                <td class="text-center">
                    <?php if (!is_null($fila["ced_lector_devuelve"])):?>
                        C.C. <?= $fila["ced_lector_devuelve"]; ?>
                    <?php else: ?>
                        No aplica
                    <?php endif; ?>
                </td>
                
                <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                <td class="text-center">
                    <form action="alquiler_delete.php" method="post">
                        <input hidden type="text" name="codigoEliminar" value="<?= $fila["codigo"]; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>

            </tr>

            <?php
            // Cerrar los estructuras de control
            endforeach;
            ?>

        </tbody>

    </table>
</div>

<?php
endif;

include "../includes/footer.php";
?>