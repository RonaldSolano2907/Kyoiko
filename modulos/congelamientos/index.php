<?php
include_once '../includes/db_connection.php';

// Obtener los datos de congelamientos
$stmt = $conn->prepare("BEGIN PaqueteCongelamientos.LeerCongelamiento(NULL, :cursor); END;");
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
    <title>Congelamientos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Gestión de Congelamientos</h1>
        <a href="create.php" class="btn">Agregar Congelamiento</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Estudiante</th>
                    <th>Motivo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['ID']; ?></td>
                        <td><?= $row['CEDULAESTUDIANTE']; ?></td>
                        <td><?= $row['MOTIVO']; ?></td>
                        <td><?= $row['FECHAINICIO']; ?></td>
                        <td><?= $row['FECHAFIN']; ?></td>
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
