<?php
require_once '../includes/db_connection.php';

$cedula = $_GET['cedula'];
$idMateria = $_GET['idMateria'];
$semestre = $_GET['semestre'];
$anio = $_GET['anio'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoSemestre = $_POST['nuevoSemestre'];
    $nuevoAnio = $_POST['nuevoAnio'];

    try {
        $query = "BEGIN PaqueteMatricula.ActualizarMatricula(:cedula, :idMateria, :semestre, :anio, :nuevoSemestre, :nuevoAnio); END;";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':cedula', $cedula);
        oci_bind_by_name($stmt, ':idMateria', $idMateria);
        oci_bind_by_name($stmt, ':semestre', $semestre);
        oci_bind_by_name($stmt, ':anio', $anio);
        oci_bind_by_name($stmt, ':nuevoSemestre', $nuevoSemestre);
        oci_bind_by_name($stmt, ':nuevoAnio', $nuevoAnio);
        oci_execute($stmt);
        header("Location: index.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Matrícula</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h1>Editar Matrícula</h1>
        <form action="" method="POST">
            <label for="nuevoSemestre">Nuevo Semestre</label>
            <input type="number" name="nuevoSemestre" id="nuevoSemestre" required>
            
            <label for="nuevoAnio">Nuevo Año</label>
            <input type="number" name="nuevoAnio" id="nuevoAnio" required>
            
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </form>
    </div>
</body>
</html>
