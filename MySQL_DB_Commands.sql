CREATE TABLE proveedor (
idProveedor int NOT NULL,
nombreProveedor varchar(25),
PRIMARY KEY (idProveedor)
);

CREATE TABLE categoria (
idCategoria int NOT NULL,
nombreCategoria varchar(15),
PRIMARY KEY (idCategoria)
);

CREATE TABLE marca (
idMarca int NOT NULL,
nombreMarca varchar(25),
PRIMARY KEY (idMarca)
);

CREATE TABLE articulo (
idArticulo varchar(20) NOT NULL,
cantidad int CHECK (cantidad > 0),
marca int,
proveedor int,
categoria int,	
FOREIGN KEY (marca)
	REFERENCES marca(idMarca),
FOREIGN KEY (proveedor)
	REFERENCES proveedor(idProveedor),
FOREIGN KEY (categoria)
	REFERENCES categoria(idCategoria)
);

CREATE TABLE purchase (
idPurchase int NOT NULL AUTO_INCREMENT,
idArticulo varchar(20),
cantidadComprada int,
PRIMARY KEY (idPurchase)
);

Insertions para después

INSERT INTO marca VALUES
(1, 'Nacobre'),
(2, 'Tuboplus'),
(3, 'Urrea'),
(4, 'Partner projects'),
(5, 'Condumex'),
(6, 'Retail'),
(7, 'Comscope'),
(8, 'Tangit'),
(9, 'Charofil'),
(10, 'North System'),
(11, '3M');

INSERT INTO proveedor VALUES
(1, 'Tudogar'),
(2, 'Tamex'),
(3, 'Fofel'),
(4, 'CDC Group');

INSERT INTO categoria VALUES
(1, 'Hidraulico'),
(2, 'Pluvial'),
(3, 'Electrico'),
(4, 'Sanitario'),
(5, 'Voz y datos');

HIDRAULICO

INSERT INTO articulo VALUES
("NAVAH013", "VALV. ANGULAR HEMBRA 13MM", 21, 53.45, 1, 1, 1),
("TTPCL16020", "TUBO TPLUS CLASE 16 20 13MM", 40, 53.36, 2, 1, 1),
("TTPCL16025", "TUBO TPLUS CLASE 16 25 19MM", 15, 99.83, 2, 1, 1),
("TTPCL16032", "TUBO TPLUS CLASE 16 32 25MM", 2, 162.98, 2, 1, 1),
("CTC9013", "CODO 90 TPLUS 20 13MM", 100, 2.91, 2, 1, 1),
("CTC9019", "CODO 90 TPLUS 25 19MM", 4, 4.27, 2, 1, 1),
("CTC9025", "CODO 90 TPLUS 32 25MM", 2, 11.91, 2, 1, 1),
("CTT013", "TEE TPLUS 20 13MM", 13, 4.23, 2, 1, 1),
("CTT019", "TEE TPLUS 25 19MM", 15, 8.04, 2, 1, 1),
("CTT025", "TEE TPLUS 32 25MM", 1, 15.37, 2, 1, 1),
("CTR2519", "RED TPLUS 32-25 25X19MM", 2, 7.97, 2, 1, 1),
("CTR1913", "RED TPLUS 25-20 19X13MM", 13, 3.40, 2, 1, 1),
("CTCM1313", "CONECT MACH TPLUS 20-20 13X13MM", 32, 23.92, 2, 1, 1),
("CTCM1919", "CONECT HEM TPLUS 25-25 19X19MM", 3, 30.39, 2, 1, 1),
("CTCH1313", "CONECT HEM TPLUS 20-20 13X13MM", 3, 22.33, 2, 1, 1),
("CTC9RH1313", "CODO 90 ROS HEM TPLUS 20-20 13X13", 3, 24.18, 2, 1, 1),
("CTPLLERCM20", "JGO LLAVE EMP P/REG C/CHAP Y MAN", 6, 275.43, 3, 1, 1),
("CTCP013", "COPLE TPLUS 20 13MM", 12, 3.21, 2, 1, 1),
("CTCP013", "COPLE TPLUS 25 19MM", 9, 6.42, 2, 1, 1),
("VULMC01013", "LLAVE P/MANGUERA DE COMPRESION 1/2 PULG F-LMC01.13", 7, 65.52, 3, 1, 1),
("VU65013", "VALV GLOBO ROSC 100LBS F-65 13MM", 1, 124.66, 3, 1, 1),
("CCT013", "TEE COBRE 13MM", 1, 7.32, 1, 1, 1),
("CCC9013", "CODO 90 COBRE 13MM", 4, 4.76, 4, 1, 1),
("TCNM013TR", "TUBO CO NACOBRE T-M 13MM TRAMO", 1, 338.79, 1, 1, 1),
("CCTU013", "TCA UNION COBRE 13MM", 2, 36.25, 1, 1, 1),
("CCCRE019", "CONECT COBRE ROSC EXT 19MM", 6, 15.41, 1, 1, 1),
("CCCRE013", "CONECT COBRE ROSC EXT 13MM", 7, 7.97, 1, 1, 1),
("ADB013", "ADAPT. DE BRONCE 13MM", 1, 16.47, 1, 1, 1),
("CT019M", "CINTA TEFLON 19MM 5.20", 5, 9.63, 1, 1, 1),
("CT025M", "CINTA TEFLON 25MM 5.20", 2, 9.37, 1, 1, 1),
("ABHS10", "ABRAZADERA HS-10 1/2 PULG X11/8 PULG", 1, 6.19, 1, 1, 1),
("LIPM", "LIJA DE ESMERIL MEDIANA # 80", 1, 10.93, 1, 1, 1);

SANITARIO
INSERT INTO articulo VALUES
("TPSN050TR", "TUBO PVC SANIT. NOR 50 MM. TRAMO", 5, 65.17, 3, 1, 4),
("TPSN0100TR", "TUBO PVC SANIT. NOR 100 MM. TRAMO", 4, 153.53, 3, 1, 4),
("TPSN0150TR", "TUBO PVC SANIT. NOR 150 MM. TRAMO", 5, 376.21, 3, 1, 4),
("CPSCY050", "Y SAN.ECO.CEMENTAR 50X50", 3, 8.11, 3, 1, 4),
("CPSCY100", "Y SAN.ECO.CEMENTAR 100 X 100", 7, 30.72, 3, 1, 4),
("CPSCY100050", "RED.SAN.ECO.CEMENTAR 100X 50", 8, 10.27, 3, 1, 4),
("CPSCC4050", "CODO SAN.ECO.CEMENTAR 45 X 50", 28, 2.69, 3, 1, 4),
("CPSCC9050", "CODO SAN.ECO.CEMENTAR 90 X 50", 18, 3.13, 3, 1, 4),
("VU3701", "CESPOL BOTE CH P/LAVABO F-3701", 6, 46.29, 3, 1, 4),
("JBCUC", "CUELLO DE CERA.", 5, 12.07, 3, 1, 4),
("PETR950", "TANGIT TODA PRESION 950 ML (ROSA) 417067", 2, 25.30, 8, 1, 4),
("FM9771", "CESPOPRACTICK FREGADERO R/BCA FAMA 9771.", 1, 25.30, 3, 1, 4),
("CEF2291", "CESPOL P/FREG GDE 2291", 2, 52.93, 3, 1, 4);

ELÉCTRICO
INSERT INTO articulo VALUES
("045-MC4S/CH2", "CABLE ALUMINIO MC4 S/CHAQUETA CAL.2", 84, 146.20, 5, 2, 3),
("045-MC4S/CH500", "CABLE ALUMINIO MC4 S/ CHAQUETA CAL.500", 152, 698.51, 5, 2, 3),
("045-MC3S/CH300", "CABLE ALUMINIO MC3 S/CHAQUETA CAL.300", 128, 401.38, 5, 2, 3),
("045-MC4S/CH250", "CABLE ALUMINIO MC4 S/CHAQUETA CAL.250", 162, 441.14, 5, 2, 3),
("045-MC4S/CH250", "CABLE ALUMINIO MC4 S/CHAQUETA CAL.250", 54, 539.95, 5, 2, 3),
("045-MC4S/CH300", "CABLE ALUMINIO MC4 S/CHAQUETA CAL.300", 54, 617.81, 5, 2, 3),
("EPRC401GISSB", "POSTE RECTO CIR 4M N3 GALV. RG P (25X25)", 37, 2305.88, 5, 2, 3),
("078-112T132H", "TRANS 3F 112.5KVA 480V", 7, 48629.57, 4, 2, 3),
("078-45T132H", "TRANSF. T. SECO 480 220/127", 1, 29899.09, 4, 2, 3),
("078-HDL36125", "INT. PP. 3 POLOS 125 A, 18KA", 7, 6840.48, 4, 2, 3),
("078-HDL36060", "INT. PP. 3 POLOS 60 A, 18KA", 1, 3967.18, 4, 2, 3),
("078-DU322", "INTERRUPTOR DE SEG NAVAJAS 3P 60AMP N-1 240V", 1, 1263.51, 4, 2, 3),
("078-DU322RB", "INTERRUPTOR DE SEG NAVAJAS 3P 60AMP N-3R 240V", 1, 3174.39, 4, 2, 3),
("078-QO312L125G", "CAJA CON INTERIOR PARA CENTRO DE CARGA DE 12 POLOS. 125 A.
TRIFASICO", 1, 1976.45, 6, 2, 3),
("078-QOC16US", "CUBIERTA PARA CENTRO DE CARGA QO 16 POLOS TIPO DE SOBREPONER.", 1, 383.06, 6, 2, 3),
("078-QO330", "INTERRUPTOR TERMOMAGNETICO 3 POLOS 30 A. ENCHUFABLE", 1, 1054.59, 6, 2, 3),
("078-QO120", "INTERRUPTOR TERMOMAGNETICO 1 POLO 20 A. ENCHUFABLE", 1, 103.19,  6, 2, 3),
("078-QO115", "INT. 15 AMP. 1 POLO.", 1, 103.19, 6, 2, 3),
("31201525", "CINTA SUPER 33 (ME900103271)", 30, 51.6379, 11, 2, 3),
("31201525", "CINTA PVC COLOR NEGRO GENERICO (ME900105151)", 50, 11.6379, 11, 2, 3),
("078-DU321", "INTERRUPTOR DE SEG NAVAJAS 3P 30AMP N-1 240V", 1, 856.33, 4, 2, 3),
("078-DU321RB", "INTERRUPTOR DE SEG NAVAJAS 3P 30AMP N-3R 240V", 1, 2808.91, 4, 2, 3);
PLUVIAL
INSERT INTO articulo VALUES
("TPSN150TR", "TUBO PVC SANIT. NORMA 150 MM. TRAMO", 5, 376.21, 3, 1, 2),
("TPSN100TR", "TUBO PVC SANIT. NORMA 100 MM. TRAMO", 10, 153.53, 3, 1, 2),
("CPSCC9100", "CODO SAN.ECO.CEMENTAR 90 X100", 15, 13.51, 3, 1, 2),
("COFE020", "COLADERA D FO.FO.20X20", 7, 101.21, 3, 1, 2);

VOZ Y DATOS
INSERT INTO articulo VALUES
("MG50-432 EZ", "PZ BANDEJA CHAROFIL 66/150 ANCHO TRAMO DE 3 METROS", 1, 309.64, 9, 4, 5),
("2171013-1", "BO (UN884031004/10) CABLE UTP CATEGORIA 6A", 1, 245.35, 7, 4, 5),
("1-1375055-3", "PZ JACK RJ45 CATEGORIA 6 SERIE SL BLANCO", 1, 4.92, 7, 4, 5),
("1-2111009-3", "PZ PLACA MODULAR 2 PUERTOS RJ45 SERIE SL BLANCA", 1, 2.02, 7, 4, 5),
("1-2111008-3", "PZ PLACA MODULAR 1 PUERTO RJ45 SERIE SL BLANCA", 1, 1.95, 7, 4, 5),
("NORTH 722-NT", "PZ KIT DE TIERRA FISICA", 1, 39.53, 10, 4, 5),
("TGBUE-RACK", "PZ BARRA UNION TIERRA FISICA MONTABLE EN RACK", 1, 34.92, 10, 4, 5),
("AX103256", "PZ PANEL DE PARCHEO KEYCONNECT 48 PUERTOS 10GX", 1, 10670.94, 7, 4, 5),
("NORTH 118-BKL", "PZ ORGANIZADOR VERTICAL DOBLE RACK 7FT DUCTO 3 PULG", 1, 2543.1, 10, 4, 5),
("NORTH 001-BKL", "PZ RACK DE ALUMINIO 7X19 LIGERO NORMAL 45UR COLOR", 1, 1347.99, 10, 4, 5),
("NORTH 115-BKL", "PZ ORGANIZADOR VERTICAL SENCILLO RACK 7FT DUCTO 4", 1, 1401.54, 10, 4, 5),
("NORTH 721-BKL", "KIT JUEGO DE SOPORTES DE PARED PARA RACK ABIERTO COLOR", 1, 1115.73, 10, 4, 5),
("NORTH 111-BKL", "PZ ORGANIZADOR HORIZONTAL 2UR DOBLE 19 PULG FRON3 PULG X3 PULG POST3 PULG", 1, 934.29, 10, 4, 5),
("NORTH 740-BKL", "PZ KIT DE ANCLAJE PARA PISO FALSO", 1, 888.3, 10, 4, 5),
("NORTH 600-BKL", "PZ BARRA 12 CONTACTOS HORIZONTAL 19 PULGX1.75 PULG NEGRO TEXT", 1, 752.43, 10, 4, 5),
("FP4LDLD003M", " PZ JUMPER DUPLEX LC-LC MULTIMODO 50/125UM OM4 3MTS", 1, 595.98, 11, 4, 5),
("NORTH 109-BKL", "PZ ORGANIZADOR HORIZONTAL 2UR SENCILLO 19FT DUCTO 3X3", 1, 389.34, 10, 4, 5),
("CA21108010", "PZ CORDON DE PARCHEO 10GX CAT.6A UNIVERSAL GRIS 10FT", 1, 295.26, 10, 4, 5),
("NORTH 105-BKL", "PZ ORGANIZADOR HORIZONTAL 1UR SENCILLO 19 PULG DUCTO1.5 PULGX2 PULG", 1, 207.9, 10, 4, 5),
("FD4D012R9", "FT B9E042T FIBRA OPTICA 12 HILOS INT/EXT MULTIMODO OM4", 1, 389.34, 10, 4, 5);

-- Stored procedure
DELIMITER $$
CREATE PROCEDURE findArticle(IN idArt CHAR(20))
BEGIN
SELECT idArticulo, cantidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
FROM 
articulo, marca, categoria, proveedor
WHERE 
articulo.marca=marca.idMarca AND 
articulo.categoria=categoria.idCategoria AND
articulo.proveedor=proveedor.idProveedor AND
idArticulo = idArt;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE getMarcas()
BEGIN
SELECT * FROM marca;
END$$
DELIMITER ;

-- Trigger
DELIMITER $$
CREATE TRIGGER checkStock AFTER UPDATE ON articulo
FOR EACH ROW 
BEGIN
IF NEW.cantidad <= 20 THEN
INSERT INTO purchase (idArticulo, cantidadComprada) VALUES (OLD.idArticulo, 100);
END IF;
END$$
DELIMITER ;

-- test inserts
INSERT INTO articulo VALUES ("1",1,1,1,1);