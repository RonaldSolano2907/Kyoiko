<?php
include_once '../includes/db_connection.php';

// Obtener los datos de departamentos
$stmt = $conn->prepare("BEGIN PaqueteDepartamento.LeerDepartamento(NULL, :cursor); END;");
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
    <title>Departamentos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Gestión de Departamentos</h1>
        <a href="create.php" class="btn">Agregar Departamento</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Jefe</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['ID']; ?></td>
                        <td><?= $row['CEDULAJEFEDEPARTAMENTO']; ?></td>
                        <td><?= $row['NOMBRE']; ?></td>
                        <td><?= $row['DESCRIPCION']; ?></td>
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
