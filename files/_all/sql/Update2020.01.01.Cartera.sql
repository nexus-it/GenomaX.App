UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.08.001';
UPDATE `itconfig_fc` SET `PeriodoActual_XFC`='01.2020';
CREATE TABLE `itconfig_ad` (	`EditDate_XAD` CHAR(1) NULL DEFAULT '0' COMMENT 'Permitir editar la fecha en el ingreso') COMMENT='Parámetros Admisiones' COLLATE='utf8_general_ci' ENGINE=INNODB;
INSERT INTO `itconfig_ad` (`EditDate_XAD`) VALUES ('0');
UPDATE `ititems` SET `Nombre_ITM`='Registro de Enfermería' WHERE  `Codigo_ITM`=374 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('501', '91', '2', '2', 'Notas de Enfermería', 'user_medical_female.png', 'forms/hcenfermeria.php', '374', '1');
UPDATE `ititems` SET `Icono_ITM`='default.png', `Enlace_ITM`='#' WHERE  `Codigo_ITM`=374 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `itpermisos` SET codigo_itm=501 WHERE codigo_itm=374;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('502', '91', '2', '2', 'Aplicación Medicamentos', '1.Pills.png', 'forms/hcenfaplmed.php', '374', '1');
INSERT INTO itpermisos(Codigo_DCD, Codigo_PRF, Codigo_ITM) SELECT a.Codigo_DCD, a.Codigo_PRF, 502 FROM itpermisos a WHERE a.Codigo_ITM=501
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('503', '91', '2', '2', 'Curaciones', '1.BandAid.png', 'forms/hcenfcuracion.php', '374', '1');
INSERT INTO itpermisos(Codigo_DCD, Codigo_PRF, Codigo_ITM) SELECT a.Codigo_DCD, a.Codigo_PRF, 503 FROM itpermisos a WHERE a.Codigo_ITM=501;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('504', '91', '2', '2', 'Cambio de Dispositivo', '1.KidneyDish.png', 'forms/hcenfdisp.php', '374', '1');
INSERT INTO itpermisos(Codigo_DCD, Codigo_PRF, Codigo_ITM) SELECT a.Codigo_DCD, a.Codigo_PRF, 504 FROM itpermisos a WHERE a.Codigo_ITM=501;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('505', '91', '2', '2', 'Valoración Herida', '1.FirstAidKit.png', 'forms/hcenfvalherida.php', '374', '1');
INSERT INTO itpermisos(Codigo_DCD, Codigo_PRF, Codigo_ITM) SELECT a.Codigo_DCD, a.Codigo_PRF, 505 FROM itpermisos a WHERE a.Codigo_ITM=501;
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `Activo_HCT`) VALUES ('ENFAPLMEDI', 'APLICACION DE MEDICAMENTOS', '1', 'X');
ALTER TABLE `czmovcajaenc`
	ADD COLUMN `Codigo_TER` VARCHAR(10) NULL DEFAULT NULL AFTER `Consec_CJA`,
	ADD INDEX `Codigo_TER` (`Codigo_TER`);
CREATE TABLE `itdashboard` (
	`Codigo_DSH` INT(3) NULL,
	`Nombre_DSH` VARCHAR(50) NULL DEFAULT NULL,
	`Reporte_DSH` VARCHAR(50) NULL DEFAULT NULL,
	INDEX `Codigo_DSH` (`Codigo_DSH`)
)
COMMENT='Graficas relevantes para el escritorio inicial'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO itdashboard(codigo_dsh, nombre_dsh) SELECT distinct a.Codigo_MNU, a.Nombre_MNU FROM itmenu a, ititems b WHERE a.Codigo_APP='2' AND b.Codigo_MNU=a.Codigo_MNU AND b.Codigo_MOD=a.Codigo_MOD AND b.Codigo_APP='2';
UPDATE `itdashboard` SET `Reporte_DSH`='gxingresosmes' WHERE  `Codigo_DSH`=47 AND `Nombre_DSH`='Admisiones' AND `Reporte_DSH` IS NULL LIMIT 1;
UPDATE `itdashboard` SET `Reporte_DSH`='gxfacturdoxmes' WHERE  `Codigo_DSH`=50 AND `Nombre_DSH`='Facturación' AND `Reporte_DSH` IS NULL LIMIT 1;
