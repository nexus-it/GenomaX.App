UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.28.001';
ALTER TABLE `gxcamas`
	CHANGE COLUMN `Codigo_ARE` `Codigo_ARE` VARCHAR(3) NULL DEFAULT NULL AFTER `Codigo_GRC`;
ALTER TABLE `gxestancias`
	CHANGE COLUMN `FechaFin_EST` `FechaFin_EST` DATETIME NULL DEFAULT '2200-12-31 00:00:00' AFTER `FechaIni_EST`;
ALTER TABLE `gxtiposexo`
	ADD COLUMN `Color_SEX` VARCHAR(7) NULL DEFAULT NULL AFTER `Nombre_SEX`;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('517', '47', '2', '2', 'Hospitalizacion');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('518', '47', '2', '2', 'Censo Diario', '1.Hospital.png', 'forms/censo.php', '517', '0');
UPDATE `ititems` SET `OptPrinter_ITM`='1' WHERE  `Codigo_ITM`=518 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Censo Hospitalario' WHERE  `Codigo_ITM`=518 AND `Codigo_MNU`=47 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
