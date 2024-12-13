<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Materia</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Crear Materia</h1>
        <form action="create.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="creditos">Créditos:</label>
            <input type="number" id="creditos" name="creditos" required>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db_connection.php';

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creditos = $_POST['creditos'];

    $query = "BEGIN PaqueteMateria.CrearMateria(:nombre, :descripcion, :creditos); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":descripcion", $descripcion);
    oci_bind_by_name($stmt, ":creditos", $creditos);

    if (oci_execute($stmt)) {
        header("Location: index.php");
    } else {
        $error = oci_error($stmt);
        echo "Error: " . $error['message'];
    }
}
?>
