CREATE TRIGGER limitar_asignaciones
BEFORE INSERT ON asignaciones
FOR EACH ROW
BEGIN
    DECLARE total_asignaciones INT;

    SELECT COUNT(*) INTO total_asignaciones
    FROM asignaciones
    WHERE cedula_profesor = NEW.cedula_profesor
      AND semestre = NEW.semestre
      AND año = NEW.año;

    IF total_asignaciones >= 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El profesor ya tiene el máximo de asignaciones permitidas en este semestre';
    END IF;
END;
