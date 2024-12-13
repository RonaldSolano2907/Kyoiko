<?php
require_once '../includes/db_connection.php';

try {
    $query = "BEGIN PaqueteMatricula.LeerMatriculasEstudiante(NULL, :matriculas); END;";
    $stmt = oci_parse($conn, $query);
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":matriculas", $cursor, -1, OCI_B_CURSOR);
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
    <title>Matrículas</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h1>Matrículas</h1>
        <a href="create.php" class="btn btn-primary">Nueva Matrícula</a>
        <table>
            <thead>
                <tr>
                    <th>Cédula Estudiante</th>
                    <th>ID Materia</th>
                    <th>Semestre</th>
                    <th>Año</th>
                    <th>Fecha Matrícula</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = oci_fetch_assoc($cursor)) : ?>
                    <tr>
                        <td><?= $row['CEDULAESTUDIANTE'] ?></td>
                        <td><?= $row['IDMATERIA'] ?></td>
                        <td><?= $row['SEMESTRE'] ?></td>
                        <td><?= $row['ANIO'] ?></td>
                        <td><?= $row['FECHAMATRICULA'] ?></td>
                        <td>
                            <a href="edit.php?cedula=<?= $row['CEDULAESTUDIANTE'] ?>&idMateria=<?= $row['IDMATERIA'] ?>&semestre=<?= $row['SEMESTRE'] ?>&anio=<?= $row['ANIO'] ?>" class="btn btn-warning">Editar</a>
                            <a href="delete.php?cedula=<?= $row['CEDULAESTUDIANTE'] ?>&idMateria=<?= $row['IDMATERIA'] ?>&semestre=<?= $row['SEMESTRE'] ?>&anio=<?= $row['ANIO'] ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
