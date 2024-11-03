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
