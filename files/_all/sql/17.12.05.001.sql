UPDATE `itconfig` SET `Version_DCD`='17.12.20.001';
ALTER TABLE `itconfig_fc`	CHANGE COLUMN `PeriodoActual` `PeriodoActual_XFC` CHAR(7) NULL DEFAULT '0' COMMENT 'MM.YYYY' AFTER `CierreDias_XFC`;
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, i.ValorServicio_ORD\r\nFrom gxadmision a, gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j\r\nWhere a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and Estado_ADM<>\'A\'  \r\nand j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN and a.Fecha_ADM>=\'@FECHA_INICIAL\' and a.Fecha_ADM<=\'@FECHA_FINAL 23:59:59\' and a.Codigo_EPS=\'@ENTIDAD\'\r\nGroup by f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm\r\nOrder by 4, 5, 6' WHERE  `Codigo_RPT`='autorizaciones' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, i.ValorServicio_ORD, m.Nombre_PTT \r\nFrom gxadmision a, gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j, gxpacientestipos m\r\nWhere a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and m.Codigo_PTT=a.Codigo_PTT and Estado_ADM<>\'A\'  \r\nand j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN and a.Fecha_ADM>=\'@FECHA_INICIAL\' and a.Fecha_ADM<=\'@FECHA_FINAL 23:59:59\' and a.Codigo_EPS=\'@ENTIDAD\'\r\nGroup by f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm\r\nOrder by 4, 5, 6' WHERE  `Codigo_RPT`='autorizaciones' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select b.Prefijo_EMI,  LPAD(b.Codigo_EMI,10,\'0\'), b.Fecha_EMI, b.Codigo_CTZ, c.Nombre_TER, d.Nombre_AGE, e.Nombre_PLA, b.Voucher_EMI, a.Edad_CTZ, a.Modalidad_CTZ, a.FechaIni_CTZ, a.FechaFin_CTZ, a.Dias_CTZ, g.Nombre_DST, h.Nombre_DST, a.Dolares_CTZ, a.Pesos_CTZ, a.Descuento_CTZ, a.Total_CTZ,\r\n concat(f.ID_USR, \'[\', f.Nombre_USR, \']\')\r\nfrom klcotizaciones a, klemisiones b, czterceros c, klagencias d, klplanes e, itusuarios f, kldestinos g, kldestinos h\r\nwhere a.Codigo_DCD=b.Codigo_DCD and a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_AGE=d.Codigo_AGE\r\n and a.Codigo_PLA=e.Codigo_PLA and f.Codigo_USR=b.Codigo_USR and g.Codigo_DST=a.Procedencia_CTZ and h.Codigo_DST=a.Codigo_DST\r\n and b.Estado_EMI<>\'A\' and b.Fecha_EMI between \'@FECHA_INICIAL 00:00:00\' and \'@FECHA_FINAL 23:59:59\'\r\n ORDER BY 3' WHERE  `Codigo_RPT`='kventas' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='select b.Prefijo_EMI,   LPAD(b.Codigo_EMI,10,\'0\'), b.Fecha_EMI, b.Codigo_CTZ, c.Nombre_TER, d.Nombre_AGE, e.Nombre_PLA, b.Voucher_EMI, a.Edad_CTZ, a.Modalidad_CTZ, a.FechaIni_CTZ, a.FechaFin_CTZ, a.Dias_CTZ, g.Nombre_DST, h.Nombre_DST, a.Dolares_CTZ, a.Pesos_CTZ, a.Descuento_CTZ, a.Total_CTZ,\r\n concat(f.ID_USR, \'[\', f.Nombre_USR, \']\')\r\nfrom klcotizaciones a, klemisiones b, czterceros c, klagencias d, klplanes e, itusuarios f, kldestinos g, kldestinos h, klagenciasusuarios i\r\nwhere a.Codigo_DCD=b.Codigo_DCD and a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_AGE=d.Codigo_AGE\r\n and a.Codigo_PLA=e.Codigo_PLA and f.Codigo_USR=b.Codigo_USR and g.Codigo_DST=a.Procedencia_CTZ and h.Codigo_DST=a.Codigo_DST\r\n and b.Estado_EMI<>\'A\' and b.Fecha_EMI between \'@FECHA_INICIAL 00:00:00\' and \'@FECHA_FINAL 23:59:59\' and i.Codigo_AGE=d.Codigo_AGE and i.Codigo_USR=\'@USUARIO\'\r\nOrder by 6, 3' WHERE  `Codigo_RPT`='kventaslocal' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Campo_RPT`='FECHA_FINAL' WHERE  `Codigo_RPT`='kventas' AND `Campo_RPT`='FECHA_FIN' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Campo_RPT`='FECHA_INICIAL' WHERE  `Codigo_RPT`='kventas' AND `Campo_RPT`='FECHA_INI' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Campo_RPT`='FECHA_FINAL' WHERE  `Codigo_RPT`='kventaslocal' AND `Campo_RPT`='FECHA_FIN' AND `Codigo_DCD`=0;
UPDATE `itreportsparam` SET `Campo_RPT`='FECHA_INICIAL' WHERE  `Codigo_RPT`='kventaslocal' AND `Campo_RPT`='FECHA_INI' AND `Codigo_DCD`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`) VALUES ('432', '104', '1', '10', 'Edición de Pólizas', 'forms/polizaedit.php');
UPDATE `itreports` SET `SQL_RPT`='select a.Codigo_ADM, f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Codigo_DGN, sum(i.Cantidad_ORD), j.Nombre_SER, a.Codigo_SDE, a.estado_adm, i.ValorServicio_ORD, (sum(i.Cantidad_ORD)*i.ValorServicio_ORD), m.Nombre_PTT \r\nFrom gxadmision a, gxpacientes b, czterceros c, czmunicipios d, czdepartamentos e, cztipoid f, gxdiagnostico g, gxordenescab h, gxordenesdet i, gxservicios j, gxpacientestipos m\r\nWhere a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and d.Codigo_MUN=b.Codigo_MUN and d.Codigo_DEP=b.Codigo_DEP and h.Codigo_ORD=i.Codigo_ORD and h.Codigo_ADM=a.Codigo_ADM and h.Estado_ORD=\'1\' and m.Codigo_PTT=a.Codigo_PTT and Estado_ADM<>\'A\'  \r\nand j.Codigo_SER=i.Codigo_SER and e.Codigo_DEP=b.Codigo_DEP and f.Codigo_TID=c.Codigo_TID and g.Codigo_DGN=a.Codigo_DGN and a.Fecha_ADM>=\'@FECHA_INICIAL\' and a.Fecha_ADM<=\'@FECHA_FINAL 23:59:59\' and a.Codigo_EPS=\'@ENTIDAD\'\r\nGroup by f.Sigla_TID, c.ID_TER, b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, b.Codigo_SEX, \r\nTIMESTAMPDIFF(YEAR, b.FechaNac_PAC, CURDATE()), b.FechaNac_PAC, d.Nombre_MUN, a.Autorizacion_ADM, c.Direccion_TER, c.Telefono_TER,\r\ndate(a.Fecha_ADM), g.Descripcion_DGN, j.Nombre_SER, a.Codigo_SDE, a.estado_adm\r\nOrder by 4, 5, 6' WHERE  `Codigo_RPT`='autorizaciones' AND `Codigo_DCD`=0;
CREATE TABLE `itconections` (	`Nombre_CNX` VARCHAR(50) NOT NULL,	`Servidor_CNX` VARCHAR(60) NULL DEFAULT 'localhost',	`DataBase_CNX` VARCHAR(60) NULL,	`Usuario_CNX` VARCHAR(60) NULL,	`Password_CNX` VARCHAR(60) NULL,	`Estado_CNX` CHAR(1) NULL DEFAULT '1',	PRIMARY KEY (`Nombre_CNX`),	UNIQUE INDEX `Servidor_CNX_DataBase_CNX` (`Servidor_CNX`, `DataBase_CNX`),	INDEX `Estado_CNX` (`Estado_CNX`),	INDEX `DataBase_CNX` (`DataBase_CNX`),	INDEX `Nombre_CNX` (`Nombre_CNX`)) COMMENT='Conexiones a otras Empresas' COLLATE='latin1_swedish_ci' ENGINE=MyISAM;
