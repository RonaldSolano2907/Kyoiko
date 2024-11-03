CREATE TABLE Horarios (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    IDMateria INT,
    Aula VARCHAR(20),
    HorarioInicio TIME,
    HorarioFin TIME,
    DiaSemana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    FOREIGN KEY (IDMateria) REFERENCES Materia(ID)
);
