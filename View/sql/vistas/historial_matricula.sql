CREATE VIEW vista_historial_matricula AS
SELECT e.cedula, e.nombre, e.apellido, m.nombre_materia, mat.fecha_matricula, mat.semestre, mat.año
FROM estudiantes e
JOIN matriculas mat ON e.cedula = mat.cedula_estudiante
JOIN materias m ON mat.id_materia = m.id;
