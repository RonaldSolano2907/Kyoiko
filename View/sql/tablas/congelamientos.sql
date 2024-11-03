CREATE TABLE Congelamientos (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Motivo TEXT,
    FechaInicio DATE,
    FechaFin DATE,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);
