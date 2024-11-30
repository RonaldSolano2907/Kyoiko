<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Horario</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Horario</h1>
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $horario['ID']; ?>">

            <label for="id_materia">ID Materia:</label>
            <input type="number" id="id_materia" name="id_materia" value="<?php echo $horario['IDMATERIA']; ?>" required>

            <label for="aula">Aula:</label>
            <input type="text" id="aula" name="aula" value="<?php echo $horario['AULA']; ?>" required>

            <label for="horario_inicio">Horario Inicio:</label>
            <input type="datetime-local" id="horario_inicio" name="horario_inicio" value="<?php echo date('Y-m-d\TH:i', strtotime($horario['HORARIOINICIO'])); ?>" required>

            <label for="horario_fin">Horario Fin:</label>
            <input type="datetime-local" id="horario_fin" name="horario_fin" value="<?php echo date('Y-m-d\TH:i', strtotime($horario['HORARIOFIN'])); ?>" required>

            <label for="dia_semana">Dia de la Semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="Lunes" <?php if ($horario['DIASEMANA'] === 'Lunes') echo 'selected'; ?>>Lunes</option>
                <option value="Martes" <?php if ($horario['DIASEMANA'] === 'Martes') echo 'selected'; ?>>Martes</option>
                <option value="Miercoles" <?php if ($horario['DIASEMANA'] === 'Miercoles') echo 'selected'; ?>>Miercoles</option>
                <option value="Jueves" <?php if ($horario['DIASEMANA'] === 'Jueves') echo 'selected'; ?>>Jueves</option>
                <option value="Viernes" <?php if ($horario['DIASEMANA'] === 'Viernes') echo 'selected'; ?>>Viernes</option>
                <option value="Sabado" <?php if ($horario['DIASEMANA'] === 'Sabado') echo 'selected'; ?>>Sabado</option>
                <option value="Domingo" <?php if ($horario['DIASEMANA'] === 'Domingo') echo 'selected'; ?>>Domingo</option>
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>
