<?php
if (isset($_GET['id'])) {
    include 'includes/db_connection.php';

    $id = $_GET['id'];

    $query = "BEGIN PaqueteMateria.EliminarMateria(:id); END;";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":id", $id);

    if (oci_execute($stmt)) {
        header("Location: index.php");
    } else {
        $error = oci_error($stmt);
        echo "Error: " . $error['message'];
    }
}
?>
