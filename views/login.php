<?php
// Inicio de sesión
session_start();
include('db_connection.php'); // Archivo para la conexión a Oracle

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Consulta para validar el usuario
        $query = "SELECT * FROM Usuarios WHERE Usuario = :username AND Clave = :password";
        $stmt = oci_parse($conn, $query);

        // Asignamos los valores
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":password", $password);

        // Ejecutamos la consulta
        oci_execute($stmt);

        if ($row = oci_fetch_assoc($stmt)) {
            // Usuario válido, creamos la sesión
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['USUARIO'];
            $_SESSION['rol'] = $row['ROL']; // Si tienes roles

            header("Location: index.php"); // Redirigir al index principal
            exit();
        } else {
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } catch (Exception $e) {
        $error_message = "Error al iniciar sesión: " . $e->getMessage();
    }
}

// Cerramos el recurso
if (isset($stmt)) {
    oci_free_statement($stmt);
}
oci_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css"> <!-- Cambia a tu archivo CSS -->
</head>
<body>
    <div class="login-page">
        <!-- Nombre del Proyecto -->
        <h1>Proyecto Kyoiko</h1>
        <!-- Logo -->
        <img src="logo.png" alt="Logo del Proyecto">

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Ingrese su usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
