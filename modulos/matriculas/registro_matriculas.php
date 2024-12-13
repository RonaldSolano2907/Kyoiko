<?php
include '../includes/db_connection.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedulaEstudiante = $_POST['cedula_estudiante'];
    $idMateria = $_POST['id_materia'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    try {
        $sql = "BEGIN RegistrarMatricula(:cedulaEstudiante, :idMateria, :semestre, :anio); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedulaEstudiante", $cedulaEstudiante);
        oci_bind_by_name($stmt, ":idMateria", $idMateria);
        oci_bind_by_name($stmt, ":semestre", $semestre);
        oci_bind_by_name($stmt, ":anio", $anio);

        oci_execute($stmt);
        $success = "Matrícula registrada exitosamente.";
    } catch (Exception $e) {
        $error = "Error al registrar la matrícula: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Matrículas</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Matrículas</h1>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <form method="POST" action="registro_matriculas.php">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" required>

            <label for="id_materia">ID de la Materia:</label>
            <input type="text" id="id_materia" name="id_materia" required>

            <label for="semestre">Semestre:</label>
            <input type="number" id="semestre" name="semestre" min="1" max="2" required>

            <label for="anio">Año:</label>
            <input type="number" id="anio" name="anio" min="2000" max="2100" required>

            <button type="submit" class="btn btn-create">Registrar</button>
        </form>
    </div>
</body>
</html>
