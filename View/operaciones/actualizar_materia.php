<?php
include '../configuracion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idMateria = $_GET['idMateria'];
    $sql = "SELECT * FROM Materia WHERE IDMateria = '$idMateria'";
    $result = $conn->query($sql);
    $materia = $result->fetch_assoc();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMateria = $_POST['idMateria'];
    $nombre = $_POST['nombre'];
    $creditos = $_POST['creditos'];
    $semestre = $_POST['semestre'];

    $sql = "UPDATE Materia SET Nombre = '$nombre', Creditos = '$creditos', Semestre = '$semestre' 
            WHERE IDMateria = '$idMateria'";

    if ($conn->query($sql) === TRUE) {
        echo "Materia actualizada exitosamente";
    } else {
        echo "Error al actualizar materia: " . $conn->error;
    }

    $conn->close();
    header("Location: ../paginas/materias.php");
    exit();
}
?>

<!-- Formulario de actualización -->
<form action="actualizar_materia.php" method="POST">
    <input type="hidden" name="idMateria" value="<?php echo $materia['IDMateria']; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $materia['Nombre']; ?>"><br>

    <label for="creditos">Créditos:</label>
    <input type="number" name="creditos" value="<?php echo $materia['Creditos']; ?>"><br>

    <label for="semestre">Semestre:</label>
    <input type="number" name="semestre" value="<?php echo $materia['Semestre']; ?>"><br>

    <button type="submit">Actualizar</button>
</form>
