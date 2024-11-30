<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llamada al procedimiento almacenado
    $stmt = oci_parse($conn, "BEGIN PaqueteHorarios.EliminarHorario(:id); END;");
    oci_bind_by_name($stmt, ':id', $id);

    if (oci_execute($stmt)) {
        header("Location: index.php");
    } else {
        $error = oci_error($stmt);
        echo "Error: " . $error['message'];
    }
}
?>
