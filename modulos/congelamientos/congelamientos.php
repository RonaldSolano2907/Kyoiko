<?php
// Configuración de conexión a la base de datos
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';

try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        throw new Exception($e['message']);
    }
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Mensajes para operaciones CRUD
$success = $error = "";

// Crear congelamiento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $cedula = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $stmt = oci_parse($conn, "BEGIN PaqueteCongelamientos.CrearCongelamiento(:cedula, :motivo, TO_DATE(:fecha_inicio, 'YYYY-MM-DD'), TO_DATE(:fecha_fin, 'YYYY-MM-DD')); END;");
    oci_bind_by_name($stmt, ':cedula', $cedula);
    oci_bind_by_name($stmt, ':motivo', $motivo);
    oci_bind_by_name($stmt, ':fecha_inicio', $fecha_inicio);
    oci_bind_by_name($stmt, ':fecha_fin', $fecha_fin);

    if (oci_execute($stmt)) {
        $success = "Congelamiento creado correctamente.";
    } else {
        $error = "Error al crear el congelamiento.";
    }
    oci_free_statement($stmt);
}

// Editar congelamiento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $cedula = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $stmt = oci_parse($conn, "BEGIN PaqueteCongelamientos.ActualizarCongelamiento(:id, :cedula, :motivo, TO_DATE(:fecha_inicio, 'YYYY-MM-DD'), TO_DATE(:fecha_fin, 'YYYY-MM-DD')); END;");
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':cedula', $cedula);
    oci_bind_by_name($stmt, ':motivo', $motivo);
    oci_bind_by_name($stmt, ':fecha_inicio', $fecha_inicio);
    oci_bind_by_name($stmt, ':fecha_fin', $fecha_fin);

    if (oci_execute($stmt)) {
        $success = "Congelamiento actualizado correctamente.";
    } else {
        $error = "Error al actualizar el congelamiento.";
    }
    oci_free_statement($stmt);
}

// Eliminar congelamiento
if (isset($_GET['eliminar'])) {
    $id = $_GET['id'];

    $stmt = oci_parse($conn, "BEGIN PaqueteCongelamientos.EliminarCongelamiento(:id); END;");
    oci_bind_by_name($stmt, ':id', $id);

    if (oci_execute($stmt)) {
        $success = "Congelamiento eliminado correctamente.";
    } else {
        $error = "Error al eliminar el congelamiento.";
    }
    oci_free_statement($stmt);
}

// Obtener datos para edición
$datosEdicion = null;
if (isset($_GET['editar'])) {
    $id = $_GET['id'];

    $stmt = oci_parse($conn, "BEGIN PaqueteCongelamientos.LeerCongelamiento(:id, :cursor); END;");
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);
    $datosEdicion = oci_fetch_assoc($cursor);
    oci_free_statement($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Congelamientos</title>
    <style>
        header { background-color: #dc3545; color: white; padding: 20px; text-align: center; }
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav li { margin: 0 10px; position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        nav a:hover { color: #dc3545; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
        .success { color: green; text-align: center; font-weight: bold; margin: 10px; }
        .error { color: red; text-align: center; font-weight: bold; margin: 10px; }
        .container { margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin: 20px 0; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, button, textarea { padding: 10px; width: 100%; margin-bottom: 15px; }
        textarea { resize: none; }
        button { background-color: #dc3545; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #c82333; }
        .actions a { margin-right: 10px; color: #007bff; text-decoration: none; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Congelamientos</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Congelamientos</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if ($success): ?>
            <div class="success"> <?= $success ?> </div>
        <?php elseif ($error): ?>
            <div class="error"> <?= $error ?> </div>
        <?php endif; ?>

        <h2><?= $datosEdicion ? 'Editar Congelamiento' : 'Crear Nuevo Congelamiento' ?></h2>
        <form method="post">
            <input type="hidden" name="id" value="<?= $datosEdicion['ID'] ?? '' ?>">

            <label for="cedula_estudiante">Cédula Estudiante:</label>
            <input type="text" name="cedula_estudiante" value="<?= $datosEdicion['CEDULAESTUDIANTE'] ?? '' ?>" required>

            <label for="motivo">Motivo:</label>
            <textarea name="motivo" required><?= $datosEdicion['MOTIVO'] ?? '' ?></textarea>

            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" value="<?= $datosEdicion['FECHAINICIO'] ?? '' ?>" required>

            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" name="fecha_fin" value="<?= $datosEdicion['FECHAFIN'] ?? '' ?>">

            <?php if ($datosEdicion): ?>
                <button type="submit" name="editar">Actualizar</button>
            <?php else: ?>
                <button type="submit" name="crear">Crear</button>
            <?php endif; ?>
        </form>

        <h2>Listado de Congelamientos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Estudiante</th>
                    <th>Motivo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = oci_parse($conn, "SELECT * FROM Congelamientos");
                oci_execute($stmt);
                while ($row = oci_fetch_assoc($stmt)) {
                    echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['CEDULAESTUDIANTE']}</td>
                            <td>{$row['MOTIVO']}</td>
                            <td>{$row['FECHAINICIO']}</td>
                            <td>{$row['FECHAFIN']}</td>
                            <td class='actions'>
                                <a href='?editar=true&id={$row['ID']}'>Editar</a>
                                <a href='?eliminar=true&id={$row['ID']}'>Eliminar</a>
                            </td>
                          </tr>";
                }
                oci_free_statement($stmt);
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
