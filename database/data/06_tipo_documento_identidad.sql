DROP TABLE IF EXISTS sunat_06;
CREATE TABLE sunat_06(
   codigo      VARCHAR(1) NOT NULL PRIMARY KEY
  ,descripcion VARCHAR(48) NOT NULL
  ,sigla       VARCHAR(48) NOT NULL
);
INSERT INTO sunat_06(codigo,descripcion,sigla) VALUES
 ('0','DOC.TRIB.NO.DOM.SIN.RUC','OTRO DOCUMENTO cod(0)')
,('1','Documento Nacional de Identidad','DNI cod(1)')
,('4','Carnet de extranjería','CE cod(4)')
,('6','Registro Unico de Contributentes','RUC cod(6)')
,('7','Pasaporte' ,'PASAPORTE cod(7)')
,('A','Cédula Diplomática de identidad','CED.DIPLOMATICA DE IDENTIDAD cod(A)')
,('B','DOC.IDENT.PAIS.RESIDENCIA-NO.D', 'DOC.IDENT.PAIS.RESIDENCIA-NO.D cod(B)')
,('C','Tax Identification Number - TIN – Doc Trib PP.NN','TIN cod(C)')
,('D','Identification Number - IN – Doc Trib PP. JJ','IN cod(D)')
,('E','TAM- Tarjeta Andina de Migración','TAM cod(E)');
