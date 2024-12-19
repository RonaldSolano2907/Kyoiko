<?php
// Configuración de conexión a la base de datos (de valeoro.txt)
$usuario_db = 'USERLBD';  // Cambia esto por tu usuario
$clave_db = '123';        // Cambia esto por tu contraseña
$cadena_conexion = 'localhost/XE'; // Cambia si usas otra cadena de conexión
try {
    // Conexión a Oracle usando OCI8
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Verificar si se ha proporcionado el ID para eliminar
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "BEGIN PaqueteCongelamientos.EliminarCongelamiento(:id); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);

    // Ejecutar la eliminación
    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php?success=1');
        exit;
    } else {
        $error = oci_error($stmt);
        header('Location: index.php?error=1');
        exit;
    }
    oci_free_statement($stmt);
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Congelamiento</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; }
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav li { margin: 0 10px; position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        nav a:hover { color: #007bff; }
        .logout-button { background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px; }
        .logout-button:hover { background-color: #c82333; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Congelamientos</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li> <!-- Regresar al dashboard -->
            <li><a href="create.php">Crear</a></li> <!-- Crear nuevo congelamiento -->
            <li><a href="edit.php">Editar</a></li> <!-- Editar congelamiento -->
            <li><a href="delete.php">Borrar</a></li> <!-- Borrar congelamiento -->
            <li><a href="index.php">Listar</a></li> <!-- Listar congelamientos -->
            <li><button class="logout-button" onclick="window.location.href='../index.php'">Salir</button></li> <!-- Salir -->
        </ul>
    </nav>

    <!-- Mensaje -->
    <p style="text-align: center; margin-top: 50px;">Eliminando congelamiento...</p>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
