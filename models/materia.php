<?php
class Materia {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una materia
    public function crearMateria($datos) {
        $sql = "BEGIN PaqueteMateria.CrearMateria(:nombre, :descripcion, :creditos); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':creditos', $datos['creditos']);
        return $stmt->execute();
    }

    // Método para obtener todas las materias
    public function obtenerMaterias() {
        $sql = "SELECT * FROM Materia";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una materia por ID
    public function obtenerMateriaPorID($id) {
        $sql = "BEGIN PaqueteMateria.LeerMateria(:id, :resultado); END;";
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

    // Método para actualizar una materia
    public function actualizarMateria($datos) {
        $sql = "BEGIN PaqueteMateria.ActualizarMateria(:id, :nombre, :descripcion, :creditos); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $datos['id']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        $stmt->bindParam(':creditos', $datos['creditos']);
        return $stmt->execute();
    }

    // Método para eliminar una materia
    public function eliminarMateria($id) {
        $sql = "BEGIN PaqueteMateria.EliminarMateria(:id); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
