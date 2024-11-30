<?php
class Congelamiento {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un congelamiento
    public function crearCongelamiento($datos) {
        $sql = "BEGIN PaqueteCongelamientos.CrearCongelamiento(:cedulaEstudiante, :motivo, TO_DATE(:fechaInicio, 'YYYY-MM-DD'), TO_DATE(:fechaFin, 'YYYY-MM-DD')); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':motivo', $datos['motivo']);
        $stmt->bindParam(':fechaInicio', $datos['fechaInicio']);
        $stmt->bindParam(':fechaFin', $datos['fechaFin']);
        return $stmt->execute();
    }

    // Método para obtener un congelamiento por ID
    public function obtenerCongelamientoPorID($id) {
        $sql = "BEGIN PaqueteCongelamientos.LeerCongelamiento(:id, :resultado); END;";
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

    // Método para actualizar un congelamiento
    public function actualizarCongelamiento($datos) {
        $sql = "BEGIN PaqueteCongelamientos.ActualizarCongelamiento(:id, :cedulaEstudiante, :motivo, TO_DATE(:fechaInicio, 'YYYY-MM-DD'), TO_DATE(:fechaFin, 'YYYY-MM-DD')); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $datos['id']);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':motivo', $datos['motivo']);
        $stmt->bindParam(':fechaInicio', $datos['fechaInicio']);
        $stmt->bindParam(':fechaFin', $datos['fechaFin']);
        return $stmt->execute();
    }

    // Método para eliminar un congelamiento
    public function eliminarCongelamiento($id) {
        $sql = "BEGIN PaqueteCongelamientos.EliminarCongelamiento(:id); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
