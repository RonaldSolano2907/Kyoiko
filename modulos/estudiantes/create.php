<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];

    try {
        $query = "BEGIN PaqueteEstudiante.CrearEstudiante(:cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correo); END;";
        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":apellidos", $apellidos);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":fechaNacimiento", $fechaNacimiento);
        oci_bind_by_name($stmt, ":correo", $correo);

        oci_execute($stmt);
        oci_free_statement($stmt);

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
    <title>Crear Estudiante</title>
    <link rel="stylesheet" href="../assets/css/crud.css">
</head>
<body>
    <form method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" id="cedula" required>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo">
        <button type="submit">Crear</button>
    </form>
</body>
</html>
