<?php
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $idMateria = $_POST['idMateria'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    try {
        $query = "BEGIN PaqueteMatricula.CrearMatricula(:cedula, :idMateria, :semestre, :anio); END;";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':cedula', $cedula);
        oci_bind_by_name($stmt, ':idMateria', $idMateria);
        oci_bind_by_name($stmt, ':semestre', $semestre);
        oci_bind_by_name($stmt, ':anio', $anio);
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
    <title>Nueva Matrícula</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h1>Nueva Matrícula</h1>
        <form action="" method="POST">
            <label for="cedula">Cédula Estudiante</label>
            <input type="text" name="cedula" id="cedula" required>
            
            <label for="idMateria">ID Materia</label>
            <input type="text" name="idMateria" id="idMateria" required>
            
            <label for="semestre">Semestre</label>
            <input type="number" name="semestre" id="semestre" required>
            
            <label for="anio">Año</label>
            <input type="number" name="anio" id="anio" required>
            
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</body>
</html>
