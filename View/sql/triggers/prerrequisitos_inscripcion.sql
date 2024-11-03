CREATE TRIGGER prerrequisitos_inscripcion
BEFORE INSERT ON matriculas
FOR EACH ROW
BEGIN
    DECLARE cumple BOOLEAN DEFAULT TRUE;
    DECLARE prerrequisito_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id_materia_prerrequisito 
        FROM prerrequisitos 
        WHERE id_materia_principal = NEW.id_materia;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cumple = FALSE;

    OPEN cur;

    verificar_loop: LOOP
        FETCH cur INTO prerrequisito_id;
        IF NOT cumple THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cumple con los prerrequisitos';
            LEAVE verificar_loop;
        END IF;
        
        IF NOT EXISTS (
            SELECT 1 
            FROM materias_aprobadas 
            WHERE cedula_estudiante = NEW.cedula_estudiante 
              AND id_materia = prerrequisito_id
        ) THEN
            SET cumple = FALSE;
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cumple con los prerrequisitos';
            LEAVE verificar_loop;
        END IF;
    END LOOP;

    CLOSE cur;
END;
