<?php
class Departamento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un departamento
    public function crearDepartamento($datos) {
        $sql = "BEGIN PaqueteDepartamento.CrearDepartamento(:cedulaJefe, :nombre, :descripcion); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaJefe', $datos['cedulaJefeDepartamento']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        return $stmt->execute();
    }

    // Método para obtener todos los departamentos
    public function obtenerDepartamentos() {
        $sql = "SELECT * FROM Departamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un departamento por ID
    public function obtenerDepartamentoPorID($id) {
        $sql = "BEGIN PaqueteDepartamento.LeerDepartamento(:id, :resultado); END;";
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

    // Método para actualizar un departamento
    public function actualizarDepartamento($datos) {
        $sql = "BEGIN PaqueteDepartamento.ActualizarDepartamento(:id, :cedulaJefe, :nombre, :descripcion); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $datos['id']);
        $stmt->bindParam(':cedulaJefe', $datos['cedulaJefeDepartamento']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':descripcion', $datos['descripcion']);
        return $stmt->execute();
    }

    // Método para eliminar un departamento
    public function eliminarDepartamento($id) {
        $sql = "BEGIN PaqueteDepartamento.EliminarDepartamento(:id); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
