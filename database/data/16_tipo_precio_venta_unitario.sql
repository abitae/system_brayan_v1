DROP TABLE IF EXISTS sunat_16;
CREATE TABLE sunat_16
(
    codigo      VARCHAR(2)  NOT NULL PRIMARY KEY,
    descripcion VARCHAR(70) NOT NULL
);
INSERT INTO sunat_16(codigo, descripcion)
VALUES ('01', 'Precio unitario (incluye el IGV)')
     , ('02', 'Valor referencial unitario en operaciones no onerosas (Gratuitas)')
     , ('03', 'Tarifas reguladas');
