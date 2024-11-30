<?php
require_once '../includes/db_connection.php';

$idMateriaPrincipal = isset($_GET['idMateriaPrincipal']) ? $_GET['idMateriaPrincipal'] : null;

try {
    $query = "BEGIN PaquetePrerrequisitos.LeerPrerrequisitosDeMateria(:idMateriaPrincipal, :prerrequisitos); END;";
    $stmt = oci_parse($conn, $query);
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":idMateriaPrincipal", $idMateriaPrincipal);
    oci_bind_by_name($stmt, ":prerrequisitos", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prerrequisitos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h1>Prerrequisitos</h1>
        <a href="create.php" class="btn btn-primary">Agregar Prerrequisito</a>
        <table>
            <thead>
                <tr>
                    <th>ID Materia Principal</th>
                    <th>ID Materia Prerrequisito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = oci_fetch_assoc($cursor)) : ?>
                    <tr>
                        <td><?= $row['IDMATERIAPRINCIPAL'] ?></td>
                        <td><?= $row['IDMATERIAPRERREQUISITO'] ?></td>
                        <td>
                            <a href="delete.php?idMateriaPrincipal=<?= $row['IDMATERIAPRINCIPAL'] ?>&idMateriaPrerrequisito=<?= $row['IDMATERIAPRERREQUISITO'] ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
