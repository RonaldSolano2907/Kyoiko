<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Materia</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Materia</h1>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $materia['ID']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $materia['NOMBRE']; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo $materia['DESCRIPCION']; ?></textarea>

            <label for="creditos">Créditos:</label>
            <input type="number" id="creditos" name="creditos" value="<?php echo $materia['CREDITOS']; ?>" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db_connection.php';

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creditos = $_POST['creditos'];

    $query = "BEGIN PaqueteMateria.ActualizarMateria(:id, :nombre, :descripcion, :creditos); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":id", $id);
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
