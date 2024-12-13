<?php
// Conexión a la base de datos
include '../includes/db_connection.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Inicializar variables
$error = "";
$success = "";

// Manejar registro de estudiantes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
    $correoElectronico = $_POST['correo_electronico'] ?? '';

    if ($cedula && $nombre && $apellidos) {
        try {
            $stmt = oci_parse($conn, "INSERT INTO Estudiante (Cedula, Nombre, Apellidos, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado) VALUES (:cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correoElectronico, SYSDATE, 'activo')");
            oci_bind_by_name($stmt, ':cedula', $cedula);
            oci_bind_by_name($stmt, ':nombre', $nombre);
            oci_bind_by_name($stmt, ':apellidos', $apellidos);
            oci_bind_by_name($stmt, ':telefono', $telefono);
            oci_bind_by_name($stmt, ':fechaNacimiento', $fechaNacimiento);
            oci_bind_by_name($stmt, ':correoElectronico', $correoElectronico);

            if (oci_execute($stmt)) {
                $success = "Estudiante registrado exitosamente.";
            } else {
                $error = "Error al registrar al estudiante.";
            }

            oci_free_statement($stmt);
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, complete todos los campos obligatorios.";
    }
}

// Manejar eliminación de estudiantes
if (isset($_GET['eliminar'])) {
    $cedulaEliminar = $_GET['eliminar'];
    try {
        $stmt = oci_parse($conn, "DELETE FROM Estudiante WHERE Cedula = :cedula");
        oci_bind_by_name($stmt, ':cedula', $cedulaEliminar);
        if (oci_execute($stmt)) {
            $success = "Estudiante eliminado exitosamente.";
        } else {
            $error = "Error al eliminar al estudiante.";
        }
        oci_free_statement($stmt);
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Obtener lista de estudiantes
$estudiantes = [];
try {
    $stmt = oci_parse($conn, "SELECT * FROM Estudiante ORDER BY FechaInscripcion DESC");
    oci_execute($stmt);
    while ($row = oci_fetch_assoc($stmt)) {
        $estudiantes[] = $row;
    }
    oci_free_statement($stmt);
} catch (Exception $e) {
    $error = "Error al obtener la lista de estudiantes.";
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes</title>
    <style>
        /* ======= CSS GENERAL ======= */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: white;
            margin: 0;
            padding: 20px;
            background-color: #007BFF;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .action-buttons a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .action-buttons .btn-edit {
            background-color: #ffc107;
            color: white;
        }

        .action-buttons .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .action-buttons .btn-edit:hover {
            background-color: #e0a800;
        }

        .action-buttons .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h1>Registro de Estudiantes</h1>

<div class="container">
    <?php if ($error): ?>
        <div class="alert alert-error"> <?= $error ?> </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"> <?= $success ?> </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="cedula">Cédula</label>
            <input type="text" name="cedula" id="cedula" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono">
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
        </div>

        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico</label>
            <input type="email" name="correo_electronico" id="correo_electronico">
        </div>

        <div class="form-group">
            <button type="submit">Registrar Estudiante</button>
        </div>
    </form>

    <h2>Listado de Estudiantes</h2>
    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= $estudiante['CEDULA'] ?></td>
                    <td><?= $estudiante['NOMBRE'] ?></td>
                    <td><?= $estudiante['APELLIDOS'] ?></td>
                    <td><?= $estudiante['TELEFONO'] ?></td>
                    <td><?= $estudiante['CORREOELECTRONICO'] ?></td>
                    <td class="action-buttons">
                        <a href="editar_estudiante.php?cedula=<?= $estudiante['CEDULA'] ?>" class="btn-edit">Editar</a>
                        <a href="?eliminar=<?= $estudiante['CEDULA'] ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este estudiante?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
