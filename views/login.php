<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyoiku - Inicio</title>
    <style>
        /* ------------------------------
           Estilos Exclusivos del Index Principal
        ------------------------------ */
        .index-header {
            background-color: #007BFF;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .index-header h1 {
            margin: 0;
            font-size: 1.8em;
        }

        .index-header .login-button {
            background-color: white;
            color: #007BFF;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9em;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .index-header .login-button:hover {
            background-color: #0056b3;
            color: white;
        }

        .index-hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #f4f4f4;
        }

        .index-hero img {
            max-width: 300px;
            height: auto;
        }

        .index-section {
            padding: 40px 20px;
            background-color: #fff;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .index-section h2 {
            margin-bottom: 10px;
            color: #007BFF;
        }

        .index-section p {
            color: #555;
        }

        .index-footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }

        /* Fondo con imagen personalizada */
        .index-hero {
            background: url('../assets/back.png') no-repeat center center;
            background-size: cover;
            padding: 100px 20px; /* Ajusta el espacio del contenedor */
        }

        .index-hero img {
            background: transparent;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Header con Login -->
    <header class="index-header">
        <h1>Kyoiko</h1>
        <a href="login.php" class="login-button">Iniciar Sesión</a>
    </header>

    <!-- Sección: Logo de la Institución -->
    <section class="index-hero">
        <img src="../assets/logo.png" alt="Logo de la Institución" class="hero-logo">
    </section>

    <!-- Sección: Acerca del Proyecto -->
    <section class="index-section">
        <h2>Acerca del Proyecto</h2>
        <p>
            Kyoiko es un sistema educativo diseñado para gestionar información académica de manera eficiente. 
            Proporciona herramientas avanzadas para estudiantes, profesores y administradores, asegurando la 
            optimización de los recursos educativos.
        </p>
    </section>

    <!-- Sección: Historia -->
    <section class="index-section">
        <h2>Nuestra Historia</h2>
        <p>
            Fundada en 2024, Kyoiko nació con la visión de revolucionar la gestión educativa. Nuestro enfoque 
            es brindar soluciones inteligentes que se adapten a las necesidades de las instituciones educativas.
        </p>
    </section>

    <!-- Sección: Contacto -->
    <section class="index-section">
        <h2>Contacto</h2>
        <p>
            Para más información, contáctanos a través del correo electrónico: 
            <a href="mailto:info@kyoiko.com">info@kyoiko.com</a>.
        </p>
    </section>

    <!-- Footer -->
    <footer class="index-footer">
        <p>&copy; 2024 Kyoiko. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
