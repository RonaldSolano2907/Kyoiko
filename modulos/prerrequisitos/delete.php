<?php
require_once '../includes/db_connection.php';

$idMateriaPrincipal = $_GET['idMateriaPrincipal'];
$idMateriaPrerrequisito = $_GET['idMateriaPrerrequisito'];

try {
    $query = "BEGIN PaquetePrerrequisitos.EliminarPrerrequisito(:idMateriaPrincipal, :idMateriaPrerrequisito); END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':idMateriaPrincipal', $idMateriaPrincipal);
    oci_bind_by_name($stmt, ':idMateriaPrerrequisito', $idMateriaPrerrequisito);
    oci_execute($stmt);
    header("Location: index.php");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
