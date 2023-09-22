UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.04.30.001';
UPDATE `gxdiagnostico` SET `Descripcion_DGN`='COVID-19, virus no identificado' WHERE  `Codigo_DGN`='U072';
UPDATE `gxdiagnostico` SET `Descripcion_DGN`='COVID-19, virus no identificado (NUEVO CORONAVIRUS)' WHERE  `Codigo_DGN`='U072';
UPDATE `gxdiagnostico` SET `Descripcion_DGN`='COVID-19, virus identificado (NUEVO CORONAVIRUS)' WHERE  `Codigo_DGN`='U071';
UPDATE gxdiagnostico SET descripcion_dgn=upper(descripcion_dgn);
ALTER TABLE `gxdiagnostico`
	ADD INDEX `Masculino_DGN` (`Masculino_DGN`),
	ADD INDEX `Femenino_DGN` (`Femenino_DGN`);
ALTER TABLE `hctipos`
	ADD COLUMN `Insumos_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Consumo de Medicamentos o Insumos' COLLATE 'swe7_swedish_ci' AFTER `Med_HCT`;
CREATE TABLE `hctipoglasgow` (
	`Tipo_GLW` CHAR(1) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_GLW` CHAR(4) NOT NULL COLLATE 'utf8_general_ci',
	`Nombre_GLW` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	INDEX `Codigo_GLW` (`Codigo_GLW`) USING BTREE,
	INDEX `Tipo_GLW` (`Tipo_GLW`) USING BTREE
)
COMMENT='Tipo Escala Glasgow'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hctipoglasgow`
	ADD COLUMN `Valor_GLW` INT NULL DEFAULT '1' AFTER `Nombre_GLW`,
	ADD PRIMARY KEY (`Tipo_GLW`, `Codigo_GLW`);
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`) VALUES ('1', 'OCU1', 'AUSENTE');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('1', 'OCU2', 'ESTIMULO DOLOROSO', '2');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('1', 'OCU3', 'ORDEN VERBAL', '3');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('1', 'OCU4', 'ESPONTANEA', '4');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`) VALUES ('2', 'VRB1', 'AUSENTE');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('2', 'VRB2', 'PALABRAS INCOMPRENSIBLES', '2');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('2', 'VRB3', 'PALABRAS INAPROPIADAS', '3');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('2', 'VRB4', 'CONFUSO', '4');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('2', 'VRB5', 'ORIENTADO', '5');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`) VALUES ('3', 'MTR1', 'AUSENTE');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('3', 'MTR2', 'EXTENSION AL DOLOR', '2');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('3', 'MTR3', 'FLEXION AL DOLOR', '3');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('3', 'MTR4', 'RETIRADA AL DOLOR', '4');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('3', 'MTR5', 'LOCALIZA DOLOR', '5');
INSERT INTO `hctipoglasgow` (`Tipo_GLW`, `Codigo_GLW`, `Nombre_GLW`, `Valor_GLW`) VALUES ('3', 'MTR6', 'OBEDECE ORDENES', '6');
ALTER TABLE `hctipos`
	ADD COLUMN `Glasgow_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Escala Glasgow' AFTER `SV_HCT`;
CREATE TABLE `hcglasgow` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Codigo_GLW` CHAR(4) NOT NULL,
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `Codigo_GLW`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE,
	INDEX `Codigo_GLW` (`Codigo_GLW`) USING BTREE
)
COMMENT='Glasgow a pacientes'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hctipos`
	ADD COLUMN `Consentimiento_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Consentimiento Informado' AFTER `Triage_HCT`;
CREATE TABLE `hcconsentimiento` (
	`Codigo_HCT` CHAR(10) NOT NULL,
	`Texto_HCT` TEXT NULL DEFAULT NULL,
	`Estado_HCT` CHAR(1) NOT NULL DEFAULT '1',
	INDEX `Codigo_HCT` (`Codigo_HCT`),
	PRIMARY KEY (`Codigo_HCT`, `Estado_HCT`),
	INDEX `Estado_HCT` (`Estado_HCT`)
)
COMMENT='Plantillas de consentimiento informado'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
RENAME TABLE `hcconsentimiento` TO `hcplantconsinform`;
CREATE TABLE `hcconsentinformados` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Nombre_HCT` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`TipoID_HCT` VARCHAR(10) NULL COLLATE 'utf8_general_ci',
	`ID_HCT` VARCHAR(25) NULL COLLATE 'utf8_general_ci',
	`IDFrom_HCT` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`EnCalidadDe_HCT` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Consentimientos Informados'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcconsentinformados`
	ADD COLUMN `Firma_HCT` BLOB NULL DEFAULT NULL AFTER `EnCalidadDe_HCT`;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('542', '106', '2', '2', 'Res. 521 de 2020 (COVID-19)', 'column_tree.png', 'forms/res521covid.php', '529', '0');
UPDATE `ititems` SET `Icono_ITM`='investment_menu_quality.png' WHERE  `Codigo_ITM`=542 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `hcsv2` (`Codigo_HSV`, `Nombre_HSV`, `Sigla_HSV`, `Min_HSV`, `Max_HSV`, `Vinculado_HSV`, `Sufijo_HSV`) VALUES ('14', 'Oximetría Sin O2', 'SPO Sin O2', '0', '100', '', '%');
INSERT INTO `hcsv2` (`Codigo_HSV`, `Nombre_HSV`, `Sigla_HSV`, `Min_HSV`, `Max_HSV`, `Vinculado_HSV`, `Sufijo_HSV`) VALUES ('15', 'Oximetría Con O2', 'SPO Con O2', '0', '100', '', '%');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('01', '5', '1');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('02', '5', '2');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('03', '5', '3');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('06', '5', '4');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('14', '5', '5');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('15', '5', '6');
ALTER TABLE `gxadmision-covid19`
	ADD COLUMN `Estado_CVD` INT NULL DEFAULT '0' AFTER `Codigo_CVG`,
	ADD INDEX `Estado_CVD` (`Estado_CVD`);
CREATE TABLE `gxpabelloncamas` (
	`Codigo_DCD` INT(5) NOT NULL DEFAULT '0',
	`Codigo_PBC` VARCHAR(4) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Codigo_GRC` VARCHAR(4) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Descripcion_PBC` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_PBC`, `Codigo_DCD`) USING BTREE,
	UNIQUE INDEX `Codigo_PBC` (`Codigo_PBC`, `Codigo_DCD`) USING BTREE,
	INDEX `Codigo_PBC_2` (`Codigo_PBC`) USING BTREE,
	INDEX `Codigo_GRC_2` (`Codigo_GRC`) USING BTREE,
	INDEX `Codigo_DCD` (`Codigo_DCD`) USING BTREE
)
COMMENT='Pabellones Fisicos de camas'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `gxpabelloncamas`
	ADD CONSTRAINT `FK_gxpabelloncamas_gxgrupocamas` FOREIGN KEY (`Codigo_GRC`) REFERENCES `gxgrupocamas` (`Codigo_GRC`) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `gxcamas`
	CHANGE COLUMN `Codigo_GRC` `Codigo_PBC` VARCHAR(4) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Descripcion_CAM`,
	DROP INDEX `Codigo_GRC`,
	ADD INDEX `Codigo_GRC` (`Codigo_PBC`) USING BTREE,
	ADD CONSTRAINT `FK_gxcamas_gxpabelloncamas` FOREIGN KEY (`Codigo_PBC`) REFERENCES `gxpabelloncamas` (`Codigo_PBC`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	ADD CONSTRAINT `FK_gxcamas_gxareas` FOREIGN KEY (`Codigo_ARE`) REFERENCES `gxareas` (`Codigo_ARE`) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `gxpabelloncamas`
	CHANGE COLUMN `Descripcion_PBC` `Descripcion_PBC` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_PBC`;
ALTER TABLE `gxcamas`
	CHANGE COLUMN `Estado_CAM` `Estado_CAM` CHAR(1) NULL DEFAULT '1' COLLATE 'utf8_general_ci' AFTER `Ocupada_CAM`;
DELETE FROM `ititems` WHERE  `Codigo_ITM`=543 AND `Codigo_MNU`=100 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('543', '47', '2', '2', 'Traslados de Camas');
UPDATE `ititems` SET `Nombre_ITM`='Configuración' WHERE  `Codigo_ITM`=517 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='0' WHERE  `Codigo_ITM`=518 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='157' WHERE  `Codigo_ITM`=321 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('544', '47', '2', '2', 'Camas', 'forms/camas.php', '157');
UPDATE `ititems` SET `Padre_ITM`='517' WHERE  `Codigo_ITM`=544 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='517' WHERE  `Codigo_ITM`=321 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='1.Stethoscope.png' WHERE  `Codigo_ITM`=475 AND `Codigo_MNU`=100 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OptNew_ITM`='1', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=475 AND `Codigo_MNU`=100 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='vbox.png' WHERE  `Codigo_ITM`=544 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Configuración' WHERE  `Codigo_ITM`=486 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='486' WHERE  `Codigo_ITM`=544 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='486' WHERE  `Codigo_ITM`=321 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='517' WHERE  `Codigo_ITM`=443 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='517' WHERE  `Codigo_ITM`=466 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Utilidades' WHERE  `Codigo_ITM`=517 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('545', '47', '2', '2', 'Grupos de Camas', 'vbox.png', 'forms/gruposcamas.php', '486');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('546', '47', '2', '2', 'Pabellones de Camas', 'vbox.png', 'forms/pabellonescamas.php', '486');
UPDATE `ititems` SET `Icono_ITM`='vdividedbox.png' WHERE  `Codigo_ITM`=546 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='workspace.png' WHERE  `Codigo_ITM`=545 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
