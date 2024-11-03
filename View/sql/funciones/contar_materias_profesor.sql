CREATE FUNCTION contar_materias_profesor(profesor_id INT) RETURNS INT
BEGIN
    DECLARE total_materias INT;
    SELECT COUNT(*) INTO total_materias FROM asignaciones WHERE cedula_profesor = profesor_id;
    RETURN total_materias;
END;
