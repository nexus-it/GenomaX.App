UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.06.05.001';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('552', '91', '2', '2', 'Control de Líquidos', 'universal_binary.png', 'forms/hcenfliq.php', '374', '1');
UPDATE `ititems` SET `Icono_ITM`='draw_convolve.png' WHERE  `Codigo_ITM`=552 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('553', '91', '2', '2', 'Control de Glucometría', 'injection.png', 'forms/hcenfgluc.php', '374', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('554', '91', '2', '2', 'Control Nerológico', 'brain_trainer.png', 'forms/hcenfneuro.php', '374', '1');
CREATE TABLE `hctiposliquidos` (
	`Codigo_HLQ` CHAR(4) NULL DEFAULT NULL,
	`Nombre_HLQ` VARCHAR(150) NULL DEFAULT NULL,
	`Ingreso_HLQ` CHAR(1) NULL DEFAULT '0',
	`Egreso_HLQ` CHAR(1) NULL DEFAULT '0'
)
COMMENT='Tipos Liquidos'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
