UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.02.25.003';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('522', '44', '1', '2', 'Facturado Vs Radicado', 'reseller_account_template.png', 'forms/carteraradvsfactura.php', '409', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('522', '59', '1', '2', 'Facturado Vs Radicado', 'chart_stock.png', 'forms/carteraradvsfactura.php', '409', '0');
UPDATE `ititems` SET `Codigo_ITM`='523' WHERE  `Codigo_ITM`=522 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='0' WHERE  `Codigo_ITM`=523 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('525', '44', '1', '2', 'Facturado Por Area', 'finance.png', 'forms/nxsfactsedearea.php', '406', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('524', '44', '1', '2', 'Venta Por Facturar', 'finance.png', 'forms/nxsfactpendiente.php', '406', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `OpSave_ITM`) VALUES ('526', '44', '1', '2', 'Estadísticas', 'statistics.png', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('527', '44', '1', '2', 'Origen Población Actual', 'statistics.png', 'forms/nxsstatgeograph.php', '52', '0');
UPDATE `ititems` SET `Padre_ITM`='526' WHERE  `Codigo_ITM`=527 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `OpSave_ITM`) VALUES ('528', '106', '2', '2', 'Info Estadística', 'statistics.png', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `OpSave_ITM`) VALUES ('529', '106', '2', '2', 'Informes y Resoluciones', 'statistics.png', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('530', '106', '2', '2', 'Origen Población Actual', 'bubblechart.png', 'forms/nxsstatgeograph.php', '528', '0');
UPDATE `ititems` SET `Padre_ITM`='529' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='529' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='529' WHERE  `Codigo_ITM`=519 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;

ALTER TABLE `gxareas`
	ADD CONSTRAINT `FK_gxareas_czsedes` FOREIGN KEY (`Codigo_SDE`) REFERENCES `czsedes` (`Codigo_SDE`);
ALTER TABLE `itusuariosareas`
	ADD CONSTRAINT `FK_itusuariosareas_gxareas` FOREIGN KEY (`Codigo_ARE`) REFERENCES `gxareas` (`Codigo_ARE`) ON UPDATE CASCADE ON DELETE NO ACTION;
