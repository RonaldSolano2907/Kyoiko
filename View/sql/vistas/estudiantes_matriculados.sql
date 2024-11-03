CREATE VIEW vista_estudiantes_matriculados AS
SELECT e.cedula, e.nombre, e.apellido, m.nombre_materia, mat.semestre, mat.año
FROM estudiantes e
JOIN matriculas mat ON e.cedula = mat.cedula_estudiante
JOIN materias m ON mat.id_materia = m.id;
