CREATE TABLE sales (
idSale int NOT NULL,
name varchar(20),
PRIMARY KEY (idSale)
);

CREATE TABLE articulo (
idArticulo varchar(20) NOT NULL,
nombre varchar(30) NOT NULL,
precioPorUnidad int NOT NULL
);

-- tets inserts
INSERT INTO articulo VALUES ('1','Martillo', 1);