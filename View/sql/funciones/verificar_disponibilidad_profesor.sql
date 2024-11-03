CREATE FUNCTION verificar_disponibilidad_profesor(profesor_id INT, horario_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE disponible BOOLEAN DEFAULT TRUE;

    IF EXISTS (
        SELECT 1 
        FROM asignaciones 
        WHERE cedula_profesor = profesor_id 
          AND id_horario = horario_id
    ) THEN
        SET disponible = FALSE;
    END IF;

    RETURN disponible;
END;
