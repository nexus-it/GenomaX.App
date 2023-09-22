-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.08.07.010' ;
UPDATE czterceros a, gxpacientes b SET a.Codigot_DEP=b.Codigo_DEP, a.Codigot_MUN=b.Codigo_MUN WHERE a.Codigo_TER=b.Codigo_TER;
ALTER TABLE `czterceros`
	CHANGE COLUMN `Codigo_PAI` `Codigo_PAI` CHAR(4) NULL DEFAULT '169' COLLATE 'utf8_general_ci' AFTER `CxP_TER`,
	CHANGE COLUMN `Codigot_MUN` `Codigot_MUN` VARCHAR(3) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigot_DEP`;
UPDATE `czterceros` SET `Codigo_PAI`='169';
ALTER TABLE `czterceros`
	DROP COLUMN `Imagen_TER`,
	DROP COLUMN `FormatImg_TER`;
ALTER TABLE `czterceros`
	CHANGE COLUMN `RetVentas_TER` `RetVentas_TER` CHAR(6) NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Codigot_MUN`;
ALTER TABLE `czcentrocosto`
	CHANGE COLUMN `Codigo_CCT` `Codigo_CCT` CHAR(6) NOT NULL COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST;
