DROP TABLE IF EXISTS sunat_23;
CREATE TABLE sunat_23
(
    codigo      VARCHAR(2) NOT NULL PRIMARY KEY,
    descripcion VARCHAR(255)       NOT NULL
);
INSERT INTO sunat_23(codigo, descripcion)
VALUES ('01', 'Tasa 3%')
     , ('02', 'Tasa 6%');
