CREATE FUNCTION calcular_cantidad_materias_semestre(estudiante_id INT, semestre INT, año INT) RETURNS INT
BEGIN
    DECLARE total_materias INT;
    SELECT COUNT(*) INTO total_materias FROM matriculas WHERE cedula_estudiante = estudiante_id AND semestre = semestre AND año = año;
    RETURN total_materias;
END;
