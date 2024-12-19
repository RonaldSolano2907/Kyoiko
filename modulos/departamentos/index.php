<?php
// Configuración de conexión a la base de datos (valeoro.txt)
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Obtener los datos de departamentos
$sql = "BEGIN PaqueteDepartamento.LeerDepartamento(NULL, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px; text-align: center; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 10px; }
        nav a:hover { color: #007bff; }
        h1 { text-align: center; margin-top: 20px; }
        .table-container { width: 90%; margin: 20px auto; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn-add { display: inline-block; background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-bottom: 10px; }
        .btn-add:hover { background-color: #218838; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Departamentos</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="edit.php">Editar</a></li>
            <li><a href="delete.php">Borrar</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Contenido Principal -->
    <div class="table-container">
        <a href="create.php" class="btn-add">Agregar Departamento</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cédula Jefe</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID']); ?></td>
                        <td><?= htmlspecialchars($row['CEDULAJEFEDEPARTAMENTO']); ?></td>
                        <td><?= htmlspecialchars($row['NOMBRE']); ?></td>
                        <td><?= htmlspecialchars($row['DESCRIPCION']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
