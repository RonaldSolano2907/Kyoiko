<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT * FROM materias";
$stmt = $pdo->query($sql);
$materias = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Materias</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Créditos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?php echo $materia['id']; ?></td>
                <td><?php echo $materia['nombre']; ?></td>
                <td><?php echo $materia['descripcion']; ?></td>
                <td><?php echo $materia['creditos']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $materia['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $materia['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="ver_prerrequisitos.php?id=<?php echo $materia['id']; ?>" class="btn btn-sm btn-info">Ver Prerrequisitos</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
