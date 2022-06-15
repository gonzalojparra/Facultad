create database feriaDeLibro;
use feriaDeLibro;

create table Persona (
    nombre char(30),
    apellido char(30),
    tipoDoc char(30),
    nroDoc int(9),
    email char(100),
    telefono int(11),
    fechaNac date,
    PRIMARY KEY (tipoDoc, nroDoc)
);

create table Lector (
    tipoDoc char(30),
    nroDoc int(9),
    actividad char(100),
    FOREIGN KEY (tipoDoc, nroDoc) REFERENCES Persona(tipoDoc, nroDoc)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    PRIMARY KEY (tipoDoc, nroDoc)
);

create table Encargado (
    tipoDoc char(30),
    nroDoc int(9),
    legajo char(20),
    FOREIGN KEY (tipoDoc, nroDoc) REFERENCES Persona(tipoDoc, nroDoc)
    /* ON UPDATE Y ON DELETE, EXCLUSIVO DE FOREIGN KEYS */
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (tipoDoc, nroDoc)
);

create table Tema (
    codigo int(20),
    nombre char(30),
    PRIMARY KEY (codigo)
);

create table Feria (
    id int(10),
    fechaInicio date,
    horaApertura date,
    codTemaExposicionInicial int(20),
    codTemaExposicionFinal int(20),
    FOREIGN KEY (codTemaExposicionInicial, codTemaExposicionFinal) REFERENCES Tema(codigo)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (id)
);

create table Libro (
    isbn int(5),
    nombre char(30),
    cantCopias int(10),
    portada char(30),
    tipoDocEncargado char(30),
    nroDocEncargado int(9),
    FOREIGN KEY (tipoDocEncargado, nroDocEncargado) REFERENCES Encargado(tipoDoc, nroDoc)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (isbn)
);

create table CopiaLibro (
    nroCopia int(10),
    isbn int(5),
    nroMesa int(10),
    FOREIGN KEY (isbn) REFERENCES Libro(isbn)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (nroCopia, isbn)
);

create table Prefiere (
    tipoDocLector char(30),
    nroDocLector int(9),
    isbn int(5),
    motivo char(50),
    FOREIGN KEY (tipoDocLector, nroDocLector) REFERENCES Lector(tipoDoc, nroDoc) 
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    FOREIGN KEY (isbn) REFERENCES Libro(isbn)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (tipoDocLector, nroDocLector, isbn)
);

create table Lectura (
    nro int(10),
    tipoDocLector char(30),
    nroDocLector int(9),
    nroCopiaLibro int(10),
    isbn int(5),
    idFeria int(10),
    fechaLectura date,
    FOREIGN KEY (tipoDocLector, nroDocLector) REFERENCES Lector(tipoDoc, nroDoc) 
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    FOREIGN KEY (nroCopiaLibro) REFERENCES CopiaLibro(nroCopia)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    FOREIGN KEY (isbn) REFERENCES Libro(isbn)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    FOREIGN KEY (idFeria) REFERENCES Feria(id)
    ON UPDATE CASCADE 
    ON DELETE CASCADE,
    PRIMARY KEY (nro)
);