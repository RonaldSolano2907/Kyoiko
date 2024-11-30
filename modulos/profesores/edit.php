<?php
include '../includes/db_connection.php';

$cedula = $_GET['cedula'] ?? '';
if (!$cedula) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idDepartamento = $_POST['id_departamento'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correoElectronico = $_POST['correo_electronico'];
    $tituloAcademico = $_POST['titulo_academico'];

    try {
        $sql = "BEGIN PaqueteProfesor.ActualizarProfesor(:cedula, :idDepartamento, :nombre, :apellidos, :telefono, :correoElectronico, :tituloAcademico); END;";
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
        echo "Error al actualizar el profesor: " . $e->getMessage();
    }
} else {
    try {
        $sql = "BEGIN PaqueteProfesor.LeerProfesor(:cedula, :cursor); END;";
        $stmt = oci_parse($conn, $sql);
        $cursor = oci_new_cursor($conn);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt);
        oci_execute($cursor);

        $profesor = oci_fetch_array($cursor, OCI_ASSOC + OCI_RETURN_NULLS);
    } catch (Exception $e) {
        echo "Error al cargar los datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesor</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Profesor</h1>
        <form action="edit.php?cedula=<?= $cedula ?>" method="POST">
            <label for="id_departamento">ID Departamento:</label>
            <input type="number" name="id_departamento" id="id_departamento" value="<?= $profesor['IDDEPARTAMENTO'] ?>" required>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?= $profesor['NOMBRE'] ?>" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="<?= $profesor['APELLIDOS'] ?>" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?= $profesor['TELEFONO'] ?>">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" name="correo_electronico" id="correo_electronico" value="<?= $profesor['CORREOELECTRONICO'] ?>" required>
            <label for="titulo_academico">Título Académico:</label>
            <input type="text" name="titulo_academico" id="titulo_academico" value="<?= $profesor['TITULOACADEMICO'] ?>" required>
            <button type="submit" class="btn btn-submit">Actualizar</button>
        </form>
    </div>
</body>
</html>
