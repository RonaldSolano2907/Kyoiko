<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM prerrequisitos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $prerrequisito = $stmt->fetch();

    if (!$prerrequisito) {
        echo "<div class='alert alert-danger'>Prerrequisito no encontrado.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $id_materia_principal = $_POST['id_materia_principal'];
    $id_materia_prerrequisito = $_POST['id_materia_prerrequisito'];

    $sql = "UPDATE prerrequisitos SET id_materia_principal = :id_materia_principal, 
            id_materia_prerrequisito = :id_materia_prerrequisito WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_materia_principal' => $id_materia_principal,
        ':id_materia_prerrequisito' => $id_materia_prerrequisito,
        ':id' => $id
    ]);

    echo "<div class='alert alert-success'>Prerrequisito actualizado correctamente.</div>";
}

// Obtener la lista de materias para mostrarlas en el formulario
$sql_materias = "SELECT id, nombre FROM materias";
$stmt_materias = $pdo->query($sql_materias);
$materias = $stmt_materias->fetchAll();
?>

<div class="container mt-4">
    <h2>Editar Prerrequisito</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="id_materia_principal">Materia Principal:</label>
            <select class="form-control" name="id_materia_principal" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>" <?php if ($materia['id'] == $prerrequisito['id_materia_principal']) echo 'selected'; ?>>
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materia_prerrequisito">Prerrequisito:</label>
            <select class="form-control" name="id_materia_prerrequisito" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>" <?php if ($materia['id'] == $prerrequisito['id_materia_prerrequisito']) echo 'selected'; ?>>
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Prerrequisito</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
