CREATE VIEW vista_estudiantes_departamento AS
SELECT d.nombre AS departamento, e.cedula, e.nombre, e.apellido
FROM departamentos d
JOIN estudiantes e ON d.id = e.id_departamento;
