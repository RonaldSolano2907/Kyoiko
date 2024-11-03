<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM materias WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $materia = $stmt->fetch();

    if (!$materia) {
        echo "<div class='alert alert-danger'>Materia no encontrada.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creditos = $_POST['creditos'];

    $sql = "UPDATE materias SET nombre = :nombre, descripcion = :descripcion, creditos = :creditos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':descripcion' => $descripcion,
        ':creditos' => $creditos,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Materia actualizada correctamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Editar Materia</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $materia['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" name="descripcion" rows="3" required><?php echo $materia['descripcion']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="creditos">Créditos:</label>
            <input type="number" class="form-control" name="creditos" value="<?php echo $materia['creditos']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Materia</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
