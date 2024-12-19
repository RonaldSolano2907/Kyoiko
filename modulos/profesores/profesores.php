<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #000;
            padding: 10px;
            display: flex;
            justify-content: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav li {
            margin: 0 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #dc3545;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-create {
            background-color: #28a745;
            color: white;
        }
        .btn-create:hover {
            background-color: #218838;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Gestión de Profesores</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="index.php">Profesores</a></li>
        </ul>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        <h2>Listado de Profesores</h2>
        <a href="?crear" class="btn btn-create">Crear Profesor</a>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Departamento</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Título Académico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los datos de los profesores
                foreach ($profesores as $profesor): ?>
                    <tr>
                        <td><?= htmlspecialchars($profesor['CEDULA']) ?></td>
                        <td><?= htmlspecialchars($profesor['IDDEPARTAMENTO']) ?></td>
                        <td><?= htmlspecialchars($profesor['NOMBRE']) ?></td>
                        <td><?= htmlspecialchars($profesor['APELLIDOS']) ?></td>
                        <td><?= htmlspecialchars($profesor['TELEFONO']) ?></td>
                        <td><?= htmlspecialchars($profesor['CORREOELECTRONICO']) ?></td>
                        <td><?= htmlspecialchars($profesor['TITULOACADEMICO']) ?></td>
                        <td>
                            <a href="?editar=<?= urlencode($profesor['CEDULA']) ?>" class="btn btn-edit">Editar</a>
                            <a href="?eliminar=<?= urlencode($profesor['CEDULA']) ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar este profesor?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>

    <?php
    // Procesar las acciones de CRUD
    if (isset($_GET['crear'])) {
        // Código para crear profesor
        include 'create.php';
    } elseif (isset($_GET['editar'])) {
        // Código para editar profesor
        include 'edit.php';
    } elseif (isset($_GET['eliminar'])) {
        // Código para eliminar profesor
        $cedula = $_GET['eliminar'];
        $sql = "BEGIN PaqueteProfesor.EliminarProfesor(:cedula); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':cedula', $cedula);
        if (oci_execute($stmt)) {
            oci_commit($conn);
            header('Location: index.php?success=Profesor eliminado');
        } else {
            echo "<p>Error al eliminar profesor: " . htmlentities(oci_error($stmt)['message']) . "</p>";
        }
        oci_free_statement($stmt);
    }
    ?>
</body>
</html>
