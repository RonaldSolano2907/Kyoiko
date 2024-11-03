CREATE TRIGGER actualizar_asistencia
AFTER INSERT ON asistencias
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET total_asistencia = (SELECT SUM(asistencias) FROM asistencias WHERE cedula_estudiante = NEW.cedula_estudiante)
    WHERE cedula = NEW.cedula_estudiante;
END;

CREATE TRIGGER actualizar_asistencia_update
AFTER UPDATE ON asistencias
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET total_asistencia = (SELECT SUM(asistencias) FROM asistencias WHERE cedula_estudiante = NEW.cedula_estudiante)
    WHERE cedula = NEW.cedula_estudiante;
END;
