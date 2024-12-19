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

    // Verificar si se solicitó eliminar una materia
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];
        $sql = "BEGIN PaqueteMateria.EliminarMateria(:id); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":id", $id);

        if (oci_execute($stmt)) {
            oci_commit($conn);
            $success = "Materia eliminada correctamente.";
        } else {
            $error = oci_error($stmt);
            $error = "Error al eliminar la materia: " . htmlentities($error['message']);
        }
        oci_free_statement($stmt);
    }

    // Verificar si se solicitó editar una materia
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];

        // Obtener los datos actuales de la materia
        $sql = "BEGIN PaqueteMateria.LeerMateria(:id, :cursor); END;";
        $stmt = oci_parse($conn, $sql);
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":id", $id);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
        oci_execute($stmt);
        oci_execute($cursor);
        $materia = oci_fetch_assoc($cursor);
        oci_free_statement($stmt);
        oci_free_cursor($cursor);

        // Procesar la edición del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $creditos = $_POST['creditos'];

            $sql = "BEGIN PaqueteMateria.ActualizarMateria(:id, :nombre, :descripcion, :creditos); END;";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":id", $id);
            oci_bind_by_name($stmt, ":nombre", $nombre);
            oci_bind_by_name($stmt, ":descripcion", $descripcion);
            oci_bind_by_name($stmt, ":creditos", $creditos);

            if (oci_execute($stmt)) {
                oci_commit($conn);
                header("Location: index.php?success=Materia actualizada correctamente.");
                exit;
            } else {
                $error = oci_error($stmt);
                $error = "Error al actualizar la materia: " . htmlentities($error['message']);
            }
            oci_free_statement($stmt);
        }
    }

    // Procesar la creación de una nueva materia
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['editar'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $creditos = $_POST['creditos'];

        $sql = "BEGIN PaqueteMateria.CrearMateria(:nombre, :descripcion, :creditos); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":descripcion", $descripcion);
        oci_bind_by_name($stmt, ":creditos", $creditos);

        if (oci_execute($stmt)) {
            oci_commit($conn);
            header('Location: index.php?success=Materia creada correctamente.');
            exit;
        } else {
            $error = oci_error($stmt);
            $error = "Error al crear la materia: " . htmlentities($error['message']);
        }
        oci_free_statement($stmt);
    }

    // Obtener la lista de materias
    $sql = "BEGIN PaqueteMateria.LeerMateria(NULL, :cursor); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_execute($stmt);
    oci_execute($cursor);
    $materias = [];
    while (($row = oci_fetch_assoc($cursor)) != false) {
        $materias[] = $row;
    }
    oci_free_statement($stmt);
    oci_free_cursor($cursor);
} catch (Exception $e) {
    $error = "Error del servidor: " . $e->getMessage();
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #000;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav li {
            margin: 0 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #dc3545;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin: 20px 0;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea, button {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Materias</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Materias</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

        <h2><?php echo isset($materia) ? 'Editar Materia' : 'Agregar Materia'; ?></h2>
        <form method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $materia['NOMBRE'] ?? ''; ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo $materia['DESCRIPCION'] ?? ''; ?></textarea>

            <label for="creditos">Créditos:</label>
            <input type="number" name="creditos" id="creditos" value="<?php echo $materia['CREDITOS'] ?? ''; ?>" required>

            <button type="submit">Guardar</button>
        </form>

        <h2>Lista de Materias</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($materias as $materia) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($materia['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($materia['NOMBRE']) . "</td>";
                    echo "<td>" . htmlspecialchars($materia['DESCRIPCION']) . "</td>";
                    echo "<td>" . htmlspecialchars($materia['CREDITOS']) . "</td>";
                    echo "<td class='actions'>
                            <a href='?editar=" . urlencode($materia['ID']) . "'>Editar</a>
                            <a href='?eliminar=" . urlencode($materia['ID']) . "' style='color: red;'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
