UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.17.01';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('509', '59', '1', 'Cuentas por Cobrar', 'credit.png', 'forms/cartera.php', '0');
UPDATE `ititems` SET `Codigo_APP`='2' WHERE  `Codigo_ITM`=509 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('510', '59', '1', '2', 'Glosas');
UPDATE `ititems` SET `Padre_ITM`='510' WHERE  `Codigo_ITM`=423 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='510' WHERE  `Codigo_ITM`=461 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='510' WHERE  `Codigo_ITM`=462 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
CREATE TABLE `czcarteraedades` (
	`Codigo_EDA` INT NOT NULL,
	`Nombre_EDA` VARCHAR(50) NULL DEFAULT NULL,
	`Minimo_EDA` INT NULL DEFAULT NULL,
	`Maximo_EDA` INT NULL DEFAULT NULL,
	`Color_EDA` VARCHAR(7) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_EDA`),
	INDEX `Minimo_EDA_Maximo_EDA` (`Minimo_EDA`, `Maximo_EDA`)
)
COMMENT='Tipos de clasificacion de cartera por edades'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
UPDATE `itreports` SET `SQL_RPT`='Select\r\n D.Codigo_FAC, DATE_FORMAT(D.Fecha_FAC, \'%d/%m/%Y\'),LPAD(A.Codigo_ADM,10,\'0\'), concat(Q.Sigla_TID,\' \',C.ID_TER), left(C.Nombre_TER, 60), \r\n J.Descripcion_ADM, E.Codigo_EPS, F.Nombre_TER, concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR), D.ValPaciente_FAC, D.ValEntidad_FAC, K.Codigo_RAD,  DATE_FORMAT(L.FechaConf_RAD, \'%d/%m/%Y\'), D.ValCredito_FAC, D.ValTotal_FAC \r\nFrom\r\n czterceros AS C, gxeps AS E, czterceros AS F, cztipoid as Q, \r\n itusuarios AS I, gxtipoingreso AS J, gxadmision AS A, gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere\r\n A.Codigo_TER = C.Codigo_TER AND Q.Codigo_TID = C.Codigo_TID and D.Codigo_ADM=A.Codigo_ADM\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR AND J.Tipo_ADM = A.Ingreso_ADM and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\n \r\n Union\r\n \r\nSelect\r\n D.Codigo_FAC, DATE_FORMAT(D.Fecha_FAC, \'%d/%m/%Y\'),\'CAPITA\', \'0\', \'POBLACION CAPITADA\', \r\n \'FACTURA CAPITADA\', E.Codigo_EPS, F.Nombre_TER, concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR), D.ValPaciente_FAC, D.ValEntidad_FAC, K.Codigo_RAD,  DATE_FORMAT(L.FechaConf_RAD, \'%d/%m/%Y\'), D.ValCredito_FAC, D.ValTotal_FAC \r\nFrom\r\n gxeps AS E, czterceros AS F, \r\n itusuarios AS I,  gxfacturascapita AS G, gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere\r\n D.Codigo_FAC=G.Codigo_FAC\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\nOrder By\r\n2,1;' WHERE  `Codigo_RPT`='listarfacturasfecha' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='Select\r\n a.Codigo_FAC, g.Nombre_EPS, d.Nombre_PLA, concat(e.Sigla_TID,\' \', c.ID_TER), c.Nombre_TER, a.Fecha_FAC, a.ValTotal_FAC \r\nFrom\r\n gxfacturas as a, gxadmision as b, czterceros as c, gxplanes as d, cztipoid as e,  gxeps g \r\nWhere a.Codigo_ADM=b.Codigo_ADM and b.Codigo_TER=c.Codigo_TER and a.Codigo_PLA=d.Codigo_PLA and c.Codigo_TID=e.Codigo_TID \r\n and a.Estado_FAC=\'1\' and a.Fecha_FAC >=\'@FECHA_INICIAL 00:00:00\' and a.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\' \r\n and a.Codigo_FAC not in (select codigo_fac from czradicacionesdet)  \r\n and a.ValTotal_FAC>0 and g.Codigo_EPS=a.Codigo_EPS \r\nOrder by 1 asc;' WHERE  `Codigo_RPT`='factpendxradicar' AND `Codigo_DCD`=0;
ALTER TABLE `czcartera`
	ADD COLUMN `ValPagos_CAR` DECIMAL(18,2) NOT NULL DEFAULT '0.00' AFTER `ValorCre_CAR`;
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('0', 'No Vencida', '0', '29');
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('30', 'De 30 a 60 Días', '30', '60');
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('60', 'De 61 a 90 Días', '61', '90');
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('90', 'De 91 a 180 Días', '91', '180');
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('180', 'De 181 a 360 Días', '181', '360');
INSERT INTO `czcarteraedades` (`Codigo_EDA`, `Nombre_EDA`, `Minimo_EDA`, `Maximo_EDA`) VALUES ('360', 'Mayor de 360', '361', '2000');
UPDATE `czcarteraedades` SET `Color_EDA`='#d9534f' WHERE  `Codigo_EDA`=360;
UPDATE `czcarteraedades` SET `Color_EDA`='#f0ad4e' WHERE  `Codigo_EDA`=90;
UPDATE `czcarteraedades` SET `Color_EDA`='#E07370' WHERE  `Codigo_EDA`=180;
UPDATE `czcarteraedades` SET `Color_EDA`='#5cb85c' WHERE  `Codigo_EDA`=30;
UPDATE `czcarteraedades` SET `Color_EDA`='#969696' WHERE  `Codigo_EDA`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('511', '59', '1', '2', 'Cartera por Edades', 'time_go.png', 'forms/carteraedades.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('512', '59', '1', '2', 'Detalle de Factura', 'document_valid.png', 'forms/factdetcar.php');
