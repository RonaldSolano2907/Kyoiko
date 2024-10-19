<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM congelamientos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $congelamiento = $stmt->fetch();

    if (!$congelamiento) {
        echo "<div class='alert alert-danger'>Congelamiento no encontrado.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $motivo = $_POST['motivo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $sql = "UPDATE congelamientos SET cedula_estudiante = :cedula_estudiante, motivo = :motivo, 
            fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_estudiante' => $cedula_estudiante,
        ':motivo' => $motivo,
        ':fecha_inicio' => $fecha_inicio,
        ':fecha_fin' => $fecha_fin,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Congelamiento actualizado correctamente.</div>";
}

// Obtener la lista de estudiantes para mostrarlas en el formulario
$sql_estudiantes = "SELECT cedula, nombre, apellidos FROM estudiantes";
$stmt_estudiantes = $pdo->query($sql_estudiantes);
$estudiantes = $stmt_estudiantes->fetchAll();
?>

<div class="container mt-4">
    <h2>Editar Congelamiento</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="cedula_estudiante">Estudiante:</label>
            <select class="form-control" name="cedula_estudiante" required>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?php echo $estudiante['cedula']; ?>" <?php if ($estudiante['cedula'] == $congelamiento['cedula_estudiante']) echo 'selected'; ?>>
                        <?php echo $estudiante['cedula'] . ' - ' . $estudiante['nombre'] . ' ' . $estudiante['apellidos']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="motivo">Motivo:</label>
            <input type="text" class="form-control" name="motivo" value="<?php echo $congelamiento['motivo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $congelamiento['fecha_inicio']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" class="form-control" name="fecha_fin" value="<?php echo $congelamiento['fecha_fin']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Congelamiento</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
