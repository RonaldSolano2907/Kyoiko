CREATE TABLE Usuarios (
    Usuario VARCHAR2(50) PRIMARY KEY,
    Clave VARCHAR2(50) NOT NULL,
    Rol VARCHAR2(20) DEFAULT 'admin' 
);

-- Insertamos un usuario
INSERT INTO Usuarios (Usuario, Clave, Rol)
VALUES ('admin', '12345', 'admin');
COMMIT;

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
INSERT INTO Departamento (IdDepartamento, Nombre, Descripcion, CedulaJefeDepartamento)
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

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, Correo_Electronico, TituloAcademico, IdDepartamento)
VALUES ('123456789', 'Carlos', 'Lopez', DATE '1985-03-15', 'carlos.lopez@uninformatica.com', 'Doctor en Informatica', 1);

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, Correo_Electronico, TituloAcademico, IdDepartamento)
VALUES ('987654321', 'Maria', 'Hernandez', DATE '1990-06-20', 'maria.hernandez@unadministracion.com', 'Master en Administracion', 2);

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, Correo_Electronico, TituloAcademico, IdDepartamento)
VALUES ('456789123', 'Luis', 'Castro', DATE '1980-11-05', 'luis.castro@unrecursoshumanos.com', 'Licenciatura en Psicologia', 3);

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, Correo_Electronico, TituloAcademico, IdDepartamento)
VALUES ('321654987', 'Ana', 'Mora', DATE '1988-01-10', 'ana.mora@unmarketing.com', 'Master en Marketing', 4);

INSERT INTO Profesores (Cedula, Nombre, PrimerApellido, FechaNacimiento, Correo_Electronico, TituloAcademico, IdDepartamento)
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

--creación de FUNCIONES 
-- Función 1: Total de estudiantes registrados
CREATE OR REPLACE FUNCTION TotalEstudiantesRegistrados RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Estudiante;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30001, 'Error al obtener total de estudiantes registrados: ' || SQLERRM);
END TotalEstudiantesRegistrados;
/

-- Función 2: Estudiantes activos
CREATE OR REPLACE FUNCTION TotalEstudiantesActivos RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Estudiante WHERE Estado = 'activo';
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30002, 'Error al obtener total de estudiantes activos: ' || SQLERRM);
END TotalEstudiantesActivos;
/

-- Función 3: Estudiantes inactivos
CREATE OR REPLACE FUNCTION TotalEstudiantesInactivos RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Estudiante WHERE Estado = 'inactivo';
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30003, 'Error al obtener total de estudiantes inactivos: ' || SQLERRM);
END TotalEstudiantesInactivos;
/

-- Función 4: Edad promedio de los estudiantes
CREATE OR REPLACE FUNCTION EdadPromedioEstudiantes RETURN NUMBER IS
    v_EdadPromedio NUMBER;
BEGIN
    SELECT ROUND(AVG(FLOOR(MONTHS_BETWEEN(SYSDATE, FechaNacimiento) / 12)), 2)
    INTO v_EdadPromedio
    FROM Estudiante
    WHERE Estado = 'activo';
    RETURN v_EdadPromedio;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30004, 'Error al calcular edad promedio de estudiantes: ' || SQLERRM);
END EdadPromedioEstudiantes;


-- Función 5: Estudiantes con matrícula activa
CREATE OR REPLACE FUNCTION EstudiantesConMatriculaActiva RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(DISTINCT CedulaEstudiante) INTO v_Total FROM Matricula;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30005, 'Error al obtener estudiantes con matrícula activa: ' || SQLERRM);
END EstudiantesConMatriculaActiva;
/

-- Función 6: Total de profesores registrados
CREATE OR REPLACE FUNCTION TotalProfesoresRegistrados RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Profesores;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30006, 'Error al obtener total de profesores registrados: ' || SQLERRM);
END TotalProfesoresRegistrados;
/

-- Función 7: Materias asignadas
CREATE OR REPLACE FUNCTION TotalMateriasAsignadas RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Asignacion;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30007, 'Error al obtener total de materias asignadas: ' || SQLERRM);
END TotalMateriasAsignadas;
/

-- Función 8: Promedio de materias por profesor
CREATE OR REPLACE FUNCTION PromedioMateriasPorProfesor RETURN NUMBER IS
    v_Promedio NUMBER;
BEGIN
    SELECT AVG(MateriasAsignadas) INTO v_Promedio
    FROM (
        SELECT COUNT(*) AS MateriasAsignadas
        FROM Asignacion
        GROUP BY CedulaProfesor
    );
    RETURN v_Promedio;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30008, 'Error al calcular promedio de materias por profesor: ' || SQLERRM);
END PromedioMateriasPorProfesor;
/

-- Función 9: Profesores con titulaciones avanzadas
CREATE OR REPLACE FUNCTION ProfesoresConTitulacionesAvanzadas RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total
    FROM Profesores
    WHERE LOWER(TituloAcademico) IN ('maestría', 'maestria', 'doctorado');
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30009, 'Error al obtener profesores con titulaciones avanzadas: ' || SQLERRM);
END ProfesoresConTitulacionesAvanzadas;
/

-- Función 10: Carga horaria promedio por profesor
CREATE OR REPLACE FUNCTION CargaHorariaPromedioPorProfesor RETURN NUMBER IS
    v_Promedio NUMBER;
BEGIN
    SELECT AVG(TotalHoras) INTO v_Promedio
    FROM (
        SELECT P.Cedula, SUM(
            EXTRACT(HOUR FROM (H.HorarioFin - H.HorarioInicio)) +
            EXTRACT(MINUTE FROM (H.HorarioFin - H.HorarioInicio)) / 60
        ) AS TotalHoras
        FROM Horarios H
        INNER JOIN Asignacion A ON H.IDMateria = A.IDMateria
        INNER JOIN Profesores P ON A.CedulaProfesor = P.Cedula
        GROUP BY P.Cedula
    );
    RETURN v_Promedio;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30010, 'Error al calcular carga horaria promedio por profesor: ' || SQLERRM);
END CargaHorariaPromedioPorProfesor;
/

-- Función 11: Total de materias ofertadas
CREATE OR REPLACE FUNCTION TotalMateriasOfertadas RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total FROM Materia;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30011, 'Error al obtener total de materias ofertadas: ' || SQLERRM);
END TotalMateriasOfertadas;
/

-- Función 12: Total de materias sin prerrequisitos (simplificada)
CREATE OR REPLACE FUNCTION TotalMateriasSinPrerrequisitos RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total
    FROM Materia
    WHERE IDMateria NOT IN (
        SELECT DISTINCT IDMateriaPrincipal
        FROM Prerrequisitos
    );
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30012, 'Error al obtener total de materias sin prerrequisitos: ' || SQLERRM);
END TotalMateriasSinPrerrequisitos;
/

-- Función 13: Total de estudiantes matriculados en todas las materias
CREATE OR REPLACE FUNCTION TotalEstudiantesMatriculados RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(DISTINCT CedulaEstudiante) INTO v_Total
    FROM Matricula;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30013, 'Error al obtener total de estudiantes matriculados: ' || SQLERRM);
END TotalEstudiantesMatriculados;
/

-- Función 14: Promedio de estudiantes matriculados por materia
CREATE OR REPLACE FUNCTION PromedioEstudiantesMatriculadosPorMateria RETURN NUMBER IS
    v_Promedio NUMBER;
BEGIN
    SELECT AVG(NumEstudiantes) INTO v_Promedio
    FROM (
        SELECT IDMateria, COUNT(*) AS NumEstudiantes
        FROM Matricula
        GROUP BY IDMateria
    );
    RETURN v_Promedio;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30014, 'Error al calcular promedio de estudiantes matriculados por materia: ' || SQLERRM);
END PromedioEstudiantesMatriculadosPorMateria;
/

--Funcion 15
CREATE OR REPLACE FUNCTION TotalMateriasImpartidas RETURN NUMBER IS
    v_Total NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_Total
    FROM Asignacion;
    RETURN v_Total;
EXCEPTION
    WHEN OTHERS THEN
        RAISE_APPLICATION_ERROR(-30018, 'Error al obtener total de materias impartidas: ' || SQLERRM);
END TotalMateriasImpartidas;

--Creacion de Triggers 
--Trigger 1: Actualizar Estado del Estudiante al Registrar un Congelamiento
CREATE OR REPLACE TRIGGER trg_EstadoEstudiante_Congelamiento
AFTER INSERT ON Congelamientos
FOR EACH ROW
BEGIN
    UPDATE Estudiante
    SET Estado = 'inactivo'
    WHERE Cedula = :NEW.CedulaEstudiante;
END;

--Trigger 2: Validar Prerrequisitos al Matricular una Materia
CREATE OR REPLACE TRIGGER trg_ValidarPrerrequisitos_Matricula
BEFORE INSERT ON Matricula
FOR EACH ROW
DECLARE
    v_Count NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_Count
    FROM Prerrequisitos PR
    WHERE PR.IDMateriaPrincipal = :NEW.IDMateria
    AND NOT EXISTS (
        SELECT 1
        FROM Matricula MT
        WHERE MT.CedulaEstudiante = :NEW.CedulaEstudiante
        AND MT.IDMateria = PR.IDMateriaPrerrequisito
    );

    IF v_Count > 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'El estudiante no cumple con los prerrequisitos para esta materia.');
    END IF;
END;

--Trigger 3: Prevenir Solapamiento de Horarios en el Mismo Aula
CREATE OR REPLACE TRIGGER trg_PrevenirSolapamiento_Horarios
BEFORE INSERT OR UPDATE ON Horarios
FOR EACH ROW
DECLARE
    v_Count NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_Count
    FROM Horarios H
    WHERE H.Aula = :NEW.Aula
    AND H.DiaSemana = :NEW.DiaSemana
    AND H.Id <> NVL(:OLD.ID, 0)
    AND (
        (:NEW.HorarioInicio BETWEEN H.HorarioInicio AND H.HorarioFin)
        OR
        (:NEW.HorarioFin BETWEEN H.HorarioInicio AND H.HorarioFin)
        OR
        (H.HorarioInicio BETWEEN :NEW.HorarioInicio AND :NEW.HorarioFin)
    );

    IF v_Count > 0 THEN
        RAISE_APPLICATION_ERROR(-20002, 'Existe un horario que se solapa en el mismo aula y día.');
    END IF;
END;

--Trigger 4: Registrar Historial de Cambios en la Tabla Matricula
-- Creación de la tabla de auditoría
CREATE TABLE Matricula_Historial (
    ID NUMBER GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY,
    CedulaEstudiante VARCHAR2(50),
    IDMateria NUMBER,
    Semestre NUMBER,
    Anio NUMBER,
    Operacion VARCHAR2(10),
    Usuario VARCHAR2(50),
    FechaOperacion DATE
);
/

-- Trigger para registrar el historial
CREATE OR REPLACE TRIGGER trg_Auditoria_Matricula
AFTER INSERT OR UPDATE OR DELETE ON Matricula
FOR EACH ROW
BEGIN
    INSERT INTO Matricula_Historial (
        CedulaEstudiante, IDMateria, Semestre, Anio, Operacion, Usuario, FechaOperacion
    ) VALUES (
        COALESCE(:NEW.CedulaEstudiante, :OLD.CedulaEstudiante),
        COALESCE(:NEW.IDMateria, :OLD.IDMateria),
        COALESCE(:NEW.Semestre, :OLD.Semestre),
        COALESCE(:NEW.Anio, :OLD.Anio),
        CASE
            WHEN INSERTING THEN 'INSERT'
            WHEN UPDATING THEN 'UPDATE'
            WHEN DELETING THEN 'DELETE'
        END,
        USER,
        SYSDATE
    );
END;

--Trigger 5: Actualizar Fecha de Fin de Congelamiento al Reactivar Estudiante
CREATE OR REPLACE TRIGGER trg_ActualizarCongelamiento_Estudiante
AFTER UPDATE OF Estado ON Estudiante
FOR EACH ROW
BEGIN
    IF :OLD.Estado = 'inactivo' AND :NEW.Estado = 'activo' THEN
        UPDATE Congelamientos
        SET FechaFin = SYSDATE
        WHERE CedulaEstudiante = :NEW.Cedula
        AND FechaFin IS NULL;
    END IF;
END;

--Vistas

-- Vista 1: Registro de estudiantes
CREATE OR REPLACE VIEW RegistroEstudiantes AS
SELECT 
    Cedula,
    Nombre,
    Apellido1,
    CorreoElectronico AS Correo,
    Telefono,
    Estado,
    FechaInscripcion
FROM Estudiante;

-- Vista 2: Consultar y editar estudiantes
CREATE OR REPLACE VIEW ConsultarEditarEstudiantes AS
SELECT 
    Cedula,
    Nombre,
    CorreoElectronico AS Correo,
    Telefono,
    Estado
FROM Estudiante;

CREATE OR REPLACE VIEW ConsultarCongelamientos AS
SELECT 
    IDCONGELAMIENTO,
    MOTIVO,
    FECHAINICIO,
    FECHAFIN
FROM CONGELAMIENTOS;

-- Vista 3: Historial académico de estudiantes
CREATE OR REPLACE VIEW HistorialAcademico AS
SELECT
    E.Cedula AS CedulaEstudiante,
    E.Nombre || ' ' || E.Apellido1 AS NombreEstudiante,
    M.IDMATERIA,
    M.Nombre AS NombreMateria,
    MT.Semestre,
    MT.Ano,
    MT.FechaMatricula
FROM Matricula MT
INNER JOIN Estudiante E ON MT.CedulaEstudiante = E.Cedula
INNER JOIN Materia M ON MT.IDMateria = M.IDMATERIA;

-- Vista 1: Registro de profesores
CREATE OR REPLACE VIEW RegistroProfesores AS
SELECT 
    P.Cedula,
    P.Nombre || ' ' || P.PrimerApellido AS NombreCompleto,
    P.FechaNacimiento,
    P.Correo_Electronico,
    D.Nombre AS Departamento
FROM Profesores P
LEFT JOIN Departamento D ON P.IDDepartamento = D.IDDepartamento;

-- Vista 2: Asignaciones de profesores
CREATE OR REPLACE VIEW AsignacionesProfesor AS
SELECT
    P.Cedula AS CedulaProfesor,
    P.Nombre || ' ' || P.PrimerApellido AS NombreProfesor,
    M.IDMateria,
    M.Nombre AS NombreMateria,
    A.Semestre,
    A.Ano
FROM Asignacion A
INNER JOIN Profesores P ON A.CedulaProfesor = P.Cedula
INNER JOIN Materia M ON A.IDMateria = M.IDMateria;

-- Vista 3: Consultar y editar profesores
CREATE OR REPLACE VIEW ConsultarEditarProfesores AS
SELECT 
    Cedula,
    Nombre || ' ' || PrimerApellido AS NombreCompleto,
    FechaNacimiento,
    Correo_Electronico,
    TituloAcademico
FROM Profesores;

-- Vista 1: Registro de materias
CREATE OR REPLACE VIEW RegistroMaterias AS
SELECT
    IDMateria AS Codigo,
    Nombre AS NombreMateria,
    Descripcion,
    Creditos
FROM Materia;

-- Vista 2: Plan de estudios
CREATE OR REPLACE VIEW PlanEstudios AS
SELECT
    M.IDMateria AS CodigoMateria,
    M.Nombre AS NombreMateria,
    M.Descripcion,
    COUNT(PR.IDMateriaPrerrequisito) AS TotalPrerrequisitos
FROM Materia M
LEFT JOIN Prerrequisitos PR ON M.IDMateria = PR.IDMateriaPrincipal
GROUP BY M.IDMateria, M.Nombre, M.Descripcion;

-- Vista 3: Prerrequisitos de materias
CREATE OR REPLACE VIEW PrerrequisitosMaterias AS
SELECT 
    MP.ID AS IDMateriaPrincipal,
    MP.Nombre AS NombreMateriaPrincipal,
    MPR.ID AS IDMateriaPrerrequisito,
    MPR.Nombre AS NombreMateriaPrerrequisito
FROM Prerrequisitos PR
INNER JOIN Materia MP ON PR.IDMateriaPrincipal = MP.ID
INNER JOIN Materia MPR ON PR.IDMateriaPrerrequisito = MPR.ID;

-- Vista 1: Registro de congelamientos
CREATE OR REPLACE VIEW RegistroCongelamientos AS
SELECT
    C.ID,
    C.CedulaEstudiante,
    E.Nombre || ' ' || E.Apellidos AS NombreEstudiante,
    C.Motivo,
    C.FechaInicio,
    C.FechaFin
FROM Congelamientos C
INNER JOIN Estudiante E ON C.CedulaEstudiante = E.Cedula;

-- Vista 2: Congelamientos activos
CREATE OR REPLACE VIEW CongelamientosActivos AS
SELECT
    C.ID,
    C.CedulaEstudiante,
    E.Nombre || ' ' || E.Apellidos AS NombreEstudiante,
    C.Motivo,
    C.FechaInicio
FROM Congelamientos C
INNER JOIN Estudiante E ON C.CedulaEstudiante = E.Cedula
WHERE C.FechaFin IS NULL;
-- Vista 1: Registro de matrículas
CREATE OR REPLACE VIEW RegistroMatriculas AS
SELECT
    MT.CedulaEstudiante,
    E.Nombre || ' ' || E.Apellidos AS NombreEstudiante,
    M.ID AS IDMateria,
    M.Nombre AS NombreMateria,
    MT.Semestre,
    MT.ano,
    MT.FechaMatricula
FROM Matricula MT
INNER JOIN Estudiante E ON MT.CedulaEstudiante = E.Cedula
INNER JOIN Materia M ON MT.IDMateria = M.ID;

-- Vista 2: Reporte de matrículas por materia
CREATE OR REPLACE VIEW ReporteMatriculasPorMateria AS
SELECT
    M.ID AS IDMateria,
    M.Nombre AS NombreMateria,
    COUNT(MT.CedulaEstudiante) AS TotalEstudiantes,
    MT.Semestre,
    MT.ano
FROM Matricula MT
INNER JOIN Materia M ON MT.IDMateria = M.ID
GROUP BY M.ID, M.Nombre, MT.Semestre, MT.ano;



--Creacion de Triggers 
--Trigger 1: Actualizar Estado del Estudiante al Registrar un Congelamiento
CREATE OR REPLACE TRIGGER trg_EstadoEstudiante_Congelamiento
AFTER INSERT ON Congelamientos
FOR EACH ROW
BEGIN
    UPDATE Estudiante
    SET Estado = 'inactivo'
    WHERE Cedula = :NEW.CedulaEstudiante;
END;

--Trigger 2: Validar Prerrequisitos al Matricular una Materia
CREATE OR REPLACE TRIGGER trg_ValidarPrerrequisitos_Matricula
BEFORE INSERT ON Matricula
FOR EACH ROW
DECLARE
    v_Count NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_Count
    FROM Prerrequisitos PR
    WHERE PR.IDMateriaPrincipal = :NEW.IDMateria
    AND NOT EXISTS (
        SELECT 1
        FROM Matricula MT
        WHERE MT.CedulaEstudiante = :NEW.CedulaEstudiante
        AND MT.IDMateria = PR.IDMateriaPrerrequisito
    );

    IF v_Count > 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'El estudiante no cumple con los prerrequisitos para esta materia.');
    END IF;
END;

--Trigger 3: Prevenir Solapamiento de Horarios en el Mismo Aula
CREATE OR REPLACE TRIGGER trg_PrevenirSolapamiento_Horarios
BEFORE INSERT OR UPDATE ON Horarios
FOR EACH ROW
DECLARE
    v_Count NUMBER;
BEGIN
    SELECT COUNT(*)
    INTO v_Count
    FROM Horarios H
    WHERE H.Aula = :NEW.Aula
    AND H.DiaSemana = :NEW.DiaSemana
    AND H.IdHorario <> NVL(:OLD.IdHorario, 0)
    AND (
        (:NEW.HorarioInicio BETWEEN H.HorarioInicio AND H.HorarioFin)
        OR
        (:NEW.HorarioFin BETWEEN H.HorarioInicio AND H.HorarioFin)
        OR
        (H.HorarioInicio BETWEEN :NEW.HorarioInicio AND :NEW.HorarioFin)
    );

    IF v_Count > 0 THEN
        RAISE_APPLICATION_ERROR(-20002, 'Existe un horario que se solapa en el mismo aula y día.');
    END IF;
END;

--Trigger4
CREATE OR REPLACE TRIGGER estado_estudiante 
AFTER INSERT ON Congelamientos 
FOR EACH ROW
BEGIN
    UPDATE Estudiante 
    SET Estado = 'inactivo'
    WHERE Cedula = :NEW.CedulaEstudiante;
END;


--Trigger 5: Actualizar Fecha de Fin de Congelamiento al Reactivar Estudiante
CREATE OR REPLACE TRIGGER trg_ActualizarCongelamiento_Estudiante
AFTER UPDATE OF Estado ON Estudiante
FOR EACH ROW
BEGIN
    IF :OLD.Estado = 'inactivo' AND :NEW.Estado = 'activo' THEN
        UPDATE Congelamientos
        SET FechaFin = SYSDATE
        WHERE CedulaEstudiante = :NEW.Cedula
        AND FechaFin IS NULL;
    END IF;
END;



--Creacion de CURSORES
--Cursor 1: Listar Materias sin Prerrequisitos
CREATE OR REPLACE FUNCTION ListarMateriasSinPrerrequisitos RETURN SYS_REFCURSOR IS
    v_Materias SYS_REFCURSOR;
BEGIN
    OPEN v_Materias FOR
    SELECT M.ID, M.Nombre, M.Creditos
    FROM Materia M
    WHERE NOT EXISTS (
        SELECT 1
        FROM Prerrequisitos PR
        WHERE PR.IDMateriaPrincipal = M.ID
    );
    
    RETURN v_Materias;
END ListarMateriasSinPrerrequisitos;


--Cursor 2: Listar Estudiantes con Congelamientos Activos
CREATE OR REPLACE PROCEDURE ListarEstudiantesCongelados(
    p_Estudiantes OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_Estudiantes FOR
    SELECT E.Cedula, E.Nombre, E.Apellidos, C.FechaInicio
    FROM Estudiante E
    INNER JOIN Congelamientos C ON E.Cedula = C.CedulaEstudiante
    WHERE C.FechaFin IS NULL;
END ListarEstudiantesCongelados;

--Cursor 3: Listar Profesores y sus Materias Asignadas
CREATE OR REPLACE FUNCTION ListarProfesoresConMaterias RETURN SYS_REFCURSOR IS
    v_ProfesoresMaterias SYS_REFCURSOR;
BEGIN
    OPEN v_ProfesoresMaterias FOR
    SELECT P.Cedula, P.Nombre || ' ' || P.Apellidos AS NombreProfesor, M.ID AS IDMateria, M.Nombre AS NombreMateria
    FROM Profesor P
    INNER JOIN Asignacion A ON P.Cedula = A.CedulaProfesor
    INNER JOIN Materia M ON A.IDMateria = M.ID;
    
    RETURN v_ProfesoresMaterias;
END ListarProfesoresConMaterias;

--Cursor 4: Listar Direcciones por Provincia
CREATE OR REPLACE PROCEDURE ListarDireccionesPorProvincia(
    p_Provincia IN Direccion.Provincia%TYPE,
    p_Direcciones OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_Direcciones FOR
    SELECT D.CedulaEstudiante, E.Nombre || ' ' || E.Apellidos AS NombreEstudiante, D.Canton, D.Distrito, D.DireccionExacta
    FROM Direccion D
    INNER JOIN Estudiante E ON D.CedulaEstudiante = E.Cedula
    WHERE D.Provincia = p_Provincia;
END ListarDireccionesPorProvincia;


--Cursor 5: Obtener Historial de Matriculas de un Estudiante
CREATE OR REPLACE FUNCTION ObtenerHistorialMatriculas(
    p_CedulaEstudiante IN Estudiante.Cedula%TYPE
) RETURN SYS_REFCURSOR IS
    v_Historial SYS_REFCURSOR;
BEGIN
    OPEN v_Historial FOR
    SELECT M.ID AS IDMateria, M.Nombre AS NombreMateria, MT.Semestre, MT.ano, MT.FechaMatricula
    FROM Matricula MT
    INNER JOIN Materia M ON MT.IDMateria = M.ID
    WHERE MT.CedulaEstudiante = p_CedulaEstudiante
    ORDER BY MT.ano DESC, MT.Semestre DESC;
    
    RETURN v_Historial;
END ObtenerHistorialMatriculas;

/*
Estructuras Avanzadas:

25 procedimientos almacenados.                   implementados 40
15 funciones adicionales.                        implementados 15
10 vistas optimizadas.                           implementados 10
10 paquetes organizadores.                       implementados 10
5 triggers específicos.                          implementados 5
15 cursores para manejo de datos complejos.      implementados 19
*/
--vista_congelamientos_activos
CREATE VIEW vista_congelamientos_activos AS
SELECT e.Cedula, e.Nombre, e.Apellido1, c.FechaInicio, c.FechaFin
FROM ESTUDIANTE e
JOIN CONGELAMIENTOS c ON e.Cedula = c.CedulaEstudiante
WHERE c.FechaFin IS NULL OR c.FechaFin > CURRENT_DATE;

--vista_departamentos_profesores
CREATE VIEW vista_departamentos_profesores AS
SELECT d.nombre AS departamento, p.nombre AS profesor, p.PrimerApellido
FROM departamento d
JOIN profesores p ON d.CedulaJefeDepartamento = p.cedula;

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



--PAQUETES
SET SERVEROUTPUT ON;

GRANT CREATE PROCEDURE TO USERLBD;


    CREATE OR REPLACE PACKAGE PaqueteAsignacion AS
        -- Procedimiento para crear una asignación
        PROCEDURE CrearAsignacion(
            p_IDMateria IN Asignacion.IDMateria%TYPE,
            p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
            p_Semestre IN Asignacion.Semestre%TYPE,
            p_ano IN Asignacion.ano%TYPE
        );
    
        -- Procedimiento para leer una asignación
        PROCEDURE LeerAsignacion(
            p_IDMateria IN Asignacion.IDMateria%TYPE,
            p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
            p_Semestre IN Asignacion.Semestre%TYPE,
            p_ano IN Asignacion.ano%TYPE,
            p_Asignacion OUT SYS_REFCURSOR
        );
    
        -- Procedimiento para actualizar una asignación
        PROCEDURE ActualizarAsignacion(
            p_IDMateria IN Asignacion.IDMateria%TYPE,
            p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
            p_Semestre IN Asignacion.Semestre%TYPE,
            p_ano IN Asignacion.ano%TYPE,
            p_NuevoSemestre IN Asignacion.Semestre%TYPE,
            p_Nuevoano IN Asignacion.ano%TYPE
        );
    
        -- Procedimiento para eliminar una asignación
        PROCEDURE EliminarAsignacion(
            p_IDMateria IN Asignacion.IDMateria%TYPE,
            p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
            p_Semestre IN Asignacion.Semestre%TYPE,
            p_ano IN Asignacion.ano%TYPE
        );
    END PaqueteAsignacion;

CREATE OR REPLACE PACKAGE BODY PaqueteAsignacion AS

    PROCEDURE CrearAsignacion(
        p_IDMateria IN Asignacion.IDMateria%TYPE,
        p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
        p_Semestre IN Asignacion.Semestre%TYPE,
        p_ano IN Asignacion.ano%TYPE
    ) AS
    BEGIN
        INSERT INTO Asignacion (
            IDMateria, CedulaProfesor, Semestre, ano
        ) VALUES (
            p_IDMateria, p_CedulaProfesor, p_Semestre, p_ano
        );
        COMMIT; -- Opcional: Si las transacciones no son controladas externamente
    EXCEPTION
        WHEN DUP_VAL_ON_INDEX THEN
            RAISE_APPLICATION_ERROR(-24001, 'La asignación ya existe.');
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-24002, 'Error al crear la asignación: ' || SQLERRM);
    END CrearAsignacion;

    PROCEDURE LeerAsignacion(
        p_IDMateria IN Asignacion.IDMateria%TYPE,
        p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
        p_Semestre IN Asignacion.Semestre%TYPE,
        p_ano IN Asignacion.ano%TYPE,
        p_Asignacion OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_Asignacion FOR
        SELECT * FROM Asignacion
        WHERE IDMateria = p_IDMateria
          AND CedulaProfesor = p_CedulaProfesor
          AND Semestre = p_Semestre
          AND ano = p_ano;
    END LeerAsignacion;

    PROCEDURE ActualizarAsignacion(
        p_IDMateria IN Asignacion.IDMateria%TYPE,
        p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
        p_Semestre IN Asignacion.Semestre%TYPE,
        p_ano IN Asignacion.ano%TYPE,
        p_NuevoSemestre IN Asignacion.Semestre%TYPE,
        p_Nuevoano IN Asignacion.ano%TYPE
    ) AS
    BEGIN
        UPDATE Asignacion
        SET Semestre = p_NuevoSemestre,
            ano = p_Nuevoano
        WHERE IDMateria = p_IDMateria
          AND CedulaProfesor = p_CedulaProfesor
          AND Semestre = p_Semestre
          AND ano = p_ano;
        IF SQL%ROWCOUNT = 0 THEN
            RAISE_APPLICATION_ERROR(-24003, 'La asignación no existe.');
        END IF;
        COMMIT; -- Opcional
    EXCEPTION
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-24004, 'Error al actualizar la asignación: ' || SQLERRM);
    END ActualizarAsignacion;

    PROCEDURE EliminarAsignacion(
        p_IDMateria IN Asignacion.IDMateria%TYPE,
        p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
        p_Semestre IN Asignacion.Semestre%TYPE,
        p_ano IN Asignacion.ano%TYPE
    ) AS
    BEGIN
        DELETE FROM Asignacion
        WHERE IDMateria = p_IDMateria
          AND CedulaProfesor = p_CedulaProfesor
          AND Semestre = p_Semestre
          AND ano = p_ano;
        IF SQL%ROWCOUNT = 0 THEN
            RAISE_APPLICATION_ERROR(-24005, 'La asignación no existe.');
        END IF;
        COMMIT; -- Opcional
    EXCEPTION
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-24006, 'Error al eliminar la asignación: ' || SQLERRM);
    END EliminarAsignacion;

END PaqueteAsignacion;


CREATE OR REPLACE PROCEDURE actualizar_asignacion (
    p_IDMateria IN Asignacion.IDMateria%TYPE,
    p_CedulaProfesor IN Asignacion.CedulaProfesor%TYPE,
    p_Semestre IN Asignacion.Semestre%TYPE,
    p_Ano IN Asignacion.ano%TYPE,
    p_NuevoSemestre IN Asignacion.Semestre%TYPE,
    p_NuevoAno IN Asignacion.ano%TYPE
) AS
BEGIN
    UPDATE Asignacion
    SET Semestre = p_NuevoSemestre,
        ano = p_NuevoAno
    WHERE IDMateria = p_IDMateria
      AND CedulaProfesor = p_CedulaProfesor
      AND Semestre = p_Semestre
      AND ano = p_Ano;
    IF SQL%ROWCOUNT = 0 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Asignación no encontrada para actualizar.');
    END IF;
END actualizar_asignacion;

---PAQUETE CONGELAMIENTOS
CREATE OR REPLACE PACKAGE PaqueteCongelamientos AS
    -- Procedimiento para crear un congelamiento
    PROCEDURE CrearCongelamiento(
        p_CedulaEstudiante IN Congelamientos.CedulaEstudiante%TYPE,
        p_Motivo IN Congelamientos.Motivo%TYPE,
        p_FechaInicio IN Congelamientos.FechaInicio%TYPE,
        p_FechaFin IN Congelamientos.FechaFin%TYPE
    );

    -- Procedimiento para leer un congelamiento
    PROCEDURE LeerCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE,
        p_Congelamiento OUT SYS_REFCURSOR
    );

    -- Procedimiento para actualizar un congelamiento
    PROCEDURE ActualizarCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE,
        p_CedulaEstudiante IN Congelamientos.CedulaEstudiante%TYPE,
        p_Motivo IN Congelamientos.Motivo%TYPE,
        p_FechaInicio IN Congelamientos.FechaInicio%TYPE,
        p_FechaFin IN Congelamientos.FechaFin%TYPE
    );

    -- Procedimiento para eliminar un congelamiento
    PROCEDURE EliminarCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE
    );
END PaqueteCongelamientos;

CREATE OR REPLACE PACKAGE BODY PaqueteCongelamientos AS

    PROCEDURE CrearCongelamiento(
        p_CedulaEstudiante IN Congelamientos.CedulaEstudiante%TYPE,
        p_Motivo IN Congelamientos.Motivo%TYPE,
        p_FechaInicio IN Congelamientos.FechaInicio%TYPE,
        p_FechaFin IN Congelamientos.FechaFin%TYPE
    ) AS
    BEGIN
        INSERT INTO Congelamientos (
            CedulaEstudiante, Motivo, FechaInicio, FechaFin
        ) VALUES (
            p_CedulaEstudiante, p_Motivo, p_FechaInicio, p_FechaFin
        );
        COMMIT; -- Opcional: Si las transacciones no son controladas externamente
    EXCEPTION
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-27001, 'Error al crear el congelamiento: ' || SQLERRM);
    END CrearCongelamiento;

    PROCEDURE LeerCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE,
        p_Congelamiento OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_Congelamiento FOR
        SELECT * FROM Congelamientos WHERE IDCONGELAMIENTO = p_IDCONGELAMIENTO;
    END LeerCongelamiento;

    PROCEDURE ActualizarCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE,
        p_CedulaEstudiante IN Congelamientos.CedulaEstudiante%TYPE,
        p_Motivo IN Congelamientos.Motivo%TYPE,
        p_FechaInicio IN Congelamientos.FechaInicio%TYPE,
        p_FechaFin IN Congelamientos.FechaFin%TYPE
    ) AS
    BEGIN
        UPDATE Congelamientos
        SET CedulaEstudiante = p_CedulaEstudiante,
            Motivo = p_Motivo,
            FechaInicio = p_FechaInicio,
            FechaFin = p_FechaFin
        WHERE IDCONGELAMIENTO = p_IDCONGELAMIENTO;
        IF SQL%ROWCOUNT = 0 THEN
            RAISE_APPLICATION_ERROR(-27002, 'El congelamiento con IDCONGELAMIENTO ' || p_IDCONGELAMIENTO || ' no existe.');
        END IF;
        COMMIT; -- Opcional: Si las transacciones no son controladas externamente
    EXCEPTION
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-27003, 'Error al actualizar el congelamiento: ' || SQLERRM);
    END ActualizarCongelamiento;

    PROCEDURE EliminarCongelamiento(
        p_IDCONGELAMIENTO IN Congelamientos.IDCONGELAMIENTO%TYPE
    ) AS
    BEGIN
        DELETE FROM Congelamientos WHERE IDCONGELAMIENTO = p_IDCONGELAMIENTO;
        IF SQL%ROWCOUNT = 0 THEN
            RAISE_APPLICATION_ERROR(-27004, 'El congelamiento con IDCONGELAMIENTO ' || p_IDCONGELAMIENTO || ' no existe.');
        END IF;
        COMMIT; -- Opcional: Si las transacciones no son controladas externamente
    EXCEPTION
        WHEN OTHERS THEN
            RAISE_APPLICATION_ERROR(-27005, 'Error al eliminar el congelamiento: ' || SQLERRM);
    END EliminarCongelamiento;

END PaqueteCongelamientos;


--CRUDS:

--CRUD ESTUDIANTE:
CREATE OR REPLACE VIEW VistaEstudiantes AS
SELECT 
    Cedula, 
    Nombre, 
    Apellido1 AS Apellidos, 
    Telefono, 
    TO_CHAR(FechaNacimiento, 'YYYY-MM-DD') AS Fecha_Nacimiento, 
    CorreoElectronico AS Correo, 
    Estado 
FROM Estudiante;

CREATE OR REPLACE PROCEDURE sp_agregar_estudiante (
    p_cedula IN VARCHAR2,
    p_idEstudiante IN VARCHAR2,
    p_nombre IN VARCHAR2,
    p_apellido1 IN VARCHAR2,
    p_telefono IN VARCHAR2,
    p_fechaNacimiento IN DATE,
    p_correoElectronico IN VARCHAR2,
    p_fechaInscripcion IN DATE,
    p_estado IN VARCHAR2
) AS
BEGIN
    INSERT INTO Estudiante (
        Cedula, IdEstudiante, Nombre, Apellido1, Telefono, FechaNacimiento, CorreoElectronico, FechaInscripcion, Estado
    ) VALUES (
        p_cedula, p_idEstudiante, p_nombre, p_apellido1, p_telefono, p_fechaNacimiento, p_correoElectronico, p_fechaInscripcion, p_estado
    );
END;
/

CREATE OR REPLACE VIEW vista_estudiantes_activos AS
SELECT * FROM Estudiante
WHERE Estado = 'activo';


CREATE OR REPLACE PROCEDURE sp_editar_estudiante (
    p_cedula IN VARCHAR2,
    p_nombre IN VARCHAR2,
    p_apellido1 IN VARCHAR2,
    p_telefono IN VARCHAR2,
    p_fechaNacimiento IN DATE,
    p_correoElectronico IN VARCHAR2,
    p_estado IN VARCHAR2
) AS
BEGIN
    UPDATE Estudiante
    SET 
        Nombre = p_nombre,
        Apellido1 = p_apellido1,
        Telefono = p_telefono,
        FechaNacimiento = p_fechaNacimiento,
        CorreoElectronico = p_correoElectronico,
        Estado = p_estado
    WHERE Cedula = p_cedula;
END;


CREATE OR REPLACE PROCEDURE sp_eliminar_estudiante (
    p_cedula IN VARCHAR2
) AS
BEGIN
    DELETE FROM Estudiante WHERE Cedula = p_cedula;
END;


--CRUD MATRICULA
CREATE VIEW VistaMatriculas AS
SELECT 
    M.IdMatricula,
    M.Semestre,
    M.Ano,
    M.FechaMatricula,
    E.Cedula AS CedulaEstudiante,
    E.Nombre AS NombreEstudiante,
    M.IdMateria,
    Ma.Nombre AS NombreMateria
FROM 
    Matricula M
JOIN 
    Estudiante E ON M.CedulaEstudiante = E.Cedula
JOIN 
    Materia Ma ON M.IdMateria = Ma.IdMateria;


