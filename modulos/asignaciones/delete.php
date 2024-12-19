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

// Verificar si se ha enviado el formulario GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['IDMateria'], $_GET['CedulaProfesor'], $_GET['Semestre'], $_GET['Anio'])) {
    $idMateria = $_GET['IDMateria'];
    $cedulaProfesor = $_GET['CedulaProfesor'];
    $semestre = $_GET['Semestre'];
    $anio = $_GET['Anio'];

    // Preparar el procedimiento para eliminar la asignación
    $query = "BEGIN PaqueteAsignacion.EliminarAsignacion(:p_IDMateria, :p_CedulaProfesor, :p_Semestre, :p_Anio); END;";
    $stmt = oci_parse($conn, $query);

    // Vincular los parámetros
    oci_bind_by_name($stmt, ':p_IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':p_CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':p_Semestre', $semestre);
    oci_bind_by_name($stmt, ':p_Anio', $anio);

    // Ejecutar la consulta
    if (oci_execute($stmt)) {
        $success = "Asignación eliminada correctamente.";
    } else {
        $e = oci_error($stmt);
        $error = "Error al eliminar la asignación: " . htmlentities($e['message']);
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
        .success { color: green; text-align: center; font-weight: bold; margin-top: 20px; }
        .error { color: red; text-align: center; font-weight: bold; margin-top: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background-color: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        button { background-color: #dc3545; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #c82333; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
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
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Mensajes -->
    <?php if ($success): ?>
        <div class="success"> <?= $success ?> </div>
    <?php elseif ($error): ?>
        <div class="error"> <?= $error ?> </div>
    <?php endif; ?>

    <!-- Contenido Principal -->
    <h1>Listado de Asignaciones</h1>
    <table>
        <tr>
            <th>ID Materia</th>
            <th>Cédula Profesor</th>
            <th>Semestre</th>
            <th>Año</th>
            <th>Acción</th>
        </tr>
        <tr>
            <td>MAT101</td>
            <td>12345678</td>
            <td>1</td>
            <td>2024</td>
            <td><a href="delete.php?IDMateria=MAT101&CedulaProfesor=12345678&Semestre=1&Anio=2024"><button>Eliminar</button></a></td>
        </tr>
        <tr>
            <td>MAT202</td>
            <td>87654321</td>
            <td>2</td>
            <td>2023</td>
            <td><a href="delete.php?IDMateria=MAT202&CedulaProfesor=87654321&Semestre=2&Anio=2023"><button>Eliminar</button></a></td>
        </tr>
        <tr>
            <td>MAT303</td>
            <td>12344321</td>
            <td>1</td>
            <td>2022</td>
            <td><a href="delete.php?IDMateria=MAT303&CedulaProfesor=12344321&Semestre=1&Anio=2022"><button>Eliminar</button></a></td>
        </tr>
    </table>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
