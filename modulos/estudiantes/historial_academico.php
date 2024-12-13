<?php
include '../includes/db_connection.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Inicializar variables
$error = "";
$datos = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cedula"])) {
    $cedula = $_POST["cedula"];

    try {
        $sql = "SELECT * FROM VistaHistorialAcademico WHERE CedulaEstudiante = :cedula";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":cedula", $cedula);

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            throw new Exception("Error al consultar el historial académico: " . htmlentities($e['message']));
        }

        while ($row = oci_fetch_assoc($stmt)) {
            $datos[] = $row;
        }
        oci_free_statement($stmt);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Académico - Estudiantes</title>
    <style>
        /* CSS Base */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .header, .footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Historial Académico de Estudiantes</h1>
    </div>

    <div class="container">
        <form method="POST" action="historial_academico.php">
            <input type="text" name="cedula" placeholder="Ingrese la cédula del estudiante" required>
            <button type="submit">Consultar</button>
        </form>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif (!empty($datos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Materia</th>
                        <th>Semestre</th>
                        <th>Año</th>
                        <th>Fecha Matrícula</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato): ?>
                        <tr>
                            <td><?php echo $dato['CEDULAESTUDIANTE']; ?></td>
                            <td><?php echo $dato['NOMBREESTUDIANTE']; ?></td>
                            <td><?php echo $dato['NOMBREMATERIA']; ?></td>
                            <td><?php echo $dato['SEMESTRE']; ?></td>
                            <td><?php echo $dato['ANIO']; ?></td>
                            <td><?php echo $dato['FECHAMATRICULA']; ?></td>
                            <td><?php echo $dato['CALIFICACION']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="footer">
        &copy; 2024 Sistema Educativo. Todos los derechos reservados.
    </div>
</body>
</html>
