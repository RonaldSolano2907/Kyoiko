CREATE FUNCTION validar_estudiante_activo(estudiante_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE activo BOOLEAN DEFAULT FALSE;
    SELECT estado INTO activo FROM estudiantes WHERE cedula = estudiante_id;
    RETURN activo;
END;
