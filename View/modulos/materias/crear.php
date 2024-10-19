<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creditos = $_POST['creditos'];

    $sql = "INSERT INTO materias (nombre, descripcion, creditos) VALUES (:nombre, :descripcion, :creditos)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':creditos' => $creditos
    ]);

    echo "<div class='alert alert-success'>Materia registrada exitosamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Registrar Nueva Materia</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="creditos">Créditos:</label>
            <input type="number" class="form-control" name="creditos" required>
        </div>
        <button type="submit" class="btn btn-primary" name="crear">Registrar Materia</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
