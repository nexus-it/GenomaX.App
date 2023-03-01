UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.24.001';
CREATE TABLE `czpagosdet` (
	`Codigo_PGS` CHAR(10) NOT NULL,
	`Codigo_FAC` VARCHAR(15) NOT NULL,
	`Saldo1_PGS` DECIMAL(10,2) NULL DEFAULT NULL,
	`Valor_PGS` DECIMAL(10,2) NULL DEFAULT NULL,
	`Saldo2_PGS` DECIMAL(10,2) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_PGS`, `Codigo_FAC`),
	INDEX `Codigo_FAC` (`Codigo_FAC`),
	INDEX `Codigo_PGS` (`Codigo_PGS`),
	INDEX `Saldo2_PGS` (`Saldo2_PGS`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `czpagosenc`
	CHANGE COLUMN `Total_PGS` `Total_PGS` DECIMAL(12,2) NULL DEFAULT NULL AFTER `Codigo_BCO`,
	CHANGE COLUMN `Estado_PGS` `Estado_PGS` CHAR(1) NULL DEFAULT '1' AFTER `Codigo_USR`;
ALTER TABLE `czpagosdet`
	CHANGE COLUMN `Saldo1_PGS` `Saldo1_PGS` DECIMAL(12,2) NULL DEFAULT NULL AFTER `Codigo_FAC`,
	CHANGE COLUMN `Valor_PGS` `Valor_PGS` DECIMAL(12,2) NULL DEFAULT NULL AFTER `Saldo1_PGS`,
	CHANGE COLUMN `Saldo2_PGS` `Saldo2_PGS` DECIMAL(12,2) NULL DEFAULT NULL AFTER `Valor_PGS`;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('513', '59', '1', '2', 'Recibir Pagos', 'card_money.png', 'forms/pagoscartera.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('514', '59', '1', '2', 'Confirmación de Pagos', 'card_gold.png', 'forms/pagoscartconf.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('515', '59', '1', '2', 'Pagos');
UPDATE `ititems` SET `Padre_ITM`='515' WHERE  `Codigo_ITM`=513 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='515' WHERE  `Codigo_ITM`=514 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `hccampos`
	ADD COLUMN `PyP_HCC` CHAR(1) NULL DEFAULT '0' AFTER `Parametros_HCC`;
ALTER TABLE `hccampos`
	ADD INDEX `PyP_HCC` (`PyP_HCC`);
CREATE TABLE `hcpypdata` (
	`Codigo_TER` CHAR(10) NOT NULL,
	`Codigo_HCF` INT(11) NOT NULL,
	`Codigo_HCT` CHAR(10) NULL,
	`Codigo_HCC` CHAR(15) NOT NULL,
	`Valor_PYP` CHAR(15) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `Codigo_HCC`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`),
	INDEX `Codigo_HCC` (`Codigo_HCC`),
	INDEX `Valor_PYP` (`Valor_PYP`),
	INDEX `Codigo_HCT` (`Codigo_HCT`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcpypdata`
	COMMENT='Libro de datos del programa de Promocion y Prevencion';
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcadmision', 'FORMATO', 'Formato', '3', 'S');
INSERT INTO `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('hcadmision', 'FORMATO', 'SELECT DISTINCT \'*\', \'TODOS\'  UNION SELECT DISTINCT b.Codigo_HCT, a.Nombre_HCT  FROM hctipos a, hcfolios b WHERE a.Codigo_HCT=b.Codigo_HCT ORDER BY 1');
