<?php
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMateriaPrincipal = $_POST['idMateriaPrincipal'];
    $idMateriaPrerrequisito = $_POST['idMateriaPrerrequisito'];

    try {
        $query = "BEGIN PaquetePrerrequisitos.CrearPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':idMateriaPrincipal', $idMateriaPrincipal);
        oci_bind_by_name($stmt, ':idMateriaPrerrequisito', $idMateriaPrerrequisito);
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
    <title>Nuevo Prerrequisito</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="main-content">
        <h1>Nuevo Prerrequisito</h1>
        <form action="" method="POST">
            <label for="idMateriaPrincipal">ID Materia Principal</label>
            <input type="text" name="idMateriaPrincipal" id="idMateriaPrincipal" required>
            
            <label for="idMateriaPrerrequisito">ID Materia Prerrequisito</label>
            <input type="text" name="idMateriaPrerrequisito" id="idMateriaPrerrequisito" required>
            
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</body>
</html>
