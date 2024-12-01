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
    <style>
        /* CSS Base */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        h1, h2 {
            margin: 0;
        }

        h1 {
            font-size: 2em;
            color: white;
            text-align: center;
            margin: 0;
            padding: 15px 0;
        }

        h2 {
            font-size: 1.5em;
            text-align: center;
            color: #007BFF;
            margin-top: 20px;
        }

        /* Header */
        .header {
            background-color: #007BFF;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            max-height: 50px;
            margin-right: 15px;
        }

        /* Navbar */
        .navbar {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar-item {
            margin: 0 15px;
        }

        .navbar-link {
            color: #333;
            text-decoration: none;
            font-size: 1em;
            font-weight: bold;
        }

        .navbar-link:hover {
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

        /* Dashboard */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 40px auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            color: white;
            font-size: 1em;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Colores cálidos y fríos */
        .card:nth-child(1) { background-color: #FF6F61; } /* Rojo cálido */
        .card:nth-child(2) { background-color: #6B5B95; } /* Púrpura frío */
        .card:nth-child(3) { background-color: #88B04B; } /* Verde frío */
        .card:nth-child(4) { background-color: #F7CAC9; } /* Rosa cálido */
        .card:nth-child(5) { background-color: #92A8D1; } /* Azul frío */
        .card:nth-child(6) { background-color: #034F84; } /* Azul oscuro frío */
        .card:nth-child(7) { background-color: #F7786B; } /* Salmón cálido */
        .card:nth-child(8) { background-color: #DE7A22; } /* Naranja cálido */
        .card:nth-child(9) { background-color: #4B8E8D; } /* Verde azulado frío */
        .card:nth-child(10) { background-color: #EFC050; } /* Amarillo cálido */
        .card:nth-child(11) { background-color: #45B8AC; } /* Turquesa frío */
        .card:nth-child(12) { background-color: #D65076; } /* Magenta cálido */
        .card:nth-child(13) { background-color: #9B2335; } /* Rojo vino cálido */
        .card:nth-child(14) { background-color: #55B4B0; } /* Verde menta frío */
        .card:nth-child(15) { background-color: #E15D44; } /* Rojo ladrillo cálido */

        .card h3 {
            font-size: 1em;
            color: #fff;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.5em;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            background-color: #0056b3;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="../assets/logo.png" alt="Logo">
        <h1>Sistema Educativo</h1>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <ul class="navbar-list">
            <li class="navbar-item"><a href="../modulos/profesores/index.php" class="navbar-link">Profesores</a></li>
            <li class="navbar-item"><a href="../modulos/estudiantes/index.php" class="navbar-link">Estudiantes</a></li>
            <li class="navbar-item"><a href="../modulos/materias/index.php" class="navbar-link">Materias</a></li>
            <li class="navbar-item"><a href="../modulos/matriculas/index.php" class="navbar-link">Matrículas</a></li>
            <li class="navbar-item"><a href="../modulos/prerrequisitos/index.php" class="navbar-link">Prerrequisitos</a></li>
            <li class="navbar-item"><a href="../modulos/congelamientos/index.php" class="navbar-link">Congelamientos</a></li>
            <li class="navbar-item"><a href="../modulos/departamentos/index.php" class="navbar-link">Departamentos</a></li>
            <li class="navbar-item"><a href="../modulos/horarios/index.php" class="navbar-link">Horarios</a></li>
            <li class="navbar-item"><a href="../modulos/asignaciones/index.php" class="navbar-link">Asignaciones</a></li>
        </ul>
        <button class="logout-button" onclick="window.location.href='../index.php'">Salir</button>
    </nav>

    <!-- Content -->
    <div class="content">
        <h2>Panel Informativo</h2>
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
                    <h3>$title</h3>
                    <p>$value</p>
                </div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Kyoiko. Todos los derechos reservados.
    </div>
</body>
</html>
