-- Ejerecicio 3. Inciso a
INSERT INTO Persona VALUES ('Lionel', 'Messi', 'DNI', 37242571, 'lio@gmail.com', 11534129, '1987--06--24');
INSERT INTO Persona VALUES ('Cristiano', 'Ronaldo', 'DNI', 35189647, 'cr7@gmail.com', 11493218, '1985-07-09');
INSERT INTO Persona VALUES ('Ronaldinho', 'Gaucho', 'DNI', 28416348, 'ronaldinho@gmail.com', 11425281, '1971-04-21');
INSERT INTO Persona VALUES ('Kylian', 'Mbappe', 'DNI', 39025871, 'mbappe@gmail.com', 114535954, '1999-09-16');
INSERT INTO Persona VALUES ('Emi', 'MC', 'DNI', 34189642, 'emimc@gmail.com', 299863478, '2001-02-03');
INSERT INTO Persona VALUES ('Gonza', 'Parra', 'DNI', 44238101, 'gonzakpo@gmail.com', 29945359, '2022-06-23');
INSERT INTO Persona VALUES ('Guillermo', 'Andrada', 'DNI', 22453678, 'guille@gmail.com', 299532248, '1994-02-24'); -- Creado ultimo

INSERT INTO Lector(tipoDoc, nroDoc, actividad) VALUES ('DNI', 37242571, 'Futbolista');
INSERT INTO Lector(tipoDoc, nroDoc, actividad) VALUES ('DNI', 35189647, 'Futbolista');
INSERT INTO Lector VALUES ('DNI', 22453678, 'Encargado xd'); -- Creado ultimo

INSERT INTO Encargado VALUES ('DNI', 28416348, 'FDL-1234');
INSERT INTO Encargado VALUES ('DNI', 34189642, 'FDL-1235');
INSERT INTO Encargado VALUES ('DNI', 44238101, 'FDL-1236');
INSERT INTO Encargado VALUES ('DNI', 39025871, 'FDL-1237');
INSERT INTO Encargado VALUES ('DNI', 22453678, 'FDL-1237'); -- Creado ultimo

INSERT INTO Tema VALUES (2, 'Pepito');
INSERT INTO Tema VALUES (3, 'Juancito');
INSERT INTO Tema VALUES (4, 'Carlitos');
INSERT INTO Tema VALUES (5, 'Jony');

INSERT INTO Feria VALUES (1, '2022-06-24', '20:00', 2, 3);
INSERT INTO Feria VALUES (2, '2022-06-26', '10:00', 4, 5);

INSERT INTO Libro VALUES (85214, 'El Principito', 255, 'El Principito', 'DNI', 28416348);
INSERT INTO Libro VALUES (74163, 'El Señor De Los Anillos', 154, 'Frodo', 'DNI', 34189642);
INSERT INTO Libro VALUES (25891, 'Ciencia xd', 154, 'Ciencia', 'DNI', 39025871);
INSERT INTO Libro VALUES (5, 'Anatomía', 100, 'Ciencia', 'DNI', 22453678); -- Creado ultimo

INSERT INTO CopiaLibro VALUES (24, 85214, 3);
INSERT INTO CopiaLibro VALUES (15, 74163, 2);
INSERT INTO CopiaLibro VALUES (1, 25891, 1);
INSERT INTO CopiaLibro VALUES (8, 5, 1); -- Creado ultimo

INSERT INTO Prefiere VALUES ('DNI', 37242571, 74163, 'Gholum facha');
INSERT INTO Prefiere VALUES ('DNI', 35189647, 85214, 'Simpatiza con franceses');

INSERT INTO Lectura VALUES (1, 'DNI', 37242571, 24, 85214, 1, '2022-06-24');
INSERT INTO Lectura VALUES (2, 'DNI', 35189647, 15, 74163, 2, '2022-06-26');
INSERT INTO Lectura VALUES (3, 'DNI', 22453678, 8, 5, 2, '2022-06-29'); -- Creado ultimo


-- Ejercicio 3. Inciso b
UPDATE Feria SET horaApertura = '14:00' WHERE id = 1;


-- Ejercicio 3. Inciso c
-- CONSULTAR COMO REALIZAR DELETE CON CLAVE COMPUESTA
DELETE FROM Encargado WHERE nroDoc NOT IN (SELECT nroDocEncargado FROM Libro);
SELECT * FROM Encargado;
SELECT * FROM Libro;


-- Ejercicio 4. Inciso a
SELECT nro, nroCopiaLibro, isbn, idFeria FROM Lectura WHERE fechaLectura >= '2022-06-25';


-- Ejercicio 4. Inciso b
SELECT * FROM CopiaLibro WHERE NOT EXISTS (SELECT Libro.isbn FROM Libro INNER JOIN Lectura ON CopiaLibro.isbn = Lectura.isbn WHERE Libro.portada = 'Ciencia');
-- funco ashe

SELECT * FROM CopiaLibro WHERE NOT EXISTS (SELECT * FROM Libro INNER JOIN Lectura WHERE CopiaLibro.isbn = Lectura.isbn AND Libro.portada = 'Ciencia');

SELECT * from CopiaLibro WHERE NOT EXISTS (SELECT * FROM Libro WHERE Libro.portada = 'Ciencia' AND Libro.isbn = Lectura.isbn);
SELECT * FROM CopiaLibro JOIN Libro WHERE Libro.portada = 'Ciencia'; 
SELECT * FROM Lectura;