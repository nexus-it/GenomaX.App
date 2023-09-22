-- NUEVO ENTERPRISE 2021

UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.03.31.100' ;
UPDATE `itreports` SET `SQL_RPT`='Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS, TipoConsulta_CIT, concat(\'SEDE: \', Nombre_SDE, \'  |  Dirección: \', Direccion_SDE,\'  |  Tels.: \', Telefonos_SDE ) \r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, czsedes k \r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID and k.Codigo_SDE=g.Codigo_SDE \r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT=\'P\' \r\nand c.Fecha_AGE between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\' and d.ID_TER like \'%@PACIENTE%\' Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasprogramadasusuario' AND `Codigo_DCD`=0;
ALTER TABLE `gxcitasmedicas`
	ADD COLUMN `Codigo_TAH` CHAR(1) NOT NULL DEFAULT '1' AFTER `Hora_AGE`,
	ADD INDEX `Codigo_TAH` (`Codigo_TAH`);
ALTER TABLE `hcodontograma`
	CHANGE COLUMN `Diente_ODG` `Estados_ODG` TEXT NOT NULL AFTER `Codigo_HCF`,
	CHANGE COLUMN `Codigo_OGC` `Nota_ODG` TEXT NOT NULL AFTER `Estados_ODG`,
	DROP COLUMN `Codigo_OGS`;
ALTER TABLE `hcordenesservicios`
	CHANGE COLUMN `Observaciones_HCS` `Observaciones_HCS` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Cantidad_HCS`;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('1', 'DIENTE INTACTO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('2', 'DIENTE AUSENTE');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('3', 'REMANENTE RADICULAR');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('4', 'EXTRUSION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('5', 'INTRUSION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('6', 'GIROVERSION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('7', 'MIGRASION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('8', 'MICRODONCIA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('9', 'MACRODONCIA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('10', 'ECTOPICO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('11', 'TRANSPOSICION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('12', 'CLAVIJA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('13', 'FRACTURA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('14', 'DIENTE DISCROMICO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('15', 'GEMINACION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('16', 'CARIES');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('17', 'OBTURACION TEMPORAL');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('18', 'AMALGAMA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('19', 'RESINA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('20', 'INCRUSTACION');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('21', 'ENDODONCIA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('22', 'DESGASTADO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('23', 'DIASTEMA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('24', 'MOVILIDAD');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('25', 'CORONA TEMPORAL');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('26', 'CORONA COMPLETA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('27', 'CORONA VEENER');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('28', 'CORONA FEXESTRADA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('29', 'CORONA TRES CUARTOS');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('30', 'CORONA PORCELANA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('31', 'PROTESIS FIJA');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('32', 'PROTESIS REMOVIBLE');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('33', 'ODONTULO TOTAL');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('34', 'APARAT. ORTO. FIJO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('35', 'APARAT. ORTO. REMOV.');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('36', 'IMPLANTE');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('37', 'SUPERNUMERARIO');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('38', 'DIENTE POR EXTRAER');
UPDATE `hcsv1` SET `Codigo_SV1`='6' WHERE  `Codigo_SV1`='0';
UPDATE `hcsv3` SET `Codigo_SV1`='6' WHERE  `Codigo_HSV`='01' AND `Codigo_SV1`='0';
UPDATE `hcsv3` SET `Codigo_SV1`='6' WHERE  `Codigo_HSV`='03' AND `Codigo_SV1`='0';
UPDATE `hcsv3` SET `Codigo_SV1`='6' WHERE  `Codigo_HSV`='02' AND `Codigo_SV1`='0';
UPDATE `hcsv3` SET `Codigo_SV1`='6' WHERE  `Codigo_HSV`='06' AND `Codigo_SV1`='0';
UPDATE `itreports` SET `SQL_RPT`='Select LPAD(a.Codigo_MCJ,10,\'0\'), p.Razonsocial_DCD, p.NIT_DCD, c.Codigo_CJA, c.Nombre_CJA, a.Fecha_MCJ, a.Consec_CJA, concat(g.Sigla_TID,\' \', f.ID_TER), f.Nombre_TER, a.Codigo_ADM, e.Nombre_TMC, e.Naturaleza_TMC, a.Codigo_TIC, a.Concepto_MCJ, a.Observaciones_MCJ, a.Estado_MCJ, concat(\'[\', d.Codigo_USR,\'] \',d.ID_USR) \r\nFrom czmovcajaenc a, czmovcajadet b, czcajas c, itusuarios d, cztipomovcaja e, itconfig p, czterceros f, cztipoid g\r\nWhere a.Codigo_MCJ=b.Codigo_MCJ and a.Codigo_CJA=c.Codigo_CJA and a.Codigo_USR=d.Codigo_USR and e.Codigo_TMC=a.Codigo_TMC and f.Codigo_TER=a.Codigo_TER\r\nand g.Codigo_TID=f.Codigo_TID and a.Codigo_MCJ between @CODIGO_INICIAL and @CODIGO_FINAL' WHERE  `Codigo_RPT`='cajasmov' AND `Codigo_DCD`=0;
ALTER TABLE `hcodontogramasimbolos`
	ADD COLUMN `Estado_OGS` CHAR(1) NULL DEFAULT '0' AFTER `Simbolo_OGS`;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('39', 'INCLUIDO', '1');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('40', 'SEMI-INCLUIDO', '1');
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=38;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=16;
UPDATE `hcodontogramasimbolos` SET `Descripcion_OGS`='ENDODONCIA INDICADA', `Estado_OGS`='1' WHERE  `Codigo_OGS`=21;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('41', 'ENDODONCIA REALIZADA', '1');
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=18;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=32;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=31;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('42', 'PROTESIS MAL ESTADO', '1');
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=19;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('43', 'IONOMETRO DE VIDRIO', '1');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('44', 'INCRUSTACION METALICA', '1');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('45', 'INCRUSTACION ESTETICA', '1');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`) VALUES ('46', 'EN ERUPCIONADO');
UPDATE `hcodontogramasimbolos` SET `Descripcion_OGS`='EN ERUPCION' WHERE  `Codigo_OGS`=46;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=46;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=1;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('47', 'SELLANTE POR REALIZAR', '1');
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('48', 'SELLANTE REALIZADO', '1');
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=34;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=35;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=23;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=33;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=25;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=26;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=27;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=28;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=29;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=30;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=3;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=4;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=5;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=6;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=7;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=8;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=9;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=10;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=11;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=12;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=13;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=14;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=15;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=17;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=20;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=22;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=24;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=37;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=36;
UPDATE `hcodontogramasimbolos` SET `Estado_OGS`='1' WHERE  `Codigo_OGS`=2;
UPDATE `ititems` SET `Enlace_ITM`='forms/ctterceros.php' WHERE  `Codigo_ITM`=1 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='reseller_programm.png' WHERE  `Codigo_ITM`=1 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
CREATE TABLE `czregimenes` (
	`Codigo_RGN` CHAR(1) NULL DEFAULT NULL,
	`Nombre_RGN` VARCHAR(50) NULL DEFAULT NULL
)
COMMENT='Regimen Tributario'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `czregimenes` (`Codigo_RGN`, `Nombre_RGN`) VALUES ('S', 'SIMPLE');
INSERT INTO `czregimenes` (`Codigo_RGN`, `Nombre_RGN`) VALUES ('C', 'COMUN');
INSERT INTO `czregimenes` (`Codigo_RGN`, `Nombre_RGN`) VALUES ('G', 'GRAN CONTRIBUYENTE');
ALTER TABLE `czterceros`
	ADD COLUMN `Codigo_RGN` CHAR(1) NULL DEFAULT 'S' AFTER `FormatImg_TER`;
CREATE TABLE `czcuentascont` (
	`Codigo_CTA` VARCHAR(10) NOT NULL,
	`Nombre_CTA` VARCHAR(255) NULL DEFAULT NULL,
	`Codigo_NVL` CHAR(1) NULL DEFAULT NULL COMMENT 'Nivel',
	`ManCC_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Maneja Centro Costo',
	`Activo_CTA` CHAR(1) NULL DEFAULT '0',
	INDEX `Codigo_NVL` (`Codigo_NVL`),
	PRIMARY KEY (`Codigo_CTA`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `hcordenesins` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Codigo_SER` VARCHAR(6) NOT NULL COLLATE 'utf8_general_ci',
	`Cantidad_HCS` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `Codigo_SER`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE,
	INDEX `Codigo_SER` (`Codigo_SER`) USING BTREE
)
COMMENT='Ordenes Para Insumos'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;
ALTER TABLE `hcordenesins`
	CHANGE COLUMN `Cantidad_HCS` `Cantidad_SER` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_SER`;
CREATE TABLE `cznivelescuentas` (
	`Codigo_NVL` INT NOT NULL,
	`Nombre_NVL` VARCHAR(50) NULL DEFAULT NULL,
	`Auxiliar_NVL` CHAR(1) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_NVL`),
	INDEX `Auxiliar_NVL` (`Auxiliar_NVL`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `cznivelescuentas` (`Codigo_NVL`, `Nombre_NVL`, `Auxiliar_NVL`) VALUES ('1', 'CLASE', '0');
INSERT INTO `cznivelescuentas` (`Codigo_NVL`, `Nombre_NVL`, `Auxiliar_NVL`) VALUES ('2', 'GRUPO', '0');
INSERT INTO `cznivelescuentas` (`Codigo_NVL`, `Nombre_NVL`, `Auxiliar_NVL`) VALUES ('3', 'CUENTA', '0');
INSERT INTO `cznivelescuentas` (`Codigo_NVL`, `Nombre_NVL`, `Auxiliar_NVL`) VALUES ('4', 'SUBCUENTA', '0');
INSERT INTO `cznivelescuentas` (`Codigo_NVL`, `Nombre_NVL`, `Auxiliar_NVL`) VALUES ('5', 'AUXILIAR', '1');
ALTER TABLE `czcuentascont`
	CHANGE COLUMN `Codigo_NVL` `Codigo_NVL` INT(1) NULL DEFAULT NULL COMMENT 'Nivel' COLLATE 'utf8_general_ci' AFTER `Nombre_CTA`;
UPDATE `ititems` SET `Nombre_ITM`='Tipos de Comprobante' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
CREATE TABLE `czclasescont` (
	`Codigo_CLA` INT NOT NULL,
	`Nombre_CLA` VARCHAR(50) NULL DEFAULT NULL,
	`Naturaleza_CLA` ENUM('Debito','Credito') NULL DEFAULT 'Debito',
	PRIMARY KEY (`Codigo_CLA`),
	INDEX `Naturaleza_CLA` (`Naturaleza_CLA`),
	INDEX `Codigo_CLA` (`Codigo_CLA`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`) VALUES ('1', 'Activos');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`, `Naturaleza_CLA`) VALUES ('2', 'Pasivos', 'Credito');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`, `Naturaleza_CLA`) VALUES ('3', 'Patrimonio', 'Credito');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`, `Naturaleza_CLA`) VALUES ('4', 'Ingresos', 'Credito');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`) VALUES ('5', 'Gastos');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`) VALUES ('6', 'Costos de Venta');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`) VALUES ('7', 'Costos de Producción');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`) VALUES ('8', 'Deudoras');
INSERT INTO `czclasescont` (`Codigo_CLA`, `Nombre_CLA`, `Naturaleza_CLA`) VALUES ('9', 'Acreedoras', 'Credito');
ALTER TABLE `czclasescont`
	ADD COLUMN `Tipo_CLA` ENUM('Balance','Resultado', 'Orden') NULL DEFAULT 'Resultado' AFTER `Naturaleza_CLA`,
	ADD COLUMN `Patrimonio_CLA` CHAR(1) NULL DEFAULT '0' AFTER `Tipo_CLA`,
	ADD INDEX `Tipo_CLA` (`Tipo_CLA`),
	ADD INDEX `Patrimonio_CLA` (`Patrimonio_CLA`);
UPDATE `czclasescont` SET `Tipo_CLA`='Balance' WHERE  `Codigo_CLA`=1;
UPDATE `czclasescont` SET `Tipo_CLA`='Balance' WHERE  `Codigo_CLA`=2;
UPDATE `czclasescont` SET `Tipo_CLA`='Balance' WHERE  `Codigo_CLA`=3;
UPDATE `czclasescont` SET `Tipo_CLA`='Orden' WHERE  `Codigo_CLA`=8;
UPDATE `czclasescont` SET `Tipo_CLA`='Orden' WHERE  `Codigo_CLA`=9;
UPDATE `czclasescont` SET `Patrimonio_CLA`='1' WHERE  `Codigo_CLA`=3;
ALTER TABLE `czcuentascont`
	ADD COLUMN `ManTer_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Maneja Terceros' AFTER `Codigo_NVL`,
	ADD COLUMN `CierreTer_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cierre Terceros' AFTER `ManTer_CTA`,
	ADD COLUMN `Codigo_TER` CHAR(6) NULL DEFAULT '' COMMENT 'Codigo Tercero' AFTER `CierreTer_CTA`,
	ADD COLUMN `ManRet_CTA` ENUM('Ninguna', 'ReteFuente', 'ReteIVA', 'ReteICA', 'Otras') NULL DEFAULT 'Ninguna' COMMENT 'Maneja Retención' AFTER `Codigo_TER`,
	ADD COLUMN `Concilia_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Conciliar Cuenta' AFTER `ManCC_CTA`,
	ADD COLUMN `Disponibilidad_CTA` ENUM('Corriente', 'No Corriente', 'Ambas') NULL DEFAULT 'Corriente' COMMENT 'Disponibilidad' AFTER `Concilia_CTA`,
	ADD COLUMN `ManAjuste_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Maneja Ajustes' AFTER `Disponibilidad_CTA`,
	ADD COLUMN `Ajuste_CTA` VARCHAR(10) NULL DEFAULT '' COMMENT 'Cuenta Ajuste' AFTER `ManAjuste_CTA`,
	ADD COLUMN `Correccion_CTA` VARCHAR(10) NULL DEFAULT '' COMMENT 'Cuenta Corrección' AFTER `Ajuste_CTA`,
	DROP COLUMN `Activo_CTA`,
	ADD INDEX `ManTer_CTA` (`ManTer_CTA`),
	ADD INDEX `ManRet_CTA` (`ManRet_CTA`),
	ADD INDEX `Concilia_CTA` (`Concilia_CTA`);
INSERT INTO `czregimenes` (`Codigo_RGN`, `Nombre_RGN`) VALUES ('E', 'EMPRESA ESTATAL');
CREATE TABLE `itconfig_ct` (
	`CtaDeficit_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Cuenta de Deficit',
	`CtaSuperavit_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Cuenta de Superavit',
	`CtaGanancias_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Cuenta de Ganancias',
	`CtCierre_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Comprobante de Cierre',
	`NitDIAN_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Nit DIAN',
	`NitTesoreria_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Tesoreria Distrital',
	`CtTraslados` CHAR(1) NULL DEFAULT '' COMMENT 'Comprobante de Traslados',
	`ReteIVA_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Retencion IVA',
	`ReteICA_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Retencion ICA',
	`ReteFuente_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Rete Fuente',
	`InterfazFC_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Interfaz Facturacion',
	`InterfazCR_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Interfaz Cartera',
	`InterfazTS_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Interfaz Tesoreria',
	`InterfazIN_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Interfaz Inventario'
)
COMMENT='Config General Contabilidad'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `czfuentescont` (
	`Codigo_FNC` CHAR(6) NOT NULL,
	`Nombre_FNC` VARCHAR(50) NULL DEFAULT NULL,
	`Consec_FNC` CHAR(6) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_FNC`),
	INDEX `Codigo_FNC` (`Codigo_FNC`)
)
COMMENT='Fuentes Contables - Comprobantes'
COLLATE='utf8_general_ci'
;
INSERT INTO `czfuentescont` (`Codigo_FNC`, `Nombre_FNC`, `Consec_FNC`) VALUES ('CT99', 'CIERRE CONTABLE', '0');
ALTER TABLE `czfuentescont`
	CHANGE COLUMN `Consec_FNC` `Consec_FNC` CHAR(6) NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Nombre_FNC`;
ALTER TABLE `czcuentascont`
	ADD COLUMN `Activo_CTA` CHAR(1) NULL DEFAULT '0' COMMENT 'Es Activo' AFTER `ManCC_CTA`;
ALTER TABLE `czcuentascont`
	COMMENT='Catalogo PUC';
UPDATE `ititems` SET `Enlace_ITM`='forms/ctpuc.php' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='text_padding_left.png' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OpSave_ITM`='0' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
