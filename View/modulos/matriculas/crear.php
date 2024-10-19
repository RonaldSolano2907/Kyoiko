<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $cedula_estudiante = $_POST['cedula_estudiante'];
    $id_materia = $_POST['id_materia'];
    $semestre = $_POST['semestre'];
    $anio = $_POST['anio'];

    $sql = "INSERT INTO matricula (cedula_estudiante, id_materia, semestre, anio) 
            VALUES (:cedula_estudiante, :id_materia, :semestre, :anio)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula_estudiante' => $cedula_estudiante,
        ':id_materia' => $id_materia,
        ':semestre' => $semestre,
        ':anio' => $anio
    ]);

    echo "<div class='alert alert-success'>Matrícula registrada exitosamente.</div>";
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
    <h2>Registrar Nueva Matrícula</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="cedula_estudiante">Estudiante:</label>
            <select class="form-control" name="cedula_estudiante" required>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?php echo $estudiante['cedula']; ?>">
                        <?php echo $estudiante['cedula'] . ' - ' . $estudiante['nombre'] . ' ' . $estudiante['apellidos']; ?>
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
        <button type="submit" class="btn btn-primary" name="crear">Registrar Matrícula</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
