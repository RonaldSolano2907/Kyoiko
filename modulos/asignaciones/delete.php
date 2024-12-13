<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['IDMateria'], $_GET['CedulaProfesor'], $_GET['Semestre'], $_GET['Anio'])) {
    $idMateria = $_GET['IDMateria'];
    $cedulaProfesor = $_GET['CedulaProfesor'];
    $semestre = $_GET['Semestre'];
    $anio = $_GET['Anio'];

    // Preparar el procedimiento para eliminar la asignación
    $query = "BEGIN PaqueteAsignacion.EliminarAsignacion(:p_IDMateria, :p_CedulaProfesor, :p_Semestre, :p_Anio); END;";
    $stmt = oci_parse($conn, $query);

    // Vincular los parámetros
    oci_bind_by_name($stmt, ':p_IDMateria', $idMateria);
    oci_bind_by_name($stmt, ':p_CedulaProfesor', $cedulaProfesor);
    oci_bind_by_name($stmt, ':p_Semestre', $semestre);
    oci_bind_by_name($stmt, ':p_Anio', $anio);

    // Ejecutar la consulta
    if (oci_execute($stmt)) {
        header("Location: index.php?success=1");
        exit();
    } else {
        $e = oci_error($stmt);
        echo "Error al eliminar la asignación: " . htmlentities($e['message']);
    }

    oci_free_statement($stmt);
    oci_close($conn);
} else {
    header("Location: index.php?error=1");
    exit();
}
?>
