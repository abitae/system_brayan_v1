DROP TABLE IF EXISTS sunat_58;
CREATE TABLE sunat_58(
   codigo      VARCHAR(1) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(10) NOT NULL
);
INSERT INTO sunat_58(codigo,descripcion) VALUES
 ('1','Trifásico')
,('2','Monofásico');
