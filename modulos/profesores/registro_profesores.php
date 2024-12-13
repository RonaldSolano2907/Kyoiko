<?php
include '../includes/db_connection.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Manejar el formulario de registro
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $id_departamento = $_POST['id_departamento'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $titulo = $_POST['titulo'];

    try {
        $sql = "BEGIN RegistrarProfesor(:cedula, :id_departamento, :nombre, :apellidos, :telefono, :correo, :titulo); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedula", $cedula);
        oci_bind_by_name($stmt, ":id_departamento", $id_departamento);
        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":apellidos", $apellidos);
        oci_bind_by_name($stmt, ":telefono", $telefono);
        oci_bind_by_name($stmt, ":correo", $correo);
        oci_bind_by_name($stmt, ":titulo", $titulo);

        if (oci_execute($stmt)) {
            header("Location: registro_profesores.php?success=1");
            exit;
        } else {
            $e = oci_error($stmt);
            throw new Exception("Error en el procedimiento: " . htmlentities($e['message']));
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Profesores</title>
    <style>
        /* CSS General */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 15px;
        }

        input, select, button {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .success {
            color: green;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<header>
    <h1>Sistema de Gestión Educativa</h1>
</header>
<div class="container">
    <h2>Registro de Profesores</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php elseif (isset($_GET['success'])): ?>
        <p class="success">¡Profesor registrado exitosamente!</p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="cedula">Cédula</label>
        <input type="text" id="cedula" name="cedula" required>

        <label for="id_departamento">ID Departamento</label>
        <input type="number" id="id_departamento" name="id_departamento" required>

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="telefono">Teléfono</label>
        <input type="text" id="telefono" name="telefono">

        <label for="correo">Correo Electrónico</label>
        <input type="email" id="correo" name="correo">

        <label for="titulo">Título Académico</label>
        <input type="text" id="titulo" name="titulo">

        <button type="submit">Registrar</button>
    </form>
</div>
<footer>
    &copy; 2024 Sistema de Gestión Educativa
</footer>
</body>
</html>
