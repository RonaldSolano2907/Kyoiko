<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Horarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Materia</th>
                    <th>Aula</th>
                    <th>Horario Inicio</th>
                    <th>Horario Fin</th>
                    <th>Dia Semana</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horarios as $horario): ?>
                    <tr>
                        <td><?php echo $horario['ID']; ?></td>
                        <td><?php echo $horario['IDMATERIA']; ?></td>
                        <td><?php echo $horario['AULA']; ?></td>
                        <td><?php echo $horario['HORARIOINICIO']; ?></td>
                        <td><?php echo $horario['HORARIOFIN']; ?></td>
                        <td><?php echo $horario['DIASEMANA']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $horario['ID']; ?>">Editar</a>
                            <a href="delete.php?id=<?php echo $horario['ID']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este horario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create.php" class="button">Crear Nuevo Horario</a>
    </div>
</body>
</html>
