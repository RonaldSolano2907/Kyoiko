<?php
// Configuración de conexión a la base de datos (valeoro.txt)
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
$error = '';
$success = '';

try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cedulaEstudiante = $_POST['cedula_estudiante'];
        $motivo = $_POST['motivo'];
        $fechaInicio = $_POST['fecha_inicio'];
        $fechaFin = $_POST['fecha_fin'];

        $sql = "BEGIN RegistrarCongelamiento(:cedulaEstudiante, :motivo, TO_DATE(:fechaInicio, 'YYYY-MM-DD'), TO_DATE(:fechaFin, 'YYYY-MM-DD')); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ":cedulaEstudiante", $cedulaEstudiante);
        oci_bind_by_name($stmt, ":motivo", $motivo);
        oci_bind_by_name($stmt, ":fechaInicio", $fechaInicio);
        oci_bind_by_name($stmt, ":fechaFin", $fechaFin);

        if (oci_execute($stmt)) {
            $success = "Congelamiento registrado exitosamente.";
        } else {
            $error = "Error al registrar el congelamiento.";
        }
        oci_free_statement($stmt);
    }
    oci_close($conn);
} catch (Exception $e) {
    $error = "Error al registrar el congelamiento: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Congelamientos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background-color: #007bff; color: #ffffff; padding: 10px; text-align: center; font-size: 1.5em; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav li { position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 10px; display: block; padding: 10px; }
        nav a:hover { color: #007bff; }
        nav ul ul { display: none; position: absolute; top: 100%; left: 0; background-color: #222; padding: 0; }
        nav li:hover > ul { display: block; }
        nav ul ul li a { padding: 10px; white-space: nowrap; }
        h1 { text-align: center; margin-top: 20px; }
        .container { width: 80%; margin: auto; margin-top: 20px; }
        form { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        input, textarea, button { padding: 10px; font-size: 1em; }
        button { background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
        .error, .success { padding: 10px; margin: 10px 0; color: white; text-align: center; }
        .error { background-color: #dc3545; }
        .success { background-color: #28a745; }
        .logout-button { background-color: #dc3545; color: #fff; padding: 10px; border: none; cursor: pointer; font-size: 1em; }
        .logout-button:hover { background-color: #c82333; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>Registro de Congelamientos</header>

    <!-- Navbar -->
    <nav class="navbar">
        <ul>
            <li><a href="#">Estudiantes</a>
                <ul>
                    <li><a href="../modulos/estudiantes/registro_estudiantes.php">Registro</a></li>
                    <li><a href="../modulos/estudiantes/consultar_editar_estudiantes.php">Consultar/Editar</a></li>
                    <li><a href="../modulos/estudiantes/historial_academico_estudiantes.php">Historial Académico</a></li>
                </ul>
            </li>
            <li><a href="#">Profesores</a>
                <ul>
                    <li><a href="../modulos/profesores/registro_profesores.php">Registro</a></li>
                    <li><a href="../modulos/profesores/asignaciones_profesor.php">Asignaciones</a></li>
                    <li><a href="../modulos/profesores/consultar_editar_profesores.php">Consultar/Editar</a></li>
                </ul>
            </li>
            <li><a href="#">Materias</a>
                <ul>
                    <li><a href="../modulos/materias/registro_materias.php">Registro</a></li>
                    <li><a href="../modulos/materias/plan_estudios.php">Plan de Estudios</a></li>
                    <li><a href="../modulos/materias/prerrequisitos_materias.php">Prerrequisitos</a></li>
                </ul>
            </li>
            <li><a href="#">Matrículas</a>
                <ul>
                    <li><a href="../modulos/matriculas/registro_matriculas.php">Registro</a></li>
                    <li><a href="../modulos/matriculas/consultar_editar_matriculas.php">Consultar/Editar</a></li>
                    <li><a href="../modulos/matriculas/reporte_matriculas.php">Reporte</a></li>
                </ul>
            </li>
        </ul>
        <button class="logout-button" onclick="window.location.href='../index.php'">Salir</button>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="POST" action="registro_congelamientos.php">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" required>

            <label for="motivo">Motivo:</label>
            <textarea id="motivo" name="motivo" required></textarea>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <button type="submit">Registrar</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
