CREATE FUNCTION validar_prerrequisitos(estudiante_id INT, materia_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE cumple_prerrequisitos BOOLEAN DEFAULT TRUE;
    DECLARE prerrequisito_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id_materia_prerrequisito 
        FROM prerrequisitos 
        WHERE id_materia_principal = materia_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cumple_prerrequisitos = FALSE;

    OPEN cur;

    prerrequisito_loop: LOOP
        FETCH cur INTO prerrequisito_id;
        
        IF NOT EXISTS (
            SELECT 1 
            FROM materias_aprobadas 
            WHERE cedula_estudiante = estudiante_id 
              AND id_materia = prerrequisito_id
        ) THEN
            SET cumple_prerrequisitos = FALSE;
            LEAVE prerrequisito_loop;
        END IF;
    END LOOP;

    CLOSE cur;

    RETURN cumple_prerrequisitos;
END;
