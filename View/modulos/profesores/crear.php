<?php 
include '../../includes/header.php'; 
include '../../configuracion/conexion.php'; 

if (isset($_POST['crear'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo_electronico = $_POST['correo_electronico'];
    $telefono = $_POST['telefono'];
    $titulo_academico = $_POST['titulo_academico'];

    $sql = "INSERT INTO profesores (cedula, nombre, apellidos, correo_electronico, telefono, titulo_academico) 
            VALUES (:cedula, :nombre, :apellidos, :correo_electronico, :telefono, :titulo_academico)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cedula' => $cedula,
        ':nombre' => $nombre,
        ':apellidos' => $apellidos,
        ':correo_electronico' => $correo_electronico,
        ':telefono' => $telefono,
        ':titulo_academico' => $titulo_academico
    ]);

    echo "<div class='alert alert-success'>Profesor registrado exitosamente.</div>";
}
?>

<div class="container mt-4">
    <h2>Registrar Nuevo Profesor</h2>
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
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" class="form-control" name="correo_electronico">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono">
        </div>
        <div class="form-group">
            <label for="titulo_academico">Título Académico:</label>
            <input type="text" class="form-control" name="titulo_academico">
        </div>
        <button type="submit" class="btn btn-primary" name="crear">Registrar Profesor</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
