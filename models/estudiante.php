<?php
class Estudiante {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Método para crear un estudiante
    public function crearEstudiante($datos) {
        $sql = "BEGIN PaqueteEstudiante.CrearEstudiante(:cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correoElectronico); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $datos['cedula']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellidos', $datos['apellidos']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':fechaNacimiento', $datos['fechaNacimiento']);
        $stmt->bindParam(':correoElectronico', $datos['correoElectronico']);
        return $stmt->execute();
    }

    // Método para obtener todos los estudiantes
    public function obtenerEstudiantes() {
        $sql = "BEGIN PaqueteEstudiante.LeerTodosEstudiantes(:resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para obtener un estudiante por cédula
    public function obtenerEstudiantePorCedula($cedula) {
        $sql = "BEGIN PaqueteEstudiante.LeerEstudiante(:cedula, :resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        $data = oci_fetch_assoc($cursor);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para actualizar un estudiante
    public function actualizarEstudiante($datos) {
        $sql = "BEGIN PaqueteEstudiante.ActualizarEstudiante(:cedula, :nombre, :apellidos, :telefono, TO_DATE(:fechaNacimiento, 'YYYY-MM-DD'), :correoElectronico, :estado); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $datos['cedula']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellidos', $datos['apellidos']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':fechaNacimiento', $datos['fechaNacimiento']);
        $stmt->bindParam(':correoElectronico', $datos['correoElectronico']);
        $stmt->bindParam(':estado', $datos['estado']);
        return $stmt->execute();
    }

    // Método para eliminar un estudiante
    public function eliminarEstudiante($cedula) {
        $sql = "BEGIN PaqueteEstudiante.EliminarEstudiante(:cedula); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        return $stmt->execute();
    }
}
?>


public function obtenerHistorialMatriculas($cedula) {
    $sql = "BEGIN :resultado := ObtenerHistorialMatriculas(:cedula); END;";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
    $stmt->execute();
    oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
    return $data;
}

public function obtenerEstudiantesActivos() {
    $sql = "SELECT * FROM VistaEstudiantesActivos";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
