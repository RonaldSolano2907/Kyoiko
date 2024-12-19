<?php
// Configuración de conexión a la base de datos (valeoro.txt)
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
$congelamientos = [];
$cedulaEstudiante = $_GET['cedula_estudiante'] ?? '';

try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }

    if ($cedulaEstudiante) {
        $sql = "BEGIN :cursor := ConsultarCongelamientos(:cedulaEstudiante); END;";
        $stmt = oci_parse($conn, $sql);
        $cursor = oci_new_cursor($conn);

        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ":cedulaEstudiante", $cedulaEstudiante);

        oci_execute($stmt);
        oci_execute($cursor);

        while (($row = oci_fetch_assoc($cursor)) != false) {
            $congelamientos[] = $row;
        }
        oci_free_statement($stmt);
        oci_free_statement($cursor);
    }
    oci_close($conn);
} catch (Exception $e) {
    echo "Error al consultar congelamientos: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Congelamientos</title>
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
        input, button { padding: 10px; font-size: 1em; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .logout-button { background-color: #dc3545; color: #fff; padding: 10px; border: none; cursor: pointer; font-size: 1em; }
        .logout-button:hover { background-color: #c82333; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>Consultar Congelamientos</header>

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
        <form method="GET" action="consultar_congelamientos.php">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" id="cedula_estudiante" name="cedula_estudiante" value="<?= htmlspecialchars($cedulaEstudiante) ?>" required>
            <button type="submit" class="btn btn-search">Buscar</button>
        </form>

        <?php if ($congelamientos): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motivo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($congelamientos as $congelamiento): ?>
                        <tr>
                            <td><?= htmlspecialchars($congelamiento['ID']) ?></td>
                            <td><?= htmlspecialchars($congelamiento['MOTIVO']) ?></td>
                            <td><?= htmlspecialchars($congelamiento['FECHAINICIO']) ?></td>
                            <td><?= htmlspecialchars($congelamiento['FECHAFIN']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron congelamientos para esta cédula.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
