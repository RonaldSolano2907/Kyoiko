<?php
include '../includes/header.php';
include '../includes/sidebar.php';
include '../configuracion/conexion.php';
?>

<div class="main-content">
    <h2>Gestión de Materias</h2>

    <!-- Formulario para agregar una nueva materia -->
    <h3>Agregar Nueva Materia</h3>
    <form action="../operaciones/crear_materia.php" method="POST">
        <label for="idMateria">ID Materia:</label>
        <input type="text" id="idMateria" name="idMateria" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="creditos">Créditos:</label>
        <input type="number" id="creditos" name="creditos" required><br>

        <label for="semestre">Semestre:</label>
        <input type="number" id="semestre" name="semestre" required><br>

        <button type="submit">Agregar Materia</button>
    </form>

    <!-- Tabla para listar materias existentes -->
    <h3>Lista de Materias</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Materia</th>
            <th>Nombre</th>
            <th>Créditos</th>
            <th>Semestre</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Consulta para obtener todas las materias
        $sql = "SELECT IDMateria, Nombre, Creditos, Semestre FROM Materia";
        $result = $conn->query($sql);

        // Mostrar cada materia en una fila de la tabla
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['IDMateria']}</td>
                    <td>{$row['Nombre']}</td>
                    <td>{$row['Creditos']}</td>
                    <td>{$row['Semestre']}</td>
                    <td>
                        <a href='../operaciones/actualizar_materia.php?idMateria={$row['IDMateria']}'>Editar</a> |
                        <a href='../operaciones/eliminar_materia.php?idMateria={$row['IDMateria']}'>Eliminar</a>
                    </td>
                  </tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
