<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];
    $fecha_inscripcion = date('Y-m-d');

    $provincia = $_POST['provincia'];
    $canton = $_POST['canton'];
    $distrito = $_POST['distrito'];
    $direccion_exacta = $_POST['direccion_exacta'];

    $sql_estudiante = "INSERT INTO estudiantes (cedula, nombre, apellidos, fecha_nacimiento, correo_electronico, telefono, estado, fecha_inscripcion) 
                       VALUES (:cedula, :nombre, :apellidos, :fecha_nacimiento, :correo_electronico, :telefono, :estado, :fecha_inscripcion)";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':correo_electronico' => $correo_electronico,
        ':telefono' => $telefono,
        ':estado' => $estado,
        ':fecha_inscripcion' => $fecha_inscripcion
    ]);

    $sql_direccion = "INSERT INTO direccion (cedula_estudiante, provincia, canton, distrito, direccion_exacta) 
                      VALUES (:cedula_estudiante, :provincia, :canton, :distrito, :direccion_exacta)";
    $stmt_direccion = $pdo->prepare($sql_direccion);
    $stmt_direccion->execute([
        ':cedula_estudiante' => $cedula,
        ':provincia' => $provincia,
        ':canton' => $canton,
        ':distrito' => $distrito,
        ':direccion_exacta' => $direccion_exacta
    ]);

    echo "<div class='alert alert-success'>Estudiante y dirección registrados exitosamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Registrar Nuevo Estudiante</h2>
    <form action="crear.php" method="POST">
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" class="form-control" name="cedula" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" class="form-control" name="fecha_nacimiento">
        </div>
        <div class="form-group">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo_electronico">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono">
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" name="estado">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>
        <h3>Dirección</h3>
        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" class="form-control" name="provincia" required>
        </div>
        <div class="form-group">
            <label for="canton">Cantón:</label>
            <input type="text" class="form-control" name="canton" required>
        </div>
        <div class="form-group">
            <label for="distrito">Distrito:</label>
            <input type="text" class="form-control" name="distrito" required>
        </div>
        <div class="form-group">
            <label for="direccion_exacta">Dirección Exacta:</label>
            <textarea class="form-control" name="direccion_exacta" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="crear">Crear Estudiante</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
