<?php
include '../includes/db_connection.php';

$success = $error = "";

// Verificar si el ID de la asignación ha sido enviado
if (isset($_GET['IDMateria']) && isset($_GET['CedulaProfesor']) && isset($_GET['Semestre']) && isset($_GET['Anio'])) {
    $IDMateria = $_GET['IDMateria'];
    $CedulaProfesor = $_GET['CedulaProfesor'];
    $Semestre = $_GET['Semestre'];
    $Anio = $_GET['Anio'];

    // Obtener los datos actuales de la asignación
    $sql = "BEGIN PaqueteAsignacion.LeerAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio, :Asignacion); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":IDMateria", $IDMateria);
    oci_bind_by_name($stmt, ":CedulaProfesor", $CedulaProfesor);
    oci_bind_by_name($stmt, ":Semestre", $Semestre);
    oci_bind_by_name($stmt, ":Anio", $Anio);
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":Asignacion", $cursor, -1, OCI_B_CURSOR);

    if (oci_execute($stmt) && oci_execute($cursor)) {
        $asignacion = oci_fetch_assoc($cursor);
    } else {
        $error = "Error al obtener los datos de la asignación.";
    }

    oci_free_statement($stmt);
    oci_free_statement($cursor);
}

// Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NuevoSemestre = $_POST['NuevoSemestre'];
    $NuevoAnio = $_POST['NuevoAnio'];

    $sql = "BEGIN PaqueteAsignacion.ActualizarAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio, :NuevoSemestre, :NuevoAnio); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":IDMateria", $IDMateria);
    oci_bind_by_name($stmt, ":CedulaProfesor", $CedulaProfesor);
    oci_bind_by_name($stmt, ":Semestre", $Semestre);
    oci_bind_by_name($stmt, ":Anio", $Anio);
    oci_bind_by_name($stmt, ":NuevoSemestre", $NuevoSemestre);
    oci_bind_by_name($stmt, ":NuevoAnio", $NuevoAnio);

    if (oci_execute($stmt)) {
        $success = "Asignación actualizada correctamente.";
    } else {
        $error = "Error al actualizar la asignación.";
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/asignaciones.css">
    <title>Editar Asignación</title>
</head>
<body>
    <div class="sidebar">
        <h2>Gestión de Asignaciones</h2>
        <ul>
            <li><a href="index.php">Lista de Asignaciones</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Editar Asignación</h1>

        <!-- Mensajes de éxito o error -->
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($asignacion)): ?>
        <form action="" method="post">
            <label for="NuevoSemestre">Nuevo Semestre:</label>
            <input type="number" name="NuevoSemestre" id="NuevoSemestre" value="<?= $asignacion['SEMESTRE'] ?>" required>

            <label for="NuevoAnio">Nuevo Año:</label>
            <input type="number" name="NuevoAnio" id="NuevoAnio" value="<?= $asignacion['ANIO'] ?>" required>

            <button type="submit">Actualizar</button>
        </form>
        <?php else: ?>
            <p>No se encontraron datos para esta asignación.</p>
        <?php endif; ?>
    </div>
</body>
</html>
