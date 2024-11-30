<?php
include_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $stmt = $conn->prepare("BEGIN PaqueteDireccion.CrearDireccion(:cedula_estudiante, :provincia, :canton, :distrito, :direccion_exacta); END;");
    oci_bind_by_name($stmt, ":cedula_estudiante", $cedula_estudiante);
    oci_bind_by_name($stmt, ":provincia", $provincia);
    oci_bind_by_name($stmt, ":canton", $canton);
    oci_bind_by_name($stmt, ":distrito", $distrito);
    oci_bind_by_name($stmt, ":direccion_exacta", $direccion_exacta);
    oci_execute($stmt);
    oci_commit($conn);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Dirección</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Agregar Dirección</h1>
        <form action="create.php" method="POST">
            <label for="cedula_estudiante">Cédula Estudiante</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" required>

            <label for="provincia">Provincia</label>
            <input type="text" id="provincia" name="provincia" required>

            <label for="canton">Cantón</label>
            <input type="text" id="canton" name="canton" required>

            <label for="distrito">Distrito</label>
            <input type="text" id="distrito" name="distrito" required>

            <label for="direccion_exacta">Dirección Exacta</label>
            <textarea id="direccion_exacta" name="direccion_exacta" required></textarea>

            <button type="submit" class="btn">Guardar</button>
        </form>
    </main>
</body>
</html>
