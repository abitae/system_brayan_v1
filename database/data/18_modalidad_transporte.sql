DROP TABLE IF EXISTS sunat_18;
CREATE TABLE sunat_18
(
    codigo      VARCHAR(2)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(18) NOT NULL
);
INSERT INTO sunat_18(codigo, descripcion)
VALUES ('01', 'Transporte público')
     , ('02', 'Transporte privado');
