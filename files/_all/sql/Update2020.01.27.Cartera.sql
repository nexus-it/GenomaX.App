UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.27.002';
ALTER TABLE `itreports`
	ADD COLUMN `Subtitle_RPT` VARCHAR(255) NULL DEFAULT NULL AFTER `Descripcion_RPT`;
UPDATE `itreports` SET `Subtitle_RPT`='Ingresos entre @FECHA_INICIAL y @FECHA_FINAL ' WHERE  `Codigo_RPT`='autorizaciones' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `Subtitle_RPT`='Cierres realizado entre @FECHA_INICIAL y @FECHA_FINAL de la caja código @IDCAJA' WHERE  `Codigo_RPT`='cajascierre' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `Subtitle_RPT`='Agenda entre @FECHA_INICIAL y @FECHA_FINAL del profesional con ID No  @MEDICO' WHERE  `Codigo_RPT`='citasprogramadasx' AND `Codigo_DCD`=0;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('activxprofesional', 'Pacientes Atendidos por Profesional', 'SELECT c.Codigo_SER, c.Nombre_SER, sum(a.Cantidad_ORD), b.Nombre_TER, g.Nombre_SDE, e.Codigo_ADM, h.Nombre_TER\r\nFROM gxordenesdet a, czterceros b, gxservicios c, gxordenescab d, gxadmision e, czsedes g, czterceros h    \r\nWHERE  a.Codigo_TER= b.Codigo_TER AND a.Codigo_SER= c.Codigo_SER AND d.Codigo_ORD=a.Codigo_ORD AND h.Codigo_TER=e.Codigo_TER \r\nAND e.Codigo_ADM=d.Codigo_ADM AND g.Codigo_SDE=e.Codigo_SDE AND e.Estado_ADM<>\'A\' AND d.Estado_ORD<>\'0\' \r\nAND b.ID_TER >= \'@PROFESIONAL1\' AND b.ID_TER <=\'@PROFESIONAL2\' AND d.Fecha_ORD >=\'@FECHA_INICIAL\' AND d.Fecha_ORD <=\'@FECHA_FINAL\' \r\nGroup By g.Nombre_SDE, b.Nombre_TER, c.Codigo_SER, c.Nombre_SER, e.Codigo_ADM, h.Nombre_TER\r\nOrder By g.Nombre_SDE, b.Nombre_TER, h.Nombre_TER, c.Codigo_SER, c.Nombre_SER');
UPDATE `itreports` SET `Subtitle_RPT`='En el periodo comprendido entre @FECHA_INICIAL y @FECHA_FINAL ' WHERE  `Codigo_RPT`='activxprofesional' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT c.Codigo_HCT, c.Nombre_HCT, count(a.Codigo_HCF), b.Nombre_TER, g.Nombre_SDE, e.Codigo_ADM, h.Nombre_TER\r\nFROM hcfolios a, czterceros b, hctipos c, gxadmision e, czsedes g, czterceros h, gxmedicos i    \r\nWHERE  a.Codigo_TER= h.Codigo_TER AND a.Codigo_HCT= c.Codigo_HCT AND b.Codigo_TER=i.Codigo_TER AND i.Codigo_USR=a.Codigo_USR \r\nAND e.Codigo_ADM=a.Codigo_ADM AND g.Codigo_SDE=e.Codigo_SDE AND e.Estado_ADM<>\'A\'  \r\nAND b.ID_TER >= \'@PROFESIONAL1\' AND b.ID_TER <=\'@PROFESIONAL2\' AND a.Fecha_HCF >=\'@FECHA_INICIAL\' AND a.Fecha_HCF <=\'@FECHA_FINAL\' \r\nGroup By g.Nombre_SDE, b.Nombre_TER, c.Codigo_HCT, c.Nombre_HCT, e.Codigo_ADM, h.Nombre_TER\r\nOrder By g.Nombre_SDE, b.Nombre_TER, h.Nombre_TER, c.Codigo_HCT, c.Nombre_HCT' WHERE  `Codigo_RPT`='activxprofesional' AND `Codigo_DCD`=0;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('activxprofesional', 'FECHA_FINAL', 'Fecha Final', '4', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('activxprofesional', 'FECHA_INICIAL', 'Fecha Inicial', '3', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Value_RPT`, `Search_RPT`) VALUES ('activxprofesional', 'PROFESIONAL1', 'Desde (Documento)', '1', '$value=\'0\';', 'ProfesionalesSalud');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Value_RPT`, `Search_RPT`) VALUES ('activxprofesional', 'PROFESIONAL2', 'Hasta (Documento)', '2', '$value=\'ZZZZZZZZZZ\';', 'ProfesionalesSalud');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('516', '91', '2', '2', 'Atenciones x Profesional', 'reports/activxprofesional.php', '493', '1', '1', '1');
-------------------------------------------------------
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
