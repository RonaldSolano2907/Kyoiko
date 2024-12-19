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

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $sql = "BEGIN PaqueteCongelamientos.CrearCongelamiento(:cedula, :motivo, TO_DATE(:fecha_inicio, 'YYYY-MM-DD'), TO_DATE(:fecha_fin, 'YYYY-MM-DD')); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":motivo", $motivo);
    oci_bind_by_name($stmt, ":fecha_inicio", $fecha_inicio);
    oci_bind_by_name($stmt, ":fecha_fin", $fecha_fin);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al crear el congelamiento: " . htmlentities($error['message']);
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
    <title>Congelamientos</title>
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
        h1 { text-align: center; margin-top: 20px; }
        .form-container { width: 50%; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, textarea, button { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        textarea { resize: none; }
        button { background-color: #007bff; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #0056b3; }
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

    <!-- Contenido Principal -->
    <div class="form-container">
        <form action="create.php" method="POST">
            <label for="cedula_estudiante">Cédula Estudiante</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" required>

            <label for="motivo">Motivo</label>
            <textarea id="motivo" name="motivo" required></textarea>

            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin">

            <button type="submit">Guardar</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
