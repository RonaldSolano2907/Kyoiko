<?php
include '../includes/db_connection.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedulaEstudiante = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];

    try {
        $sql = "BEGIN RegistrarCongelamiento(:cedulaEstudiante, :motivo, TO_DATE(:fechaInicio, 'YYYY-MM-DD'), TO_DATE(:fechaFin, 'YYYY-MM-DD')); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedulaEstudiante", $cedulaEstudiante);
        oci_bind_by_name($stmt, ":motivo", $motivo);
        oci_bind_by_name($stmt, ":fechaInicio", $fechaInicio);
        oci_bind_by_name($stmt, ":fechaFin", $fechaFin);

        oci_execute($stmt);
        $success = "Congelamiento registrado exitosamente.";
    } catch (Exception $e) {
        $error = "Error al registrar el congelamiento: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Congelamientos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Congelamientos</h1>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" action="registro_congelamientos.php">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" required>

            <label for="motivo">Motivo:</label>
            <textarea id="motivo" name="motivo" required></textarea>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <button type="submit" class="btn btn-create">Registrar</button>
        </form>
    </div>
</body>
</html>
