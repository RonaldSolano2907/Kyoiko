<?php
include '../configuracion/conexion.php';

// Obtener datos del formulario
$idMateria = $_POST['idMateria'];
$nombre = $_POST['nombre'];
$creditos = $_POST['creditos'];
$semestre = $_POST['semestre'];

// Insertar la nueva materia en la base de datos
$sql = "INSERT INTO Materia (IDMateria, Nombre, Creditos, Semestre) 
        VALUES ('$idMateria', '$nombre', '$creditos', '$semestre')";

if ($conn->query($sql) === TRUE) {
    echo "Materia agregada exitosamente";
} else {
    echo "Error al agregar materia: " . $conn->error;
}

$conn->close();
header("Location: ../paginas/materias.php");
exit();
