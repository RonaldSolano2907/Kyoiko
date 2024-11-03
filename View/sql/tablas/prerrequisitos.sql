CREATE TABLE Prerrequisitos (
    IDMateriaPrincipal INT,
    IDMateriaPrerrequisito INT,
    PRIMARY KEY (IDMateriaPrincipal, IDMateriaPrerrequisito),
    FOREIGN KEY (IDMateriaPrincipal) REFERENCES Materia(ID),
    FOREIGN KEY (IDMateriaPrerrequisito) REFERENCES Materia(ID)
);
