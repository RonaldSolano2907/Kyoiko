<?php
include '../includes/db_connection.php';

$success = $error = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $IDMateria = $_POST['IDMateria'];
    $CedulaProfesor = $_POST['CedulaProfesor'];
    $Semestre = $_POST['Semestre'];
    $Anio = $_POST['Anio'];

    // Llamar al procedimiento para crear la asignación
    $sql = "BEGIN PaqueteAsignacion.CrearAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":IDMateria", $IDMateria);
    oci_bind_by_name($stmt, ":CedulaProfesor", $CedulaProfesor);
    oci_bind_by_name($stmt, ":Semestre", $Semestre);
    oci_bind_by_name($stmt, ":Anio", $Anio);

    if (oci_execute($stmt)) {
        $success = "Asignación creada correctamente.";
    } else {
        $error = "Error al crear la asignación.";
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
    <title>Crear Asignación</title>
</head>
<body>
    <div class="sidebar">
        <h2>Gestión de Asignaciones</h2>
        <ul>
            <li><a href="index.php">Lista de Asignaciones</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Crear Asignación</h1>

        <!-- Mensajes de éxito o error -->
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="IDMateria">ID Materia:</label>
            <input type="text" name="IDMateria" id="IDMateria" required>

            <label for="CedulaProfesor">Cédula Profesor:</label>
            <input type="text" name="CedulaProfesor" id="CedulaProfesor" required>

            <label for="Semestre">Semestre:</label>
            <input type="number" name="Semestre" id="Semestre" required>

            <label for="Anio">Año:</label>
            <input type="number" name="Anio" id="Anio" required>

            <button type="submit">Crear</button>
        </form>
    </div>
</body>
</html>
