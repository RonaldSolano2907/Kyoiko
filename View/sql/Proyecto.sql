CREATE DATABASE  IF NOT EXISTS `proyectobd`;
USE `proyectobd`;

CREATE TABLE Materia (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Creditos INT NOT NULL
);

CREATE TABLE Horarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    IDMateria INT,
    Aula VARCHAR(20),
    HorarioInicio TIME,
    HorarioFin TIME,
    DiaSemana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID)
);

CREATE TABLE Estudiante (
    Cedula INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15),
    FechaNacimiento DATE,
    CorreoElectronico VARCHAR(100),
    FechaInscripcion DATE,
    Estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

ALTER TABLE Estudiante ADD COLUMN IDDepartamento INT;


CREATE TABLE Direccion (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Provincia VARCHAR(50),
    Canton VARCHAR(50),
    Distrito VARCHAR(50),
    DireccionExacta TEXT,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);

CREATE TABLE Prerrequisitos (
    IDMateriaPrincipal INT,
    IDMateriaPrerrequisito INT,
    PRIMARY KEY (IDMateriaPrincipal, IDMateriaPrerrequisito),
    FOREIGN KEY (IDMateriaPrincipal) REFERENCES Materia(ID),
    FOREIGN KEY (IDMateriaPrerrequisito) REFERENCES Materia(ID)
);


CREATE TABLE Congelamientos (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Motivo TEXT,
    FechaInicio DATE,
    FechaFin DATE,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
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

CREATE TABLE Departamento (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaJefeDepartamento INT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT
);

ALTER TABLE Departamento
ADD FOREIGN KEY (CedulaJefeDepartamento) REFERENCES Profesor(Cedula);

CREATE TABLE Profesor (
    Cedula INT PRIMARY KEY,
    IDDepartamento INT,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(50) NOT NULL,
    Telefono VARCHAR(15),
    CorreoElectronico VARCHAR(100),
    FechaInscripcion DATE,
    TituloAcademico VARCHAR(100),
    FOREIGN KEY (IDDepartamento) REFERENCES Departamento(ID)
);

CREATE TABLE Asignacion (
    IDMateria INT,
    CedulaProfesor INT,
    Semestre INT,
    Año INT,
    PRIMARY KEY (IDMateria, CedulaProfesor, Semestre, Año),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID),
    FOREIGN KEY (CedulaProfesor) REFERENCES Profesor(Cedula)
);

/*Vistas*/

CREATE VIEW vista_congelamientos_activos AS
SELECT 
    e.Cedula, 
    e.Nombre, 
    e.Apellidos, 
    c.FechaInicio, 
    c.FechaFin
FROM 
    Estudiante e
JOIN 
    Congelamientos c 
ON 
    e.Cedula = c.CedulaEstudiante
WHERE 
    c.FechaFin IS NULL 
    OR c.FechaFin > CURRENT_DATE;
    
    
CREATE VIEW vista_departamentos_profesores AS
SELECT 
    d.Nombre AS Departamento, 
    p.Nombre AS Profesor, 
    p.Apellidos AS Apellido
FROM 
    Departamento d
JOIN 
    Profesor p 
ON 
    d.CedulaJefeDepartamento = p.Cedula;
    
    
CREATE VIEW vista_estudiantes_departamento AS
SELECT 
    d.Nombre AS Departamento, 
    e.Cedula, 
    e.Nombre, 
    e.Apellidos AS Apellido
FROM 
    Departamento d
JOIN 
    Estudiante e 
ON 
    d.ID = e.IDDepartamento;
    
    
CREATE VIEW vista_estudiantes_matriculados AS
SELECT 
    e.Cedula, 
    e.Nombre, 
    e.Apellidos AS Apellido, 
    m.Nombre AS NombreMateria, 
    mat.Semestre, 
    mat.Año
FROM 
    Estudiante e
JOIN 
    Matricula mat 
ON 
    e.Cedula = mat.CedulaEstudiante
JOIN 
    Materia m 
ON 
    mat.IDMateria = m.ID;


CREATE VIEW vista_historial_matricula AS
SELECT 
    e.Cedula, 
    e.Nombre, 
    e.Apellidos AS Apellido, 
    m.Nombre AS NombreMateria, 
    mat.FechaMatricula, 
    mat.Semestre, 
    mat.Año
FROM 
    Estudiante e
JOIN 
    Matricula mat 
ON 
    e.Cedula = mat.CedulaEstudiante
JOIN 
    Materia m 
ON 
    mat.IDMateria = m.ID;
    
    
CREATE VIEW vista_horarios_clases AS
SELECT 
    m.Nombre AS Materia, 
    h.Aula, 
    h.HorarioInicio AS HoraInicio, 
    h.HorarioFin AS HoraFin, 
    h.DiaSemana AS DiaSemana
FROM 
    Horarios h
JOIN 
    Materia m 
ON 
    h.IDMateria = m.ID;
    
CREATE VIEW vista_materias_inscritos AS
SELECT 
    m.Nombre AS Materia, 
    COUNT(mat.CedulaEstudiante) AS Inscritos
FROM 
    Materia m
LEFT JOIN 
    Matricula mat ON m.ID = mat.IDMateria
GROUP BY 
    m.Nombre;
    
CREATE VIEW vista_materias_prerrequisitos AS
SELECT 
    m.Nombre AS Materia, 
    p.Nombre AS Prerrequisito
FROM 
    Prerrequisitos pr
JOIN 
    Materia m ON pr.IDMateriaPrincipal = m.ID
JOIN 
    Materia p ON pr.IDMateriaPrerrequisito = p.ID;
    

CREATE VIEW vista_profesores_asignados AS
SELECT 
    p.Cedula, 
    p.Nombre, 
    p.Apellidos, 
    m.Nombre AS Materia, 
    a.Semestre, 
    a.Año
FROM 
    Profesor p
JOIN 
    Asignacion a ON p.Cedula = a.CedulaProfesor
JOIN 
    Materia m ON a.IDMateria = m.ID;
    
CREATE VIEW vista_profesores_materias AS
SELECT 
    p.Cedula, 
    p.Nombre, 
    p.Apellidos, 
    COUNT(a.IDMateria) AS NumeroMaterias
FROM 
    Profesor p
LEFT JOIN 
    Asignacion a ON p.Cedula = a.CedulaProfesor
GROUP BY 
    p.Cedula, p.Nombre, p.Apellidos;
    
/*Triggers*/







