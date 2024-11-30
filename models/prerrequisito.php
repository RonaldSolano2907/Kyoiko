<?php
class Prerrequisito {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear un prerrequisito
    public function crearPrerrequisito($datos) {
        $sql = "BEGIN PaquetePrerrequisitos.CrearPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateriaPrincipal', $datos['idMateriaPrincipal']);
        $stmt->bindParam(':idMateriaPrerrequisito', $datos['idMateriaPrerrequisito']);
        return $stmt->execute();
    }

    // Método para obtener los prerrequisitos de una materia
    public function obtenerPrerrequisitosDeMateria($idMateriaPrincipal) {
        $sql = "BEGIN PaquetePrerrequisitos.LeerPrerrequisitosDeMateria(:idMateriaPrincipal, :resultado); END;";
        $stmt = $this->conn->prepare($sql);
        $cursor = oci_new_cursor($this->conn);
        $stmt->bindParam(':idMateriaPrincipal', $idMateriaPrincipal);
        $stmt->bindParam(':resultado', $cursor, PDO::PARAM_STMT);
        $stmt->execute();
        oci_execute($cursor, OCI_DEFAULT);
        oci_fetch_all($cursor, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($cursor);
        return $data;
    }

    // Método para eliminar un prerrequisito
    public function eliminarPrerrequisito($idMateriaPrincipal, $idMateriaPrerrequisito) {
        $sql = "BEGIN PaquetePrerrequisitos.EliminarPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idMateriaPrincipal', $idMateriaPrincipal);
        $stmt->bindParam(':idMateriaPrerrequisito', $idMateriaPrerrequisito);
        return $stmt->execute();
    }
}
?>
