<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

$sql = "SELECT * FROM direccion";
$stmt = $pdo->query($sql);
$direcciones = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Direcciones</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula Estudiante</th>
                <th>Provincia</th>
                <th>Cantón</th>
                <th>Distrito</th>
                <th>Dirección Exacta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($direcciones as $direccion): ?>
            <tr>
                <td><?php echo $direccion['id']; ?></td>
                <td><?php echo $direccion['cedula_estudiante']; ?></td>
                <td><?php echo $direccion['provincia']; ?></td>
                <td><?php echo $direccion['canton']; ?></td>
                <td><?php echo $direccion['distrito']; ?></td>
                <td><?php echo $direccion['direccion_exacta']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $direccion['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $direccion['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
