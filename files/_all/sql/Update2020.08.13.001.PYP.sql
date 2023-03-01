UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.08.12.005';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('558', '100', '2', '2', 'Ordenes de Servicio', 'database_table.png', 'reports/hcordserv.php', '437', '0');
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('hcordserv', 'Ordenes de Servicio', 'Ordenes realizadas entre @FECHA_INICIAL y @FECHA_FINAL ', 'SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\',\r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Confirma_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\',\r\n v.TipoSer_HCS AS \'ORDENAMIENTO\', v.Cantidad_HCS AS \'CANTIDAD\', v.Observaciones_HCS AS \'OBSERVACIONES\' \r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, \r\ngxareas g, gxeps i, cztipoid j, hcfolios t, hcordenesservicios v\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID \r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE  and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\nAND t.Codigo_TER=v.Codigo_TER AND t.Codigo_HCF=v.Codigo_HCF AND c.Codigo_TER=t.Codigo_TER AND DATE(c.Fecha_AGE)=DATE(t.Fecha_HCF)\r\n AND t.Fecha_HCF  BETWEEN  \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7', 'L');
ALTER TABLE `czempleados`
	CHANGE COLUMN `FechaNac_EMP` `FechaNac_EMP` DATE NULL DEFAULT '0000-00-00' AFTER `Apellido2_EMP`,
	CHANGE COLUMN `Barrio_EMP` `Barrio_EMP` VARCHAR(60) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_MUN`,
	CHANGE COLUMN `SalarioAct_EMP` `SalarioAct_EMP` DECIMAL(10,2) NULL DEFAULT '0' AFTER `Codigo_SDE`,
	CHANGE COLUMN `FechaIng_EMP` `FechaIng_EMP` DATE NULL DEFAULT '0000-00-00' AFTER `SalarioAnt_EMP`;
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\',\r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Confirma_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\',\r\n s.CUPS_PRC AS \'CUPS\', s.Nombre_PRC AS \'EXAMEN\', v.Cantidad_HCS AS \'CANTIDAD\', v.Observaciones_HCS AS \'OBSERVACIONES\' \r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, \r\ngxareas g, gxeps i, cztipoid j, hcfolios t, hcordenesdx v, gxprocedimientos s\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID \r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE  and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' AND s.Codigo_SER=v.Codigo_SER\r\nAND t.Codigo_TER=v.Codigo_TER AND t.Codigo_HCF=v.Codigo_HCF AND c.Codigo_TER=t.Codigo_TER AND DATE(c.Fecha_AGE)=DATE(t.Fecha_HCF)\r\n AND t.Fecha_HCF  BETWEEN  \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='hcorddx' AND `Codigo_DCD`=0;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcordserv', 'FECHA_FINAL', 'Fecha Final', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcordserv', 'FECHA_INICIAL', 'Fecha Inicial', '1', 'D');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('559', '100', '2', '2', 'Ordenes de Procedimientos', 'database_table.png', 'reports/hcordqx.php', '437', '0');
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('hcordqx', 'Ordenes de Procedimientos', 'Ordenes realizadas entre @FECHA_INICIAL y @FECHA_FINAL ', 'SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\',\r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Confirma_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\',\r\n s.CUPS_PRC AS \'CUPS\', s.Nombre_PRC AS \'EXAMEN\', v.Cantidad_HCS AS \'CANTIDAD\', v.Observaciones_HCS AS \'OBSERVACIONES\' \r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, \r\ngxareas g, gxeps i, cztipoid j, hcfolios t, hcordenesqx v, gxprocedimientos s\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID \r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE  and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' AND s.Codigo_SER=v.Codigo_SER\r\nAND t.Codigo_TER=v.Codigo_TER AND t.Codigo_HCF=v.Codigo_HCF AND c.Codigo_TER=t.Codigo_TER AND DATE(c.Fecha_AGE)=DATE(t.Fecha_HCF)\r\n AND t.Fecha_HCF  BETWEEN  \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7', 'L');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcordqx', 'FECHA_FINAL', 'Fecha Final', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcordqx', 'FECHA_INICIAL', 'Fecha Inicial', '1', 'D');



UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
