DROP TABLE IF EXISTS sunat_57;
CREATE TABLE sunat_57(
   codigo      VARCHAR(1) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(33) NOT NULL
);
INSERT INTO sunat_57(codigo,descripcion) VALUES
 ('1','Servicios Portadores')
,('2','Teleservicios o Servicios Finales')
,('3','Servicios de Difusión')
,('4','Servicios de valor añadido');
