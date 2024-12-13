<?php

$usuario_db = 'admin';        
$clave_db = '12345';            
$cadena_conexion = 'localhost/XE'; 

$conn = oci_connect($usuario_db, $clave_db, $cadena_conexion, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    die("No se pudo conectar a la base de datos: " . $e['message']);
}
?>
