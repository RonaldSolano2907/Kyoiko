<?php
include_once '../includes/db_connection.php';

// Obtener las direcciones
$stmt = $conn->prepare("BEGIN PaqueteDireccion.LeerDireccion(NULL, :cursor); END;");
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direcciones</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Gestión de Direcciones</h1>
        <a href="create.php" class="btn">Agregar Dirección</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Estudiante</th>
                    <th>Provincia</th>
                    <th>Cantón</th>
                    <th>Distrito</th>
                    <th>Dirección Exacta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['ID']; ?></td>
                        <td><?= $row['CEDULAESTUDIANTE']; ?></td>
                        <td><?= $row['PROVINCIA']; ?></td>
                        <td><?= $row['CANTON']; ?></td>
                        <td><?= $row['DISTRITO']; ?></td>
                        <td><?= $row['DIRECCIONEXACTA']; ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['ID']; ?>" class="btn btn-edit">Editar</a>
                            <a href="delete.php?id=<?= $row['ID']; ?>" class="btn btn-delete">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
