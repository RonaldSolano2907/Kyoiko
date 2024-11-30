<?php
class Direccion {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una dirección
    public function crearDireccion($datos) {
        $sql = "BEGIN PaqueteDireccion.CrearDireccion(:cedulaEstudiante, :provincia, :canton, :distrito, :direccionExacta); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':provincia', $datos['provincia']);
        $stmt->bindParam(':canton', $datos['canton']);
        $stmt->bindParam(':distrito', $datos['distrito']);
        $stmt->bindParam(':direccionExacta', $datos['direccionExacta']);
        return $stmt->execute();
    }

    // Método para obtener una dirección por ID
    public function obtenerDireccionPorID($id) {
        $sql = "BEGIN PaqueteDireccion.LeerDireccion(:id, :resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        $data = oci_fetch_assoc($cursor);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para actualizar una dirección
    public function actualizarDireccion($datos) {
        $sql = "BEGIN PaqueteDireccion.ActualizarDireccion(:id, :cedulaEstudiante, :provincia, :canton, :distrito, :direccionExacta); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $datos['id']);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':provincia', $datos['provincia']);
        $stmt->bindParam(':canton', $datos['canton']);
        $stmt->bindParam(':distrito', $datos['distrito']);
        $stmt->bindParam(':direccionExacta', $datos['direccionExacta']);
        return $stmt->execute();
    }

    // Método para eliminar una dirección
    public function eliminarDireccion($id) {
        $sql = "BEGIN PaqueteDireccion.EliminarDireccion(:id); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
