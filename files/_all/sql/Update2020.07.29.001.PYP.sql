UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.08.10.000';
ALTER TABLE `gxservicios`
	CHANGE COLUMN `EdadMaxima_SER` `EdadMaxima_SER` INT(10) UNSIGNED NULL DEFAULT '43800' AFTER `EdadMinima_SER`;
UPDATE `itreports` SET `SQL_RPT`='SELECT c.Codigo_SER, c.Nombre_SER, sum(a.Cantidad_ORD), b.Nombre_TER, g.Nombre_SDE, e.Codigo_ADM, h.Nombre_TER\r\nFROM gxordenesdet a, czterceros b, gxservicios c, gxordenescab d, gxadmision e, czsedes g, czterceros h    \r\nWHERE  a.Codigo_TER= b.Codigo_TER AND a.Codigo_SER= c.Codigo_SER AND d.Codigo_ORD=a.Codigo_ORD AND h.Codigo_TER=e.Codigo_TER \r\nAND e.Codigo_ADM=d.Codigo_ADM AND g.Codigo_SDE=e.Codigo_SDE AND e.Estado_ADM<>\'A\' AND d.Estado_ORD<>\'0\' \r\nAND b.ID_TER >= \'@PROFESIONAL1\' AND b.ID_TER <=\'@PROFESIONAL2\' AND d.Fecha_ORD >=\'@FECHA_INICIAL\' AND d.Fecha_ORD <=\'@FECHA_FINAL 23:59:59\' \r\nGroup By g.Nombre_SDE, b.Nombre_TER, c.Codigo_SER, c.Nombre_SER, e.Codigo_ADM, h.Nombre_TER\r\nOrder By g.Nombre_SDE, b.Nombre_TER, h.Nombre_TER, c.Codigo_SER, c.Nombre_SER' WHERE  `Codigo_RPT`='servprofesional' AND `Codigo_DCD`=0;
CREATE TABLE `hcanalisis` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Analisis_HCA` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Analisis de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcanalisis`
	CHANGE COLUMN `Analisis_HCA` `Analisis_HCA` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('555', '100', '2', '2', 'Citas por Día', 'reports/citasxdia.php', '437', '0');
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=555 AND `Codigo_MNU`=100 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
ALTER TABLE `czsedes`
	ADD COLUMN `Direccion_SDE` VARCHAR(120) NULL DEFAULT NULL AFTER `Nombre_SDE`,
	ADD COLUMN `Telefonos_SDE` VARCHAR(120) NULL DEFAULT NULL AFTER `Direccion_SDE`;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('citasxdia', 'Citas por Dia', 'Agendamiento de citas entre @FECHA_INICIAL y @FECHA_FINAL ', 'Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS, u.ID_USR, c.FechaGraba_CIT\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT=\'P\' AND Estado_AGE=\'1\' \r\nAND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\' and e.ID_TER like \'%@MEDICO%\' Order By  5,2,3,6,1,7', 'L');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('citasxdia', 'FECHA_INICIAL', 'Fecha Inicial', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('citasxdia', 'FECHA_FINAL', 'Fecha Final', '3', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('citasxdia', 'VARFECHA', 'Tipo Fecha', '1', 'L');
INSERT INTO `itreportslistas` (`Codigo_RPT`, `Campo_RPT`, `Orden_RPT`, `Valor_RPT`, `Texto_RPT`, `Seleccionado_RPT`) VALUES ('citasxdia', 'VARFECHA', '1', 'c.Fecha_AGE', 'F. Programada', '1');
INSERT INTO `itreportslistas` (`Codigo_RPT`, `Campo_RPT`, `Orden_RPT`, `Valor_RPT`, `Texto_RPT`) VALUES ('citasxdia', 'VARFECHA', '2', 'c.FechaGraba_CIT', 'F. Registro');
UPDATE `itreports` SET `SQL_RPT`='Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS, u.ID_USR, c.FechaGraba_CIT\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT=\'P\' AND Estado_AGE=\'1\' \r\nAND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=311 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=313 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=363 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=380 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=412 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=413 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=414 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=467 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=478 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
