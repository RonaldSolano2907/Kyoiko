<?php
class LoginController {
    public function index() {
        include 'views/auth/login.php';
    }

    public function authenticate() {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Aquí debes validar las credenciales, posiblemente llamando a un procedimiento almacenado
        // Supongamos que las credenciales son correctas
        session_start();
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php?controller=dashboard&action=index');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php');
    }
}
?>
