<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT estudiantes.*, direccion.provincia, direccion.canton, direccion.distrito, direccion.direccion_exacta 
        FROM estudiantes 
        LEFT JOIN direccion ON estudiantes.cedula = direccion.cedula_estudiante";
$stmt = $pdo->query($sql);
$estudiantes = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Estudiantes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo Electrónico</th>
                <th>Provincia</th>
                <th>Cantón</th>
                <th>Distrito</th>
                <th>Dirección Exacta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $estudiante): ?>
            <tr>
                <td><?php echo $estudiante['id']; ?></td>
                <td><?php echo $estudiante['cedula']; ?></td>
                <td><?php echo $estudiante['nombre']; ?></td>
                <td><?php echo $estudiante['apellidos']; ?></td>
                <td><?php echo $estudiante['correo_electronico']; ?></td>
                <td><?php echo $estudiante['provincia']; ?></td>
                <td><?php echo $estudiante['canton']; ?></td>
                <td><?php echo $estudiante['distrito']; ?></td>
                <td><?php echo $estudiante['direccion_exacta']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $estudiante['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="ver_matriculas.php?cedula=<?php echo $estudiante['cedula']; ?>" class="btn btn-sm btn-info">Ver Matrículas</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
