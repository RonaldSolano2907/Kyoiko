<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

$sql = "SELECT c.id, e.nombre, e.apellidos, c.motivo, c.fecha_inicio, c.fecha_fin 
        FROM congelamientos c
        JOIN estudiantes e ON c.cedula_estudiante = e.cedula";
$stmt = $pdo->query($sql);
$congelamientos = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Lista de Congelamientos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Motivo</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($congelamientos as $congelamiento): ?>
            <tr>
                <td><?php echo $congelamiento['id']; ?></td>
                <td><?php echo $congelamiento['nombre'] . ' ' . $congelamiento['apellidos']; ?></td>
                <td><?php echo $congelamiento['motivo']; ?></td>
                <td><?php echo $congelamiento['fecha_inicio']; ?></td>
                <td><?php echo $congelamiento['fecha_fin']; ?></td>
                <td>
                    <a href="actualizar.php?id=<?php echo $congelamiento['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $congelamiento['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
