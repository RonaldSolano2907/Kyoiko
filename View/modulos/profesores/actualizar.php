<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM profesores WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $profesor = $stmt->fetch();

    if (!$profesor) {
        echo "<div class='alert alert-danger'>Profesor no encontrado.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $titulo_academico = $_POST['titulo_academico'];

    $sql = "UPDATE profesores SET cedula = :cedula, nombre = :nombre, apellidos = :apellidos, 
            correo_electronico = :correo_electronico, telefono = :telefono, titulo_academico = :titulo_academico 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':correo_electronico' => $correo_electronico,
        ':telefono' => $telefono,
        ':titulo_academico' => $titulo_academico,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Profesor actualizado correctamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Editar Profesor</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" name="cedula" value="<?php echo $profesor['cedula']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $profesor['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" value="<?php echo $profesor['apellidos']; ?>" required>
        </div>
        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo_electronico" value="<?php echo $profesor['correo_electronico']; ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" value="<?php echo $profesor['telefono']; ?>">
        </div>
        <div class="form-group">
            <label for="titulo_academico">Título Académico:</label>
            <input type="text" class="form-control" name="titulo_academico" value="<?php echo $profesor['titulo_academico']; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Profesor</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
