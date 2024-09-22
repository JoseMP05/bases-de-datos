<?php

// Crear conexión con la BD
require('../config/conexion.php');

// Query SQL a la BD
$query = "SELECT codigo, DATE_FORMAT(fecha_alquiler, '%d %m %Y') as fecha_alquiler, precio, ced_lector_solicita, ced_lector_devuelve  FROM alquiler";

// Ejecutar la consulta
$resultadoAlquiler = mysqli_query($conn, $query) or die(mysqli_error($conn));

mysqli_close($conn);