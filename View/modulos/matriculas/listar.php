<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT matricula.*, estudiantes.nombre AS nombre_estudiante, estudiantes.apellidos, materias.nombre AS nombre_materia 
        FROM matricula
        JOIN estudiantes ON matricula.cedula_estudiante = estudiantes.cedula
        JOIN materias ON matricula.id_materia = materias.id";
$stmt = $pdo->query($sql);
$matriculas = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Matrículas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Semestre</th>
                <th>Año</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matriculas as $matricula): ?>
            <tr>
                <td><?php echo $matricula['id']; ?></td>
                <td><?php echo $matricula['nombre_estudiante'] . ' ' . $matricula['apellidos']; ?></td>
                <td><?php echo $matricula['nombre_materia']; ?></td>
                <td><?php echo $matricula['semestre']; ?></td>
                <td><?php echo $matricula['anio']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $matricula['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $matricula['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
