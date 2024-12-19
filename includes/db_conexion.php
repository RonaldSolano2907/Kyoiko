<?php
try {
    $usuario_db = 'USERLBD';          // Usuario de la base de datos
    $clave_db = '123';            // Contraseña de la base de datos
    $cadena_conexion = 'localhost/XE'; // Cadena de conexión (puedes ajustar según tu configuración)

    // Conexión a Oracle utilizando OCI8
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion, 'AL32UTF8');

    if (!$conn) {
        $e = oci_error();
        die("No se pudo conectar a la base de datos: " . $e['message']);
    }

    echo "Conexión exitosa a Oracle Database.";
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
