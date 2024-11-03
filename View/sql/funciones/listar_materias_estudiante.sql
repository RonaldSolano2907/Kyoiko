CREATE FUNCTION listar_materias_estudiante(estudiante_id INT) RETURNS TEXT
BEGIN
    DECLARE materias TEXT;
    SELECT GROUP_CONCAT(nombre_materia) INTO materias 
    FROM materias m JOIN matriculas mat ON m.id = mat.id_materia 
    WHERE mat.cedula_estudiante = estudiante_id;
    RETURN materias;
END;
