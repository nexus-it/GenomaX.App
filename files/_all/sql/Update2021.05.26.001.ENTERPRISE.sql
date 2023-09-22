-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.06.20.001' ;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Tipo_OGS`, `Estado_OGS`) VALUES ('50', 'EXODONCIA', 'A', '1');
INSERT INTO `itusuarios` (`Codigo_USR`, `ID_USR`, `Nombre_USR`, `Codigo_PRF`, `Email_USR`, `FechaCreacion_USR`) VALUES ('NX1', 'NICKYZ', 'NICOLL ZAMBRANO', '0', 'nicoll.zambrano@nexus-it.co', NOW());
UPDATE `itusuarios` SET `Clave_USR`='d21555745f88dc32e3a9f2f92502b2727a9ab31d' WHERE  `Codigo_USR`='1' AND `ID_USR`='NEXUS';
UPDATE `itusuarios` SET `Clave_USR`='d21555745f88dc32e3a9f2f92502b2727a9ab31d' WHERE  `Codigo_USR`='NX1' AND `ID_USR`='NICKYZ';
ALTER TABLE `gxmedicos`
	COMMENT='Profesionales de la Salud';
ALTER TABLE `itconfig_ct`
	ADD COLUMN `SaldosIni_XCT` CHAR(6) NULL DEFAULT '' COMMENT 'Documento Saldos Iniciales' AFTER `Codigo_FNC`;
UPDATE `itconfig_ct` SET `SaldosIni_XCT`='INI';
ALTER TABLE `itconfig_ct`
	CHANGE COLUMN `InterfazFC_XCT` `InterfazFC_XCT` CHAR(1) NULL DEFAULT '' COMMENT 'Interfaz Facturacion' COLLATE 'utf8_general_ci' AFTER `SaldosIni_XCT`;
ALTER TABLE `itconfig_ct`
	CHANGE COLUMN `CtaDeficit_XCT` `CtaDeficit_XCT` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta de Deficit' COLLATE 'utf8_general_ci' FIRST,
	CHANGE COLUMN `CtaSuperavit_XCT` `CtaSuperavit_XCT` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta de Superavit' COLLATE 'utf8_general_ci' AFTER `CtaDeficit_XCT`,
	CHANGE COLUMN `CtaGanancias_XCT` `CtaGanancias_XCT` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta de Ganancias' COLLATE 'utf8_general_ci' AFTER `CtaSuperavit_XCT`,
	CHANGE COLUMN `CtCierre_XCT` `CtCierre_XCT` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Comprobante de Cierre' COLLATE 'utf8_general_ci' AFTER `CtaGanancias_XCT`;
UPDATE `itconfig_ct` SET `Codigo_FNC`='NCT';
ALTER TABLE `czterceros`
	ADD COLUMN `CxC_TER` VARCHAR(10) NULL DEFAULT '' AFTER `IDAnterior_TER`,
	ADD COLUMN `CxP_TER` VARCHAR(10) NULL DEFAULT '' AFTER `CxC_TER`,
	ADD COLUMN `RegimenSimple_TER` CHAR(1) NULL DEFAULT '0' AFTER `CxP_TER`,
	ADD COLUMN `GranContribuyente_TER` CHAR(1) NULL DEFAULT '0' AFTER `RegimenSimple_TER`,
	ADD COLUMN `Autorretenedor_TER` CHAR(1) NULL DEFAULT '0' AFTER `GranContribuyente_TER`,
	ADD COLUMN `RetVentas_TER` CHAR(1) NULL DEFAULT '0' AFTER `Autorretenedor_TER`,
	ADD COLUMN `PersonaNatural_TER` CHAR(1) NULL DEFAULT '1' AFTER `RetVentas_TER`;
ALTER TABLE `czterceros`
	ADD COLUMN `Cliente_TER` CHAR(1) NULL DEFAULT '0' AFTER `PersonaNatural_TER`,
	ADD COLUMN `Proveedor_TER` CHAR(1) NULL DEFAULT '0' AFTER `Cliente_TER`,
	ADD INDEX `Proveedor_TER` (`Proveedor_TER`),
	ADD INDEX `Cliente_TER` (`Cliente_TER`);
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('ctterceros', 'Reporte de Terceros', 'SELECT a.Nombre_TER, CONCAT(b.Sigla_TID,\' \',a.ID_TER), a.Direccion_TER, a.Telefono_TER, a.Correo_TER, a.Web_TER, c.Nombre_RGN, a.Cliente_TER, a.Proveedor_TER, case a.PersonaNatural_TER when \'1\' then \'NATURAL\' ELSE \'JURIDICA\' END, a.Codigo_TER FROM czterceros a, cztipoid b, czregimenes c WHERE a.Codigo_TID=b.Codigo_TID AND a.Codigo_RGN=c.Codigo_RGN ');
CREATE TABLE `ittables` (
	`NameShow_TBL` VARCHAR(50) NULL DEFAULT NULL,
	`NameSystem_TBL` VARCHAR(50) NOT NULL,
	`Show_TBL` CHAR(1) NULL DEFAULT '1',
	INDEX `Show_TBL` (`Show_TBL`),
	PRIMARY KEY (`NameSystem_TBL`)
)
COMMENT='Tablas que se pueden mostrar a los usuarios administradores'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `czterceros`
	CHANGE COLUMN `RegimenSimple_TER` `Codigo_PAI` CHAR(4) NULL COLLATE 'utf8_general_ci' AFTER `CxP_TER`,
	CHANGE COLUMN `GranContribuyente_TER` `Codigo_DEP` VARCHAR(2) NULL COLLATE 'utf8_general_ci' AFTER `Codigo_PAI`,
	CHANGE COLUMN `Autorretenedor_TER` `Codigo_MUN` VARCHAR(3) NULL COLLATE 'utf8_general_ci' AFTER `Codigo_DEP`;
UPDATE `itreports` SET `SQL_RPT`='Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, \n b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, \'\', c.Fecha_FAC, c.ValPaciente_FAC, \n c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, CONCAT(e.ID_TER,\'-\',e.DigitoVerif_TER), e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, \n \'\', \' * * * * * \', \'POBLACION CAPITADA - PTES. VARIOS\', i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), d.Contrato_EPS, a.Ciudad_DCD, \'Direccion\', \'Telefono\', \'Barrio\', \'mun\', \'dx\', \'ndx\', Prefijo_AFC, ValCredito_FAC, f.fechaini_fac, f.FechaFin_fac  \nFrom itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxfacturascapita f, gxplanes i\nWhere c.Codigo_AFC = b.Codigo_AFC and  d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_FAC =c.Codigo_FAC \n and i.Codigo_PLA= c.Codigo_PLA and c.Codigo_FAC>=Concat(\'@PREFIJO\',b.Separador_AFC,trim(LPAD(\'@CODIGO_INICIAL\',10,b.Ceros_AFC))) and c.Codigo_FAC<=Concat(\'@PREFIJO\',b.Separador_AFC,trim(LPAD(\'@CODIGO_FINAL\',10,b.Ceros_AFC))) ;' WHERE  `Codigo_RPT`='facturasaludcapita' AND `Codigo_DCD`=0;
ALTER TABLE `hctipos`
	ADD COLUMN `MedQuimio_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Registro Medicamentos Quimioterapia' AFTER `Insumos_HCT`;
ALTER TABLE `czterceros`
	ADD COLUMN `Contacto_TER` VARCHAR(200) NULL DEFAULT NULL AFTER `Correo_TER`,
	ADD COLUMN `RepLegal_TER` VARCHAR(200) NULL DEFAULT NULL AFTER `Contacto_TER`;
ALTER TABLE `czterceros`
	CHANGE COLUMN `Codigo_DEP` `Codigot_DEP` VARCHAR(2) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_PAI`,
	CHANGE COLUMN `Codigo_MUN` `Codigot_MUN` VARCHAR(3) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigot_DEP`;
UPDATE `gxdiagnostico` SET `Descripcion_DGN`='EFECTOS ADVERSOS DE DIURETICOS DE ASA [HIGH-CEILING]' WHERE  `Codigo_DGN`='Y544';
UPDATE `gxdiagnostico` SET `Descripcion_DGN`='ESPONDILOPATIA INTERESPINOSA (VERTEBRAS EN BESO)' WHERE  `Codigo_DGN`='M482';
UPDATE `itreports` SET `SQL_RPT`='Select  D.Codigo_FAC as \'Factura\', D.Fecha_FAC as \'Fecha Factura\',concat(Month_FAC,\' \',Year_FAC) as \'Periodo\', LPAD(A.Codigo_ADM,10,\'0\') as \'Ingreso\', concat(Q.Sigla_TID,\' \',C.ID_TER) as \'ID Paciente\', left(C.Nombre_TER, 60) as \'Paciente\', \r\n J.Descripcion_ADM as \'Descripcion\', F.Nombre_TER as \'Entidad\', E.Nombre_EPS as \'Contrato\', concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR) as \'Usuario Admisiona\', D.ValPaciente_FAC as \'Val Paciente\', D.ValEntidad_FAC as \'Val Entidad\', K.Codigo_RAD as \'No. Radicado\',  L.FechaConf_RAD as \'Fec Radicado\', D.ValCredito_FAC as \'Val Crédito\', D.ValTotal_FAC as \'Total\' \r\nFrom  czterceros AS C, gxeps AS E, czterceros AS F, cztipoid as Q,  itusuarios AS I, gxtipoingreso AS J, gxadmision AS A, gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere A.Codigo_TER = C.Codigo_TER AND Q.Codigo_TID = C.Codigo_TID and D.Codigo_ADM=A.Codigo_ADM\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR AND J.Tipo_ADM = A.Ingreso_ADM and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\n \r\n Union\r\n \r\nSelect \r\n D.Codigo_FAC, DATE_FORMAT(D.Fecha_FAC, \'%d/%m/%Y\'),concat(Month_FAC,\' \',Year_FAC) ,\'CAPITA\', \'0\', \'POBLACION CAPITADA\', \r\n \'FACTURA CAPITADA\', F.Nombre_TER, concat(\'{\',I.Codigo_USR,\'} \', I.ID_USR), D.ValPaciente_FAC, D.ValEntidad_FAC, E.Nombre_EPS, K.Codigo_RAD,  DATE_FORMAT(L.FechaConf_RAD, \'%d/%m/%Y\'), D.ValCredito_FAC, D.ValTotal_FAC \r\nFrom\r\n gxeps AS E, czterceros AS F, \r\n itusuarios AS I,  gxfacturascapita AS G, gxfacturas AS D \r\n left join czradicacionesdet AS K On D.Codigo_FAC=K.Codigo_FAC left join czradicacionescab AS L On L.Codigo_RAD=K.Codigo_RAD\r\nWhere\r\n D.Codigo_FAC=G.Codigo_FAC\r\n AND F.Codigo_TER = E.Codigo_TER AND trim(D.Codigo_EPS) = trim(E.Codigo_EPS) \r\n AND D.Codigo_USR = I.Codigo_USR and D.Estado_FAC=\'1\'\r\n AND D.Fecha_FAC>=\'@FECHA_INICIAL 00:00:00\' AND D.Fecha_FAC<=\'@FECHA_FINAL 23:59:59\'\r\nOrder By\r\n2,1;' WHERE  `Codigo_RPT`='listarfacturasfecha' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT f.Nombre_SDE, a.Codigo_SER, a.Nombre_SER, sum(c.Cantidad_ORD), sum(c.Cantidad_ORD * c.ValorServicio_ORD)\r\nFrom gxservicios a, gxordenescab b, gxordenesdet c, gxfacturas d, gxadmision e, czsedes f\r\nWhere b.Codigo_ORD=c.Codigo_ORD and c.Codigo_SER=a.Codigo_SER and d.Codigo_ADM=b.Codigo_ADM AND f.Codigo_SDE=e.Codigo_SDE\r\nand a.Codigo_CFC not in (\'09\', \'12\', \'13\') and b.Estado_ORD=\'1\' and d.Estado_FAC=\'1\' AND e.Codigo_ADM=b.Codigo_ADM\r\nand b.Fecha_ORD between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'\r\nGroup By f.Nombre_SDE, a.Codigo_SER, a.Nombre_SER' WHERE  `Codigo_RPT`='servprestadosperiodo' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT f.Nombre_SDE AS \'SEDE\', g.Nombre_EPS AS \'CONTRATO\', CONCAT(d.Month_FAC,\' \',d.Year_FAC) AS \'PERIODO\', a.Codigo_SER AS \'COD.\', a.Nombre_SER AS \'NOMBRE SERVICIO\', sum(c.Cantidad_ORD) AS \'CANT\', sum(c.Cantidad_ORD * c.ValorServicio_ORD) AS \'VALOR\' \r\nFrom gxservicios a, gxordenescab b, gxordenesdet c, gxfacturas d, gxadmision e, czsedes f, gxeps g \r\nWhere b.Codigo_ORD=c.Codigo_ORD and c.Codigo_SER=a.Codigo_SER and d.Codigo_ADM=b.Codigo_ADM AND f.Codigo_SDE=e.Codigo_SDE \r\nand a.Codigo_CFC not in (\'09\', \'12\', \'13\') and b.Estado_ORD=\'1\' and d.Estado_FAC=\'1\' AND e.Codigo_ADM=b.Codigo_ADM AND g.Codigo_EPS=c.Codigo_EPS \r\nand b.Fecha_ORD between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\' \r\nGroup By f.Nombre_SDE, g.Nombre_EPS, CONCAT(d.Month_FAC,\' \',d.Year_FAC), a.Codigo_SER, a.Nombre_SER' WHERE  `Codigo_RPT`='servprestadosperiodo' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT f.Nombre_SDE AS \'SEDE\', g.Nombre_EPS AS \'CONTRATO\', CONCAT(d.Month_FAC,\' \',d.Year_FAC) AS \'PERIODO\', a.Codigo_SER AS \'COD.\', a.Nombre_SER AS \'NOMBRE SERVICIO\', sum(c.Cantidad_ORD) AS \'CANT\', sum(c.Cantidad_ORD * c.ValorServicio_ORD) AS \'VALOR\' \r\nFrom gxservicios a, gxordenescab b, gxordenesdet c, gxfacturas d, gxadmision e, czsedes f, gxeps g \r\nWhere b.Codigo_ORD=c.Codigo_ORD and c.Codigo_SER=a.Codigo_SER and d.Codigo_ADM=b.Codigo_ADM AND f.Codigo_SDE=e.Codigo_SDE \r\nand b.Estado_ORD=\'1\' and d.Estado_FAC=\'1\' AND e.Codigo_ADM=b.Codigo_ADM AND g.Codigo_EPS=c.Codigo_EPS \r\nand b.Fecha_ORD between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\' \r\nGroup By f.Nombre_SDE, g.Nombre_EPS, CONCAT(d.Month_FAC,\' \',d.Year_FAC), a.Codigo_SER, a.Nombre_SER' WHERE  `Codigo_RPT`='servprestadosperiodo' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, t.Codigo_FAC, s.Nombre_PLA, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) as \'PERIODO\', i.ValorServicio_ORD, (sum(i.Cantidad_ORD)*i.ValorServicio_ORD), m.Nombre_PTT \r\nFrom gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j, gxpacientestipos m, gxplanes s, gxadmision a left join gxfacturas t on t.Codigo_ADM=a.Codigo_ADM  \r\nWhere s.Codigo_PLA=a.Codigo_PLA and a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and m.Codigo_PTT=a.Codigo_PTT and Estado_ADM<>\'A\'  \r\nand j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN and  a.Fecha_ADM>=\'@FECHA_INICIAL\' and a.Fecha_ADM<=\'@FECHA_FINAL 23:59:59\' and a.Codigo_EPS=\'@ENTIDAD\'\r\nGroup by f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm, concat(t.Month_FAC,\' \', t.Year_FAC) \r\nOrder by 6, 7, 8' WHERE  `Codigo_RPT`='autorizaciones' AND `Codigo_DCD`=0;
ALTER TABLE `gxeps`
	CHANGE COLUMN `PhoneContact_EPS` `PhoneContact_EPS` VARCHAR(12) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `LastnameContact_EPS`,
	CHANGE COLUMN `CellContact_EPS` `CellContact_EPS` VARCHAR(12) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `PhoneContact_EPS`;
UPDATE `itreportsparam` SET `Search_RPT`='PrefFacturas' WHERE  `Codigo_RPT`='facturasaluddet' AND `Campo_RPT`='PREFIJO' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='PrefFacturas' WHERE  `Codigo_RPT`='facturasalud' AND `Campo_RPT`='PREFIJO' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='PrefFacturas' WHERE  `Codigo_RPT`='facturasaludcapita' AND `Campo_RPT`='PREFIJO' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='PrefFacturas' WHERE  `Codigo_RPT`='anexofacturasalud' AND `Campo_RPT`='PREFIJO' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='autorizaciones' AND `Campo_RPT`='ENTIDAD' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='altocosto' AND `Campo_RPT`='ENTIDAD' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='listarfacturasentidad' AND `Campo_RPT`='CONTRATO' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='pacientesatendidosxfechaxentidad' AND `Campo_RPT`='ENTIDAD' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='servicioscargadosfecha' AND `Campo_RPT`='ENTIDAD' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Contrato' WHERE  `Codigo_RPT`='servicioscargadosfechadetalle' AND `Campo_RPT`='ENTIDAD' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Search_RPT`='Paciente' WHERE  `Codigo_RPT`='admxpcte' AND `Campo_RPT`='PACIENTE' AND `Codigo_DCD`=0;
