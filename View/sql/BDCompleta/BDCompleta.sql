--Tablas
CREATE TABLE Asignacion (
    IDMateria INT,
    CedulaProfesor INT,
    Semestre INT,
    Año INT,
    PRIMARY KEY (IDMateria, CedulaProfesor, Semestre, Año),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID),
    FOREIGN KEY (CedulaProfesor) REFERENCES Profesor(Cedula)
);

CREATE TABLE Congelamientos (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Motivo TEXT,
    FechaInicio DATE,
    FechaFin DATE,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);

CREATE TABLE Departamento (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaJefeDepartamento INT,
    Nombre VARCHAR2(100) NOT NULL,
    Descripcion TEXT,
    FOREIGN KEY (CedulaJefeDepartamento) REFERENCES Profesor(Cedula)
);

CREATE TABLE Direccion (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Provincia VARCHAR2(50),
    Canton VARCHAR2(50),
    Distrito VARCHAR2(50),
    DireccionExacta TEXT,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);

CREATE TABLE Estudiante (
    Cedula INT PRIMARY KEY,
    Nombre VARCHAR2(50) NOT NULL,
    Apellidos VARCHAR2(50) NOT NULL,
    Telefono VARCHAR2(15),
    FechaNacimiento DATE,
    CorreoElectronico VARCHAR2(100),
    FechaInscripcion DATE,
    Estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

CREATE TABLE Horarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    IDMateria INT,
    Aula VARCHAR2(20),
    HorarioInicio TIME,
    HorarioFin TIME,
    DiaSemana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID)
);

CREATE TABLE Materia (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR2(100) NOT NULL,
    Descripcion TEXT,
    Creditos INT NOT NULL
);

CREATE TABLE Matricula (
    CedulaEstudiante INT,
    IDMateria INT,
    Semestre INT,
    Año INT,
    FechaMatricula DATE,
    PRIMARY KEY (CedulaEstudiante, IDMateria, Semestre, Año),
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID)
);

CREATE TABLE Prerrequisitos (
    IDMateriaPrincipal INT,
    IDMateriaPrerrequisito INT,
    PRIMARY KEY (IDMateriaPrincipal, IDMateriaPrerrequisito),
    FOREIGN KEY (IDMateriaPrincipal) REFERENCES Materia(ID),
    FOREIGN KEY (IDMateriaPrerrequisito) REFERENCES Materia(ID)
);

CREATE TABLE Profesor (
    Cedula INT PRIMARY KEY,
    IDDepartamento INT,
    Nombre VARCHAR2(50) NOT NULL,
    Apellidos VARCHAR2(50) NOT NULL,
    Telefono VARCHAR2(15),
    CorreoElectronico VARCHAR2(100),
    FechaInscripcion DATE,
    TituloAcademico VARCHAR2(100),
    FOREIGN KEY (IDDepartamento) REFERENCES Departamento(ID)
);

--Funciones

-- calcular_asistencia
CREATE FUNCTION calcular_asistencia(estudiante_id INT) RETURNS INT
BEGIN
    DECLARE total_asistencia INT;
    SELECT SUM(asistencias) INTO total_asistencia FROM asistencias WHERE cedula_estudiante = estudiante_id;
    RETURN total_asistencia;
END;

--calcular_cantidad_materias_semestre
CREATE FUNCTION calcular_cantidad_materias_semestre(estudiante_id INT, semestre INT, año INT) RETURNS INT
BEGIN
    DECLARE total_materias INT;
    SELECT COUNT(*) INTO total_materias FROM matriculas WHERE cedula_estudiante = estudiante_id AND semestre = semestre AND año = año;
    RETURN total_materias;
END;

--calcular_promedio_notas
CREATE FUNCTION calcular_promedio_notas(estudiante_id INT) RETURNS FLOAT
BEGIN
    DECLARE promedio FLOAT;
    SELECT AVG(nota) INTO promedio FROM notas WHERE cedula_estudiante = estudiante_id;
    RETURN promedio;
END;

--contar_congelamientos_activos
CREATE FUNCTION contar_congelamientos_activos(estudiante_id INT) RETURNS INT
BEGIN
    DECLARE total_congelamientos INT;
    SELECT COUNT(*) INTO total_congelamientos FROM congelamientos WHERE cedula_estudiante = estudiante_id AND (fecha_fin IS NULL OR fecha_fin > CURRENT_DATE);
    RETURN total_congelamientos;
END;

--contar_estudiantes_materia
CREATE FUNCTION contar_estudiantes_materia(materia_id INT) RETURNS INT
BEGIN
    DECLARE total_estudiantes INT;
    SELECT COUNT(*) INTO total_estudiantes FROM matriculas WHERE id_materia = materia_id;
    RETURN total_estudiantes;
END;

--contar_materias_profesor
CREATE FUNCTION contar_materias_profesor(profesor_id INT) RETURNS INT
BEGIN
    DECLARE total_materias INT;
    SELECT COUNT(*) INTO total_materias FROM asignaciones WHERE cedula_profesor = profesor_id;
    RETURN total_materias;
END;

--listar_estudiantes_congelamiento
CREATE FUNCTION listar_estudiantes_congelamiento() RETURNS TEXT
BEGIN
    DECLARE estudiantes TEXT;
    SELECT GROUP_CONCAT(cedula) INTO estudiantes FROM estudiantes WHERE congelamiento_activo = TRUE;
    RETURN estudiantes;
END;

--listar_materias_estudiante
CREATE FUNCTION listar_materias_estudiante(estudiante_id INT) RETURNS TEXT
BEGIN
    DECLARE materias TEXT;
    SELECT GROUP_CONCAT(nombre_materia) INTO materias 
    FROM materias m JOIN matriculas mat ON m.id = mat.id_materia 
    WHERE mat.cedula_estudiante = estudiante_id;
    RETURN materias;
END;

--obtener_horario_materia
CREATE FUNCTION obtener_horario_materia(materia_id INT) RETURNS TEXT
BEGIN
    DECLARE horario TEXT;
    SELECT CONCAT(hora_inicio, ' - ', hora_fin) INTO horario FROM horarios WHERE id_materia = materia_id;
    RETURN horario;
END;

--obtener_prerrequisitos
CREATE FUNCTION obtener_prerrequisitos(materia_id INT) RETURNS TEXT
BEGIN
    DECLARE prerrequisitos TEXT;
    SELECT GROUP_CONCAT(nombre) INTO prerrequisitos 
    FROM materias m JOIN prerrequisitos p ON m.id = p.id_materia_prerrequisito
    WHERE p.id_materia_principal = materia_id;
    RETURN prerrequisitos;
END;

--validar_estudiante_activo
CREATE FUNCTION validar_estudiante_activo(estudiante_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE activo BOOLEAN DEFAULT FALSE;
    SELECT estado INTO activo FROM estudiantes WHERE cedula = estudiante_id;
    RETURN activo;
END;

--validar_prerrequisitos
CREATE FUNCTION validar_prerrequisitos(estudiante_id INT, materia_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE cumple_prerrequisitos BOOLEAN DEFAULT TRUE;
    DECLARE prerrequisito_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id_materia_prerrequisito 
        FROM prerrequisitos 
        WHERE id_materia_principal = materia_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cumple_prerrequisitos = FALSE;

    OPEN cur;

    prerrequisito_loop: LOOP
        FETCH cur INTO prerrequisito_id;
        
        IF NOT EXISTS (
            SELECT 1 
            FROM materias_aprobadas 
            WHERE cedula_estudiante = estudiante_id 
              AND id_materia = prerrequisito_id
        ) THEN
            SET cumple_prerrequisitos = FALSE;
            LEAVE prerrequisito_loop;
        END IF;
    END LOOP;

    CLOSE cur;

    RETURN cumple_prerrequisitos;
END;

--verificar_disponibilidad_profesor
CREATE FUNCTION verificar_disponibilidad_profesor(profesor_id INT, horario_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE disponible BOOLEAN DEFAULT TRUE;

    IF EXISTS (
        SELECT 1 
        FROM asignaciones 
        WHERE cedula_profesor = profesor_id 
          AND id_horario = horario_id
    ) THEN
        SET disponible = FALSE;
    END IF;

    RETURN disponible;
END;

--verificar_estado_matricula
CREATE FUNCTION verificar_estado_matricula(estudiante_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE estado BOOLEAN;
    SELECT estado INTO estado FROM matriculas WHERE cedula_estudiante = estudiante_id;
    RETURN estado;
END;

--verificar_requisitos_matricula
CREATE FUNCTION verificar_requisitos_matricula(estudiante_id INT, materia_id INT) RETURNS BOOLEAN
BEGIN
    DECLARE cumple_requisitos BOOLEAN DEFAULT TRUE;
    DECLARE prerrequisito_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id_materia_prerrequisito 
        FROM prerrequisitos 
        WHERE id_materia_principal = materia_id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cumple_requisitos = FALSE;

    OPEN cur;

    requisitos_loop: LOOP
        FETCH cur INTO prerrequisito_id;
        
        IF NOT EXISTS (
            SELECT 1 
            FROM materias_aprobadas 
            WHERE cedula_estudiante = estudiante_id 
              AND id_materia = prerrequisito_id
        ) THEN
            SET cumple_requisitos = FALSE;
            LEAVE requisitos_loop;
        END IF;
    END LOOP;

    CLOSE cur;

    RETURN cumple_requisitos;
END;

--Triggers

--actualizar_asistencia
CREATE TRIGGER actualizar_asistencia
AFTER INSERT ON asistencias
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET total_asistencia = (SELECT SUM(asistencias) FROM asistencias WHERE cedula_estudiante = NEW.cedula_estudiante)
    WHERE cedula = NEW.cedula_estudiante;
END;

CREATE TRIGGER actualizar_asistencia_update
AFTER UPDATE ON asistencias
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET total_asistencia = (SELECT SUM(asistencias) FROM asistencias WHERE cedula_estudiante = NEW.cedula_estudiante)
    WHERE cedula = NEW.cedula_estudiante;
END;

--cupo_materia
CREATE TRIGGER cupo_materia
BEFORE INSERT ON matriculas
FOR EACH ROW
BEGIN
    DECLARE cupo_actual INT;
    DECLARE cupo_maximo INT;

    SELECT COUNT(*) INTO cupo_actual FROM matriculas WHERE id_materia = NEW.id_materia;
    SELECT cupo INTO cupo_maximo FROM materias WHERE id = NEW.id_materia;

    IF cupo_actual >= cupo_maximo THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay cupo disponible en la materia';
    END IF;
END;

--estado_estudiante
CREATE TRIGGER estado_estudiante
AFTER INSERT ON congelamientos
FOR EACH ROW
BEGIN
    UPDATE estudiantes
    SET estado = 'inactivo'
    WHERE cedula = NEW.cedula_estudiante;
END;

CREATE TRIGGER finalizar_congelamiento
AFTER UPDATE ON congelamientos
FOR EACH ROW
BEGIN
    IF NEW.fecha_fin IS NOT NULL THEN
        UPDATE estudiantes
        SET estado = 'activo'
        WHERE cedula = NEW.cedula_estudiante;
    END IF;
END;

--limitar_asignaciones
CREATE TRIGGER limitar_asignaciones
BEFORE INSERT ON asignaciones
FOR EACH ROW
BEGIN
    DECLARE total_asignaciones INT;

    SELECT COUNT(*) INTO total_asignaciones
    FROM asignaciones
    WHERE cedula_profesor = NEW.cedula_profesor
      AND semestre = NEW.semestre
      AND año = NEW.año;

    IF total_asignaciones >= 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El profesor ya tiene el máximo de asignaciones permitidas en este semestre';
    END IF;
END;

--prerrequisitos_inscripcion
CREATE TRIGGER prerrequisitos_inscripcion
BEFORE INSERT ON matriculas
FOR EACH ROW
BEGIN
    DECLARE cumple BOOLEAN DEFAULT TRUE;
    DECLARE prerrequisito_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id_materia_prerrequisito 
        FROM prerrequisitos 
        WHERE id_materia_principal = NEW.id_materia;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cumple = FALSE;

    OPEN cur;

    verificar_loop: LOOP
        FETCH cur INTO prerrequisito_id;
        IF NOT cumple THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cumple con los prerrequisitos';
            LEAVE verificar_loop;
        END IF;
        
        IF NOT EXISTS (
            SELECT 1 
            FROM materias_aprobadas 
            WHERE cedula_estudiante = NEW.cedula_estudiante 
              AND id_materia = prerrequisito_id
        ) THEN
            SET cumple = FALSE;
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No cumple con los prerrequisitos';
            LEAVE verificar_loop;
        END IF;
    END LOOP;

    CLOSE cur;
END;


--Vistas

--vista_congelamientos_activos
CREATE VIEW vista_congelamientos_activos AS
SELECT e.cedula, e.nombre, e.apellido, c.fecha_inicio, c.fecha_fin
FROM estudiantes e
JOIN congelamientos c ON e.cedula = c.cedula_estudiante
WHERE c.fecha_fin IS NULL OR c.fecha_fin > CURRENT_DATE;

--vista_departamentos_profesores
CREATE VIEW vista_departamentos_profesores AS
SELECT d.nombre AS departamento, p.nombre AS profesor, p.apellido
FROM departamentos d
JOIN profesores p ON d.cedula_jefe = p.cedula;

--vista_estudiantes_departamento
CREATE VIEW vista_estudiantes_departamento AS
SELECT d.nombre AS departamento, e.cedula, e.nombre, e.apellido
FROM departamentos d
JOIN estudiantes e ON d.id = e.id_departamento;

--vista_estudiantes_matriculados
CREATE VIEW vista_estudiantes_matriculados AS
SELECT e.cedula, e.nombre, e.apellido, m.nombre_materia, mat.semestre, mat.año
FROM estudiantes e
JOIN matriculas mat ON e.cedula = mat.cedula_estudiante
JOIN materias m ON mat.id_materia = m.id;

--vista_historial_matricula
CREATE VIEW vista_historial_matricula AS
SELECT e.cedula, e.nombre, e.apellido, m.nombre_materia, mat.fecha_matricula, mat.semestre, mat.año
FROM estudiantes e
JOIN matriculas mat ON e.cedula = mat.cedula_estudiante
JOIN materias m ON mat.id_materia = m.id;

--vista_horarios_clases
CREATE VIEW vista_horarios_clases AS
SELECT m.nombre AS materia, h.aula, h.hora_inicio, h.hora_fin, h.dia_semana
FROM horarios h
JOIN materias m ON h.id_materia = m.id;

--vista_materias_inscritos
CREATE VIEW vista_materias_inscritos AS
SELECT m.nombre AS materia, COUNT(mat.cedula_estudiante) AS inscritos
FROM materias m
LEFT JOIN matriculas mat ON m.id = mat.id_materia
GROUP BY m.nombre;

--vista_materias_prerrequisitos
CREATE VIEW vista_materias_prerrequisitos AS
SELECT m.nombre AS materia, p.nombre AS prerrequisito
FROM prerrequisitos pr
JOIN materias m ON pr.id_materia_principal = m.id
JOIN materias p ON pr.id_materia_prerrequisito = p.id;

--vista_profesores_asignados
CREATE VIEW vista_profesores_asignados AS
SELECT p.cedula, p.nombre, p.apellido, m.nombre_materia, a.semestre, a.año
FROM profesores p
JOIN asignaciones a ON p.cedula = a.cedula_profesor
JOIN materias m ON a.id_materia = m.id;

--vista_profesores_materias
CREATE VIEW vista_profesores_materias AS
SELECT p.cedula, p.nombre, p.apellido, COUNT(a.id_materia) AS numero_materias
FROM profesores p
LEFT JOIN asignaciones a ON p.cedula = a.cedula_profesor
GROUP BY p.cedula, p.nombre, p.apellido;
