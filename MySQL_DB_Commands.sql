CREATE TABLE articulo (
idArticulo varchar(20) NOT NULL,
nombre varchar(30) NOT NULL,
precioPorUnidad int NOT NULL,
PRIMARY KEY (idArticulo)
);


-- test inserts --

INSERT INTO articulo VALUES ("1", "Martillo", 25);
INSERT INTO articulo VALUES ("2", "Desarmador", 50);