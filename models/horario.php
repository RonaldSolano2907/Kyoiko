<?php
class Horario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un horario
    public function crearHorario($datos) {
        $sql = "BEGIN PaqueteHorarios.CrearHorario(:idMateria, :aula, TO_DATE(:horarioInicio, 'HH24:MI'), TO_DATE(:horarioFin, 'HH24:MI'), :diaSemana); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':aula', $datos['aula']);
        $stmt->bindParam(':horarioInicio', $datos['horarioInicio']);
        $stmt->bindParam(':horarioFin', $datos['horarioFin']);
        $stmt->bindParam(':diaSemana', $datos['diaSemana']);
        return $stmt->execute();
    }

    // Método para obtener un horario por ID
    public function obtenerHorarioPorID($id) {
        $sql = "BEGIN PaqueteHorarios.LeerHorario(:id, :resultado); END;";
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

    // Método para actualizar un horario
    public function actualizarHorario($datos) {
        $sql = "BEGIN PaqueteHorarios.ActualizarHorario(:id, :idMateria, :aula, TO_DATE(:horarioInicio, 'HH24:MI'), TO_DATE(:horarioFin, 'HH24:MI'), :diaSemana); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $datos['id']);
        $stmt->bindParam(':idMateria', $datos['idMateria']);
        $stmt->bindParam(':aula', $datos['aula']);
        $stmt->bindParam(':horarioInicio', $datos['horarioInicio']);
        $stmt->bindParam(':horarioFin', $datos['horarioFin']);
        $stmt->bindParam(':diaSemana', $datos['diaSemana']);
        return $stmt->execute();
    }

    // Método para eliminar un horario
    public function eliminarHorario($id) {
        $sql = "BEGIN PaqueteHorarios.EliminarHorario(:id); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
