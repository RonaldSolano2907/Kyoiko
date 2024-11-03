CREATE FUNCTION calcular_asistencia(estudiante_id INT) RETURNS INT
BEGIN
    DECLARE total_asistencia INT;
    SELECT SUM(asistencias) INTO total_asistencia FROM asistencias WHERE cedula_estudiante = estudiante_id;
    RETURN total_asistencia;
END;
