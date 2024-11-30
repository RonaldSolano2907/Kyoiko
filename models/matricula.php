<?php
class Matricula {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una matrícula
    public function crearMatricula($datos) {
        $sql = "BEGIN PaqueteMatricula.CrearMatricula(:cedulaEstudiante, :idMateria, :semestre, :anio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':semestre', $datos['semestre']);
        $stmt->bindParam(':anio', $datos['anio']);
        return $stmt->execute();
    }

    // Método para obtener las matrículas de un estudiante
    public function obtenerMatriculasEstudiante($cedulaEstudiante) {
        $sql = "BEGIN PaqueteMatricula.LeerMatriculasEstudiante(:cedulaEstudiante, :resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':cedulaEstudiante', $cedulaEstudiante);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para actualizar una matrícula
    public function actualizarMatricula($datos) {
        $sql = "BEGIN PaqueteMatricula.ActualizarMatricula(:cedulaEstudiante, :idMateria, :semestre, :anio, :nuevoSemestre, :nuevoAnio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaEstudiante', $datos['cedulaEstudiante']);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':semestre', $datos['semestre']);
        $stmt->bindParam(':anio', $datos['anio']);
        $stmt->bindParam(':nuevoSemestre', $datos['nuevoSemestre']);
        $stmt->bindParam(':nuevoAnio', $datos['nuevoAnio']);
        return $stmt->execute();
    }

    // Método para eliminar una matrícula
    public function eliminarMatricula($cedulaEstudiante, $idMateria, $semestre, $anio) {
        $sql = "BEGIN PaqueteMatricula.EliminarMatricula(:cedulaEstudiante, :idMateria, :semestre, :anio); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedulaEstudiante', $cedulaEstudiante);
        $stmt->bindParam(':idMateria', $idMateria);
        $stmt->bindParam(':semestre', $semestre);
        $stmt->bindParam(':anio', $anio);
        return $stmt->execute();
    }
}
?>
