-- NUEVO ENTERPRISE 2021

UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.02.02.100' ;
ALTER TABLE `itconfig_fe`
	ADD COLUMN `Payments_XFE` VARCHAR(10) NULL DEFAULT NULL AFTER `UsuarioAPP_XFE`;

UPDATE `itconfig_fe` SET `Payments_XFE`='1590' WHERE  `Codigo_XFE`='Siigo';
UPDATE `itconfig_fe` SET `Payments_XFE`='1590' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `UsuarioAPP_XFE`='90023' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `Payments_XFE`='2039' WHERE  `Codigo_XFE`='SiigoTest';
ALTER TABLE `gxfacturas`
	ADD COLUMN `IdFE_FAC` INT NOT NULL DEFAULT 0 AFTER `Codigo_ADM`,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_FAC`, `Codigo_DCD`, `Codigo_AFC`, `IdFE_FAC`) USING BTREE;
ALTER TABLE `gxfacturas`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_FAC`, `Codigo_DCD`, `Codigo_AFC`, `IdFE_FAC`, `Codigo_ADM`) USING BTREE;
ALTER TABLE `gxfacturas`
	DROP INDEX `Codigo1_FAC`,
	ADD UNIQUE INDEX `Codigo1_FAC` (`Codigo_FAC`, `Codigo_DCD`, `Codigo_ADM`) USING BTREE;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `IdFE_FAC` `IdFE_FAC` VARCHAR(50) NOT NULL DEFAULT '0' AFTER `Codigo_ADM`;
ALTER TABLE `gxfacturaselectronicas`
	CHANGE COLUMN `Codigo_AFC` `IdFE_FAC` VARCHAR(50) NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Codigo_FAC`,
	CHANGE COLUMN `Estado_FAC` `NumFE_FAC` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `IdFE_FAC`,
	DROP INDEX `Codigo_AFC`,
	ADD INDEX `Codigo_AFC` (`IdFE_FAC`) USING BTREE;

INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('571', '50', '2', '2', 'Exportar Facturas a Siigo', 'document_editing.png', 'forms/factsiigo.php', '489');
----------------------------------------------------------------


CREATE TABLE `gxserviciostipos` (
	`Tipo_SER` CHAR(1) NOT NULL,
	`GrupoFE_SER` VARCHAR(50) NOT NULL DEFAULT '',
	PRIMARY KEY (`Tipo_SER`)
)
COMMENT='Tipos de Servicios'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `italertas` (
	`Class_ALR` VARCHAR(50) NULL DEFAULT 'danger',
	`Titulo_ALR` VARCHAR(50) NULL DEFAULT 'GenomaX',
	`Texto_ALR` VARCHAR(1000) NULL,
	`Estado_ALR` CHAR(50) NULL DEFAULT '1',
	INDEX `Estado_ALR` (`Estado_ALR`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `italertas` (`Titulo_ALR`, `Texto_ALR`) VALUES ('Atención:', 'No se registra el pago correspondiente al periodo. Si ya fue realizado, por favor envíe el respectivo comprobante a genomax@nexus-it.co');

