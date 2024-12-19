<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Sistema Kyoiko</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #dc3545;
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .navbar {
            background-color: #343a40;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-menu {
            display: flex;
            gap: 1rem;
            list-style: none;
        }

        .nav-menu > li {
            position: relative;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: block;
            transition: background-color 0.3s;
        }

        .nav-menu > li > a:hover {
            background-color: #495057;
            border-radius: 4px;
        }

        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #343a40;
            border-radius: 4px;
            width: 220px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .nav-menu li:hover .submenu {
            display: block;
        }

        .submenu a {
            padding: 0.8rem 1.2rem;
            color: white;
            border-bottom: 1px solid #495057;
        }

        .submenu a:hover {
            background-color: #495057;
        }

        .stats-title {
            text-align: center;
            color: #343a40;
            margin: 2rem 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 0 1.5rem;
        }

        .card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #343a40;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .card p {
            font-size: 2rem;
            color: #343a40;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            margin: 1rem auto;
            max-width: 1200px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    include '../includes/db_connection.php';
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }

    $error = "";
    $datos = [];

    $procedures = [
        ['title' => 'Total Estudiantes Registrados', 'procedure' => 'TotalEstudiantesRegistrados'],
        ['title' => 'Estudiantes Activos', 'procedure' => 'TotalEstudiantesActivos'],
        ['title' => 'Estudiantes Inactivos', 'procedure' => 'TotalEstudiantesInactivos'],
        ['title' => 'Edad Promedio de Estudiantes', 'procedure' => 'EdadPromedioEstudiantes'],
        ['title' => 'Estudiantes con Matrícula Activa', 'procedure' => 'EstudiantesConMatriculaActiva'],
        ['title' => 'Total Profesores Registrados', 'procedure' => 'TotalProfesoresRegistrados'],
        ['title' => 'Total Materias Asignadas', 'procedure' => 'TotalMateriasAsignadas'],
        ['title' => 'Materias sin Prerrequisitos', 'procedure' => 'TotalMateriasSinPrerrequisitos'],
        ['title' => 'Promedio de Materias por Profesor', 'procedure' => 'PromedioMateriasPorProfesor'],
        ['title' => 'Profesores con Titulaciones Avanzadas', 'procedure' => 'ProfesoresConTitulacionesAvanzadas'],
        ['title' => 'Carga Horaria Promedio por Profesor', 'procedure' => 'CargaHorariaPromedioPorProfesor'],
        ['title' => 'Total de Materias Ofertadas', 'procedure' => 'TotalMateriasOfertadas'],
        ['title' => 'Materias con Cupo Disponible', 'procedure' => 'TotalMateriasConCupoDisponible'],
        ['title' => 'Promedio de Estudiantes por Materia', 'procedure' => 'PromedioEstudiantesPorMateria'],
        ['title' => 'Materias Más Demandadas', 'procedure' => 'MateriasMasDemandadas']
    ];
    

    try {
        foreach ($procedures as $proc) {
            $stmt = oci_parse($conn, "BEGIN {$proc['procedure']}(:resultado); END;");
            oci_bind_by_name($stmt, ":resultado", $resultado, 20);

            if (!oci_execute($stmt)) {
                $e = oci_error($stmt);
                throw new Exception("Error al ejecutar {$proc['procedure']}: " . $e['message']);
            }

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

    <header class="header">
        <h1>Panel de Control - Sistema Kyoiko</h1>
        <p>Gestión Académica Integral</p>
    </header>

    <nav class="navbar">
        <div class="nav-container">
            <ul class="nav-menu">
                <li>
                    <a href="#">Estudiantes</a>
                    <ul class="submenu">
                        <li><a href="../modulos/estudiantes/registro_estudiantes.php">Registro de Estudiantes</a></li>
                        <li><a href="../modulos/estudiantes/consultar_editar_estudiantes.php">Consultar y Editar</a></li>
                        <li><a href="../modulos/estudiantes/historial_academico.php">Historial Académico</a></li>
                        <li><a href="../modulos/estudiantes/reportes_estudiantes.php">Reportes y Estadísticas</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Profesores</a>
                    <ul class="submenu">
                        <li><a href="../modulos/profesores/registro_profesores.php">Registro de Profesores</a></li>
                        <li><a href="../modulos/profesores/asignaciones.php">Asignación de Materias</a></li>
                        <li><a href="../modulos/profesores/horarios.php">Gestión de Horarios</a></li>
                        <li><a href="../modulos/profesores/reportes_profesores.php">Reportes</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Materias</a>
                    <ul class="submenu">
                        <li><a href="../modulos/materias/registro_materias.php">Registro de Materias</a></li>
                        <li><a href="../modulos/materias/prerrequisitos.php">Gestión de Prerrequisitos</a></li>
                        <li><a href="../modulos/materias/plan_estudios.php">Plan de Estudios</a></li>
                        <li><a href="../modulos/materias/reportes_materias.php">Reportes</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Matrículas</a>
                    <ul class="submenu">
                        <li><a href="../modulos/matriculas/nueva_matricula.php">Nueva Matrícula</a></li>
                        <li><a href="../modulos/matriculas/congelamientos.php">Congelamientos</a></li>
                        <li><a href="../modulos/matriculas/retiros.php">Retiros</a></li>
                        <li><a href="../modulos/matriculas/reportes_matriculas.php">Reportes</a></li>
                    </ul>
                </li>
                <li>
                <a href="#">CRUDS</a>
<ul class="submenu">
    <li><a href="../modulos/estudiantes/index.php">Estudiantes</a></li>
    <li><a href="../modulos/profesores/index.php">Profesores</a></li>
    <li><a href="../modulos/departamentos/index.php">Departamentos</a></li>
    <li><a href="../modulos/materias/index.php">Materias</a></li>
    <li><a href="../modulos/prerrequisitos/index.php">Prerrequisitos</a></li>
    <li><a href="../modulos/horarios/index.php">Horarios</a></li>
    <li><a href="../modulos/matriculas/index.php">Matrículas</a></li>
    <li><a href="../modulos/congelamientos/index.php">Congelamientos</a></li>
    <li><a href="../modulos/direcciones/index.php">Direcciones</a></li>
</ul>

            
            <button class="logout-btn" onclick="window.location.href='../includes/logout.php'">Cerrar Sesión</button>
        </div>
    </nav>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>
        <h2 class="stats-title">Estadísticas Generales del Sistema</h2>
        <div class="dashboard">
            <?php foreach ($datos as $dato): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($dato['title']) ?></h3>
                    <p><?= htmlspecialchars($dato['value']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Sistema Kyoiko - Todos los derechos reservados</p>
    </footer>
</body>
</html>