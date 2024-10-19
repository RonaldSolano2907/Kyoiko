<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_GET['id'])) {
    $id_materia = $_GET['id'];

    $sql_materia = "SELECT nombre FROM materias WHERE id = :id";
    $stmt_materia = $pdo->prepare($sql_materia);
    $stmt_materia->execute([':id' => $id_materia]);
    $materia = $stmt_materia->fetch();

    if (!$materia) {
        echo "<div class='alert alert-danger'>Materia no encontrada.</div>";
        exit;
    }

    $sql_prerrequisitos = "SELECT m.nombre AS nombre_prerrequisito 
                           FROM prerrequisitos p
                           JOIN materias m ON p.id_materia_prerrequisito = m.id
                           WHERE p.id_materia_principal = :id";
    $stmt_prerrequisitos = $pdo->prepare($sql_prerrequisitos);
    $stmt_prerrequisitos->execute([':id' => $id_materia]);
    $prerrequisitos = $stmt_prerrequisitos->fetchAll();
} else {
    echo "<div class='alert alert-danger'>No se proporcionó una materia válida.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2>Prerrequisitos de la Materia: <?php echo $materia['nombre']; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del Prerrequisito</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prerrequisitos as $prerrequisito): ?>
            <tr>
                <td><?php echo $prerrequisito['nombre_prerrequisito']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
