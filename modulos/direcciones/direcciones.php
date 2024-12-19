<?php
// Configuración de conexión a la base de datos
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Variables para mensajes de operaciones CRUD
$success = $error = "";

// Crear dirección
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql = "BEGIN PaqueteDireccion.CrearDireccion(:cedula_estudiante, :provincia, :canton, :distrito, :direccion_exacta); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":cedula_estudiante", $cedula_estudiante);
    oci_bind_by_name($stmt, ":provincia", $provincia);
    oci_bind_by_name($stmt, ":canton", $canton);
    oci_bind_by_name($stmt, ":distrito", $distrito);
    oci_bind_by_name($stmt, ":direccion_exacta", $direccion_exacta);

    if (oci_execute($stmt)) {
        $success = "Dirección creada correctamente.";
    } else {
        $error = "Error al crear la dirección.";
    }
    oci_free_statement($stmt);
}

// Editar dirección
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql = "BEGIN PaqueteDireccion.ActualizarDireccion(:id, :cedula_estudiante, :provincia, :canton, :distrito, :direccion_exacta); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_bind_by_name($stmt, ":cedula_estudiante", $cedula_estudiante);
    oci_bind_by_name($stmt, ":provincia", $provincia);
    oci_bind_by_name($stmt, ":canton", $canton);
    oci_bind_by_name($stmt, ":distrito", $distrito);
    oci_bind_by_name($stmt, ":direccion_exacta", $direccion_exacta);

    if (oci_execute($stmt)) {
        $success = "Dirección actualizada correctamente.";
    } else {
        $error = "Error al actualizar la dirección.";
    }
    oci_free_statement($stmt);
}

// Eliminar dirección
if (isset($_GET['eliminar'])) {
    $id = $_GET['id'];

    $sql = "BEGIN PaqueteDireccion.EliminarDireccion(:id); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);

    if (oci_execute($stmt)) {
        $success = "Dirección eliminada correctamente.";
    } else {
        $error = "Error al eliminar la dirección.";
    }
    oci_free_statement($stmt);
}

// Obtener todas las direcciones
$sql = "BEGIN PaqueteDireccion.LeerDireccion(NULL, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direcciones</title>
    <style>
        header { background-color: #dc3545; color: #ffffff; padding: 10px; text-align: center; }
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
        input, textarea, button { padding: 10px; width: 100%; margin-bottom: 15px; }
        button { background-color: #dc3545; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #c82333; }
        .actions a { margin-right: 10px; color: #007bff; text-decoration: none; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Direcciones</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Direcciones</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if ($success): ?>
            <div class="success"> <?= $success ?> </div>
        <?php elseif ($error): ?>
            <div class="error"> <?= $error ?> </div>
        <?php endif; ?>

        <h2>Crear / Editar Dirección</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">
            <label for="cedula_estudiante">Cédula Estudiante:</label>
            <input type="text" name="cedula_estudiante" value="" required>

            <label for="provincia">Provincia:</label>
            <input type="text" name="provincia" value="" required>

            <label for="canton">Cantón:</label>
            <input type="text" name="canton" value="" required>

            <label for="distrito">Distrito:</label>
            <input type="text" name="distrito" value="" required>

            <label for="direccion_exacta">Dirección Exacta:</label>
            <textarea name="direccion_exacta" required></textarea>

            <button type="submit" name="crear">Crear</button>
            <button type="submit" name="editar">Editar</button>
        </form>

        <h2>Listado de Direcciones</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Estudiante</th>
                    <th>Provincia</th>
                    <th>Cantón</th>
                    <th>Distrito</th>
                    <th>Dirección Exacta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID']); ?></td>
                        <td><?= htmlspecialchars($row['CEDULAESTUDIANTE']); ?></td>
                        <td><?= htmlspecialchars($row['PROVINCIA']); ?></td>
                        <td><?= htmlspecialchars($row['CANTON']); ?></td>
                        <td><?= htmlspecialchars($row['DISTRITO']); ?></td>
                        <td><?= htmlspecialchars($row['DIRECCIONEXACTA']); ?></td>
                        <td class="actions">
                            <a href="?editar=true&id=<?= $row['ID'] ?>">Editar</a>
                            <a href="?eliminar=true&id=<?= $row['ID'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
<?php
oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
