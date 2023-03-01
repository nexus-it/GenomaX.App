UPDATE `itconfig` SET `Version_DCD`='17.11.18.001';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptNew_ITM`) VALUES ('428', '71', '8', '2', 'Cajas', 'money_bag.png', 'forms/cajaconf.php', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('429', '71', '8', '2', 'Tipos Movimientos Caja', 'money_bag.png', 'forms/cajatipomov.php');
UPDATE `ititems` SET `Icono_ITM`='safe.png' WHERE  `Codigo_ITM`=428 AND `Codigo_MNU`=71 AND `Codigo_MOD`=8 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('430', '71', '8', '2', 'Usuarios x Caja', 'attribution.png', 'forms/cajausuarios.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptNew_ITM`) VALUES ('431', '51', '3', '2', 'Edición Ingresos Facturados', 'document_editing.png', 'forms/facturaedit.php', '1');
ALTER TABLE `itconfig_fc`	ADD COLUMN `PeriodoActual` CHAR(7) NULL DEFAULT '0' COMMENT 'MM.YYYY' AFTER `CierreDias_XFC`;
INSERT INTO `itconfig_fc` (`CierreDias_XFC`, `PeriodoActual`) VALUES ('3', '11.2017');
