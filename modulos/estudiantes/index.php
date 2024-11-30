<?php
include '../includes/db_connection.php';

try {
    $query = "BEGIN PaqueteEstudiante.LeerEstudiante(null, :cursor); END;";
    $stmt = oci_parse($conn, $query);

    // Cursor para la salida
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor); // Ejecutar el cursor

    $students = [];
    while (($row = oci_fetch_assoc($cursor)) != false) {
        $students[] = $row;
    }

    oci_free_statement($stmt);
    oci_free_statement($cursor);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="../assets/css/crud.css">
</head>
<body>
    <div class="content">
        <a href="create.php" class="btn btn-primary">Añadir Estudiante</a>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['CEDULA']; ?></td>
                    <td><?= $student['NOMBRE']; ?></td>
                    <td><?= $student['APELLIDOS']; ?></td>
                    <td><?= $student['TELEFONO']; ?></td>
                    <td><?= $student['CORREOELECTRONICO']; ?></td>
                    <td><?= $student['ESTADO']; ?></td>
                    <td>
                        <a href="edit.php?cedula=<?= $student['CEDULA']; ?>" class="btn btn-warning">Editar</a>
                        <a href="delete.php?cedula=<?= $student['CEDULA']; ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar este estudiante?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
