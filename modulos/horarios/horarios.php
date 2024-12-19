<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Horarios</title>
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
        <h1>Gestión de Horarios</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="#">Horarios</a></li>
            <li><a href="logout.php">Salir</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Mensajes de éxito o error -->
        <?php if (isset($_GET['success'])) echo "<p style='color: green;'>{$_GET['success']}</p>"; ?>
        <?php if (isset($_GET['error'])) echo "<p style='color: red;'>{$_GET['error']}</p>"; ?>

        <!-- Formulario de creación o edición -->
        <h2><?php echo isset($data) ? 'Editar Horario' : 'Agregar Horario'; ?></h2>
        <form method="post">
            <label for="id_materia">ID Materia:</label>
            <input type="number" name="id_materia" id="id_materia" value="<?php echo $data['IDMATERIA'] ?? ''; ?>" required>

            <label for="aula">Aula:</label>
            <input type="text" name="aula" id="aula" value="<?php echo $data['AULA'] ?? ''; ?>" required>

            <label for="horario_inicio">Horario Inicio:</label>
            <input type="datetime-local" name="horario_inicio" id="horario_inicio" value="<?php echo isset($data['HORARIOINICIO']) ? date('Y-m-d\TH:i', strtotime($data['HORARIOINICIO'])) : ''; ?>" required>

            <label for="horario_fin">Horario Fin:</label>
            <input type="datetime-local" name="horario_fin" id="horario_fin" value="<?php echo isset($data['HORARIOFIN']) ? date('Y-m-d\TH:i', strtotime($data['HORARIOFIN'])) : ''; ?>" required>

            <label for="dia_semana">Día de la Semana:</label>
            <select name="dia_semana" id="dia_semana" required>
                <?php
                    $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                    foreach ($dias as $dia) {
                        $selected = (isset($data['DIASEMANA']) && $data['DIASEMANA'] === $dia) ? 'selected' : '';
                        echo "<option value='$dia' $selected>$dia</option>";
                    }
                ?>
            </select>

            <button type="submit">Guardar</button>
        </form>

        <!-- Listado de horarios -->
        <h2>Listado de Horarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Materia</th>
                    <th>Aula</th>
                    <th>Horario Inicio</th>
                    <th>Horario Fin</th>
                    <th>Día de la Semana</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($horarios as $horario) {
                    echo "<tr>";
                    echo "<td>{$horario['ID']}</td>";
                    echo "<td>{$horario['IDMATERIA']}</td>";
                    echo "<td>{$horario['AULA']}</td>";
                    echo "<td>{$horario['HORARIOINICIO']}</td>";
                    echo "<td>{$horario['HORARIOFIN']}</td>";
                    echo "<td>{$horario['DIASEMANA']}</td>";
                    echo "<td class='actions'>
                            <a href='?editar={$horario['ID']}'>Editar</a>
                            <a href='?eliminar={$horario['ID']}' style='color: red;'>Eliminar</a>
                          </td>";
                    echo "</tr>";
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
