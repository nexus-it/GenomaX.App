UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]19.08.13.001';
UPDATE `itreports` SET `SQL_RPT`='Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, \n b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, c.Fecha_FAC, c.ValPaciente_FAC, \n c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, CONCAT(e.ID_TER,\'-\',e.DigitoVerif_TER), e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, \n LPAD(f.Codigo_ADM,10,\'0\'), CONCAT(h.Sigla_TID,\' \', g.ID_TER), g.Nombre_TER, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD, g.Direccion_TER, g.Telefono_TER, Barrio_PAC, Nombre_MUN, x.Codigo_DGN, x.Descripcion_DGN, Prefijo_AFC, ValCredito_FAC, date(f.fecha_adm), f.FechaFin_ADM, d.contrato_eps, d.nombre_eps, d.Tipo_EPS  \nFrom itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, czterceros g, cztipoid h, gxplanes i, gxpacientes p, czmunicipios m, gxdiagnostico x \nWhere x.Codigo_DGN=f.Codigo_DGN and m.Codigo_MUN=p.Codigo_MUN and m.Codigo_DEP=p.Codigo_DEP and c.Codigo_AFC = b.Codigo_AFC and \np.Codigo_TER=g.Codigo_TER and d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_ADM =c.Codigo_ADM \n and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA\n and c.Codigo_FAC>=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_INICIAL\',10,\'0\')) and c.Codigo_FAC<=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_FINAL\',10,\'0\'));' WHERE  `Codigo_RPT`='facturasaluddet' AND `Codigo_DCD`=0;
ALTER TABLE `gxfacturaconf`	ADD COLUMN `ShowConcepto_FCN` CHAR(1) NOT NULL DEFAULT '0' AFTER `Identificacion_FCN`;
ALTER TABLE `gxfacturaconf`	ADD COLUMN `ShowODS_FCN` CHAR(1) NOT NULL DEFAULT '0' AFTER `ShowConcepto_FCN`;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('hctriage', 'Clasificación Triage', 'select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, e.Logo2_HCH, b.Nombre_HCT\r\nFrom\r\n itconfig a, hctipos b, hcfolios c, czterceros d, hcencabezadosdet e\r\nWhere \r\n c.Codigo_TER=d.Codigo_TER and c.Codigo_HCT=b.Codigo_HCT and b.Codigo_HCH=e.Codigo_HCH\r\n and d.ID_TER=\'@HISTORIA\' and c.Codigo_HCF>=\'@FOLIO_INICIAL\' and c.Codigo_HCF<=\'@FOLIO_FINAL\'');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`) VALUES ('hctriage', 'PACIENTE', 'No Historia', '1');
UPDATE `itreportsparam` SET `Titulo_RPT`='No ID' WHERE  `Codigo_RPT`='hctriage' AND `Campo_RPT`='PACIENTE' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Titulo_RPT`='Paciente' WHERE  `Codigo_RPT`='hctriage' AND `Campo_RPT`='PACIENTE' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Campo_RPT`='HISTORIA' WHERE  `Codigo_RPT`='hctriage' AND `Campo_RPT`='PACIENTE' AND `Codigo_DCD`=0;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`) VALUES ('hctriage', 'FOLIO_INICIAL', 'Folio Inicial', '2');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`) VALUES ('hctriage', 'FOLIO_FINAL', 'Folio Final', '3');
UPDATE `itreports` SET `SQL_RPT`='select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, e.Logo2_HCH, b.Nombre_HCT\r\nFrom\r\n itconfig a, hctipos b, hcfolios c, czterceros d, hcencabezadosdet e, hctriage f\r\nWhere \r\n c.Codigo_TER=d.Codigo_TER and c.Codigo_HCT=b.Codigo_HCT and b.Codigo_HCH=e.Codigo_HCH and f.Codigo_TER=c.Codigo_TER and f.Codigo_HCF=c.Codigo_HCF \r\n and d.ID_TER=\'@HISTORIA\' and c.Codigo_HCF>=\'@FOLIO_INICIAL\' and c.Codigo_HCF<=\'@FOLIO_FINAL\'' WHERE  `Codigo_RPT`='hctriage' AND `Codigo_DCD`=0;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('triagexfecha', 'Triages atendidos por fecha', 'SELECT a.Codigo_HTR, b.Sigla_TID, c.ID_TER, case d.Codigo_SEX when \'F\' then \'M\' ELSE \'H\' END, d.Apellido1_PAC, d.Apellido2_PAC, d.Nombre1_PAC, d.Nombre2_PAC, e.CodMin_EPS, e.Nombre_EPS, DATE( a.Fecha_TRG), DATE_FORMAT(a.Fecha_TRG, "%H:%I" ), DATE( a.Fecha2_TRG), DATE_FORMAT(a.Fecha2_TRG, "%H:%I" ), DATE(a.Fecha3_TRG), DATE_FORMAT(a.Fecha3_TRG, "%H:%I" ) \r\nFROM hctriage a, cztipoid b, czterceros c, gxpacientes d, gxeps e \r\nWHERE a.Codigo_TER=c.Codigo_TER AND c.Codigo_TID=b.Codigo_TID AND d.Codigo_TER=c.Codigo_TER AND e.Codigo_EPS=a.Codigo_EPS \r\nAND a.Fecha2_TRG >=\'@FECHA_INICIAL\' AND a.Fecha2_TRG<=\'@FECHA_FINAL 23:59:59\'', 'L');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('triagexfecha', 'FECHA_FINAL', 'Fecha Final', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('triagexfecha', 'FECHA_INICIAL', 'Fecha Inicial', '1', 'D');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('500', '91', '2', '2', 'Res. 256 Reg.Tipo 6', 'reports/res256t6.php', '492', '1', '1', '1');
UPDATE `ititems` SET `Nombre_ITM`='Listado Triage por Fechas', `Enlace_ITM`='reports/triagexfecha.php' WHERE  `Codigo_ITM`=500 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='0' WHERE  `Codigo_ITM`=500 AND `Codigo_MNU`=93 AND `Codigo_MOD`=6 AND `Codigo_APP`=2;
