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

try {
    $sql = "BEGIN PaqueteProfesor.LeerProfesores(:cursor); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);

    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);
} catch (Exception $e) {
    echo "Error al cargar los datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Profesores</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px; text-align: center; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 10px; }
        nav a:hover { color: #007bff; }
        h1 { text-align: center; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { display: inline-block; padding: 10px 15px; margin: 5px 0; text-decoration: none; border-radius: 5px; }
        .btn-create { background-color: #28a745; color: white; }
        .btn-create:hover { background-color: #218838; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Profesores</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Contenido Principal -->
    <div class="container">
        <a href="create.php" class="btn btn-create">Crear Profesor</a>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Departamento</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Título Académico</th>
                </tr>
            </thead>
            <tbody>
                <?php while (($row = oci_fetch_assoc($cursor)) != false): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['CEDULA']); ?></td>
                        <td><?= htmlspecialchars($row['IDDEPARTAMENTO']); ?></td>
                        <td><?= htmlspecialchars($row['NOMBRE']); ?></td>
                        <td><?= htmlspecialchars($row['APELLIDOS']); ?></td>
                        <td><?= htmlspecialchars($row['TELEFONO']); ?></td>
                        <td><?= htmlspecialchars($row['CORREOELECTRONICO']); ?></td>
                        <td><?= htmlspecialchars($row['TITULOACADEMICO']); ?></td>
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

<?php
oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
