UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.08.18.000';
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('560', '100', '2', '2', 'Citas por Paciente', 'database_table.png', 'reports/citasxpcte.php', '437', '0');
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('citasxpcte', 'Citas por Paciente', 'Agendamiento de la Historia Clinica No. @PACIENTE', 'SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7', 'L');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Search_RPT`) VALUES ('citasxpcte', 'PACIENTE', 'HC No.', '1', 'FacturasPre');
UPDATE `itreportsparam` SET `Search_RPT`='Paciente' WHERE  `Codigo_RPT`='citasxpcte' AND `Campo_RPT`='PACIENTE' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\',  AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\nAND d.ID_TER=\'@PACIENTE\' AND  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxpcte' AND `Codigo_DCD`=0;
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-01-06');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-03-23');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-04-09');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-04-10');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-05-01');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-05-25');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-06-15');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-06-22');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-06-29');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-07-20');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-08-07');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-08-17');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-10-12');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-11-02');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-11-16');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-12-08');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-12-25');
ALTER TABLE `czsedes`
	ADD COLUMN `Ciudad_SDE` VARCHAR(120) NULL DEFAULT NULL AFTER `Telefonos_SDE`;
UPDATE czsedes a, itconfig b SET a.Direccion_SDE=b.Direccion_DCD, a.Telefonos_SDE=b.Telefonos_DCD, a.Ciudad_SDE=b.Ciudad_DCD;
UPDATE `itreports` SET `SQL_RPT`='select a.Razonsocial_DCD, a.NIT_DCD, f.direccion_SDE, f.Telefonos_SDE, e.Logo2_HCH, b.Nombre_HCT\r\nFrom\r\n itconfig a, hctipos b, hcfolios c, czterceros d, hcencabezadosdet e, czsedes f, gxareas g\r\nWhere f.Codigo_SDE=g.Codigo_SDE and g.Codigo_ARE=c.Codigo_ARE and\r\n c.Codigo_TER=d.Codigo_TER and c.Codigo_HCT=b.Codigo_HCT and b.Codigo_HCH=e.Codigo_HCH\r\n and d.ID_TER=\'@HISTORIA\' and Folio_HCF>=\'@FOLIO_INICIAL\' and Folio_HCF<=\'@FOLIO_FINAL\'' WHERE  `Codigo_RPT`='hc' AND `Codigo_DCD`=0;
