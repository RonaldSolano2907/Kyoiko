<?php
class Asignacion {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una asignación
    public function crearAsignacion($datos) {
        $sql = "BEGIN PaqueteAsignacion.CrearAsignacion(:idMateria, :cedulaProfesor, :semestre, :anio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':cedulaProfesor', $datos['cedulaProfesor']);
        $stmt->bindParam(':semestre', $datos['semestre']);
        $stmt->bindParam(':anio', $datos['anio']);
        return $stmt->execute();
    }

    // Método para obtener todas las asignaciones
    public function obtenerAsignaciones() {
        $sql = "SELECT * FROM Asignacion";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener una asignación específica
    public function obtenerAsignacion($idMateria, $cedulaProfesor, $semestre, $anio) {
        $sql = "BEGIN PaqueteAsignacion.LeerAsignacion(:idMateria, :cedulaProfesor, :semestre, :anio, :resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':idMateria', $idMateria);
        $stmt->bindParam(':cedulaProfesor', $cedulaProfesor);
        $stmt->bindParam(':semestre', $semestre);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        $data = oci_fetch_assoc($cursor);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para actualizar una asignación
    public function actualizarAsignacion($datos) {
        $sql = "BEGIN PaqueteAsignacion.ActualizarAsignacion(:idMateria, :cedulaProfesor, :semestre, :anio, :nuevoSemestre, :nuevoAnio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':cedulaProfesor', $datos['cedulaProfesor']);
        $stmt->bindParam(':semestre', $datos['semestre']);
        $stmt->bindParam(':anio', $datos['anio']);
        $stmt->bindParam(':nuevoSemestre', $datos['nuevoSemestre']);
        $stmt->bindParam(':nuevoAnio', $datos['nuevoAnio']);
        return $stmt->execute();
    }

    // Método para eliminar una asignación
    public function eliminarAsignacion($idMateria, $cedulaProfesor, $semestre, $anio) {
        $sql = "BEGIN PaqueteAsignacion.EliminarAsignacion(:idMateria, :cedulaProfesor, :semestre, :anio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateria', $idMateria);
        $stmt->bindParam(':cedulaProfesor', $cedulaProfesor);
        $stmt->bindParam(':semestre', $semestre);
        $stmt->bindParam(':anio', $anio);
        return $stmt->execute();
    }
}
?>
