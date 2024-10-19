<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT a.id, p.nombre AS nombre_profesor, p.apellidos AS apellidos_profesor, m.nombre AS nombre_materia, a.semestre, a.anio 
        FROM asignacion a
        JOIN profesores p ON a.cedula_profesor = p.cedula
        JOIN materias m ON a.id_materia = m.id";
$stmt = $pdo->query($sql);
$asignaciones = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Asignaciones</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Profesor</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Año</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asignaciones as $asignacion): ?>
            <tr>
                <td><?php echo $asignacion['id']; ?></td>
                <td><?php echo $asignacion['nombre_profesor'] . ' ' . $asignacion['apellidos_profesor']; ?></td>
                <td><?php echo $asignacion['nombre_materia']; ?></td>
                <td><?php echo $asignacion['semestre']; ?></td>
                <td><?php echo $asignacion['anio']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $asignacion['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $asignacion['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
