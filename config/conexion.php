<?php
if (!defined('DB')) {
  define('DB', 'bibliotecas');
}

$host = "localhost";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, DB) or die("Error al conectar a la Base de datos" . mysqli_error($link));
