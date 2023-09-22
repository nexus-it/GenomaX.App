UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]19.09.06.001';
UPDATE `itreports` SET `SQL_RPT`='Select b.Codigo_FAC, c.ID_TER, c.Nombre_TER, DATE_FORMAT(b.Fecha_FAC, \'%d/%m/%Y\'), b.ValEntidad_FAC \nFrom czradicacionesdet as a, gxfacturas as b, czterceros as c, gxadmision as d \nWhere  trim(a.Codigo_FAC)=trim(b.Codigo_FAC) and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=b.Codigo_ADM and \nLPAD(a.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \nUnion\nSelect g.Codigo_FAC, concat(e.FechaIni_FAC, \' - \', e.FechaFin_FAC), e.Servicio_FAC, DATE_FORMAT(g.Fecha_FAC, \'%d/%m/%Y\'), g.ValEntidad_FAC \nFrom czradicacionesdet as w, gxfacturas as g, gxfacturascapita as e \nWhere  trim(w.Codigo_FAC)=trim(g.Codigo_FAC) and g.Codigo_FAC=e.Codigo_FAC and \nLPAD(w.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \nOrder By 1' WHERE  `Codigo_RPT`='radicaciones' AND `Codigo_DCD`=0;
RENAME TABLE `gxfacturaconf` TO `gxprestadores`;
INSERT INTO `gnx_sdnc`.`cztipoid` (`Codigo_TID`, `Nombre_TID`, `Sigla_TID`) VALUES ('11', 'Salvoconducto', 'SC');
CREATE TABLE `nxsturnocall` (
	`Codigo_TRN` INT(11) NOT NULL,
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Fecha_TRG` DATETIME NOT NULL COMMENT 'Ingreso a Cola (Pretriage)',
	`Fecha2_TRG` DATETIME NOT NULL COMMENT 'Llamado a Clasificación (Triage)',
	`Fecha3_TRG` DATETIME NOT NULL COMMENT 'Llamado a Atención (Urgencias)',
	`Codigo_EPS` VARCHAR(10) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_SDE` CHAR(4) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`Estado_TRG` CHAR(1) NULL DEFAULT '1' COMMENT '0: ANULADO; 1: PRETRIAGE; 2:TRIAGE' COLLATE 'latin1_swedish_ci',
	`Call_TRG` CHAR(1) NULL DEFAULT '0' COMMENT '0: NO LLAMAR; 1:LLAMAR',
	`Codigo_CNS` CHAR(6) NULL DEFAULT NULL COMMENT 'Consultorio Triage',
	`Edad_TRG` VARCHAR(10) NULL DEFAULT NULL,
	`Codigo_HCF` INT(11) NULL DEFAULT '0',
	`Codigo_HTR` INT(2) NULL DEFAULT '0' COMMENT 'Clasificación Triage',
	`Consultorio_TRG` CHAR(6) NULL DEFAULT NULL COMMENT 'Consultorio Urgencias',
	PRIMARY KEY (`Codigo_TRG`),
	INDEX `Codigo_TRG` (`Codigo_TRG`),
	INDEX `Fecha_TRG` (`Fecha_TRG`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Estado_TRG` (`Estado_TRG`),
	INDEX `Codigo_HCF` (`Codigo_HCF`),
	INDEX `Codigo_HTR` (`Codigo_HTR`),
	INDEX `Codigo_CNS` (`Codigo_CNS`),
	INDEX `Consultorio_TRG` (`Consultorio_TRG`),
	INDEX `Fecha3_TRG` (`Fecha3_TRG`),
	INDEX `Fecha2_TRG` (`Fecha2_TRG`)
)
COMMENT='Triage'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
