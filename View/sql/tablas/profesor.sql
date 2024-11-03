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
