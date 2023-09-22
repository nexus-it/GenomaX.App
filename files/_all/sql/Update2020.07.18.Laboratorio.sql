UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.07.20.001';
ALTER TABLE `lbsolicitudes`
	CHANGE COLUMN `Tipo_SBL` `Tipo_SLB` CHAR(1) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Codigo_SLB`,
	CHANGE COLUMN `Estado_SBL` `Estado_SLB` CHAR(1) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Codigo_TER`,
	CHANGE COLUMN `Fecha_SBL` `Fecha_SLB` DATETIME NOT NULL AFTER `Institucion_TER`,
	CHANGE COLUMN `Area_SBL` `Area_SLB` VARCHAR(120) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Fecha_SLB`,
	DROP INDEX `Estado_SBL`,
	ADD INDEX `Estado_SBL` (`Estado_SLB`) USING BTREE,
	DROP INDEX `Fecha_SBL`,
	ADD INDEX `Fecha_SBL` (`Fecha_SLB`) USING BTREE;
ALTER TABLE `lbsolicitudes`
	CHANGE COLUMN `Area_SLB` `Codigo_ARE` VARCHAR(3) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Fecha_SLB`,
	ADD INDEX `Codigo_ARE` (`Codigo_ARE`);
ALTER TABLE `lbsolicitudes`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_SLB`, `Codigo_TER`) USING BTREE;
Insert Into lbsolicitudes(Codigo_SLB, Tipo_SLB, Origen_CNX, Codigo_ORD, Codigo_TER, Estado_SLB, Codigo_USR, Institucion_TER, Fecha_SLB, Codigo_ARE)
SELECT distinct a.Codigo_HCS, 'O', '0', '', a.Codigo_TER, '0', b.Codigo_USR, 'X', b.Fecha_HCF, b.Codigo_ARE FROM hcordenesdx a, hcfolios b WHERE b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF;
SET @numexa=0;
Insert Into lbexamenes(Codigo_EXA, Codigo_SLB, Codigo_SER, Cantidad_EXA, Observaciones_EXA, Estado_EXA)
Select @numexa:=@numexa+1, a.Codigo_HCS, a.Codigo_SER, a.Cantidad_HCS, a.Observaciones_HCS, '0' FROM hcordenesdx a;
Update itconsecutivos SET `Consecutivo_CNS`=@numexa WHERE  `Campo_CNS`='Codigo_EXA' AND `Tabla_CNS`='lbexamenes' AND `Codigo_DCD`=0;
CREATE TABLE `hcresultadoslab` (
	`Codigo_TER` CHAR(10) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Codigo_HCF` CHAR(11) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Codigo_EXA` CHAR(10) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `Codigo_EXA`) USING BTREE,
	INDEX `Codigo_EXA_1` (`Codigo_EXA`) USING BTREE,
	INDEX `Codigo_TER_1` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF_1` (`Codigo_HCF`) USING BTREE
)
COMMENT='Lectura Resultados Exámenes Laboratorio'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
