<?php
include '../configuracion/conexion.php';

$idMateria = $_GET['idMateria'];
$sql = "DELETE FROM Materia WHERE IDMateria = '$idMateria'";

if ($conn->query($sql) === TRUE) {
    echo "Materia eliminada exitosamente";
} else {
    echo "Error al eliminar materia: " . $conn->error;
}

$conn->close();
header("Location: ../paginas/materias.php");
exit();
