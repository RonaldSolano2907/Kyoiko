CREATE TRIGGER estado_estudiante
AFTER INSERT ON congelamientos
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET estado = 'inactivo'
    WHERE cedula = NEW.cedula_estudiante;
END;

CREATE TRIGGER finalizar_congelamiento
AFTER UPDATE ON congelamientos
FOR EACH ROW
BEGIN
    IF NEW.fecha_fin IS NOT NULL THEN
        UPDATE estudiantes
        SET estado = 'activo'
        WHERE cedula = NEW.cedula_estudiante;
    END IF;
END;
