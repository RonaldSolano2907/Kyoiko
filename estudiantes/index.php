<?php include 'views/layouts/header.php'; ?>
<h1>Listado de Estudiantes</h1>
<a href="index.php?controller=estudiante&action=create">Agregar Estudiante</a>
<table>
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantes as $estudiante): ?>
        <tr>
            <td><?php echo $estudiante['CEDULA']; ?></td>
            <td><?php echo $estudiante['NOMBRE']; ?></td>
            <td><?php echo $estudiante['APELLIDOS']; ?></td>
            <td><?php echo $estudiante['CORREOELECTRONICO']; ?></td>
            <td>
                <a href="index.php?controller=estudiante&action=edit&id=<?php echo $estudiante['CEDULA']; ?>">Editar</a>
                <a href="index.php?controller=estudiante&action=delete&id=<?php echo $estudiante['CEDULA']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'views/layouts/footer.php'; ?>
