<?php
// Configuración de conexión a la base de datos (valeoro.txt)
$usuario_db = 'USERLBD';
$clave_db = '123';
$cadena_conexion = 'localhost/XE';
try {
    $conn = oci_connect($usuario_db, $clave_db, $cadena_conexion);
    if (!$conn) {
        $e = oci_error();
        die("Error de conexión: " . $e['message']);
    }
} catch (Exception $e) {
    die("Excepción capturada: " . $e->getMessage());
}

// Obtener el ID del horario
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Leer datos actuales del horario
$sql = "BEGIN PaqueteHorarios.LeerHorario(:id, :cursor); END;";
$stmt = oci_parse($conn, $sql);
$cursor = oci_new_cursor($conn);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
oci_execute($stmt);
oci_execute($cursor);
$horario = oci_fetch_assoc($cursor);
oci_free_statement($stmt);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_materia = $_POST['id_materia'];
    $aula = $_POST['aula'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $dia_semana = $_POST['dia_semana'];

    $sql = "BEGIN PaqueteHorarios.ActualizarHorario(:id, :id_materia, :aula, TO_DATE(:horario_inicio, 'YYYY-MM-DD HH24:MI'), TO_DATE(:horario_fin, 'YYYY-MM-DD HH24:MI'), :dia_semana); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":id", $id);
    oci_bind_by_name($stmt, ":id_materia", $id_materia);
    oci_bind_by_name($stmt, ":aula", $aula);
    oci_bind_by_name($stmt, ":horario_inicio", $horario_inicio);
    oci_bind_by_name($stmt, ":horario_fin", $horario_fin);
    oci_bind_by_name($stmt, ":dia_semana", $dia_semana);

    if (oci_execute($stmt)) {
        oci_commit($conn);
        header('Location: index.php?success=1');
        exit;
    } else {
        $error = oci_error($stmt);
        echo "Error al actualizar el horario: " . htmlentities($error['message']);
    }
    oci_free_statement($stmt);
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Horario</title>
    <style>
        header { background-color: #007bff; color: #ffffff; padding: 10px; text-align: center; }
        nav { background-color: #000; padding: 10px; display: flex; justify-content: space-between; }
        nav ul { display: flex; list-style: none; margin: 0; padding: 0; }
        nav a { color: white; text-decoration: none; font-weight: bold; margin: 0 10px; }
        nav a:hover { color: #007bff; }
        h1 { text-align: center; margin-top: 20px; }
        .form-container { width: 50%; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, button { width: 100%; margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; font-weight: bold; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        footer { background-color: #333; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Horarios</h1>
    </header>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="../dashboard.php">Regresar</a></li>
            <li><a href="create.php">Crear</a></li>
            <li><a href="edit.php">Editar</a></li>
            <li><a href="delete.php">Borrar</a></li>
            <li><a href="index.php">Listar</a></li>
            <li><button onclick="window.location.href='../index.php'">Salir</button></li>
        </ul>
    </nav>

    <!-- Formulario -->
    <div class="form-container">
        <h1>Editar Horario</h1>
        <form method="POST">
            <label for="id_materia">ID Materia:</label>
            <input type="number" id="id_materia" name="id_materia" value="<?= htmlspecialchars($horario['IDMATERIA']); ?>" required>

            <label for="aula">Aula:</label>
            <input type="text" id="aula" name="aula" value="<?= htmlspecialchars($horario['AULA']); ?>" required>

            <label for="horario_inicio">Horario Inicio:</label>
            <input type="datetime-local" id="horario_inicio" name="horario_inicio" value="<?= date('Y-m-d\TH:i', strtotime($horario['HORARIOINICIO'])); ?>" required>

            <label for="horario_fin">Horario Fin:</label>
            <input type="datetime-local" id="horario_fin" name="horario_fin" value="<?= date('Y-m-d\TH:i', strtotime($horario['HORARIOFIN'])); ?>" required>

            <label for="dia_semana">Día de la Semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <?php
                    $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                    foreach ($dias as $dia) {
                        $selected = $horario['DIASEMANA'] === $dia ? 'selected' : '';
                        echo "<option value='$dia' $selected>$dia</option>";
                    }
                ?>
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Sistema de Gestión Kyoiko</p>
    </footer>
</body>
</html>
