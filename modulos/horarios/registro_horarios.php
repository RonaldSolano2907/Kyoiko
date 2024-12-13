<?php
include '../includes/db_connection.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMateria = $_POST['id_materia'];
    $aula = $_POST['aula'];
    $horarioInicio = $_POST['horario_inicio'];
    $horarioFin = $_POST['horario_fin'];
    $diaSemana = $_POST['dia_semana'];

    try {
        $sql = "BEGIN RegistrarHorario(:idMateria, :aula, :horarioInicio, :horarioFin, :diaSemana); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":idMateria", $idMateria);
        oci_bind_by_name($stmt, ":aula", $aula);
        oci_bind_by_name($stmt, ":horarioInicio", $horarioInicio);
        oci_bind_by_name($stmt, ":horarioFin", $horarioFin);
        oci_bind_by_name($stmt, ":diaSemana", $diaSemana);

        oci_execute($stmt);
        $success = "Horario registrado exitosamente.";
    } catch (Exception $e) {
        $error = "Error al registrar el horario: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Horarios</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Horarios</h1>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" action="registro_horarios.php">
            <label for="id_materia">ID Materia:</label>
            <input type="text" id="id_materia" name="id_materia" required>
            
            <label for="aula">Aula:</label>
            <input type="text" id="aula" name="aula" required>
            
            <label for="horario_inicio">Horario Inicio:</label>
            <input type="time" id="horario_inicio" name="horario_inicio" required>
            
            <label for="horario_fin">Horario Fin:</label>
            <input type="time" id="horario_fin" name="horario_fin" required>
            
            <label for="dia_semana">Día de la Semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
            
            <button type="submit" class="btn btn-create">Registrar</button>
        </form>
    </div>
</body>
</html>
