<?php
// Datos de conexión
$host = "localhost";
$port = "1521";
$sid = "orcl";
$username = "USERLBD"; 
$password = "123"; 

try {
    // Crear la conexión
    $dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))";
    $pdo = new PDO($dsn, $username, $password);

    // Configurar opciones PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "¡Conexión exitosa a la base de datos Oracle!";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
