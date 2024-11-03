<?php
include '../../configuracion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT cedula FROM estudiantes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $cedula = $stmt->fetchColumn();

    $sql_direccion = "DELETE FROM direccion WHERE cedula_estudiante = :cedula";
    $stmt_direccion = $pdo->prepare($sql_direccion);
    $stmt_direccion->execute([':cedula' => $cedula]);

    $sql_estudiante = "DELETE FROM estudiantes WHERE id = :id";
    $stmt_estudiante = $pdo->prepare($sql_estudiante);
    $stmt_estudiante->execute([':id' => $id]);

    header("Location: listar.php");
    exit;
}
?>
