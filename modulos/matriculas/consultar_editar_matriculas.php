<?php
include '../includes/db_connection.php';

try {
    $sql = "BEGIN :cursor := ConsultarMatriculas(); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar las matrículas: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar y Editar Matrículas</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Matrículas</h1>
        <table>
            <thead>
                <tr>
                    <th>Cédula del Estudiante</th>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Año</th>
                    <th>Fecha Matrícula</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['CEDULAESTUDIANTE'] ?></td>
                        <td><?= $row['ESTUDIANTE'] ?></td>
                        <td><?= $row['MATERIA'] ?></td>
                        <td><?= $row['SEMESTRE'] ?></td>
                        <td><?= $row['ANIO'] ?></td>
                        <td><?= $row['FECHAMATRICULA'] ?></td>
                        <td>
                            <a href="edit.php?cedula=<?= $row['CEDULAESTUDIANTE'] ?>" class="btn btn-edit">Editar</a>
                            <a href="delete.php?cedula=<?= $row['CEDULAESTUDIANTE'] ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro de eliminar esta matrícula?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
