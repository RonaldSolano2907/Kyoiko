CREATE FUNCTION obtener_horario_materia(materia_id INT) RETURNS TEXT
BEGIN
    DECLARE horario TEXT;
    SELECT CONCAT(hora_inicio, ' - ', hora_fin) INTO horario FROM horarios WHERE id_materia = materia_id;
    RETURN horario;
END;
