<?php
// Incluimos la conexión a la base de datos
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

// Procedimientos y sus títulos
$procedures = [
    ['title' => 'Total Estudiantes Registrados', 'procedure' => 'ObtenerTotalEstudiantesRegistrados'],
    ['title' => 'Estudiantes Activos', 'procedure' => 'ObtenerTotalEstudiantesActivos'],
    ['title' => 'Estudiantes Inactivos', 'procedure' => 'ObtenerTotalEstudiantesInactivos'],
    ['title' => 'Edad Promedio de Estudiantes', 'procedure' => 'ObtenerEdadPromedioEstudiantes'],
    ['title' => 'Estudiantes con Matrícula Activa', 'procedure' => 'ObtenerEstudiantesConMatriculaActiva'],
    ['title' => 'Total Profesores Registrados', 'procedure' => 'ObtenerTotalProfesoresRegistrados'],
    ['title' => 'Total Materias Asignadas', 'procedure' => 'ObtenerTotalMateriasAsignadas'],
    ['title' => 'Materias sin Prerrequisitos', 'procedure' => 'ObtenerTotalMateriasSinPrerrequisitos']
];

try {
    foreach ($procedures as $proc) {
        // Preparar la llamada al procedimiento almacenado
        $stmt = oci_parse($conn, "BEGIN {$proc['procedure']}(:resultado); END;");
        oci_bind_by_name($stmt, ":resultado", $resultado, 20);

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            throw new Exception("Error al ejecutar {$proc['procedure']}: " . $e['message']);
        }

        // Almacenar el título y el resultado en la variable $datos
        $datos[] = [
            'title' => $proc['title'],
            'value' => $resultado
        ];

        oci_free_statement($stmt);
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Kyoiko</title>
    <style>
        /* Estilos Base */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .header {
            background-color: #007BFF;
            text-align: center;
            padding: 20px;
            color: white;
        }

        .navbar {
            background-color: #000;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar li {
            margin: 0 10px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #007BFF;
        }

        .logout-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 40px auto;
        }

        .card {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .error {
            color: red;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Panel de Control - Kyoiko</h1>
    </div>

    <nav class="navbar">
        <ul>
            <li>Módulo Estudiantes
                <ul>
                    <li><a href="../modulos/estudiantes/registro_estudiantes.php">Registro</a></li>
                    <li><a href="../modulos/estudiantes/consultar_editar_estudiantes.php">Consultar/Editar</a></li>
                    <li><a href="../modulos/estudiantes/historial_academico_estudiantes.php">Historial Académico</a></li>
                </ul>
            </li>
            <li>Módulo Profesores
                <ul>
                    <li><a href="../modulos/profesores/registro_profesores.php">Registro</a></li>
                    <li><a href="../modulos/profesores/asignaciones_profesor.php">Asignaciones</a></li>
                    <li><a href="../modulos/profesores/consultar_editar_profesores.php">Consultar/Editar</a></li>
                </ul>
            </li>
            <li>Módulo Materias
                <ul>
                    <li><a href="../modulos/materias/registro_materias.php">Registro</a></li>
                    <li><a href="../modulos/materias/plan_estudios.php">Plan de Estudios</a></li>
                    <li><a href="../modulos/materias/prerrequisitos_materias.php">Prerrequisitos</a></li>
                </ul>
            </li>
            <li>Módulo Matrículas
                <ul>
                    <li><a href="../modulos/matriculas/registro_matriculas.php">Registro</a></li>
                    <li><a href="../modulos/matriculas/consultar_editar_matriculas.php">Consultar/Editar</a></li>
                    <li><a href="../modulos/matriculas/reporte_matriculas.php">Reporte</a></li>
                </ul>
            </li>
        </ul>
        <button class="logout-button" onclick="window.location.href='../index.php'">Salir</button>
    </nav>

    <?php if ($error): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <div class="dashboard">
            <?php foreach ($datos as $dato): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($dato['title']) ?></h3>
                    <p><?= htmlspecialchars($dato['value']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
