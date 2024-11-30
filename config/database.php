<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'tu_base_de_datos';
    private $username = 'tu_usuario';
    private $password = 'tu_contraseña';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("oci:dbname=".$this->host."/".$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
