<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$biblioteca = $_POST["biblioteca"];
$cedula = $_POST["cedula"];
$nombre = $_POST["nombre"];
$puntuacion = $_POST["puntuacion"];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
$query = "INSERT INTO LECTOR (cedula, nombre, puntuacion, cod_biblioteca) VALUES ('$cedula', '$nombre', '$puntuacion', '$biblioteca')";

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: lector.php");
else:
	echo "Ha ocurrido un error al crear la persona";
endif;

mysqli_close($conn);