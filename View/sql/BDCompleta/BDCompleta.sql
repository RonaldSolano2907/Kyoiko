--Tablas

--TABLA ESTUDIANTE
CREATE TABLE Estudiante (
    Cedula VARCHAR2(9) PRIMARY KEY NOT NULL,
    IdEstudiante VARCHAR2(100) NOT NULL,
    Nombre VARCHAR2(50) NOT NULL,
    Apellido1 VARCHAR2(50) NOT NULL,
    Telefono VARCHAR2(15),
    FechaNacimiento DATE,
    CorreoElectronico VARCHAR2(100),
    FechaInscripcion DATE,
    Estado VARCHAR2(10) DEFAULT 'activo' CHECK (Estado IN ('activo', 'inactivo'))
);

--INSERTS ESTUDIANTE
INSERT INTO Estudiante (
    Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
) VALUES (
    '123456789', 'EST001', 'Juan', 'Perez', '88888888', DATE '1995-05-15', 'juan.perez@gmail.com', DATE '2024-01-15', 'activo');

INSERT INTO Estudiante (
    Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
) VALUES (
    '987654321', 'EST002', 'Ana', 'Gomez', '87776655', DATE '1997-09-10', 'ana.gomez@hotmail.com', DATE '2023-12-01', 'activo');
INSERT INTO Estudiante (
    Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
) VALUES (
    '456789123', 'EST003', 'Luis', 'Ramirez', '89990000', DATE '1999-03-25', 'luis.ramirez@gmail.com', DATE '2022-05-20', 'inactivo');

INSERT INTO Estudiante (
    Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
) VALUES (
    '321654987', 'EST004', 'Maria', 'Lopez', '86667744', DATE '1996-07-08', 'maria.lopez@yahoo.com', DATE '2021-10-10', 'activo');
INSERT INTO Estudiante (
    Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
) VALUES (
    '789123456', 'EST005', 'Carlos', 'Fernandez', '85554433', DATE '2000-12-30', 'carlos.fernandez@gmail.com', DATE '2024-02-14', 'inactivo');
--TABLA DIRECCION
CREATE TABLE Direccion (
    IdDireccion INT PRIMARY KEY NOT NULL,
    Provincia VARCHAR2(50),
    Canton VARCHAR2(50),
    Distrito VARCHAR2(50),
    DireccionExacta  VARCHAR2(100),
    CedulaEstudiante VARCHAR2(9),
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);

--INSERTS DIRECCION
INSERT INTO Direccion (IdDireccion, Provincia, Canton, Distrito, DireccionExacta, CedulaEstudiante)
VALUES (1, 'San Jose', 'Central', 'Carmen', 'Calle 1, Avenida 2, casa amarilla', '123456789');

INSERT INTO Direccion (IdDireccion, Provincia, Canton, Distrito, DireccionExacta, CedulaEstudiante)
VALUES (3, 'Alajuela', 'Central', 'San Jose', 'Barrio La Paz, del parque 200 metros este', '987654321');

INSERT INTO Direccion (IdDireccion, Provincia, Canton, Distrito, DireccionExacta, CedulaEstudiante)
VALUES (4, 'Heredia', 'Central', 'San Francisco', 'Residencial El Prado, casa 15', '456789123');

INSERT INTO Direccion (IdDireccion, Provincia, Canton, Distrito, DireccionExacta, CedulaEstudiante)
VALUES (2, 'Cartago', 'La Union', 'Tres Rios', 'Del supermercado 300 metros norte', '321654987');

INSERT INTO Direccion (IdDireccion, Provincia, Canton, Distrito, DireccionExacta, CedulaEstudiante)
VALUES (6, 'Puntarenas', 'Central', 'Barranca', 'Frente a la iglesia principal', '789123456');

--TABLA MATERIA
CREATE TABLE Materia (
    IdMateria INT PRIMARY KEY NOT NULL,
    Nombre VARCHAR2(100) NOT NULL,
    Descripcion VARCHAR2(100),
    Creditos INT NOT NULL
);
-- INSERTS MATERIA
INSERT INTO Materia (IdMateria, Nombre, Descripcion, Creditos)
VALUES (1001, 'Matematicas', 'Calculo diferencial e integral', 4);
 
INSERT INTO Materia (IdMateria, Nombre, Descripcion, Creditos)
VALUES (1002, 'Fisica', 'Introduccion a la fisica clasica', 3);
 
INSERT INTO Materia (IdMateria, Nombre, Descripcion, Creditos)
VALUES (1003, 'Quimica', 'Quimica general y aplicada', 4);
 
INSERT INTO Materia (IdMateria, Nombre, Descripcion, Creditos)
VALUES (1004, 'Historia', 'Historia de Costa Rica', 2);
 
INSERT INTO Materia (IdMateria, Nombre, Descripcion, Creditos)
VALUES (1005, 'Ingles', 'Curso avanzado de ingles tecnico', 3);

--TABLA HORARIOS
CREATE TABLE Horarios (
    IdHorario INT PRIMARY KEY NOT NULL,
    Aula VARCHAR2(20),
    HorarioInicio TIMESTAMP, 
    HorarioFin TIMESTAMP,    
    IdMateria INT,
    DiaSemana VARCHAR2(15),
    FOREIGN KEY (IdMateria) REFERENCES Materia(IdMateria),
    CONSTRAINT chk_dia_semana CHECK (DiaSemana IN (
        'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) 
);
-- INSERTS HORARIOS
INSERT INTO Horarios (IdHorario, Aula, HorarioInicio, HorarioFin, IdMateria, DiaSemana)
VALUES (1, 'A101', TO_TIMESTAMP('08:00:00', 'HH24:MI:SS'), TO_TIMESTAMP('10:00:00', 'HH24:MI:SS'), 1001, 'Lunes');

INSERT INTO Horarios (IdHorario, Aula, HorarioInicio, HorarioFin, IdMateria, DiaSemana)
VALUES (2, 'B202', TO_TIMESTAMP('10:30:00', 'HH24:MI:SS'), TO_TIMESTAMP('12:30:00', 'HH24:MI:SS'), 1002, 'Martes');

INSERT INTO Horarios (IdHorario, Aula, HorarioInicio, HorarioFin, IdMateria, DiaSemana)
VALUES (3, 'C303', TO_TIMESTAMP('14:00:00', 'HH24:MI:SS'), TO_TIMESTAMP('16:00:00', 'HH24:MI:SS'), 1003, 'Miercoles');

INSERT INTO Horarios (IdHorario, Aula, HorarioInicio, HorarioFin, IdMateria, DiaSemana)
VALUES (4, 'D404', TO_TIMESTAMP('09:00:00', 'HH24:MI:SS'), TO_TIMESTAMP('11:00:00', 'HH24:MI:SS'), 1004, 'Jueves');

INSERT INTO Horarios (IdHorario, Aula, HorarioInicio, HorarioFin, IdMateria, DiaSemana)
VALUES (5, 'E505', TO_TIMESTAMP('15:00:00', 'HH24:MI:SS'), TO_TIMESTAMP('17:00:00', 'HH24:MI:SS'), 1005, 'Viernes');

--TABLA CONGELAMIENTOS
CREATE TABLE Congelamientos (
    IdCongelamiento INT PRIMARY KEY NOT NULL,
    Motivo VARCHAR2(100),
    FechaInicio DATE,
    FechaFin DATE,
    CedulaEstudiante VARCHAR2(9),
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);
-- INSERTS CONGELAMIENTOS
INSERT INTO Congelamientos (IdCongelamiento, Motivo, FechaInicio, FechaFin, CedulaEstudiante)
VALUES (1, 'Problemas de salud', DATE '2023-01-15', DATE '2023-06-15', '123456789');
 
INSERT INTO Congelamientos (IdCongelamiento, Motivo, FechaInicio, FechaFin, CedulaEstudiante)
VALUES (2, 'Viaje academico', DATE '2023-08-01', DATE '2023-12-01', '987654321');
 
INSERT INTO Congelamientos (IdCongelamiento, Motivo, FechaInicio, FechaFin, CedulaEstudiante)
VALUES (3, 'Razones familiares', DATE '2024-03-01', DATE '2024-07-01', '456789123');
 
INSERT INTO Congelamientos (IdCongelamiento, Motivo, FechaInicio, FechaFin, CedulaEstudiante)
VALUES (4, 'Problemas economicos', DATE '2024-05-15', DATE '2024-09-15', '321654987');
 
INSERT INTO Congelamientos (IdCongelamiento, Motivo, FechaInicio, FechaFin, CedulaEstudiante)
VALUES (5, 'Participacion en eventos deportivos', DATE '2024-10-01', DATE '2024-12-31', '789123456');

--TABLA MATRICULA
CREATE TABLE Matricula (
    IdMatricula VARCHAR2(100) PRIMARY KEY NOT NULL,
    Semestre INT,
    Ano INT,
    FechaMatricula DATE,
    CedulaEstudiante VARCHAR2(9),
    IdMateria INT,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula),
    FOREIGN KEY (IdMateria) REFERENCES Materia(IdMateria)
);

-- INSERTS MATRICULA

INSERT INTO Matricula (IdMatricula, Semestre, Ano, FechaMatricula, CedulaEstudiante, IdMateria)
VALUES ('MATR001', 1, 2024, DATE '2024-01-15', '123456789', 1001);
 
INSERT INTO Matricula (IdMatricula, Semestre, Ano, FechaMatricula, CedulaEstudiante, IdMateria)
VALUES ('MATR002', 1, 2024, DATE '2024-02-20', '987654321', 1002);
 
INSERT INTO Matricula (IdMatricula, Semestre, Ano, FechaMatricula, CedulaEstudiante, IdMateria)
VALUES ('MATR003', 2, 2024, DATE '2024-03-10', '456789123', 1003);
 
INSERT INTO Matricula (IdMatricula, Semestre, Ano, FechaMatricula, CedulaEstudiante, IdMateria)
VALUES ('MATR004', 2, 2023, DATE '2023-07-01', '321654987', 1004);
 
INSERT INTO Matricula (IdMatricula, Semestre, Ano, FechaMatricula, CedulaEstudiante, IdMateria)
VALUES ('MATR005', 1, 2023, DATE '2023-09-15', '789123456', 1005);

--TABLA PRERREQUISITOS
CREATE TABLE Prerrequisitos (
    IdPrerrequisito INT PRIMARY KEY NOT NULL,
    IDMateriaPrincipal INT,
    IDMateriaPrerrequisito INT,
    FOREIGN KEY (IDMateriaPrincipal) REFERENCES Materia(IdMateria),
    FOREIGN KEY (IDMateriaPrerrequisito) REFERENCES Materia(IdMateria)
);

-- INSERTS PRERREQUISITOS

INSERT INTO Prerrequisitos (IdPrerrequisito, IdMateriaPrincipal, IdMateriaPrerrequisito)
VALUES (1, 1002, 1001);
 
INSERT INTO Prerrequisitos (IdPrerrequisito, IdMateriaPrincipal, IdMateriaPrerrequisito)
VALUES (2, 1003, 1002);
 
INSERT INTO Prerrequisitos (IdPrerrequisito, IdMateriaPrincipal, IdMateriaPrerrequisito)
VALUES (3, 1004, 1003);
 
INSERT INTO Prerrequisitos (IdPrerrequisito, IdMateriaPrincipal, IdMateriaPrerrequisito)
VALUES (4, 1005, 1004);
 
INSERT INTO Prerrequisitos (IdPrerrequisito, IdMateriaPrincipal, IdMateriaPrerrequisito)
VALUES (5, 1003, 1001);

--TABLA JEFES DEPARTAMENTOS
CREATE TABLE JEFES_DEPARTAMENTOS(
    Cedula VARCHAR2(9) NOT NULL PRIMARY KEY,
    Nombre VARCHAR2(100) NOT NULL,
    PrimerApellido VARCHAR(100) NOT NULL,
    SegundoApellido VARCHAR(100) NOT NULL
);

-- INSERTS JEFES DEPARTAMENTOS

INSERT INTO JEFES_DEPARTAMENTOS (Cedula, Nombre, PrimerApellido, SegundoApellido)
VALUES ('123456789', 'Carlos', 'Perez', 'Rodriguez');
 
INSERT INTO JEFES_DEPARTAMENTOS (Cedula, Nombre, PrimerApellido, SegundoApellido)
VALUES ('987654321', 'Maria', 'Gomez', 'Fernandez');
 
INSERT INTO JEFES_DEPARTAMENTOS (Cedula, Nombre, PrimerApellido, SegundoApellido)
VALUES ('456789123', 'Luis', 'Ramirez', 'Lopez');
 
INSERT INTO JEFES_DEPARTAMENTOS (Cedula, Nombre, PrimerApellido, SegundoApellido)
VALUES ('321654987', 'Ana', 'Martinez', 'Castro');
 
INSERT INTO JEFES_DEPARTAMENTOS (Cedula, Nombre, PrimerApellido, SegundoApellido)
VALUES ('789123456', 'Jose', 'Hernandez', 'Morales');

--TABLA DEPARTAMENTO
CREATE TABLE Departamento (
    IdDepartamento INT PRIMARY KEY NOT NULL,
    Nombre VARCHAR2(100) NOT NULL,
    Descripcion VARCHAR2(100) NOT NULL,
    CedulaJefeDepartamento VARCHAR2(9) NOT NULL,
    FOREIGN KEY (CedulaJefeDepartamento) REFERENCES JEFES_DEPARTAMENTOS(Cedula)
);

-- INSERTS  DEPARTAMENTO

NSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
VALUES (1, 'Informatica', 'Departamento de Tecnologia e Informatica', '123456789');
 
INSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
VALUES (2, 'Administracion', 'Departamento de Gestion Administrativa', '987654321');
 
INSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
VALUES (3, 'Recursos Humanos', 'Departamento de Gestion del Talento Humano', '456789123');
 
INSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
VALUES (4, 'Marketing', 'Departamento de Promocion y Ventas', '321654987');
 
INSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
VALUES (5, 'Finanzas', 'Departamento de Gestion Financiera', '789123456');

--TABLA PROFESOR
CREATE TABLE PROFESORES (
    Cedula VARCHAR2(9) NOT NULL PRIMARY KEY,
    Nombre VARCHAR2(100) NOT NULL,
    PrimerApellido VARCHAR2(100) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    Correo_Electronico VARCHAR2(100) NOT NULL,
    TituloAcademico VARCHAR2(100) NOT NULL,
    IdDepartamento INT NOT NULL,
    CONSTRAINT FK_Id_Departamento FOREIGN KEY (IdDepartamento) REFERENCES DEPARTAMENTO(IdDepartamento)
);

-- INSERTS  PROFESOR

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, CorreoElectronico, TituloAcademico, IdDepartamento)
VALUES ('123456789', 'Carlos', 'Lopez', DATE '1985-03-15', 'carlos.lopez@uninformatica.com', 'Doctor en Informatica', 1);
 
INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, CorreoElectronico, TituloAcademico, IdDepartamento)
VALUES ('987654321', 'Maria', 'Hernandez', DATE '1990-06-20', 'maria.hernandez@unadministracion.com', 'Master en Administracion', 2);
 
INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, CorreoElectronico, TituloAcademico, IdDepartamento)
VALUES ('456789123', 'Luis', 'Castro', DATE '1980-11-05', 'luis.castro@unrecursoshumanos.com', 'Licenciatura en Psicologia', 3);
 
INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, CorreoElectronico, TituloAcademico, IdDepartamento)
VALUES ('321654987', 'Ana', 'Mora', DATE '1988-01-10', 'ana.mora@unmarketing.com', 'Master en Marketing', 4);
 
INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, CorreoElectronico, TituloAcademico, IdDepartamento)
VALUES ('789123456', 'Jose', 'Rodriguez', DATE '1975-08-25', 'jose.rodriguez@unfinanzas.com', 'Doctor en Finanzas', 5);

--TABLA ASIGNACION
CREATE TABLE Asignacion (
    IdAsignacion VARCHAR2(100) PRIMARY KEY NOT NULL,
    Semestre INT,
    Ano INT,
    IdMateria INT,
    CedulaProfesor VARCHAR(9),
    FOREIGN KEY (IdMateria) REFERENCES Materia(IdMateria),
    FOREIGN KEY (CedulaProfesor) REFERENCES Profesores(Cedula)
);

-- INSERTS  ASIGNACION

INSERT INTO Asignacion (IdAsignacion, Semestre, Ano, IdMateria, CedulaProfesor)
VALUES ('ASIG001', 1, 2024, 1001, '123456789');
 
INSERT INTO Asignacion (IdAsignacion, Semestre, Ano, IdMateria, CedulaProfesor)
VALUES ('ASIG002', 1, 2024, 1002, '987654321');
 
INSERT INTO Asignacion (IdAsignacion, Semestre, Ano, IdMateria, CedulaProfesor)
VALUES ('ASIG003', 2, 2024, 1003, '456789123');
 
INSERT INTO Asignacion (IdAsignacion, Semestre, Ano, IdMateria, CedulaProfesor)
VALUES ('ASIG004', 2, 2024, 1004, '321654987');
 
INSERT INTO Asignacion (IdAsignacion, Semestre, Ano, IdMateria, CedulaProfesor)
VALUES ('ASIG005', 1, 2023, 1005, '789123456');

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
SELECT e.Cedula, e.Nombre, e.Apellido1, c.FechaInicio, c.FechaFin
FROM ESTUDIANTE e
JOIN CONGELAMIENTOS c ON e.Cedula = c.CedulaEstudiante
WHERE c.FechaFin IS NULL OR c.FechaFin > CURRENT_DATE;

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


