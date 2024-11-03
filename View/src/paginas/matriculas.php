<?php
include '../includes/header.php';
include '../includes/sidebar.php';
include '../configuracion/conexion.php';
?>

<div class="main-content">
    <h2>Gestión de Matrículas</h2>

    <!-- Formulario para agregar una nueva matrícula -->
    <h3>Agregar Nueva Matrícula</h3>
    <form action="../operaciones/crear_matricula.php" method="POST">
        <label for="cedulaEstudiante">Cédula del Estudiante:</label>
        <input type="text" id="cedulaEstudiante" name="cedulaEstudiante" required><br>

        <label for="idMateria">ID de Materia:</label>
        <input type="text" id="idMateria" name="idMateria" required><br>

        <label for="semestre">Semestre:</label>
        <input type="number" id="semestre" name="semestre" required><br>

        <label for="anio">Año:</label>
        <input type="number" id="anio" name="anio" required><br>

        <button type="submit">Agregar Matrícula</button>
    </form>

    <!-- Tabla para listar matrículas existentes -->
    <h3>Lista de Matrículas</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Cédula Estudiante</th>
            <th>ID Materia</th>
            <th>Semestre</th>
            <th>Año</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Consulta para obtener todas las matrículas
        $sql = "SELECT CedulaEstudiante, IDMateria, Semestre, Año FROM Matricula";
        $result = $conn->query($sql);

        // Mostrar cada matrícula en una fila de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['CedulaEstudiante']}</td>
                    <td>{$row['IDMateria']}</td>
                    <td>{$row['Semestre']}</td>
                    <td>{$row['Año']}</td>
                    <td>
                        <a href='../operaciones/actualizar_matricula.php?cedulaEstudiante={$row['CedulaEstudiante']}&idMateria={$row['IDMateria']}&semestre={$row['Semestre']}&anio={$row['Año']}'>Editar</a> |
                        <a href='../operaciones/eliminar_matricula.php?cedulaEstudiante={$row['CedulaEstudiante']}&idMateria={$row['IDMateria']}&semestre={$row['Semestre']}&anio={$row['Año']}'>Eliminar</a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
