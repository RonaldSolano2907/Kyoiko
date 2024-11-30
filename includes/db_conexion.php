<?php
try {
    $host = "localhost";
    $port = "1521";
    $service_name = "orcl";
    $username = "tu_usuario";
    $password = "tu_contraseña";

    $tns = "(DESCRIPTION =
              (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
              (CONNECT_DATA =
                (SERVICE_NAME = $service_name)
              )
            )";

    $pdo = new PDO("oci:dbname=$tns;charset=UTF8", $username, $password);
    echo "Conexión exitosa a Oracle Database.";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
