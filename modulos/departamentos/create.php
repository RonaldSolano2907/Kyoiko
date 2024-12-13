<?php
include_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula_jefe = $_POST['cedula_jefe'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("BEGIN PaqueteDepartamento.CrearDepartamento(:cedula_jefe, :nombre, :descripcion); END;");
    oci_bind_by_name($stmt, ":cedula_jefe", $cedula_jefe);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":descripcion", $descripcion);
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
    <title>Agregar Departamento</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Agregar Departamento</h1>
        <form action="create.php" method="POST">
            <label for="cedula_jefe">Cédula Jefe</label>
            <input type="text" id="cedula_jefe" name="cedula_jefe" required>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <button type="submit" class="btn">Guardar</button>
        </form>
    </main>
</body>
</html>
