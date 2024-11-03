CREATE FUNCTION listar_estudiantes_congelamiento() RETURNS TEXT
BEGIN
    DECLARE estudiantes TEXT;
    SELECT GROUP_CONCAT(cedula) INTO estudiantes FROM estudiantes WHERE congelamiento_activo = TRUE;
    RETURN estudiantes;
END;
