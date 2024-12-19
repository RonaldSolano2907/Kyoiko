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

// Obtener parámetros
$cedula = $_GET['cedula'] ?? null;
$idMateria = $_GET['idMateria'] ?? null;
$semestre = $_GET['semestre'] ?? null;
$anio = $_GET['anio'] ?? null;

if (!$cedula || !$idMateria || !$semestre || !$anio) {
    header('Location: index.php');
    exit;
}

// Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoSemestre = $_POST['nuevoSemestre'];
    $nuevoAnio = $_POST['nuevoAnio'];

    $sql = "BEGIN PaqueteMatricula.ActualizarMatricula(:cedula, :idMateria, :semestre, :anio, :nuevoSemestre, :nuevoAnio); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":idMateria", $idMateria);
    oci_bind_by_name($stmt, ":semestre", $semestre);
    oci_bind_by_name($stmt, ":anio", $anio);
    oci_bind_by_name($stmt, ":nuevoSemestre", $nuevoSemestre);
    oci_bind_by_name($stmt, ":nuevoAnio", $nuevoAnio);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php?success=1');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al actualizar la matrícula: " . htmlentities($error['message']);
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
    <title>Editar Matrícula</title>
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
        <h1>Matrículas</h1>
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
        <h1>Editar Matrícula</h1>
        <form method="POST">
            <label for="nuevoSemestre">Nuevo Semestre:</label>
            <input type="number" name="nuevoSemestre" id="nuevoSemestre" required>

            <label for="nuevoAnio">Nuevo Año:</label>
            <input type="number" name="nuevoAnio" id="nuevoAnio" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
