<?php
include '../includes/db_connection.php';

// Inicializar la variable de error o éxito
$success = isset($_GET['success']) ? $_GET['success'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;

// Consultar las asignaciones
$query = "SELECT * FROM Asignacion";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/asignaciones.css">
    <title>Lista de Asignaciones</title>
</head>
<body>
    <div class="sidebar">
        <h2>Gestión de Asignaciones</h2>
        <ul>
            <li><a href="create.php">Crear Asignación</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Lista de Asignaciones</h1>

        <!-- Mensajes de éxito o error -->
        <?php if ($success): ?>
            <div class="success">La operación se realizó con éxito.</div>
        <?php elseif ($error): ?>
            <div class="error">Ocurrió un error al realizar la operación.</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID Materia</th>
                    <th>Cédula Profesor</th>
                    <th>Semestre</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = oci_fetch_assoc($stmt)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['IDMATERIA']) ?></td>
                        <td><?= htmlspecialchars($row['CEDULAPROFESOR']) ?></td>
                        <td><?= htmlspecialchars($row['SEMESTRE']) ?></td>
                        <td><?= htmlspecialchars($row['ANIO']) ?></td>
                        <td>
                            <a href="edit.php?IDMateria=<?= $row['IDMATERIA'] ?>&CedulaProfesor=<?= $row['CEDULAPROFESOR'] ?>&Semestre=<?= $row['SEMESTRE'] ?>&Anio=<?= $row['ANIO'] ?>">Editar</a>
                            <a href="delete.php?IDMateria=<?= $row['IDMATERIA'] ?>&CedulaProfesor=<?= $row['CEDULAPROFESOR'] ?>&Semestre=<?= $row['SEMESTRE'] ?>&Anio=<?= $row['ANIO'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta asignación?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
oci_free_statement($stmt);
oci_close($conn);
?>
