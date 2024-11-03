CREATE VIEW vista_materias_inscritos AS
SELECT m.nombre AS materia, COUNT(mat.cedula_estudiante) AS inscritos
FROM materias m
LEFT JOIN matriculas mat ON m.id = mat.id_materia
GROUP BY m.nombre;
