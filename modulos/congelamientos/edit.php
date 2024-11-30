<?php
include_once '../includes/db_connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $stmt = $conn->prepare("BEGIN PaqueteCongelamientos.ActualizarCongelamiento(:id, :cedula, :motivo, TO_DATE(:fecha_inicio, 'YYYY-MM-DD'), TO_DATE(:fecha_fin, 'YYYY-MM-DD')); END;");
    oci_bind_by_name($stmt, ":id", $id);
    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":motivo", $motivo);
    oci_bind_by_name($stmt, ":fecha_inicio", $fecha_inicio);
    oci_bind_by_name($stmt, ":fecha_fin", $fecha_fin);
    oci_execute($stmt);
    oci_commit($conn);

    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("BEGIN PaqueteCongelamientos.LeerCongelamiento(:id, :cursor); END;");
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
$data = oci_fetch_assoc($cursor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Congelamiento</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Editar Congelamiento</h1>
        <form action="edit.php?id=<?= $id ?>" method="POST">
            <label for="cedula_estudiante">Cédula Estudiante</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" value="<?= $data['CEDULAESTUDIANTE'] ?>" required>

            <label for="motivo">Motivo</label>
            <textarea id="motivo" name="motivo" required><?= $data['MOTIVO'] ?></textarea>

            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= $data['FECHAINICIO'] ?>" required>

            <label for="fecha_fin">Fecha Fin</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?= $data['FECHAFIN'] ?>">

            <button type="submit" class="btn">Actualizar</button>
        </form>
    </main>
</body>
</html>