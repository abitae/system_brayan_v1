DROP TABLE IF EXISTS sunat_19;
CREATE TABLE sunat_19
(
    codigo      VARCHAR(1) NOT NULL PRIMARY KEY,
    descripcion VARCHAR(9) NOT NULL
);
INSERT INTO sunat_19(codigo, descripcion)
VALUES ('1', 'Adicionar')
     , ('2', 'Modificar')
     , ('3', 'Anulado');
