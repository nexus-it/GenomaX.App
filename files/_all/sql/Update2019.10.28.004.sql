UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]19.11.15.001';
UPDATE `itreports` SET `SQL_RPT`='select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, e.Logo2_HCH, b.Nombre_HCT\r\nFrom\r\n itconfig a, hctipos b, hcfolios c, czterceros d, hcencabezadosdet e\r\nWhere \r\n c.Codigo_TER=d.Codigo_TER and c.Codigo_HCT=b.Codigo_HCT and b.Codigo_HCH=e.Codigo_HCH\r\n and d.ID_TER=\'@HISTORIA\' and Folio_HCF>=\'@FOLIO_INICIAL\' and Folio_HCF<=\'@FOLIO_FINAL\'' WHERE  `Codigo_RPT`='hc' AND `Codigo_DCD`=0;
ALTER TABLE `gxprestadores`	ADD COLUMN `Codigo_FCN` INT(5) NOT NULL DEFAULT '1' AFTER `Codigo_DCD`, 	CHANGE COLUMN `TipoId_FCN` `TipoId_FCN` CHAR(2) NULL DEFAULT NULL AFTER `RazonSocial_FCN`, 	DROP PRIMARY KEY,	ADD PRIMARY KEY (`Codigo_DCD`, `Codigo_FCN`),	ADD INDEX `Codigo_FCN` (`Codigo_FCN`);
UPDATE `czsedes` SET `Codigo_PRS`='1';
ALTER TABLE `gxprestadores`	CHANGE COLUMN `Codigo_FCN` `Codigo_PRS` INT(5) NOT NULL DEFAULT '1' AFTER `Codigo_DCD`;
