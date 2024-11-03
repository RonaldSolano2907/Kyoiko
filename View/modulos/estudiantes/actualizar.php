<?php 
include '../../includes/header.php';
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_estudiante = "SELECT * FROM estudiantes WHERE id = :id";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([':id' => $id]);
    $estudiante = $stmt_estudiante->fetch();

    $sql_direccion = "SELECT * FROM direccion WHERE cedula_estudiante = :cedula";
    $stmt_direccion = $pdo->prepare($sql_direccion);
    $stmt_direccion->execute([':cedula' => $estudiante['cedula']]);
    $direccion = $stmt_direccion->fetch();

    if (!$estudiante) {
        echo "<div class='alert alert-danger'>Estudiante no encontrado.</div>";
        exit;
    }
}

if (isset($_POST['actualizar'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql_estudiante = "UPDATE estudiantes SET cedula = :cedula, nombre = :nombre, apellidos = :apellidos, 
                      fecha_nacimiento = :fecha_nacimiento, correo_electronico = :correo_electronico, 
                      telefono = :telefono, estado = :estado WHERE id = :id";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':correo_electronico' => $correo_electronico,
        ':telefono' => $telefono,
        ':estado' => $estado,
        ':id' => $id
    ]);

    $sql_direccion = "UPDATE direccion SET provincia = :provincia, canton = :canton, distrito = :distrito, 
                      direccion_exacta = :direccion_exacta WHERE cedula_estudiante = :cedula";
    $stmt_direccion = $pdo->prepare($sql_direccion);
    $stmt_direccion->execute([
        ':provincia' => $provincia,
        ':canton' => $canton,
        ':distrito' => $distrito,
        ':direccion_exacta' => $direccion_exacta,
        ':cedula' => $cedula
    ]);

    echo "<div class='alert alert-success'>Estudiante y dirección actualizados correctamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Editar Estudiante</h2>
    <form action="actualizar.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" name="cedula" value="<?php echo $estudiante['cedula']; ?>" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $estudiante['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" value="<?php echo $estudiante['apellidos']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $estudiante['fecha_nacimiento']; ?>">
        </div>
        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo_electronico" value="<?php echo $estudiante['correo_electronico']; ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" value="<?php echo $estudiante['telefono']; ?>">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" name="estado">
                <option value="activo" <?php if ($estudiante['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                <option value="inactivo" <?php if ($estudiante['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
            </select>
        </div>
        <h3>Dirección</h3>
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" class="form-control" name="provincia" value="<?php echo $direccion['provincia']; ?>" required>
        </div>
        <div class="form-group">
            <label for="canton">Cantón:</label>
            <input type="text" class="form-control" name="canton" value="<?php echo $direccion['canton']; ?>" required>
        </div>
        <div class="form-group">
            <label for="distrito">Distrito:</label>
            <input type="text" class="form-control" name="distrito" value="<?php echo $direccion['distrito']; ?>" required>
        </div>
        <div class="form-group">
            <label for="direccion_exacta">Dirección Exacta:</label>
            <textarea class="form-control" name="direccion_exacta" rows="3" required><?php echo $direccion['direccion_exacta']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar Estudiante</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
