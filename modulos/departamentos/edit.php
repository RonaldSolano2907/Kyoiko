<?php
include_once '../includes/db_connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula_jefe = $_POST['cedula_jefe'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare("BEGIN PaqueteDepartamento.ActualizarDepartamento(:id, :cedula_jefe, :nombre, :descripcion); END;");
    oci_bind_by_name($stmt, ":id", $id);
    oci_bind_by_name($stmt, ":cedula_jefe", $cedula_jefe);
    oci_bind_by_name($stmt, ":nombre", $nombre);
    oci_bind_by_name($stmt, ":descripcion", $descripcion);
    oci_execute($stmt);
    oci_commit($conn);

    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("BEGIN PaqueteDepartamento.LeerDepartamento(:id, :cursor); END;");
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
$data = oci_fetch_assoc($cursor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Departamento</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <main>
        <h1>Editar Departamento</h1>
        <form action="edit.php?id=<?= $id ?>" method="POST">
            <label for="cedula_jefe">Cédula Jefe</label>
            <input type="text" id="cedula_jefe" name="cedula_jefe" value="<?= $data['CEDULAJEFEDEPARTAMENTO'] ?>" required>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= $data['NOMBRE'] ?>" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?= $data['DESCRIPCION'] ?></textarea>

            <button type="submit" class="btn">Actualizar</button>
        </form>
    </main>
</body>
</html>
