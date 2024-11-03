CREATE FUNCTION verificar_estado_matricula(estudiante_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE estado BOOLEAN;
    SELECT estado INTO estado FROM matriculas WHERE cedula_estudiante = estudiante_id;
    RETURN estado;
END;
