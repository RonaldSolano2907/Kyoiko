<?php
// /views/login.php

include '../includes/db_connection.php';
session_start();

// Procesamos el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    // Validaciones básicas
    if (empty($usuario) || empty($clave)) {
        $error = "Por favor, ingrese usuario y contraseña.";
    } else {
        // Procedimiento almacenado para verificar credenciales
        $query = "BEGIN PaqueteUsuarios.VerificarCredenciales(:usuario, :clave, :existe); END;";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ":usuario", $usuario);
        oci_bind_by_name($stmt, ":clave", $clave);
        oci_bind_by_name($stmt, ":existe", $existe, 1);

        if (oci_execute($stmt)) {
            if ($existe === '1') {
                // Credenciales válidas, redirigimos al dashboard
                $_SESSION['usuario'] = $usuario;
                header("Location: dashboard.php");
                exit;
            } else {
                // Credenciales inválidas
                $error = "Usuario o contraseña incorrectos.";
            }
        } else {
            $e = oci_error($stmt);
            $error = "Error al verificar credenciales: " . htmlentities($e['message']);
        }

        oci_free_statement($stmt);
    }

    oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Kyoiko - Iniciar Sesión</title>
    <style>
        /* ------------------------------
           Estilos del Login
        ------------------------------ */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: url('../assets/images/back.png') no-repeat center center fixed;
            background-size: contain; /* Ajusta el ancho al tamaño de la pantalla */
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 100vh; /* Altura completa de la pantalla */
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95); /* Fondo semitransparente */
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%; /* Ocupa el 90% del ancho de la pantalla en dispositivos pequeños */
            max-width: 400px; /* Ancho máximo en pantallas grandes */
        }

        .login-container h1 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        .login-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        /* Para pantallas pequeñas */
        @media (max-width: 768px) {
            body {
                background-size: cover; /* Cambia el ajuste de la imagen en pantallas pequeñas */
            }

            .login-container {
                width: 100%; /* Ocupa el ancho completo en dispositivos pequeños */
                max-width: 90%; /* Con límites */
            }
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>

        <!-- Mensaje de error -->
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingrese su usuario" required>
            </div>
            <div class="form-group">
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="login-button">Entrar</button>
        </form>
    </div>
</body>
</html>
