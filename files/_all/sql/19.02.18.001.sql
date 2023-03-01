UPDATE `itconfig` SET `Version_DCD`='19.02.27.001';
UPDATE `hctipos` SET `Dx_HCT`='0' WHERE  `Codigo_HCT`='TRIAGE';
DELETE FROM `hccampos` WHERE  `Codigo_HCT`='TRIAGE' AND `Codigo_HCC`='alientalcohl';
DELETE FROM `hccampos` WHERE  `Codigo_HCT`='TRIAGE' AND `Codigo_HCC`='tipollegada';
UPDATE `ititems` SET `Nombre_ITM`='Admisiones Triage' WHERE  `Codigo_ITM`=482 AND `Codigo_MNU`=48 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Admisiones Triage' WHERE  `Codigo_ITM`=372 AND `Codigo_MNU`=92 AND `Codigo_MOD`=6 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `OpSave_ITM`) VALUES ('486', '92', '6', '2', 'Listado Triage', '0');
UPDATE `ititems` SET `Icono_ITM`='legend.png', `Enlace_ITM`='forms/listotaltriage.php' WHERE  `Codigo_ITM`=486 AND `Codigo_MNU`=92 AND `Codigo_MOD`=6 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Activo_ITM`='0' WHERE  `Codigo_ITM`=486 AND `Codigo_MNU`=92 AND `Codigo_MOD`=6 AND `Codigo_APP`=2;
