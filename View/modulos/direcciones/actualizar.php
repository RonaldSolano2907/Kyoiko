<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM direccion WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $direccion = $stmt->fetch();

    if (!$direccion) {
        echo "<div class='alert alert-danger'>Dirección no encontrada.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql = "UPDATE direccion SET provincia = :provincia, canton = :canton, distrito = :distrito, 
            direccion_exacta = :direccion_exacta WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':provincia' => $provincia,
        ':canton' => $canton,
        ':distrito' => $distrito,
        ':direccion_exacta' => $direccion_exacta,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Dirección actualizada correctamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Editar Dirección</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" class="form-control" name="provincia" value="<?php echo $direccion['provincia']; ?>" required>
        </div>
        <div class="form-group">
            <label for="canton">Cantón:</label>
            <input type="text" class="form-control" name="canton" value="<?php echo $direccion['canton']; ?>" required>
        </div>
        <div class="form-group">
            <label for="distrito">Distrito:</label>
            <input type="text" class="form-control" name="distrito" value="<?php echo $direccion['distrito']; ?>" required>
        </div>
        <div class="form-group">
            <label for="direccion_exacta">Dirección Exacta:</label>
            <textarea class="form-control" name="direccion_exacta" rows="3" required><?php echo $direccion['direccion_exacta']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Dirección</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
