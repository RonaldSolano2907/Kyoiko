<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Estudiantes</title>
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
            justify-content: space-between;
            align-items: center;
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
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin: 20px 0;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, select, button {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        button {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #c82333;
        }
        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Estudiantes</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Estudiantes</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Mensajes de éxito o error -->
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

        <!-- Formulario de creación o edición -->
        <h2><?php echo isset($data) ? 'Editar Estudiante' : 'Agregar Estudiante'; ?></h2>
        <form method="post">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" value="<?php echo $data['CEDULA'] ?? ''; ?>" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $data['NOMBRE'] ?? ''; ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="<?php echo $data['APELLIDOS'] ?? ''; ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo $data['TELEFONO'] ?? ''; ?>">

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $data['FECHANACIMIENTO'] ?? ''; ?>">

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" id="correo" value="<?php echo $data['CORREO'] ?? ''; ?>">

            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                <option value="activo" <?php echo (isset($data['ESTADO']) && $data['ESTADO'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo (isset($data['ESTADO']) && $data['ESTADO'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <button type="submit">Guardar</button>
        </form>

        <!-- Listado de estudiantes -->
        <h2>Listado de Estudiantes</h2>
<table>
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Fecha de Nacimiento</th>
            <th>Correo Electrónico</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterar sobre los estudiantes para mostrarlos en la tabla
        if (isset($estudiantes) && !empty($estudiantes)) {
            foreach ($estudiantes as $estudiante) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($estudiante['CEDULA']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['NOMBRE']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['APELLIDOS']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['TELEFONO']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['FECHANACIMIENTO']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['CORREO']) . "</td>";
                echo "<td>" . htmlspecialchars($estudiante['ESTADO']) . "</td>";
                echo "<td class='actions'>
                        <a href='?editar=" . urlencode($estudiante['CEDULA']) . "'>Editar</a>
                        <a href='?eliminar=" . urlencode($estudiante['CEDULA']) . "' style='color: red;'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8' style='text-align: center;'>No hay estudiantes registrados.</td></tr>";
        }
        ?>
    </tbody>
</table>
</div>

<footer>
    <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
</footer>

</body>
</html>
