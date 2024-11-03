<?php
include '../includes/header.php';
include '../includes/sidebar.php';
include '../configuracion/conexion.php';
?>

<div class="main-content">
    <h2>Gestión de Profesores</h2>

    <!-- Formulario para agregar un nuevo profesor -->
    <h3>Agregar Nuevo Profesor</h3>
    <form action="../operaciones/crear_profesor.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono"><br>

        <label for="correoElectronico">Correo Electrónico:</label>
        <input type="email" id="correoElectronico" name="correoElectronico"><br>

        <label for="tituloAcademico">Título Académico:</label>
        <input type="text" id="tituloAcademico" name="tituloAcademico"><br>

        <button type="submit">Agregar Profesor</button>
    </form>

    <!-- Tabla para listar profesores existentes -->
    <h3>Lista de Profesores</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Correo Electrónico</th>
            <th>Título Académico</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Consulta para obtener todos los profesores
        $sql = "SELECT Cedula, Nombre, Apellidos, Telefono, CorreoElectronico, TituloAcademico FROM Profesor";
        $result = $conn->query($sql);

        // Mostrar cada profesor en una fila de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['Cedula']}</td>
                    <td>{$row['Nombre']}</td>
                    <td>{$row['Apellidos']}</td>
                    <td>{$row['Telefono']}</td>
                    <td>{$row['CorreoElectronico']}</td>
                    <td>{$row['TituloAcademico']}</td>
                    <td>
                        <a href='../operaciones/actualizar_profesor.php?cedula={$row['Cedula']}'>Editar</a> |
                        <a href='../operaciones/eliminar_profesor.php?cedula={$row['Cedula']}'>Eliminar</a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
