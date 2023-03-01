-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.08.10.001' ;
ALTER TABLE `czfestivos`
	ADD COLUMN `Codigo_PAI` CHAR(4) NULL DEFAULT NULL AFTER `DiaFest_FST`,
	ADD INDEX `Codigo_PAI` (`Codigo_PAI`);
CREATE TABLE `itupdates` (
	`Codigo_UPD` CHAR(13) NOT NULL,
	`Descripcion_UDP` VARCHAR(255) NULL DEFAULT NULL,
	`Script_UDP` TEXT NULL DEFAULT NULL,
	`Estado_UDP` CHAR(1) NULL DEFAULT '0',
	PRIMARY KEY (`Codigo_UPD`),
	INDEX `Estado_UDP` (`Estado_UDP`),
	INDEX `Codigo_UPD` (`Codigo_UPD`)
)
COMMENT='Actualizaciones en BD (Scripts)'
COLLATE='latin1_swedish_ci'
;
ALTER TABLE `itupdates`
	CHANGE COLUMN `Codigo_UPD` `Codigo_UPD` CHAR(14) NOT NULL COLLATE 'latin1_swedish_ci' FIRST;
UPDATE `itconfig` SET `Version_DCD`='Enterprise';
ALTER TABLE `itconfig`
	CHANGE COLUMN `Version_DCD` `Version_DCD` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Updatelink_DCD`,
	ADD COLUMN `Plan_DCD` VARCHAR(10) NULL DEFAULT NULL AFTER `Version_DCD`,
	ADD COLUMN `Update_DCD` CHAR(14) NULL AFTER `Plan_DCD`;
UPDATE `itconfig` SET `Plan_DCD`='PRO', `Update_DCD`='2021.08.07.001';
UPDATE `czfestivos` SET `Codigo_PAI`='169';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('595', '91', '2', '2', 'Solicitud a Farmacia', '1.Pills.png', 'forms/inventariosolfarm.php', '1', '1', '1');
UPDATE `ititems` SET `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=595 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=356 AND `Codigo_MNU`=97 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
ALTER TABLE `czinvsolfarmacia`
	ADD COLUMN `Fecha_ISF` DATE NOT NULL AFTER `Codigo_SER`,
	ADD COLUMN `Hora_ISF` TIME NOT NULL AFTER `Fecha_ISF`,
	ADD COLUMN `Codigo_ADM` VARCHAR(10) NULL DEFAULT NULL AFTER `Hora_ISF`,
	ADD COLUMN `Codigo_ARE` VARCHAR(10) NULL DEFAULT NULL AFTER `Codigo_ADM`,
	ADD COLUMN `Codigo_USR` VARCHAR(4) NULL DEFAULT NULL AFTER `Pendiente_ISF`,
	ADD INDEX `Fecha_ISF` (`Fecha_ISF`),
	ADD INDEX `Codigo_ADM` (`Codigo_ADM`),
	ADD INDEX `Codigo_ARE` (`Codigo_ARE`),
	ADD INDEX `Codigo_USR` (`Codigo_USR`);
