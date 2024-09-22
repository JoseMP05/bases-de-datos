<?php
    include "../includes/header.php";
?>

<!-- TÍTULO. Cambiarlo, pero dejar especificada la analogía -->
<h1 class="mt-3">Lector (Entidad análoga a CLIENTE/MECANICO)</h1>

<!-- FORMULARIO. Cambiar los campos de acuerdo a su trabajo -->
<div class="formulario p-4 m-3 border rounded-3">

    <form action="lector_insert.php" method="post" class="form-group">
        <div class="mb-3">
            <label for="cedula" class="form-label">Cédula</label>
            <input type="number" class="form-control" id="cedula" name="cedula" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="puntuacion" class="form-label">Puntuación</label>
            <input type="number" class="form-control" id="puntuacion" name="puntuacion" required>
        </div>
        <!-- Consultar la lista de BIBLIOTECAS y desplegarlas -->
        <div class="mb-3">
            <label for="biblioteca" class="form-label">Biblioteca</label>
            <select name="biblioteca" id="biblioteca" class="form-select">
                
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
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
    
</div>

<?php
// Importar el código del otro archivo
require("lector_select.php");

// Verificar si llegan datos
if($resultadoLector and $resultadoLector->num_rows > 0){
    ?>
    <!-- MOSTRAR LA TABLA. Cambiar las cabeceras -->
    <div class="tabla mt-5 mx-3 rounded-3 overflow-hidden">

        <table class="table table-striped table-bordered">

            <!-- Títulos de la tabla, cambiarlos -->
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">Cédula</th>
                    <th scope="col" class="text-center">Nombre</th>
                    <th scope="col" class="text-center">puntuacion</th>
                    <th scope="col" class="text-center">Biblioteca</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php
                // Iterar sobre los registros que llegaron
                foreach ($resultadoLector as $fila):
                ?>

                <!-- Fila que se generará -->
                <tr>
                    <!-- Cada una de las columnas, con su valor correspondiente -->
                    <td class="text-center"><?= $fila["cedula"]; ?></td>
                    <td class="text-center"><?= $fila["nombre"]; ?></td>
                    <td class="text-center"><?= $fila["puntuacion"]; ?></td>
                    <td class="text-center"><?= $fila["cod_biblioteca"]; ?></td>
                    
                    <!-- Botón de eliminar. Debe de incluir la CP de la entidad para identificarla -->
                    <td class="text-center">
                        <form action="lector_delete.php" method="post">
                            <input hidden type="text" name="cedulaEliminar" value="<?= $fila["cedula"]; ?>">
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
}

include "../includes/footer.php";
?>