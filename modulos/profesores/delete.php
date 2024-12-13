<?php
include '../includes/db_connection.php';

$cedula = $_GET['cedula'] ?? '';
if ($cedula) {
    try {
        $sql = "BEGIN PaqueteProfesor.EliminarProfesor(:cedula); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":cedula", $cedula);

        oci_execute($stmt);
    } catch (Exception $e) {
        echo "Error al eliminar el profesor: " . $e->getMessage();
    }
}

header("Location: index.php");
exit;
?>
