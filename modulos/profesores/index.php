<?php
include '../includes/db_connection.php';

// Llamar al procedimiento almacenado con el cursor
$stmt = oci_parse($conn, "BEGIN ObtenerProfesoresCursor(:cursor); END;");
$cursor = oci_new_cursor($conn);

// Vincular el cursor
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

if (!oci_execute($stmt)) {
    $e = oci_error($stmt);
    die("Error al ejecutar el procedimiento: " . htmlentities($e['message']));
}

// Ejecutar el cursor
oci_execute($cursor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores</title>
    <style>
        /* Estilos base */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 5px;
        }

        .btn-create {
            background-color: #28a745;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestión de Profesores</h1>
        <a href="create.php" class="btn btn-create">Crear Profesor</a>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Departamento</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Título Académico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['CEDULA']) ?></td>
                        <td><?= htmlspecialchars($row['IDDEPARTAMENTO']) ?></td>
                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                        <td><?= htmlspecialchars($row['APELLIDOS']) ?></td>
                        <td><?= htmlspecialchars($row['TELEFONO']) ?></td>
                        <td><?= htmlspecialchars($row['CORREOELECTRONICO']) ?></td>
                        <td><?= htmlspecialchars($row['TITULOACADEMICO']) ?></td>
                        <td>
                            <a href="edit.php?cedula=<?= urlencode($row['CEDULA']) ?>" class="btn btn-edit">Editar</a>
                            <a href="delete.php?cedula=<?= urlencode($row['CEDULA']) ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro de eliminar este profesor?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
