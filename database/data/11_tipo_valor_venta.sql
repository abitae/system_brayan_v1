DROP TABLE IF EXISTS sunat_11;
CREATE TABLE sunat_11
(
    codigo      VARCHAR(2)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(11) NOT NULL
);
INSERT INTO sunat_11(codigo, descripcion)
VALUES ('01', 'Gravado')
     , ('02', 'Exonerado')
     , ('03', 'Inafecto')
     , ('04', 'Exportación')
     , ('05', 'Gratuitas');
