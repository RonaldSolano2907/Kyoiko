CREATE FUNCTION obtener_prerrequisitos(materia_id INT) RETURNS TEXT
BEGIN
    DECLARE prerrequisitos TEXT;
    SELECT GROUP_CONCAT(nombre) INTO prerrequisitos 
    FROM materias m JOIN prerrequisitos p ON m.id = p.id_materia_prerrequisito
    WHERE p.id_materia_principal = materia_id;
    RETURN prerrequisitos;
END;
