UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.03.31.000';
ALTER TABLE `itusuarios`
	ADD INDEX `ID_USR` (`ID_USR`);
CREATE TABLE `hctipoatencion` (
	`Codigo_TAH` CHAR(1) NOT NULL,
	`Nombre_TAH` VARCHAR(100) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_TAH`),
	INDEX `Codigo_TAH` (`Codigo_TAH`)
)
COMMENT='Tipo Atencion HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `hctipoatencion` (`Codigo_TAH`, `Nombre_TAH`) VALUES ('1', 'Presencial');
INSERT INTO `hctipoatencion` (`Codigo_TAH`, `Nombre_TAH`) VALUES ('2', 'Seguimiento telefónico o virtual');
INSERT INTO `hctipoatencion` (`Codigo_TAH`, `Nombre_TAH`) VALUES ('3', 'Atención por telesalud');
ALTER TABLE `hcfolios`
	ADD COLUMN `Codigo_TAH` CHAR(1) NULL DEFAULT '1' AFTER `Codigo_ARE`,
	ADD INDEX `Codigo_TAH` (`Codigo_TAH`);
ALTER TABLE `hctipoatencion`
	ADD COLUMN `Video_TAH` CHAR(1) NULL DEFAULT '0' AFTER `Nombre_TAH`,
	ADD COLUMN `Estado_TAH` CHAR(1) NULL DEFAULT '1' AFTER `Video_TAH`,
	ADD INDEX `Estado_TAH` (`Estado_TAH`);
UPDATE `hctipoatencion` SET `Video_TAH`='1' WHERE  `Codigo_TAH`='3';
CREATE TABLE `gxadmision-covid19` (
	`Codigo_ADM` CHAR(10) NOT NULL,
	`Codigo_CVD` CHAR(1) NULL DEFAULT NULL,
	`Codigo_CVG` CHAR(1) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_ADM`),
	INDEX `Codigo_CVD` (`Codigo_CVD`),
	INDEX `Codigo_CVG` (`Codigo_CVG`)
)
COLLATE='latin1_swedish_ci'
;
ALTER TABLE `gxadmision-covid19`
	COMMENT='ADMISIONES CON COVID-19',
	COLLATE='utf8_general_ci',
	ENGINE=InnoDB;
CREATE TABLE `gxcovid19` (
	`Codigo_CVD` CHAR(1) NOT NULL,
	`Nombre_CVD` VARCHAR(60) NULL DEFAULT NULL,
	`Estado_CVD` CHAR(1) NULL DEFAULT '1',
	PRIMARY KEY (`Codigo_CVD`),
	INDEX `Estado_CVD` (`Estado_CVD`),
	INDEX `Codigo_CVD` (`Codigo_CVD`)
)
COMMENT='PRESENTA COVID-19?'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `gxcovid19` (`Codigo_CVD`, `Nombre_CVD`) VALUES ('0', 'NO PRESENTA');
INSERT INTO `gxcovid19` (`Codigo_CVD`, `Nombre_CVD`) VALUES ('1', 'PRESENTA SINTOMAS');
INSERT INTO `gxcovid19` (`Codigo_CVD`, `Nombre_CVD`) VALUES ('2', 'COVID-19 CONFIRMADO');
CREATE TABLE `gxcovid19grupos` (
	`Codigo_CVG` CHAR(1) NOT NULL,
	`Nombre_CVG` VARCHAR(60) NULL DEFAULT NULL,
	`Estado_CVG` CHAR(1) NULL DEFAULT '1',
	PRIMARY KEY (`Codigo_CVG`),
	INDEX `Estado_CVG` (`Estado_CVG`),
	INDEX `Codigo_CVG` (`Codigo_CVG`)
)
COMMENT='GRUPO COVID-19?'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `gxcovid19grupos` (`Codigo_CVG`, `Nombre_CVG`) VALUES ('1', 'GRUPO I');
INSERT INTO `gxcovid19grupos` (`Codigo_CVG`, `Nombre_CVG`) VALUES ('2', 'GRUPO II');
INSERT INTO `gxcovid19grupos` (`Codigo_CVG`, `Nombre_CVG`) VALUES ('3', 'GRUPO III');
ALTER TABLE `hctipos`
	CHANGE COLUMN `Nombre_HCT` `Nombre_HCT` VARCHAR(65) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `Codigo_HCT`;
DELETE FROM `itauditoria` WHERE YEAR(Fecha_AUD)<'2019';