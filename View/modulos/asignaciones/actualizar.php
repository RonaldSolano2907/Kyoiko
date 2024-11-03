<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM asignacion WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $asignacion = $stmt->fetch();

    if (!$asignacion) {
        echo "<div class='alert alert-danger'>Asignación no encontrada.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $cedula_profesor = $_POST['cedula_profesor'];
    $id_materia = $_POST['id_materia'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    $sql = "UPDATE asignacion SET cedula_profesor = :cedula_profesor, id_materia = :id_materia, semestre = :semestre, 
            anio = :anio WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_profesor' => $cedula_profesor,
        ':id_materia' => $id_materia,
        ':semestre' => $semestre,
        ':anio' => $anio,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Asignación actualizada correctamente.</div>";
}

// Obtener la lista de profesores y materias para mostrarlas en el formulario
$sql_profesores = "SELECT cedula, nombre, apellidos FROM profesores";
$stmt_profesores = $pdo->query($sql_profesores);
$profesores = $stmt_profesores->fetchAll();

$sql_materias = "SELECT id, nombre FROM materias";
$stmt_materias = $pdo->query($sql_materias);
$materias = $stmt_materias->fetchAll();
?>

<div class="container mt-4">
    <h2>Editar Asignación</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="cedula_profesor">Profesor:</label>
            <select class="form-control" name="cedula_profesor" required>
                <?php foreach ($profesores as $profesor): ?>
                    <option value="<?php echo $profesor['cedula']; ?>" <?php if ($profesor['cedula'] == $asignacion['cedula_profesor']) echo 'selected'; ?>>
                        <?php echo $profesor['cedula'] . ' - ' . $profesor['nombre'] . ' ' . $profesor['apellidos']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materia">Materia:</label>
            <select class="form-control" name="id_materia" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>" <?php if ($materia['id'] == $asignacion['id_materia']) echo 'selected'; ?>>
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="semestre">Semestre:</label>
            <input type="text" class="form-control" name="semestre" value="<?php echo $asignacion['semestre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" class="form-control" name="anio" value="<?php echo $asignacion['anio']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Asignación</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
