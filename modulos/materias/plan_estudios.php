<?php
include '../includes/db_connection.php';

try {
    // Llamar al procedimiento que retorna el cursor con las materias del plan de estudios
    $sql = "BEGIN OPEN :cursor FOR SELECT * FROM VistaPlanEstudios; END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar el plan de estudios: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Estudios</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Plan de Estudios</h1>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Créditos</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false): ?>
                    <tr>
                        <td><?= $row['CODIGO'] ?></td>
                        <td><?= $row['NOMBREMATERIA'] ?></td>
                        <td><?= $row['DESCRIPCION'] ?></td>
                        <td><?= $row['CREDITOS'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="index.php" class="back-link">Volver</a>
    </div>
</body>
</html>

<?php
oci_free_statement($stmt);
oci_free_cursor($cursor);
oci_close($conn);
?>
