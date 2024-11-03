CREATE TABLE Direccion (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaEstudiante INT,
    Provincia VARCHAR(50),
    Canton VARCHAR(50),
    Distrito VARCHAR(50),
    DireccionExacta TEXT,
    FOREIGN KEY (CedulaEstudiante) REFERENCES Estudiante(Cedula)
);
