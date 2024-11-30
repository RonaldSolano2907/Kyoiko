<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $idDepartamento = $_POST['id_departamento'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correoElectronico = $_POST['correo_electronico'];
    $tituloAcademico = $_POST['titulo_academico'];

    try {
        $sql = "BEGIN PaqueteProfesor.CrearProfesor(:cedula, :idDepartamento, :nombre, :apellidos, :telefono, :correoElectronico, :tituloAcademico); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":idDepartamento", $idDepartamento);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":apellidos", $apellidos);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":correoElectronico", $correoElectronico);
        oci_bind_by_name($stmt, ":tituloAcademico", $tituloAcademico);

        oci_execute($stmt);

        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        echo "Error al crear el profesor: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Profesor</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Crear Profesor</h1>
        <form action="create.php" method="POST">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" required>
            <label for="id_departamento">ID Departamento:</label>
            <input type="number" name="id_departamento" id="id_departamento" required>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" name="correo_electronico" id="correo_electronico" required>
            <label for="titulo_academico">Título Académico:</label>
            <input type="text" name="titulo_academico" id="titulo_academico" required>
            <button type="submit" class="btn btn-submit">Crear</button>
        </form>
    </div>
</body>
</html>
