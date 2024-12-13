<?php
include '../includes/db_connection.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Inicializar variables
$error = "";
$estudiantes = [];

// Consultar estudiantes mediante el procedimiento
try {
    $stmt = oci_parse($conn, "BEGIN ConsultarEstudiantes(:cursor); END;");
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        throw new Exception("Error al consultar estudiantes: " . htmlentities($e['message']));
    }

    oci_execute($cursor); // Ejecutar el cursor para obtener los resultados
    while ($row = oci_fetch_assoc($cursor)) {
        $estudiantes[] = $row;
    }

    oci_free_statement($stmt);
    oci_free_cursor($cursor);
} catch (Exception $e) {
    $error = $e->getMessage();
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar y Editar Estudiantes</title>
    <style>
        /* CSS para la interfaz */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            text-align: center;
            background-color: #007BFF;
            color: white;
            padding: 15px 0;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #007BFF;
            color: white;
        }

        .button {
            padding: 8px 12px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-form {
            display: none;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .edit-form input, .edit-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Consultar y Editar Estudiantes</h1>

    <div class="container">
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <tr>
                            <td><?= htmlentities($estudiante['CEDULA']) ?></td>
                            <td><?= htmlentities($estudiante['NOMBRE']) ?></td>
                            <td><?= htmlentities($estudiante['CORREO']) ?></td>
                            <td><?= htmlentities($estudiante['TELEFONO']) ?></td>
                            <td><?= htmlentities($estudiante['ESTADO']) ?></td>
                            <td>
                                <button class="button" onclick="editarEstudiante('<?= $estudiante['CEDULA'] ?>', '<?= $estudiante['NOMBRE'] ?>', '<?= $estudiante['CORREO'] ?>', '<?= $estudiante['TELEFONO'] ?>', '<?= $estudiante['ESTADO'] ?>')">Editar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form id="edit-form" class="edit-form" method="post" action="actualizar_estudiante.php">
                <h3>Editar Estudiante</h3>
                <input type="hidden" name="cedula" id="edit-cedula">
                <label for="edit-nombre">Nombre</label>
                <input type="text" name="nombre" id="edit-nombre" required>
                <label for="edit-correo">Correo</label>
                <input type="email" name="correo" id="edit-correo" required>
                <label for="edit-telefono">Teléfono</label>
                <input type="text" name="telefono" id="edit-telefono" required>
                <label for="edit-estado">Estado</label>
                <select name="estado" id="edit-estado">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
                <button class="button" type="submit">Guardar Cambios</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function editarEstudiante(cedula, nombre, correo, telefono, estado) {
            document.getElementById('edit-cedula').value = cedula;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-correo').value = correo;
            document.getElementById('edit-telefono').value = telefono;
            document.getElementById('edit-estado').value = estado;

            document.getElementById('edit-form').style.display = 'block';
        }
    </script>
</body>
</html>
