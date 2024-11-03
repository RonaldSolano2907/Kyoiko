CREATE TABLE Asignacion (
    IDMateria INT,
    CedulaProfesor INT,
    Semestre INT,
    Año INT,
    PRIMARY KEY (IDMateria, CedulaProfesor, Semestre, Año),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID),
    FOREIGN KEY (CedulaProfesor) REFERENCES Profesor(Cedula)
);
