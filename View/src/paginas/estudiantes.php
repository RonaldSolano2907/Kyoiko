<?php
include '../includes/header.php';
include '../includes/sidebar.php';
include '../configuracion/conexion.php';
?>

<div class="main-content">
    <h2>Gestión de Estudiantes</h2>

    <!-- Formulario para agregar un nuevo estudiante -->
    <h3>Agregar Nuevo Estudiante</h3>
    <form action="../operaciones/crear_estudiante.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono"><br>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento"><br>

        <label for="correoElectronico">Correo Electrónico:</label>
        <input type="email" id="correoElectronico" name="correoElectronico"><br>

        <button type="submit">Agregar Estudiante</button>
    </form>

    <!-- Tabla para listar estudiantes existentes -->
    <h3>Lista de Estudiantes</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Consulta para obtener todos los estudiantes
        $sql = "SELECT Cedula, Nombre, Apellidos, Telefono, CorreoElectronico FROM Estudiante";
        $result = $conn->query($sql);

        // Mostrar cada estudiante en una fila de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Cedula']}</td>
                    <td>{$row['Nombre']}</td>
                    <td>{$row['Apellidos']}</td>
                    <td>{$row['Telefono']}</td>
                    <td>{$row['CorreoElectronico']}</td>
                    <td>
                        <a href='../operaciones/actualizar_estudiante.php?cedula={$row['Cedula']}'>Editar</a> |
                        <a href='../operaciones/eliminar_estudiante.php?cedula={$row['Cedula']}'>Eliminar</a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
