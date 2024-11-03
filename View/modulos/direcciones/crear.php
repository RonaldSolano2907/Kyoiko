<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 
?>

<div class="container mt-4">
    <h2>Registrar Dirección del Estudiante</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="cedula_estudiante">Cédula del Estudiante:</label>
            <input type="text" class="form-control" name="cedula_estudiante" required>
        </div>
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" class="form-control" name="provincia" required>
        </div>
        <div class="form-group">
            <label for="canton">Cantón:</label>
            <input type="text" class="form-control" name="canton" required>
        </div>
        <div class="form-group">
            <label for="distrito">Distrito:</label>
            <input type="text" class="form-control" name="distrito" required>
        </div>
        <div class="form-group">
            <label for="direccion_exacta">Dirección Exacta:</label>
            <textarea class="form-control" name="direccion_exacta" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="crear_direccion">Crear Dirección</button>
    </form>
</div>

<?php 
if (isset($_POST['crear_direccion'])) {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql = "INSERT INTO direccion (cedula_estudiante, provincia, canton, distrito, direccion_exacta) 
            VALUES (:cedula_estudiante, :provincia, :canton, :distrito, :direccion_exacta)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_estudiante' => $cedula_estudiante,
        ':provincia' => $provincia,
        ':canton' => $canton,
        ':distrito' => $distrito,
        ':direccion_exacta' => $direccion_exacta
    ]);

    echo "<div class='alert alert-success'>Dirección registrada exitosamente.</div>";
}

include '../../includes/footer.php'; 
?>
