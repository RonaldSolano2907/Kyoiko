<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_GET['cedula'])) {
    $cedula_profesor = $_GET['cedula'];

    $sql_profesor = "SELECT nombre, apellidos FROM profesores WHERE cedula = :cedula";
    $stmt_profesor = $pdo->prepare($sql_profesor);
    $stmt_profesor->execute([':cedula' => $cedula_profesor]);
    $profesor = $stmt_profesor->fetch();

    if (!$profesor) {
        echo "<div class='alert alert-danger'>Profesor no encontrado.</div>";
        exit;
    }

    $sql_asignaciones = "SELECT m.nombre AS nombre_materia, a.semestre, a.anio 
                         FROM asignacion a
                         JOIN materias m ON a.id_materia = m.id
                         WHERE a.cedula_profesor = :cedula";
    $stmt_asignaciones = $pdo->prepare($sql_asignaciones);
    $stmt_asignaciones->execute([':cedula' => $cedula_profesor]);
    $asignaciones = $stmt_asignaciones->fetchAll();
} else {
    echo "<div class='alert alert-danger'>No se proporcionó un profesor válido.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2>Materias Asignadas al Profesor: <?php echo $profesor['nombre'] . ' ' . $profesor['apellidos']; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre de la Materia</th>
                <th>Semestre</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asignaciones as $asignacion): ?>
            <tr>
                <td><?php echo $asignacion['nombre_materia']; ?></td>
                <td><?php echo $asignacion['semestre']; ?></td>
                <td><?php echo $asignacion['anio']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
