<?php
include '../includes/db_connection.php';

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    try {
        $query = "BEGIN PaqueteEstudiante.EliminarEstudiante(:cedula); END;";
        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ":cedula", $cedula);

        oci_execute($stmt);
        oci_free_statement($stmt);

        header("Location: index.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
