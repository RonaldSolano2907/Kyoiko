<?php
// Incluimos la conexión a la base de datos
include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <!-- Header -->
    <?php include '../includes/header.php'; ?>

    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Content -->
    <div class="content">
        <h1>Panel de Control</h1>
        <div class="dashboard">
            <?php
            // Consultas de las funciones
            $queries = [
                ['Total Estudiantes Registrados', 'SELECT TotalEstudiantesRegistrados() AS resultado'],
                ['Estudiantes Activos', 'SELECT TotalEstudiantesActivos() AS resultado'],
                ['Estudiantes Inactivos', 'SELECT TotalEstudiantesInactivos() AS resultado'],
                ['Edad Promedio de Estudiantes', 'SELECT EdadPromedioEstudiantes() AS resultado'],
                ['Estudiantes con Matrícula Activa', 'SELECT EstudiantesConMatriculaActiva() AS resultado'],
                ['Total Profesores Registrados', 'SELECT TotalProfesoresRegistrados() AS resultado'],
                ['Total Materias Asignadas', 'SELECT TotalMateriasAsignadas() AS resultado'],
                ['Promedio de Materias por Profesor', 'SELECT PromedioMateriasPorProfesor() AS resultado'],
                ['Profesores con Titulaciones Avanzadas', 'SELECT ProfesoresConTitulacionesAvanzadas() AS resultado'],
                ['Carga Horaria Promedio por Profesor', 'SELECT CargaHorariaPromedioPorProfesor() AS resultado'],
                ['Total de Materias Ofertadas', 'SELECT TotalMateriasOfertadas() AS resultado'],
                ['Materias sin Prerrequisitos', 'SELECT TotalMateriasSinPrerrequisitos() AS resultado'],
                ['Materias con Cupo Disponible', 'SELECT TotalMateriasConCupoDisponible(1, 2024) AS resultado'],
                ['Promedio de Estudiantes por Materia', 'SELECT PromedioEstudiantesPorMateria(1, 2024) AS resultado'],
                ['Materias Más Demandadas', 'SELECT COUNT(*) FROM MateriasMasDemandadas(1, 2024, 5)']
            ];

            // Ejecutamos las consultas y mostramos los resultados
            foreach ($queries as $query) {
                $title = $query[0];
                $sql = $query[1];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $value = $row['resultado'];
                echo "
                <div class='card'>
                    <h2>$title</h2>
                    <p>$value</p>
                </div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
