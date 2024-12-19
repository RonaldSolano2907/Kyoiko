<?php
// Configuración de conexión a la base de datos (de valeoro.txt)
$usuario_db = 'USERLBD';  // Cambia esto por tu usuario
$clave_db = '123';        // Cambia esto por tu contraseña
$cadena_conexion = 'localhost/XE'; // Cambia si usas otra cadena de conexión
try {
    // Conexión a Oracle usando OCI8
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Consultar las asignaciones
$query = "SELECT * FROM Asignacion";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asignaciones</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px 20px; text-align: center; }
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; align-items: center; }
        nav ul { list-style: none; margin: 0; padding: 0; display: flex; }
        nav li { margin: 0 10px; position: relative; }
        nav a { color: white; text-decoration: none; font-weight: bold; }
        nav a:hover { color: #007bff; }
        h1 { text-align: center; margin-top: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background-color: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Asignaciones</h1>
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
    <h1>Lista de Asignaciones</h1>
    <table>
        <thead>
            <tr>
                <th>ID Materia</th>
                <th>Cédula Profesor</th>
                <th>Semestre</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = oci_fetch_assoc($stmt)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['IDMATERIA']) ?></td>
                    <td><?= htmlspecialchars($row['CEDULAPROFESOR']) ?></td>
                    <td><?= htmlspecialchars($row['SEMESTRE']) ?></td>
                    <td><?= htmlspecialchars($row['ANIO']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
