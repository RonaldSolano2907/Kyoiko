CREATE VIEW vista_profesores_asignados AS
SELECT p.cedula, p.nombre, p.apellido, m.nombre_materia, a.semestre, a.año
FROM profesores p
JOIN asignaciones a ON p.cedula = a.cedula_profesor
JOIN materias m ON a.id_materia = m.id;
