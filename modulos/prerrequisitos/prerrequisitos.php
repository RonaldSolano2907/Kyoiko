<?php
// Configuración de conexión a la base de datos (valeoro.txt)
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

// Procesar formulario de creación o edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMateriaPrincipal = $_POST['idMateriaPrincipal'];
    $idMateriaPrerrequisito = $_POST['idMateriaPrerrequisito'];

    if (isset($_GET['editar'])) {
        // Invoca al procedimiento almacenado ActualizarPrerrequisito
        $sql = "BEGIN PaquetePrerrequisitos.ActualizarPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
    } else {
        // Invoca al procedimiento almacenado CrearPrerrequisito
        $sql = "BEGIN PaquetePrerrequisitos.CrearPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
    }

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":idMateriaPrincipal", $idMateriaPrincipal);
    oci_bind_by_name($stmt, ":idMateriaPrerrequisito", $idMateriaPrerrequisito);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php?success=1');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al procesar el prerrequisito: " . htmlentities($error['message']);
    }
    oci_free_statement($stmt);
}

// Eliminar prerrequisito
if (isset($_GET['eliminar'])) {
    $idMateriaPrincipal = $_GET['idMateriaPrincipal'];
    $idMateriaPrerrequisito = $_GET['idMateriaPrerrequisito'];

    // Invoca al procedimiento almacenado EliminarPrerrequisito
    $sql = "BEGIN PaquetePrerrequisitos.EliminarPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":idMateriaPrincipal", $idMateriaPrincipal);
    oci_bind_by_name($stmt, ":idMateriaPrerrequisito", $idMateriaPrerrequisito);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php?success=1');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al eliminar el prerrequisito: " . htmlentities($error['message']);
    }
    oci_free_statement($stmt);
}

// Leer prerrequisitos existentes
$sql = "BEGIN PaquetePrerrequisitos.LeerPrerrequisitosDeMateria(NULL, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Prerrequisitos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
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
            color: #007bff;
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
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        form {
            margin: 20px 0;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, button {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
        <h1>Gestión de Prerrequisitos</h1>
    </header>

    <nav>
        <ul>
            <li><a href="../dashboard.php">Inicio</a></li>
            <li><a href="#">Prerrequisitos</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Formulario de creación o edición -->
        <h2><?php echo isset($_GET['editar']) ? 'Editar Prerrequisito' : 'Nuevo Prerrequisito'; ?></h2>
        <form method="post">
            <label for="idMateriaPrincipal">ID Materia Principal:</label>
            <input type="text" name="idMateriaPrincipal" id="idMateriaPrincipal" value="<?php echo $_GET['idMateriaPrincipal'] ?? ''; ?>" required>

            <label for="idMateriaPrerrequisito">ID Materia Prerrequisito:</label>
            <input type="text" name="idMateriaPrerrequisito" id="idMateriaPrerrequisito" value="<?php echo $_GET['idMateriaPrerrequisito'] ?? ''; ?>" required>

            <button type="submit">Guardar</button>
        </form>

        <!-- Lista de prerrequisitos -->
        <h2>Lista de Prerrequisitos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Materia Principal</th>
                    <th>ID Materia Prerrequisito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IDMATERIAPRINCIPAL']); ?></td>
                        <td><?php echo htmlspecialchars($row['IDMATERIAPRERREQUISITO']); ?></td>
                        <td class="actions">
                            <a href="?editar=1&idMateriaPrincipal=<?php echo urlencode($row['IDMATERIAPRINCIPAL']); ?>&idMateriaPrerrequisito=<?php echo urlencode($row['IDMATERIAPRERREQUISITO']); ?>">Editar</a>
                            <a href="?eliminar=1&idMateriaPrincipal=<?php echo urlencode($row['IDMATERIAPRINCIPAL']); ?>&idMateriaPrerrequisito=<?php echo urlencode($row['IDMATERIAPRERREQUISITO']); ?>" style="color: red;">Eliminar</a>
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
