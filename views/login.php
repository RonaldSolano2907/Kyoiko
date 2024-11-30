<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <form action="index.php?controller=login&action=authenticate" method="POST">
        <h2>Iniciar Sesión</h2>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
