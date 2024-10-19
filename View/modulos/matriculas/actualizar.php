<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM matricula WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $matricula = $stmt->fetch();

    if (!$matricula) {
        echo "<div class='alert alert-danger'>Matrícula no encontrada.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $id_materia = $_POST['id_materia'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    $sql = "UPDATE matricula SET cedula_estudiante = :cedula_estudiante, id_materia = :id_materia, semestre = :semestre, 
            anio = :anio WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_estudiante' => $cedula_estudiante,
        ':id_materia' => $id_materia,
        ':semestre' => $semestre,
        ':anio' => $anio,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Matrícula actualizada correctamente.</div>";
}

// Obtener la lista de estudiantes y materias para mostrarlas en el formulario
$sql_estudiantes = "SELECT cedula, nombre, apellidos FROM estudiantes";
$stmt_estudiantes = $pdo->query($sql_estudiantes);
$estudiantes = $stmt_estudiantes->fetchAll();

$sql_materias = "SELECT id, nombre FROM materias";
$stmt_materias = $pdo->query($sql_materias);
$materias = $stmt_materias->fetchAll();
?>

<div class="container mt-4">
    <h2>Editar Matrícula</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="cedula_estudiante">Estudiante:</label>
            <select class="form-control" name="cedula_estudiante" required>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?php echo $estudiante['cedula']; ?>" <?php if ($estudiante['cedula'] == $matricula['cedula_estudiante']) echo 'selected'; ?>>
                        <?php echo $estudiante['cedula'] . ' - ' . $estudiante['nombre'] . ' ' . $estudiante['apellidos']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materia">Materia:</label>
            <select class="form-control" name="id_materia" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>" <?php if ($materia['id'] == $matricula['id_materia']) echo 'selected'; ?>>
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="semestre">Semestre:</label>
            <input type="text" class="form-control" name="semestre" value="<?php echo $matricula['semestre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" class="form-control" name="anio" value="<?php echo $matricula['anio']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Matrícula</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
