CREATE VIEW vista_horarios_clases AS
SELECT m.nombre AS materia, h.aula, h.hora_inicio, h.hora_fin, h.dia_semana
FROM horarios h
JOIN materias m ON h.id_materia = m.id;
