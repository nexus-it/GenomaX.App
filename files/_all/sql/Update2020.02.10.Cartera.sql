UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.02.20.002';
UPDATE `ititems` SET `Nombre_ITM`='Res. 0256 de 2016' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Res. 1552 de 2013' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('519', '106', '2', '2', 'Res. 0256 de 2016 (x Fechas)', 'document_redirect.png', 'forms/res256_2.php', '0');
UPDATE gxpacientes a SET a.Nombre1_PAC=TRIM(a.Nombre1_PAC), a.Nombre2_PAC=TRIM(a.Nombre2_PAC), a.Apellido1_PAC=TRIM(a.Apellido1_PAC), a.Apellido2_PAC=TRIM(a.Apellido2_PAC);
UPDATE `czcarteraedades` SET `Color_EDA`='#F4D24A' WHERE  `Codigo_EDA`=60;
ALTER TABLE `itreports`
	CHANGE COLUMN `Subtitle_RPT` `Subtitle_RPT` VARCHAR(255) NULL DEFAULT ' ' AFTER `Descripcion_RPT`;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('carteraxedades', 'Cartera por Edades', 'SELECT h.Codigo_EDA, h.Nombre_EDA, count(a.Codigo_FAC), sum(Saldo_CAR) FROM czcartera a, czcarteraedades h WHERE  (DATEDIFF(NOW(), a.Fecha_CAR) BETWEEN h.Minimo_EDA AND h.Maximo_EDA) AND  a.Saldo_CAR>0  GROUP BY h.Nombre_EDA, h.Codigo_EDA Order BY h.Codigo_EDA');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('520', '59', '1', '2', 'Cartera por Edades', 'reports/carteraxedades.php', '0');
UPDATE `ititems` SET `Nombre_ITM`='Cartera' WHERE  `Codigo_ITM`=409 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('521', '44', '1', '2', 'Cartera por Edades', 'forms/carteraedades.php', '409', '0');
UPDATE `ititems` SET `Icono_ITM`='time_go.png' WHERE  `Codigo_ITM`=521 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
