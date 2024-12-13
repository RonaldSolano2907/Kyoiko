<?php
include '../includes/db_connection.php';

try {
    // Llamar a la vista para obtener los prerrequisitos
    $sql = "SELECT * FROM VistaPrerrequisitosMaterias";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
} catch (Exception $e) {
    echo "Error al cargar los prerrequisitos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Prerrequisitos</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Prerrequisitos de Materias</h1>
        <a href="create.php" class="btn btn-create">Crear Prerrequisito</a>
        <table>
            <thead>
                <tr>
                    <th>ID Materia Principal</th>
                    <th>Nombre Materia Principal</th>
                    <th>ID Materia Prerrequisito</th>
                    <th>Nombre Materia Prerrequisito</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) != false): ?>
                    <tr>
                        <td><?= $row['IDMATERIAPRINCIPAL'] ?></td>
                        <td><?= $row['NOMBREMATERIAPRINCIPAL'] ?></td>
                        <td><?= $row['IDMATERIAPRERREQUISITO'] ?></td>
                        <td><?= $row['NOMBREMATERIAPRERREQUISITO'] ?></td>
                        <td>
                            <a href="edit.php?id_principal=<?= $row['IDMATERIAPRINCIPAL'] ?>&id_prerrequisito=<?= $row['IDMATERIAPRERREQUISITO'] ?>" class="btn btn-edit">Editar</a>
                            <a href="delete.php?id_principal=<?= $row['IDMATERIAPRINCIPAL'] ?>&id_prerrequisito=<?= $row['IDMATERIAPRERREQUISITO'] ?>" class="btn btn-delete" onclick="return confirm('¿Está seguro de eliminar este prerrequisito?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
