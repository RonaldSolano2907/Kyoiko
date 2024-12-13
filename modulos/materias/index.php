<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materias</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Materias</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'includes/db_connection.php';

                $query = "BEGIN PaqueteMateria.LeerMateria(null, :materias); END;";
                $stmt = oci_parse($conn, $query);

                $cursor = oci_new_cursor($conn);
                oci_bind_by_name($stmt, ":materias", $cursor, -1, OCI_B_CURSOR);

                oci_execute($stmt);
                oci_execute($cursor);

                while (($row = oci_fetch_assoc($cursor)) != false) {
                    echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['NOMBRE']}</td>
                        <td>{$row['DESCRIPCION']}</td>
                        <td>{$row['CREDITOS']}</td>
                        <td>
                            <a href='edit.php?id={$row['ID']}'>Editar</a>
                            <a href='delete.php?id={$row['ID']}' onclick=\"return confirm('¿Seguro que deseas eliminar esta materia?');\">Eliminar</a>
                        </td>
                    </tr>";
                }
                oci_free_statement($stmt);
                oci_free_statement($cursor);
                ?>
            </tbody>
        </table>
        <a href="create.php" class="button">Nueva Materia</a>
    </div>
</body>
</html>
