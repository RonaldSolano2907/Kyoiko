CREATE TRIGGER cupo_materia
BEFORE INSERT ON matriculas
FOR EACH ROW
BEGIN
    DECLARE cupo_actual INT;
    DECLARE cupo_maximo INT;

    SELECT COUNT(*) INTO cupo_actual FROM matriculas WHERE id_materia = NEW.id_materia;
    SELECT cupo INTO cupo_maximo FROM materias WHERE id = NEW.id_materia;

    IF cupo_actual >= cupo_maximo THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay cupo disponible en la materia';
    END IF;
END;
