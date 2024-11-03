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
