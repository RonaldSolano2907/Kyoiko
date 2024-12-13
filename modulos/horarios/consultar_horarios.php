<?php
include '../includes/db_connection.php';

try {
    $sql = "BEGIN :cursor := ConsultarHorarios(); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar los horarios: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Horarios</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Horarios Disponibles</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Materia</th>
                    <th>Aula</th>
                    <th>Horario Inicio</th>
                    <th>Horario Fin</th>
                    <th>Día de la Semana</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= $row['ID'] ?></td>
                        <td><?= $row['MATERIA'] ?></td>
                        <td><?= $row['AULA'] ?></td>
                        <td><?= $row['HORARIOINICIO'] ?></td>
                        <td><?= $row['HORARIOFIN'] ?></td>
                        <td><?= $row['DIASEMANA'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
