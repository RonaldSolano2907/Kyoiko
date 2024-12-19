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

// Mensajes para operaciones CRUD
$success = $error = "";

// Crear departamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $cedula_jefe = $_POST['cedula_jefe'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = oci_parse($conn, "BEGIN PaqueteDepartamento.CrearDepartamento(:cedula_jefe, :nombre, :descripcion); END;");
    oci_bind_by_name($stmt, ':cedula_jefe', $cedula_jefe);
    oci_bind_by_name($stmt, ':nombre', $nombre);
    oci_bind_by_name($stmt, ':descripcion', $descripcion);

    if (oci_execute($stmt)) {
        $success = "Departamento creado correctamente.";
    } else {
        $error = "Error al crear el departamento.";
    }
    oci_free_statement($stmt);
}

// Editar departamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $cedula_jefe = $_POST['cedula_jefe'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = oci_parse($conn, "BEGIN PaqueteDepartamento.ActualizarDepartamento(:id, :cedula_jefe, :nombre, :descripcion); END;");
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':cedula_jefe', $cedula_jefe);
    oci_bind_by_name($stmt, ':nombre', $nombre);
    oci_bind_by_name($stmt, ':descripcion', $descripcion);

    if (oci_execute($stmt)) {
        $success = "Departamento actualizado correctamente.";
    } else {
        $error = "Error al actualizar el departamento.";
    }
    oci_free_statement($stmt);
}

// Eliminar departamento
if (isset($_GET['eliminar'])) {
    $id = $_GET['id'];

    $stmt = oci_parse($conn, "BEGIN PaqueteDepartamento.EliminarDepartamento(:id); END;");
    oci_bind_by_name($stmt, ':id', $id);

    if (oci_execute($stmt)) {
        $success = "Departamento eliminado correctamente.";
    } else {
        $error = "Error al eliminar el departamento.";
    }
    oci_free_statement($stmt);
}

// Obtener datos para edición
$datosEdicion = null;
if (isset($_GET['editar'])) {
    $id = $_GET['id'];

    $stmt = oci_parse($conn, "BEGIN PaqueteDepartamento.LeerDepartamento(:id, :cursor); END;");
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);

    $datosEdicion = oci_fetch_assoc($cursor);
    oci_free_statement($stmt);
    oci_free_statement($cursor);
}

// Obtener todos los departamentos
$departamentos = [];
$stmt = oci_parse($conn, "BEGIN PaqueteDepartamento.LeerDepartamento(NULL, :cursor); END;");
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
while (($row = oci_fetch_assoc($cursor)) != false) {
    $departamentos[] = $row;
}
oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos</title>
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
        input, textarea, button { padding: 10px; width: 100%; margin-bottom: 15px; }
        button { background-color: #dc3545; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .actions a { margin-right: 10px; color: #dc3545; text-decoration: none; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Departamentos</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Departamentos</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if ($success): ?>
            <div class="success"> <?= $success ?> </div>
        <?php elseif ($error): ?>
            <div class="error"> <?= $error ?> </div>
        <?php endif; ?>

        <h2><?= $datosEdicion ? 'Editar Departamento' : 'Crear Nuevo Departamento' ?></h2>
        <form method="post">
            <?php if ($datosEdicion): ?>
                <input type="hidden" name="id" value="<?= $datosEdicion['ID'] ?>">
            <?php endif; ?>
            <label for="cedula_jefe">Cédula Jefe:</label>
            <input type="text" name="cedula_jefe" value="<?= $datosEdicion['CEDULAJEFEDEPARTAMENTO'] ?? '' ?>" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= $datosEdicion['NOMBRE'] ?? '' ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required><?= $datosEdicion['DESCRIPCION'] ?? '' ?></textarea>

            <?php if ($datosEdicion): ?>
                <button type="submit" name="editar">Actualizar</button>
            <?php else: ?>
                <button type="submit" name="crear">Crear</button>
            <?php endif; ?>
        </form>

        <h2>Listado de Departamentos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Jefe</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departamentos as $departamento): ?>
                    <tr>
                        <td><?= $departamento['ID'] ?></td>
                        <td><?= $departamento['CEDULAJEFEDEPARTAMENTO'] ?></td>
                        <td><?= $departamento['NOMBRE'] ?></td>
                        <td><?= $departamento['DESCRIPCION'] ?></td>
                        <td class="actions">
                            <a href="?editar=true&id=<?= $departamento['ID'] ?>">Editar</a>
                            <a href="?eliminar=true&id=<?= $departamento['ID'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
