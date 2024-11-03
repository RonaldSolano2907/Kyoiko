<?php

$host = "localhost";
$usuario = "admin";
$password = "12345";
$base_datos = "kyouiku"; // Nombre de base de datos


$conn = new mysqli($host, $usuario, $password, $base_datos);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
