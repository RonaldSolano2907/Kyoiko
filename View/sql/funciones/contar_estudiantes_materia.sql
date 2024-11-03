CREATE FUNCTION contar_estudiantes_materia(materia_id INT) RETURNS INT
BEGIN
    DECLARE total_estudiantes INT;
    SELECT COUNT(*) INTO total_estudiantes FROM matriculas WHERE id_materia = materia_id;
    RETURN total_estudiantes;
END;
