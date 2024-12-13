<?php
include '../includes/db_connection.php';

try {
    $sql = "BEGIN :cursor := ReporteMatriculas(); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al generar el reporte de matrículas: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Matrículas</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Reporte de Matrículas</h1>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Número de Estudiantes</th>
                    <th>Semestre</th>
                    <th>Año</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['MATERIA'] ?></td>
                        <td><?= $row['ESTUDIANTES'] ?></td>
                        <td><?= $row['SEMESTRE'] ?></td>
                        <td><?= $row['ANIO'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
