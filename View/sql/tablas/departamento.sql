CREATE TABLE Departamento (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    CedulaJefeDepartamento INT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    FOREIGN KEY (CedulaJefeDepartamento) REFERENCES Profesor(Cedula)
);
