<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $cedula_profesor = $_POST['cedula_profesor'];
    $id_materia = $_POST['id_materia'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    $sql = "INSERT INTO asignacion (cedula_profesor, id_materia, semestre, anio) 
            VALUES (:cedula_profesor, :id_materia, :semestre, :anio)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_profesor' => $cedula_profesor,
        ':id_materia' => $id_materia,
        ':semestre' => $semestre,
        ':anio' => $anio
    ]);

    echo "<div class='alert alert-success'>Asignación registrada exitosamente.</div>";
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
    <h2>Registrar Nueva Asignación</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="cedula_profesor">Profesor:</label>
            <select class="form-control" name="cedula_profesor" required>
                <?php foreach ($profesores as $profesor): ?>
                    <option value="<?php echo $profesor['cedula']; ?>">
                        <?php echo $profesor['cedula'] . ' - ' . $profesor['nombre'] . ' ' . $profesor['apellidos']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materia">Materia:</label>
            <select class="form-control" name="id_materia" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>">
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="semestre">Semestre:</label>
            <input type="text" class="form-control" name="semestre" required>
        </div>
        <div class="form-group">
            <label for="anio">Año:</label>
            <input type="number" class="form-control" name="anio" required>
        </div>
        <button type="submit" class="btn btn-primary" name="crear">Registrar Asignación</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
