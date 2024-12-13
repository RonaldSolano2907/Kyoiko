<?php
include '../includes/db_connection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creditos = $_POST['creditos'];

    try {
        // Llamar al procedimiento almacenado
        $sql = "BEGIN RegistrarMateria(:nombre, :descripcion, :creditos); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":nombre", $nombre);
        oci_bind_by_name($stmt, ":descripcion", $descripcion);
        oci_bind_by_name($stmt, ":creditos", $creditos);

        if (oci_execute($stmt)) {
            $success = "Materia registrada exitosamente.";
        } else {
            $error = "Error al registrar la materia.";
        }
        oci_free_statement($stmt);
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Materias</title>
    <style>
        /* CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input, textarea, button {
            padding: 10px;
            margin-top: 5px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Materias</h1>
        <?php if ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="nombre">Nombre de la Materia:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Introduzca el nombre de la materia" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" placeholder="Introduzca una descripción de la materia" rows="3" required></textarea>

            <label for="creditos">Créditos:</label>
            <input type="number" id="creditos" name="creditos" placeholder="Introduzca los créditos" required>

            <button type="submit">Registrar Materia</button>
        </form>
        <a href="index.php" class="back-link">Volver</a>
    </div>
</body>
</html>
