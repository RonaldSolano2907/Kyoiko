<?php
// Conexión a la base de datos
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

// Crear asignación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $idMateria = $_POST['IDMateria'];
    $cedulaProfesor = $_POST['CedulaProfesor'];
    $semestre = $_POST['Semestre'];
    $anio = $_POST['Anio'];

    $stmt = oci_parse($conn, "BEGIN PaqueteAsignacion.CrearAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio); END;");
    oci_bind_by_name($stmt, ':IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':Semestre', $semestre);
    oci_bind_by_name($stmt, ':Anio', $anio);

    if (oci_execute($stmt)) {
        $success = "Asignación creada correctamente.";
    } else {
        $error = "Error al crear la asignación.";
    }
    oci_free_statement($stmt);
}

// Editar asignación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $idMateria = $_POST['IDMateria'];
    $cedulaProfesor = $_POST['CedulaProfesor'];
    $semestre = $_POST['Semestre'];
    $anio = $_POST['Anio'];
    $nuevoSemestre = $_POST['NuevoSemestre'];
    $nuevoAnio = $_POST['NuevoAnio'];

    $stmt = oci_parse($conn, "BEGIN PaqueteAsignacion.ActualizarAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio, :NuevoSemestre, :NuevoAnio); END;");
    oci_bind_by_name($stmt, ':IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':Semestre', $semestre);
    oci_bind_by_name($stmt, ':Anio', $anio);
    oci_bind_by_name($stmt, ':NuevoSemestre', $nuevoSemestre);
    oci_bind_by_name($stmt, ':NuevoAnio', $nuevoAnio);

    if (oci_execute($stmt)) {
        $success = "Asignación actualizada correctamente.";
    } else {
        $error = "Error al actualizar la asignación.";
    }
    oci_free_statement($stmt);
}

// Eliminar asignación
if (isset($_GET['eliminar'])) {
    $idMateria = $_GET['IDMateria'];
    $cedulaProfesor = $_GET['CedulaProfesor'];
    $semestre = $_GET['Semestre'];
    $anio = $_GET['Anio'];

    $stmt = oci_parse($conn, "BEGIN PaqueteAsignacion.EliminarAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio); END;");
    oci_bind_by_name($stmt, ':IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':Semestre', $semestre);
    oci_bind_by_name($stmt, ':Anio', $anio);

    if (oci_execute($stmt)) {
        $success = "Asignación eliminada correctamente.";
    } else {
        $error = "Error al eliminar la asignación.";
    }
    oci_free_statement($stmt);
}

// Obtener datos para edición
$datosEdicion = null;
if (isset($_GET['editar'])) {
    $idMateria = $_GET['IDMateria'];
    $cedulaProfesor = $_GET['CedulaProfesor'];
    $semestre = $_GET['Semestre'];
    $anio = $_GET['Anio'];

    $stmt = oci_parse($conn, "BEGIN PaqueteAsignacion.LeerAsignacion(:IDMateria, :CedulaProfesor, :Semestre, :Anio, :Asignacion); END;");
    oci_bind_by_name($stmt, ':IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':Semestre', $semestre);
    oci_bind_by_name($stmt, ':Anio', $anio);
    oci_bind_by_name($stmt, ':Asignacion', $datosEdicion, -1, OCI_B_CURSOR);
    oci_execute($stmt);

    oci_execute($datosEdicion);
    $datosEdicion = oci_fetch_assoc($datosEdicion);
    oci_free_statement($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Asignaciones</title>
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
        input, button { padding: 10px; width: 100%; margin-bottom: 15px; }
        button { background-color: #dc3545; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #c82333; }
        .actions a { margin-right: 10px; color: #007bff; text-decoration: none; }
        .actions a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Asignaciones</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Asignaciones</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if ($success): ?>
            <div class="success"> <?= $success ?> </div>
        <?php elseif ($error): ?>
            <div class="error"> <?= $error ?> </div>
        <?php endif; ?>

        <h2><?= $datosEdicion ? 'Editar Asignación' : 'Crear Nueva Asignación' ?></h2>
        <form method="post">
            <label for="IDMateria">ID Materia:</label>
            <input type="number" name="IDMateria" value="<?= $datosEdicion['IDMATERIA'] ?? '' ?>" required>

            <label for="CedulaProfesor">Cédula Profesor:</label>
            <input type="text" name="CedulaProfesor" value="<?= $datosEdicion['CEDULAPROFESOR'] ?? '' ?>" required>

            <label for="Semestre">Semestre:</label>
            <input type="number" name="Semestre" value="<?= $datosEdicion['SEMESTRE'] ?? '' ?>" required>

            <label for="Anio">Año:</label>
            <input type="number" name="Anio" value="<?= $datosEdicion['ANIO'] ?? '' ?>" required>

            <?php if ($datosEdicion): ?>
                <label for="NuevoSemestre">Nuevo Semestre:</label>
                <input type="number" name="NuevoSemestre" required>

                <label for="NuevoAnio">Nuevo Año:</label>
                <input type="number" name="NuevoAnio" required>

                <button type="submit" name="editar">Actualizar</button>
            <?php else: ?>
                <button type="submit" name="crear">Crear</button>
            <?php endif; ?>
        </form>

        <h2>Listado de Asignaciones</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Materia</th>
                    <th>Cédula Profesor</th>
                    <th>Semestre</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = oci_parse($conn, "SELECT * FROM Asignacion");
                oci_execute($stmt);
                while ($row = oci_fetch_assoc($stmt)) {
                    echo "<tr>
                            <td>{$row['IDMATERIA']}</td>
                            <td>{$row['CEDULAPROFESOR']}</td>
                            <td>{$row['SEMESTRE']}</td>
                            <td>{$row['ANIO']}</td>
                            <td class='actions'>
                                <a href='?editar=true&IDMateria={$row['IDMATERIA']}&CedulaProfesor={$row['CEDULAPROFESOR']}&Semestre={$row['SEMESTRE']}&Anio={$row['ANIO']}'>Editar</a>
                                <a href='?eliminar=true&IDMateria={$row['IDMATERIA']}&CedulaProfesor={$row['CEDULAPROFESOR']}&Semestre={$row['SEMESTRE']}&Anio={$row['ANIO']}'>Eliminar</a>
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
