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

// Procedimientos y sus títulos
$procedures = [
    ['title' => 'Total Estudiantes Registrados', 'procedure' => 'ObtenerTotalEstudiantesRegistrados'],
    ['title' => 'Estudiantes Activos', 'procedure' => 'ObtenerTotalEstudiantesActivos'],
    ['title' => 'Estudiantes Inactivos', 'procedure' => 'ObtenerTotalEstudiantesInactivos'],
    ['title' => 'Edad Promedio de Estudiantes', 'procedure' => 'ObtenerEdadPromedioEstudiantes'],
    ['title' => 'Estudiantes con Matrícula Activa', 'procedure' => 'ObtenerEstudiantesConMatriculaActiva'],
    ['title' => 'Total Profesores Registrados', 'procedure' => 'ObtenerTotalProfesoresRegistrados'],
    ['title' => 'Total Materias Asignadas', 'procedure' => 'ObtenerTotalMateriasAsignadas'],
    ['title' => 'Promedio de Materias por Profesor', 'procedure' => 'ObtenerPromedioMateriasPorProfesor'],
    ['title' => 'Profesores con Titulaciones Avanzadas', 'procedure' => 'ObtenerProfesoresConTitulacionesAvanzadas'],
    ['title' => 'Carga Horaria Promedio por Profesor', 'procedure' => 'ObtenerCargaHorariaPromedioPorProfesor'],
    ['title' => 'Total de Materias Ofertadas', 'procedure' => 'ObtenerTotalMateriasOfertadas'],
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

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
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

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
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
