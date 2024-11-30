<?php
include '../includes/db_connection.php';

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    // Obtener los datos actuales del estudiante
    try {
        $query = "BEGIN PaqueteEstudiante.LeerEstudiante(:cedula, :cursor); END;";
        $stmt = oci_parse($conn, $query);

        // Cursor para la salida
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt);
        oci_execute($cursor); // Ejecutar el cursor

        $student = oci_fetch_assoc($cursor);

        if (!$student) {
            echo "El estudiante con la cédula especificada no existe.";
            exit;
        }

        oci_free_statement($stmt);
        oci_free_statement($cursor);
    } catch (Exception $e) {
        echo "Error al obtener los datos del estudiante: " . $e->getMessage();
        exit;
    }
}

// Procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];

    try {
        $query = "BEGIN PaqueteEstudiante.ActualizarEstudiante(
            :cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correo, :estado
        ); END;";
        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":apellidos", $apellidos);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":fechaNacimiento", $fechaNacimiento);
        oci_bind_by_name($stmt, ":correo", $correo);
        oci_bind_by_name($stmt, ":estado", $estado);

        oci_execute($stmt);
        oci_free_statement($stmt);

        header("Location: index.php");
    } catch (Exception $e) {
        echo "Error al actualizar el estudiante: " . $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="../assets/css/crud.css">
</head>
<body>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($student['NOMBRE']); ?>" required>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($student['APELLIDOS']); ?>" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?= htmlspecialchars($student['TELEFONO']); ?>">
        
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?= htmlspecialchars($student['FECHANACIMIENTO']); ?>">
        
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($student['CORREOELECTRONICO']); ?>">
        
        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="activo" <?= $student['ESTADO'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?= $student['ESTADO'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>
        
        <button type="submit">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
