<?php
class Profesor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un profesor
    public function crearProfesor($datos) {
        $sql = "BEGIN PaqueteProfesor.CrearProfesor(:cedula, :idDepartamento, :nombre, :apellidos, :telefono, :correoElectronico, :tituloAcademico); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $datos['cedula']);
        $stmt->bindParam(':idDepartamento', $datos['idDepartamento']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellidos', $datos['apellidos']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':correoElectronico', $datos['correoElectronico']);
        $stmt->bindParam(':tituloAcademico', $datos['tituloAcademico']);
        return $stmt->execute();
    }

    // Método para obtener todos los profesores
    public function obtenerProfesores() {
        $sql = "BEGIN PaqueteProfesor.LeerTodosProfesores(:resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para obtener un profesor por cédula
    public function obtenerProfesorPorCedula($cedula) {
        $sql = "BEGIN PaqueteProfesor.LeerProfesor(:cedula, :resultado); END;";
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

    // Método para actualizar un profesor
    public function actualizarProfesor($datos) {
        $sql = "BEGIN PaqueteProfesor.ActualizarProfesor(:cedula, :idDepartamento, :nombre, :apellidos, :telefono, :correoElectronico, :tituloAcademico); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $datos['cedula']);
        $stmt->bindParam(':idDepartamento', $datos['idDepartamento']);
        $stmt->bindParam(':nombre', $datos['nombre']);
        $stmt->bindParam(':apellidos', $datos['apellidos']);
        $stmt->bindParam(':telefono', $datos['telefono']);
        $stmt->bindParam(':correoElectronico', $datos['correoElectronico']);
        $stmt->bindParam(':tituloAcademico', $datos['tituloAcademico']);
        return $stmt->execute();
    }

    // Método para eliminar un profesor
    public function eliminarProfesor($cedula) {
        $sql = "BEGIN PaqueteProfesor.EliminarProfesor(:cedula); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        return $stmt->execute();
    }
}
?>
