<?php
include '../includes/db_connection.php';

try {
    // Llamar al procedimiento para obtener todos los profesores
    $sql = "BEGIN OPEN :cursor FOR SELECT * FROM Profesor; END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar los datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores</title>
    <link rel="stylesheet" href="../assets/styles.css">
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
                        <td><?= $row['CEDULA'] ?></td>
                        <td><?= $row['IDDEPARTAMENTO'] ?></td>
                        <td><?= $row['NOMBRE'] ?></td>
                        <td><?= $row['APELLIDOS'] ?></td>
                        <td><?= $row['TELEFONO'] ?></td>
                        <td><?= $row['CORREOELECTRONICO'] ?></td>
                        <td><?= $row['TITULOACADEMICO'] ?></td>
                        <td>
                            <a href="edit.php?cedula=<?= $row['CEDULA'] ?>" class="btn btn-edit">Editar</a>
                            <a href="delete.php?cedula=<?= $row['CEDULA'] ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro de eliminar este profesor?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
