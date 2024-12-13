<?php
include '../includes/db_connection.php';

try {
    // Llamar al procedimiento almacenado para obtener asignaciones
    $sql = "BEGIN ObtenerAsignacionesProfesores(:cursor); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar las asignaciones: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones de Profesores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .btn-create {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-create:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            color: white;
            font-size: 0.9em;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Asignaciones de Profesores</h1>
    <a href="create_assignment.php" class="btn-create">Agregar Asignación</a>
    <table>
        <thead>
            <tr>
                <th>Nombre del Profesor</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Año</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false): ?>
                <tr>
                    <td><?= $row['NOMBREPROFESOR'] ?></td>
                    <td><?= $row['NOMBREMATERIA'] ?></td>
                    <td><?= $row['SEMESTRE'] ?></td>
                    <td><?= $row['ANIO'] ?></td>
                    <td>
                        <a href="edit_assignment.php?id_materia=<?= $row['IDMATERIA'] ?>&cedula=<?= $row['CEDULAPROFESOR'] ?>" class="btn btn-edit">Editar</a>
                        <a href="delete_assignment.php?id_materia=<?= $row['IDMATERIA'] ?>&cedula=<?= $row['CEDULAPROFESOR'] ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro de eliminar esta asignación?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
