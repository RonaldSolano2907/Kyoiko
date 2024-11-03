<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT p.id, m1.nombre AS materia_principal, m2.nombre AS prerrequisito 
        FROM prerrequisitos p
        JOIN materias m1 ON p.id_materia_principal = m1.id
        JOIN materias m2 ON p.id_materia_prerrequisito = m2.id";
$stmt = $pdo->query($sql);
$prerrequisitos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Prerrequisitos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Materia Principal</th>
                <th>Prerrequisito</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prerrequisitos as $prerrequisito): ?>
            <tr>
                <td><?php echo $prerrequisito['id']; ?></td>
                <td><?php echo $prerrequisito['materia_principal']; ?></td>
                <td><?php echo $prerrequisito['prerrequisito']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $prerrequisito['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $prerrequisito['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
