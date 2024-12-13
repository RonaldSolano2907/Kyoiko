<?php
include '../includes/db_connection.php';

// Inicializar variables
$cedula = $_GET['cedula'] ?? '';
$profesor = null;
$error = "";

// Consultar los datos del profesor
try {
    $sql = "BEGIN ObtenerProfesor(:cedula, :result); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cedula", $cedula);
    oci_bind_by_name($stmt, ":result", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $profesor = oci_fetch_assoc($cursor);
    oci_free_statement($cursor);
    oci_free_statement($stmt);
} catch (Exception $e) {
    $error = "Error al cargar los datos del profesor: " . $e->getMessage();
}

// Actualizar los datos del profesor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_departamento = $_POST['departamento'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $titulo = $_POST['titulo'];

    try {
        $sql = "BEGIN ActualizarProfesor(:cedula, :id_departamento, :nombre, :apellidos, :telefono, :correo, :titulo); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":id_departamento", $id_departamento);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":apellidos", $apellidos);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":correo", $correo);
        oci_bind_by_name($stmt, ":titulo", $titulo);

        oci_execute($stmt);
        oci_free_statement($stmt);

        header("Location: index.php?success=1");
        exit;
    } catch (Exception $e) {
        $error = "Error al actualizar el profesor: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar y Editar Profesor</title>
    <style>
        /* Aquí puedes agregar los estilos directamente */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input, select, button {
            padding: 10px;
            margin-top: 5px;
            font-size: 1em;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultar y Editar Profesor</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php else: ?>
            <form method="POST">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" value="<?= $profesor['CEDULA'] ?>" readonly>

                <label for="departamento">Departamento:</label>
                <select id="departamento" name="departamento">
                    <option value="1" <?= $profesor['IDDEPARTAMENTO'] == 1 ? 'selected' : '' ?>>Ciencias Básicas</option>
                    <option value="2" <?= $profesor['IDDEPARTAMENTO'] == 2 ? 'selected' : '' ?>>Ingeniería</option>
                    <option value="3" <?= $profesor['IDDEPARTAMENTO'] == 3 ? 'selected' : '' ?>>Humanidades</option>
                </select>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= $profesor['NOMBRE'] ?>">

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?= $profesor['APELLIDOS'] ?>">

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?= $profesor['TELEFONO'] ?>">

                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?= $profesor['CORREOELECTRONICO'] ?>">

                <label for="titulo">Título Académico:</label>
                <select id="titulo" name="titulo">
                    <option value="Licenciatura" <?= $profesor['TITULOACADEMICO'] == 'Licenciatura' ? 'selected' : '' ?>>Licenciatura</option>
                    <option value="Maestría" <?= $profesor['TITULOACADEMICO'] == 'Maestría' ? 'selected' : '' ?>>Maestría</option>
                    <option value="Doctorado" <?= $profesor['TITULOACADEMICO'] == 'Doctorado' ? 'selected' : '' ?>>Doctorado</option>
                </select>

                <button type="submit">Guardar Cambios</button>
            </form>
        <?php endif; ?>
        <a href="index.php" class="back-link">Volver</a>
    </div>
</body>
</html>
