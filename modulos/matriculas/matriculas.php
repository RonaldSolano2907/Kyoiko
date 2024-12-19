<?php
// Configuración de conexión a la base de datos
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

// Acción de eliminar
if (isset($_GET['eliminar'])) {
    $cedula = $_GET['cedula'];
    $idMateria = $_GET['idMateria'];
    $semestre = $_GET['semestre'];
    $anio = $_GET['anio'];

    // Procedimiento almacenado para eliminar
    $sql = "BEGIN PaqueteMatricula.EliminarMatricula(:cedula, :idMateria, :semestre, :anio); END;"; // <--- Aquí se invoca el procedimiento almacenado "EliminarMatricula"
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":idMateria", $idMateria);
    oci_bind_by_name($stmt, ":semestre", $semestre);
    oci_bind_by_name($stmt, ":anio", $anio);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        $success = "Matrícula eliminada exitosamente.";
    } else {
        $error = oci_error($stmt);
        $error_message = htmlentities($error['message']);
    }
    oci_free_statement($stmt);
}

// Acción de editar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $cedula = $_POST['cedula'];
    $idMateria = $_POST['idMateria'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];
    $nuevoSemestre = $_POST['nuevoSemestre'];
    $nuevoAnio = $_POST['nuevoAnio'];

    // Procedimiento almacenado para editar
    $sql = "BEGIN PaqueteMatricula.ActualizarMatricula(:cedula, :idMateria, :semestre, :anio, :nuevoSemestre, :nuevoAnio); END;"; // <--- Aquí se invoca el procedimiento almacenado "ActualizarMatricula"
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":idMateria", $idMateria);
    oci_bind_by_name($stmt, ":semestre", $semestre);
    oci_bind_by_name($stmt, ":anio", $anio);
    oci_bind_by_name($stmt, ":nuevoSemestre", $nuevoSemestre);
    oci_bind_by_name($stmt, ":nuevoAnio", $nuevoAnio);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        $success = "Matrícula actualizada exitosamente.";
    } else {
        $error = oci_error($stmt);
        $error_message = htmlentities($error['message']);
    }
    oci_free_statement($stmt);
}

// Obtener las matrículas
$sql = "BEGIN PaqueteMatricula.LeerMatriculasEstudiante(NULL, :cursor); END;"; // <--- Aquí se invoca el procedimiento almacenado "LeerMatriculasEstudiante"
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Matrículas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #000;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav li {
            margin: 0 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #007bff;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Matrículas</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Matrículas</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Mensajes de éxito o error -->
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>

        <!-- Listado de matrículas -->
        <h2>Lista de Matrículas</h2>
        <table>
            <thead>
                <tr>
                    <th>Cédula Estudiante</th>
                    <th>ID Materia</th>
                    <th>Semestre</th>
                    <th>Año</th>
                    <th>Fecha Matrícula</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['CEDULAESTUDIANTE']); ?></td>
                        <td><?= htmlspecialchars($row['IDMATERIA']); ?></td>
                        <td><?= htmlspecialchars($row['SEMESTRE']); ?></td>
                        <td><?= htmlspecialchars($row['ANIO']); ?></td>
                        <td><?= htmlspecialchars($row['FECHAMATRICULA']); ?></td>
                        <td class="actions">
                            <a href="?cedula=<?= urlencode($row['CEDULAESTUDIANTE']); ?>&idMateria=<?= urlencode($row['IDMATERIA']); ?>&semestre=<?= urlencode($row['SEMESTRE']); ?>&anio=<?= urlencode($row['ANIO']); ?>&editar=1">Editar</a>
                            <a href="?cedula=<?= urlencode($row['CEDULAESTUDIANTE']); ?>&idMateria=<?= urlencode($row['IDMATERIA']); ?>&semestre=<?= urlencode($row['SEMESTRE']); ?>&anio=<?= urlencode($row['ANIO']); ?>&eliminar=1" style="color: red;">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
