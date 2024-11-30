<?php
require_once '../includes/db_connection.php';

$cedula = $_GET['cedula'];
$idMateria = $_GET['idMateria'];
$semestre = $_GET['semestre'];
$anio = $_GET['anio'];

try {
    $query = "BEGIN PaqueteMatricula.EliminarMatricula(:cedula, :idMateria, :semestre, :anio); END;";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':cedula', $cedula);
    oci_bind_by_name($stmt, ':idMateria', $idMateria);
    oci_bind_by_name($stmt, ':semestre', $semestre);
    oci_bind_by_name($stmt, ':anio', $anio);
    oci_execute($stmt);
    header("Location: index.php");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
