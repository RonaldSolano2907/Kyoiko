<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT * FROM profesores";
$stmt = $pdo->query($sql);
$profesores = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Profesores</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Título Académico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profesores as $profesor): ?>
            <tr>
                <td><?php echo $profesor['id']; ?></td>
                <td><?php echo $profesor['cedula']; ?></td>
                <td><?php echo $profesor['nombre']; ?></td>
                <td><?php echo $profesor['apellidos']; ?></td>
                <td><?php echo $profesor['correo_electronico']; ?></td>
                <td><?php echo $profesor['telefono']; ?></td>
                <td><?php echo $profesor['titulo_academico']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $profesor['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $profesor['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="ver_asignaciones.php?cedula=<?php echo $profesor['cedula']; ?>" class="btn btn-sm btn-info">Ver Asignaciones</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
