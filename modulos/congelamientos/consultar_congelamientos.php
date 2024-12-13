<?php
include '../includes/db_connection.php';

$cedulaEstudiante = $_GET['cedula_estudiante'] ?? '';
$congelamientos = [];

if ($cedulaEstudiante) {
    try {
        $sql = "BEGIN :cursor := ConsultarCongelamientos(:cedulaEstudiante); END;";
        $stmt = oci_parse($conn, $sql);
        $cursor = oci_new_cursor($conn);

        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":cedulaEstudiante", $cedulaEstudiante);

        oci_execute($stmt);
        oci_execute($cursor);

        while (($row = oci_fetch_assoc($cursor)) != false) {
            $congelamientos[] = $row;
        }
    } catch (Exception $e) {
        echo "Error al consultar congelamientos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Congelamientos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Consultar Congelamientos</h1>
        <form method="GET" action="consultar_congelamientos.php">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" value="<?= $cedulaEstudiante ?>" required>
            <button type="submit" class="btn btn-search">Buscar</button>
        </form>
        <?php if ($congelamientos): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($congelamientos as $congelamiento): ?>
                        <tr>
                            <td><?= $congelamiento['ID'] ?></td>
                            <td><?= $congelamiento['MOTIVO'] ?></td>
                            <td><?= $congelamiento['FECHAINICIO'] ?></td>
                            <td><?= $congelamiento['FECHAFIN'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron congelamientos para esta cédula.</p>
        <?php endif; ?>
    </div>
</body>
</html>
