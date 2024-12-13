<?php
// Incluimos la conexión a la base de datos
include '../includes/db_connection.php';

// Procesamos el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $clave = mysqli_real_escape_string($conn, $_POST['clave']);

    // Consulta para verificar las credenciales
    $query = "SELECT * FROM Usuarios WHERE Usuario = '$usuario' AND Clave = '$clave'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Credenciales válidas, redirigimos al dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Credenciales inválidas, mostramos el mensaje de error y redirigimos
        echo "<script>
                alert('Usuario o contraseña incorrectos. Redirigiendo a la página principal...');
                setTimeout(function() {
                    window.location.href = '../index.php';
                }, 3000); // 3 segundos antes de redirigir
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyoiko - Iniciar Sesión</title>
    <style>
        /* ------------------------------
           Estilos del Login
        ------------------------------ */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: url('../assets/back.png') no-repeat center center fixed;
            background-size: contain; 
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95); 
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%; 
            max-width: 400px; 
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

       
        @media (max-width: 768px) {
            body {
                background-size: cover; 
            }

            .login-container {
                width: 100%; 
                max-width: 90%; /
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form method="POST">
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
