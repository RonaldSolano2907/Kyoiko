<?php
// Configuración de conexión a la base de datos (de valeoro.txt)
$usuario_db = 'USERLBD';  // Cambia esto por tu usuario
$clave_db = '123';        // Cambia esto por tu contraseña
$cadena_conexion = 'localhost/XE'; // Cambia si usas otra cadena de conexión
try {
    // Conexión a Oracle usando OCI8
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaciones</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; }
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav li { margin: 0 10px; position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        nav a:hover { color: #007bff; }
        .success { color: green; text-align: center; font-weight: bold; margin-top: 20px; }
        .error { color: red; text-align: center; font-weight: bold; margin-top: 20px; }
        .form-container { width: 50%; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, button { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Asignaciones</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="edit.php">Editar</a></li>
            <li><a href="delete.php">Borrar</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Mensajes -->
    <?php if ($success): ?>
        <div class="success"> <?= $success ?> </div>
    <?php elseif ($error): ?>
        <div class="error"> <?= $error ?> </div>
    <?php endif; ?>

    <!-- Formulario de Edición -->
    <div class="form-container">
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

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
