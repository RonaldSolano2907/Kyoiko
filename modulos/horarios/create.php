<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Horario</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Crear Horario</h1>
        <form action="create.php" method="POST">
            <label for="id_materia">ID Materia:</label>
            <input type="number" id="id_materia" name="id_materia" required>

            <label for="aula">Aula:</label>
            <input type="text" id="aula" name="aula" required>

            <label for="horario_inicio">Horario Inicio:</label>
            <input type="datetime-local" id="horario_inicio" name="horario_inicio" required>

            <label for="horario_fin">Horario Fin:</label>
            <input type="datetime-local" id="horario_fin" name="horario_fin" required>

            <label for="dia_semana">Dia de la Semana:</label>
            <select id="dia_semana" name="dia_semana" required>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>
