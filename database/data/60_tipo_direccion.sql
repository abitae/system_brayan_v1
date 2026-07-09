DROP TABLE IF EXISTS sunat_60;
CREATE TABLE sunat_60(
   codigo      VARCHAR(2) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(14) NOT NULL
);
INSERT INTO sunat_60(codigo,descripcion) VALUES
 ('01','Punto de venta')
,('02','Producción')
,('03','Extracción')
,('04','Explotación')
,('05','Otros');
