<?php
include_once '../includes/db_connection.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("BEGIN PaqueteCongelamientos.EliminarCongelamiento(:id); END;");
    oci_bind_by_name($stmt, ":id", $id);
    oci_execute($stmt);
    oci_commit($conn);
}

header('Location: index.php');
exit;
?>
