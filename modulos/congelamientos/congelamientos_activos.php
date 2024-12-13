<?php
include '../includes/db_connection.php';

$congelamientosActivos = [];

try {
    $sql = "BEGIN :cursor := CongelamientosActivos(); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);

    while (($row = oci_fetch_assoc($cursor)) != false) {
        $congelamientosActivos[] = $row;
    }
} catch (Exception $e) {
    echo "Error al consultar congelamientos activos: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congelamientos Activos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Congelamientos Activos</h1>
        <?php if ($congelamientosActivos): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cédula del Estudiante</th>
                        <th>Estudiante</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($congelamientosActivos as $congelamiento): ?>
                        <tr>
                            <td><?= $congelamiento['ID'] ?></td>
                            <td><?= $congelamiento['CEDULA'] ?></td>
                            <td><?= $congelamiento['ESTUDIANTE'] ?></td>
                            <td><?= $congelamiento['MOTIVO'] ?></td>
                            <td><?= $congelamiento['FECHAINICIO'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay congelamientos activos en este momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>
