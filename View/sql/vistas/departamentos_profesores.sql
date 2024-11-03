CREATE VIEW vista_departamentos_profesores AS
SELECT d.nombre AS departamento, p.nombre AS profesor, p.apellido
FROM departamentos d
JOIN profesores p ON d.cedula_jefe = p.cedula;
