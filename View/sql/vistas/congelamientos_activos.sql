CREATE VIEW vista_congelamientos_activos AS
SELECT e.cedula, e.nombre, e.apellido, c.fecha_inicio, c.fecha_fin
FROM estudiantes e
JOIN congelamientos c ON e.cedula = c.cedula_estudiante
WHERE c.fecha_fin IS NULL OR c.fecha_fin > CURRENT_DATE;
