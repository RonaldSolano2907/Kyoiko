<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_GET['cedula'])) {
    $cedula_estudiante = $_GET['cedula'];

    $sql_estudiante = "SELECT nombre, apellidos FROM estudiantes WHERE cedula = :cedula";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([':cedula' => $cedula_estudiante]);
    $estudiante = $stmt_estudiante->fetch();

    if (!$estudiante) {
        echo "<div class='alert alert-danger'>Estudiante no encontrado.</div>";
        exit;
    }

    $sql_matriculas = "SELECT m.nombre AS nombre_materia, ma.semestre, ma.anio 
                       FROM matricula ma
                       JOIN materias m ON ma.id_materia = m.id
                       WHERE ma.cedula_estudiante = :cedula";
    $stmt_matriculas = $pdo->prepare($sql_matriculas);
    $stmt_matriculas->execute([':cedula' => $cedula_estudiante]);
    $materias = $stmt_matriculas->fetchAll();
} else {
    echo "<div class='alert alert-danger'>No se proporcionó un estudiante válido.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2>Materias Inscritas por <?php echo $estudiante['nombre'] . ' ' . $estudiante['apellidos']; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre de la Materia</th>
                <th>Semestre</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?php echo $materia['nombre_materia']; ?></td>
                <td><?php echo $materia['semestre']; ?></td>
                <td><?php echo $materia['anio']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
