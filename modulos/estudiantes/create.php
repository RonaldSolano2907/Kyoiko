<?php
// Configuración de conexión a la base de datos (valeoro.txt)
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];

    $sql = "BEGIN PaqueteEstudiante.CrearEstudiante(:cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correo); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":apellidos", $apellidos);
    oci_bind_by_name($stmt, ":telefono", $telefono);
    oci_bind_by_name($stmt, ":fechaNacimiento", $fechaNacimiento);
    oci_bind_by_name($stmt, ":correo", $correo);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al crear el estudiante: " . htmlentities($error['message']);
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
    <title>Agregar Estudiante</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px; text-align: center; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 10px; }
        nav a:hover { color: #007bff; }
        h1 { text-align: center; margin-top: 20px; }
        .form-container { width: 50%; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, button { width: 100%; margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; font-weight: bold; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Estudiantes</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="edit.php">Editar</a></li>
            <li><a href="delete.php">Borrar</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Formulario -->
    <div class="form-container">
        <h1>Agregar Estudiante</h1>
        <form method="POST">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono">

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" id="correo">

            <button type="submit">Crear</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
