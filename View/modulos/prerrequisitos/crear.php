<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $id_materia_principal = $_POST['id_materia_principal'];
    $id_materia_prerrequisito = $_POST['id_materia_prerrequisito'];

    $sql = "INSERT INTO prerrequisitos (id_materia_principal, id_materia_prerrequisito) 
            VALUES (:id_materia_principal, :id_materia_prerrequisito)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_materia_principal' => $id_materia_principal,
        ':id_materia_prerrequisito' => $id_materia_prerrequisito
    ]);

    echo "<div class='alert alert-success'>Prerrequisito registrado exitosamente.</div>";
}

// Obtener la lista de materias para mostrarlas en el formulario
$sql_materias = "SELECT id, nombre FROM materias";
$stmt_materias = $pdo->query($sql_materias);
$materias = $stmt_materias->fetchAll();
?>

<div class="container mt-4">
    <h2>Registrar Nuevo Prerrequisito</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="id_materia_principal">Materia Principal:</label>
            <select class="form-control" name="id_materia_principal" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>">
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_materia_prerrequisito">Prerrequisito:</label>
            <select class="form-control" name="id_materia_prerrequisito" required>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['id']; ?>">
                        <?php echo $materia['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="crear">Registrar Prerrequisito</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
