<?php
 
// Crear conexión con la BD
require('../config/conexion.php');

// Sacar los datos del formulario. Cada input se identifica con su "name"
$codigo = $_POST["codigo"];
$fechaAlquiler = $_POST["fechaAlquiler"];
$precio = $_POST["precio"];
$lectorSolicita = $_POST["lectorSolicita"];
$lectorDevuelve = $_POST['lectorDevuelve'];

// Query SQL a la BD. Si tienen que hacer comprobaciones, hacerlas acá (Generar una query diferente para casos especiales)
if($lectorDevuelve === null):
	$query = "INSERT INTO `alquiler`(`codigo`,`fecha_alquiler`, `precio`, `ced_lector_solicita`, `ced_lector_devuelve`) VALUES ('$codigo', '$fechaAlquiler', '$precio', '$lectorSolicita', NULL)";
else:
	$query = "INSERT INTO `alquiler`(`codigo`,`fecha_alquiler`, `precio`, `ced_lector_solicita`, `ced_lector_devuelve`) VALUES ('$codigo', '$fechaAlquiler', '$precio', '$lectorSolicita', '$lectorDevuelve')";
endif;

// Ejecutar consulta
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

// Redirigir al usuario a la misma pagina
if($result):
    // Si fue exitosa, redirigirse de nuevo a la página de la entidad
	header("Location: alquiler.php");
else:
	echo "Ha ocurrido un error al crear el alquiler";
endif;

mysqli_close($conn);