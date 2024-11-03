CREATE FUNCTION calcular_promedio_notas(estudiante_id INT) RETURNS FLOAT
BEGIN
    DECLARE promedio FLOAT;
    SELECT AVG(nota) INTO promedio FROM notas WHERE cedula_estudiante = estudiante_id;
    RETURN promedio;
END;
