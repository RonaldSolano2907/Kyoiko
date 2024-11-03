CREATE VIEW vista_materias_prerrequisitos AS
SELECT m.nombre AS materia, p.nombre AS prerrequisito
FROM prerrequisitos pr
JOIN materias m ON pr.id_materia_principal = m.id
JOIN materias p ON pr.id_materia_prerrequisito = p.id;
