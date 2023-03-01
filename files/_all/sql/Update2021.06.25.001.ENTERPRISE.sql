-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.07.25.001' ;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`) VALUES ('593', '50', '2', '2', 'Facturado x Periodo Detalle (Servicios)', 'databse_table.png');
UPDATE `ititems` SET `Enlace_ITM`='reports/listarfactfechadetserv.php', `Padre_ITM`='487', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=593 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('listarfactfechadetserv', 'FECHA_FINAL', 'Fecha Final', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('listarfactfechadetserv', 'FECHA_INICIAL', 'Fecha Inicial', '1', 'D');
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=593 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `itreports` SET `SQL_RPT`='\r\nSelect  D.Codigo_FAC as \'Factura\', D.Fecha_FAC as \'Fecha Factura\',concat(Month_FAC,\' \',Year_FAC) as \'Periodo\', LPAD(A.Codigo_ADM,10,\'0\') as \'Ingreso\', concat(Q.Sigla_TID,\' \',C.ID_TER) as \'ID Paciente\', left(C.Nombre_TER, 60) as \'Paciente\', \r\n J.Descripcion_ADM as \'Descripcion\', F.Nombre_TER as \'Entidad\', E.Nombre_EPS as \'Contrato\', concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR) as \'Usuario Admisiona\', D.ValPaciente_FAC as \'Val Paciente\', D.ValEntidad_FAC as \'Val Entidad\', K.Codigo_RAD as \'No. Radicado\',  L.FechaConf_RAD as \'Fec Radicado\', D.ValCredito_FAC as \'Val Crédito\', D.ValTotal_FAC as \'Total\', M.Codigo_ORD AS \'Orden Servicio\', N.Codigo_SER AS \'Cod. Serv.\', O.Nombre_SER AS \'Servicio\', N.Cantidad_ORD AS \'Cant.\', N.ValorServicio_ORD AS \'Valor\'\r\nFrom  czterceros AS C, gxeps AS E, czterceros AS F, cztipoid as Q,  itusuarios AS I, gxtipoingreso AS J,\r\n gxordenescab M, gxordenesdet N, gxservicios O,\r\n gxadmision AS A, gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere A.Codigo_TER = C.Codigo_TER AND Q.Codigo_TID = C.Codigo_TID and D.Codigo_ADM=A.Codigo_ADM \r\n AND M.Codigo_ADM=A.Codigo_ADM AND M.Codigo_ORD=N.Codigo_ORD AND M.Estado_ORD=\'1\' AND O.Codigo_SER=N.Codigo_SER\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR AND J.Tipo_ADM = A.Ingreso_ADM and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\n \r\n Union\r\n \r\nSelect \r\n D.Codigo_FAC, DATE_FORMAT(D.Fecha_FAC, \'%d/%m/%Y\'),concat(Month_FAC,\' \',Year_FAC) ,\'CAPITA\', \'0\', \'POBLACION CAPITADA\', \r\n \'FACTURA CAPITADA\', F.Nombre_TER, concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR), D.ValPaciente_FAC, D.ValEntidad_FAC, E.Nombre_EPS, K.Codigo_RAD,  DATE_FORMAT(L.FechaConf_RAD, \'%d/%m/%Y\'), D.ValCredito_FAC, D.ValTotal_FAC, \r\n \' - - \', \'CPTD\', G.Servicio_FAC, G.Cantidad_FAC , G.ValTotal_FAC \r\nFrom\r\n gxeps AS E, czterceros AS F, \r\n itusuarios AS I,  gxfacturascapita AS G,\r\n  gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere\r\n D.Codigo_FAC=G.Codigo_FAC\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\nOrder By\r\n2,1;' WHERE  `Codigo_RPT`='listarfactfechadetserv' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, t.Codigo_FAC, u.Nombre_EPS, s.Nombre_PLA, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) as \'PERIODO\', i.ValorServicio_ORD, (sum(i.Cantidad_ORD)*i.ValorServicio_ORD), m.Nombre_PTT \r\nFrom gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j, gxpacientestipos m, gxplanes s, gxadmision a,  gxfacturas t, gxeps u \r\nWhere s.Codigo_PLA=a.Codigo_PLA and t.Codigo_ADM=a.Codigo_ADM and a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and m.Codigo_PTT=a.Codigo_PTT and Estado_ADM<>\'A\'  \r\nAND u.Codigo_EPS=t.Codigo_EPS and j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN AND  t.Fecha_FAC>=\'@FECHA_INICIAL\' AND t.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\' \r\nGroup by f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) \r\nOrder by 6, 7, 8' WHERE  `Codigo_RPT`='listarfactfechadetserv' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, t.Codigo_FAC, u.Nombre_EPS, s.Nombre_PLA, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) as \'PERIODO\', i.ValorServicio_ORD, (sum(i.Cantidad_ORD)*i.ValorServicio_ORD), m.Nombre_PTT \r\nFrom gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j, gxpacientestipos m, gxplanes s, gxadmision a,  gxfacturas t, gxeps u \r\nWhere s.Codigo_PLA=a.Codigo_PLA and t.Codigo_ADM=a.Codigo_ADM and a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and m.Codigo_PTT=a.Codigo_PTT and Estado_ADM<>\'A\'  \r\nAND u.Codigo_EPS=t.Codigo_EPS and j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN AND  t.Fecha_FAC>=\'@FECHA_INICIAL\' AND t.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\' \r\nGroup by a.Codigo_ADM, t.Codigo_FAC, u.Nombre_EPS, s.Nombre_PLA, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) \r\nOrder by 6, 7, 8' WHERE  `Codigo_RPT`='listarfactfechadetserv' AND `Codigo_DCD`=0;
INSERT INTO `gxespecialidades` (`Codigo_ESP`, `Nombre_ESP`) VALUES ('500', 'TRABAJO SOCIAL');
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=411 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `itreports` SET `SQL_RPT`='Select\r\n K.Codigo_RAD as \'Remisión\',  DATE_FORMAT(L.FechaConf_RAD, \'%d/%m/%Y\') as \'Fecha\', D.Codigo_FAC as \'Factura\', DATE_FORMAT(D.Fecha_FAC, \'%d/%m/%Y\') as \'F. Factura\',LPAD(A.Codigo_ADM,10,\'0\') as \'Admision\', concat(Q.Sigla_TID,\' \',C.ID_TER) as \'ID Pcte\', left(C.Nombre_TER, 60) as \'Paciente\', \r\n J.Descripcion_ADM as \'Descripción\', E.Codigo_EPS as \'Codigo Ent.\', F.Nombre_TER as \'Entidad\', concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR) as \'Usuario\', D.ValPaciente_FAC as \'Val Pcte.\', D.ValEntidad_FAC as \'Val Ent.\', D.ValCredito_FAC as \'Notas Crédito\', (D.ValPaciente_FAC+ D.ValEntidad_FAC - D.ValCredito_FAC) as \'Val Total\' \r\nFrom\r\n czterceros AS C, gxeps AS E, czterceros AS F, cztipoid as Q, \r\n itusuarios AS I, gxtipoingreso AS J, gxadmision AS A, gxfacturas AS D,\r\n czradicacionesdet AS K, czradicacionescab AS L \r\nWhere\r\n L.Codigo_RAD=K.Codigo_RAD and D.Codigo_FAC=K.Codigo_FAC and A.Codigo_TER = C.Codigo_TER \r\n AND Q.Codigo_TID = C.Codigo_TID and D.Codigo_ADM=A.Codigo_ADM\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR AND J.Tipo_ADM = A.Ingreso_ADM and D.Estado_FAC=\'1\'\r\n AND L.Estado_RAD=\'2\'\r\n AND L.FechaConf_RAD>=\'@FECHA_INICIAL 00:00:00\' AND L.FechaConf_RAD<=\'@FECHA_FINAL 23:59:59\'\r\nOrder By\r\nL.Codigo_RAD, L.FechaConf_RAD, D.Codigo_FAC' WHERE  `Codigo_RPT`='radicadofecha' AND `Codigo_DCD`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('594', '91', '2', '2', 'HC x Periodo', 'database_table.png', 'reports/hcxfechas.php', '493', '1', '1', '1');
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('hcxfechas', 'Listado de Pacientes  con HC en un rango de fechas', NULL, '', 'L');
UPDATE `itreports` SET `Subtitle_RPT`='Informe entre @FECHA_INICIAL y @FECHA_FINAL ', `SQL_RPT`='SELECT a.Fecha_HCF AS \'Fecha HC\', b.Codigo_ADM AS \'Ingreso\', c.ID_TER AS \'Historia\', c.Nombre_TER AS \'Paciente\', d.Nombre_EPS AS \'Contrato\', e.Nombre_PLA AS \'Plan\', f.Nombre_HCT AS \'Tipo HC\', h.Nombre_TER AS \'Profesional\', i.Nombre_SDE AS \'Sede\'\r\nFROM hcfolios a, gxadmision b, czterceros c, gxeps d, gxplanes e, hctipos f, gxmedicos g, czterceros h, czsedes i\r\nWHERE a.Codigo_ADM=b.Codigo_ADM AND c.Codigo_TER=a.Codigo_TER AND d.Codigo_EPS=b.Codigo_EPS AND e.Codigo_PLA=b.Codigo_PLA AND g.Codigo_USR=a.Codigo_USR AND h.Codigo_TER=g.Codigo_TER AND b.Codigo_SDE=i.Codigo_SDE\r\nAND a.Fecha_HCF>=\'@FECHA_INICIAL\' AND a.Fecha_HCF<=\'@FECHA_FINAL 23:59:59\' ' WHERE  `Codigo_RPT`='hcxfechas' AND `Codigo_DCD`=0;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcxfechas', 'FECHA_INICIAL', 'Fecha Inicial', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcxfechas', 'FECHA_FINAL', 'Fecha Final', '3', 'D');
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Fecha_HCF AS \'Fecha HC\', b.Codigo_ADM AS \'Ingreso\', c.ID_TER AS \'Historia\', c.Nombre_TER AS \'Paciente\', d.Nombre_EPS AS \'Contrato\', e.Nombre_PLA AS \'Plan\', f.Nombre_HCT AS \'Tipo HC\', h.Nombre_TER AS \'Profesional\', i.Nombre_SDE AS \'Sede\'\r\nFROM hcfolios a, gxadmision b, czterceros c, gxeps d, gxplanes e, hctipos f, gxmedicos g, czterceros h, czsedes i\r\nWHERE a.Codigo_ADM=b.Codigo_ADM AND c.Codigo_TER=a.Codigo_TER AND f.Codigo_HCT=a.Codigo_HCT AND d.Codigo_EPS=b.Codigo_EPS AND e.Codigo_PLA=b.Codigo_PLA AND g.Codigo_USR=a.Codigo_USR AND h.Codigo_TER=g.Codigo_TER AND b.Codigo_SDE=i.Codigo_SDE\r\nAND a.Fecha_HCF>=\'@FECHA_INICIAL\' AND a.Fecha_HCF<=\'@FECHA_FINAL 23:59:59\' ' WHERE  `Codigo_RPT`='hcxfechas' AND `Codigo_DCD`=0;
