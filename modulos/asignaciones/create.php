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

$success = $error = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $IDMateria = $_POST['IDMateria'];
    $CedulaProfesor = $_POST['CedulaProfesor'];
    $Semestre = $_POST['Semestre'];
    $Anio = $_POST['Anio'];

    // Llamar al procedimiento para crear la asignación
    $sql = "BEGIN PaqueteAsignacion.CrearAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":IDMateria", $IDMateria);
    oci_bind_by_name($stmt, ":CedulaProfesor", $CedulaProfesor);
    oci_bind_by_name($stmt, ":Semestre", $Semestre);
    oci_bind_by_name($stmt, ":Anio", $Anio);

    if (oci_execute($stmt)) {
        $success = "Asignación creada correctamente.";
    } else {
        $error = "Error al crear la asignación.";
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
    <title>Asignaciones</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; }
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav li { margin: 0 10px; position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        nav a:hover { color: #007bff; }
        nav ul ul { display: none; position: absolute; top: 100%; left: 0; background-color: #000; padding: 10px; list-style: none; }
        nav li:hover ul { display: block; }
        h1 { text-align: center; margin-top: 20px; }
        .form-container { width: 50%; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, button { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .logout-button { width: auto; padding: 5px 15px; font-size: 1em; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .logout-button:hover { background-color: #c82333; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
        .success { color: green; text-align: center; font-weight: bold; }
        .error { color: red; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Asignaciones</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="edit.php">Editar</a></li>
            <li><a href="delete.php">Borrar</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button class="logout-button" onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Mensajes -->
    <?php if ($success): ?>
        <div class="success"> <?= $success ?> </div>
    <?php elseif ($error): ?>
        <div class="error"> <?= $error ?> </div>
    <?php endif; ?>

    <!-- Contenido Principal -->
    <h1>Crear Nueva Asignación</h1>
    <div class="form-container">
        <form action="" method="post">
            <label for="IDMateria">ID Materia:</label>
            <input type="text" name="IDMateria" id="IDMateria" required>

            <label for="CedulaProfesor">Cédula Profesor:</label>
            <input type="text" name="CedulaProfesor" id="CedulaProfesor" required>

            <label for="Semestre">Semestre:</label>
            <input type="number" name="Semestre" id="Semestre" required>

            <label for="Anio">Año:</label>
            <input type="number" name="Anio" id="Anio" required>

            <button type="submit">Crear</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
