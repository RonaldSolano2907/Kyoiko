CREATE VIEW vista_profesores_materias AS
SELECT p.cedula, p.nombre, p.apellido, COUNT(a.id_materia) AS numero_materias
FROM profesores p
LEFT JOIN asignaciones a ON p.cedula = a.cedula_profesor
GROUP BY p.cedula, p.nombre, p.apellido;
