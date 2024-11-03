CREATE FUNCTION contar_congelamientos_activos(estudiante_id INT) RETURNS INT
BEGIN
    DECLARE total_congelamientos INT;
    SELECT COUNT(*) INTO total_congelamientos FROM congelamientos WHERE cedula_estudiante = estudiante_id AND (fecha_fin IS NULL OR fecha_fin > CURRENT_DATE);
    RETURN total_congelamientos;
END;
