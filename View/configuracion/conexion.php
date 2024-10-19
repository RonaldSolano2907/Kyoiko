<?php
$host = 'localhost';
$dbname = 'kyoikobd';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO usuarios (nombre_usuario, clave, rol) 
            VALUES ('admin', :clave, 'administrador')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':clave' => password_hash('123', PASSWORD_BCRYPT)
    ]);

} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
