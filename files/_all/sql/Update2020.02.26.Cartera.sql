UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.03.19.001';
UPDATE `ititems` SET `Nombre_ITM`='Impresión e Informes' WHERE  `Codigo_ITM`=339 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='339' WHERE  `Codigo_ITM`=511 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Activo_ITM`='0' WHERE  `Codigo_ITM`=520 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='339' WHERE  `Codigo_ITM`=523 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='339' WHERE  `Codigo_ITM`=512 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Recepcion de Pagos' WHERE  `Codigo_ITM`=513 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('531', '59', '1', '2', 'Pagos Cartera', 'reports/pagoscartera.php', '0');
UPDATE `ititems` SET `Padre_ITM`='339' WHERE  `Codigo_ITM`=531 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Codigo_PGS, a.Fecha_PGS, d.Nombre_TER, e.Nombre_FPG, f.Nombre_BCO, a.Total_PGS, a.Observaciones_PGS, a.Codigo_USR, case a.Estado_PGS when \'1\' then \'Sin Confirmar\' when \'2\' then \'Confirmado\' when \'0\' then \'Anulado\' end,\r\nb.Codigo_FAC, c.Fecha_FAC, c.Codigo_RAD, c.Fecha_CAR, c.ValorFac_CAR, c.ValorDeb_CAR, c.ValorCre_CAR, c.ValPagos_CAR, c.Saldo_CAR, b.Valor_PGS,  (c.Saldo_CAR - b.Valor_PGS) AS \'VALOR DESPUES DE PAGO\'\r\nFROM czpagosenc a, czpagosdet b, czcartera c, czterceros d, czformasdepago e, czbancos f\r\nWHERE a.Codigo_PGS=b.Codigo_PGS AND b.Codigo_FAC=c.Codigo_FAC AND d.Codigo_TER=a.Codigo_TER AND e.Codigo_FPG=a.Codigo_FPG\r\nAND f.Codigo_BCO=a.Codigo_BCO AND a.Codigo_PGS BETWEEN \'@CODIGO_INICIAL\' AND \'@CODIGO_FINAL\'' WHERE  `Codigo_RPT`='pagoscartera' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Codigo_PGS, a.Fecha_PGS, d.Nombre_TER, e.Nombre_FPG, f.Nombre_BCO, a.Total_PGS, a.Observaciones_PGS, a.Codigo_USR, case a.Estado_PGS when \'1\' then \'Sin Confirmar\' when \'2\' then \'Confirmado\' when \'0\' then \'Anulado\' end,\r\nb.Codigo_FAC, c.Fecha_FAC, c.Codigo_RAD, c.Fecha_CAR, c.ValorFac_CAR, c.ValorDeb_CAR, c.ValorCre_CAR, c.ValPagos_CAR, Case a.Estado_PGS When \'2\' then b.Saldo1_PGS else c.Saldo_CAR end, b.Valor_PGS,  Case a.Estado_PGS When \'2\'  then b.Saldo2_PGS else  (c.Saldo_CAR - b.Valor_PGS) end AS \'VALOR DESPUES DE PAGO\'\r\nFROM czpagosenc a, czpagosdet b, czcartera c, czterceros d, czformasdepago e, czbancos f\r\nWHERE a.Codigo_PGS=b.Codigo_PGS AND b.Codigo_FAC=c.Codigo_FAC AND d.Codigo_TER=a.Codigo_TER AND e.Codigo_FPG=a.Codigo_FPG\r\nAND f.Codigo_BCO=a.Codigo_BCO AND a.Codigo_PGS BETWEEN \'@CODIGO_INICIAL\' AND \'@CODIGO_FINAL\'' WHERE  `Codigo_RPT`='pagoscartera' AND `Codigo_DCD`=0;
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('carterafacvsrad', 'Facturado Vs Radicado', 'SELECT h.Codigo_EDA, h.Nombre_EDA, count(a.Codigo_FAC), sum(Saldo_CAR) FROM czcartera a, czcarteraedades h WHERE  (DATEDIFF(NOW(), a.Fecha_CAR) BETWEEN h.Minimo_EDA AND h.Maximo_EDA) AND  a.Saldo_CAR>0  GROUP BY h.Nombre_EDA, h.Codigo_EDA Order BY h.Codigo_EDA');
UPDATE `itreports` SET `SQL_RPT`='Select distinct LEFT(MONTHNAME(a.Fecha_FAC),3), year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -@MESES MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)' WHERE  `Codigo_RPT`='carterafacvsrad' AND `Codigo_DCD`=0;
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('carterafacvsrad', 'MESES', 'Número de Meses', '1', 'N');
INSERT INTO `gxespecialidades` (`Codigo_ESP`, `Nombre_ESP`) VALUES ('991', 'NEUROCIRUGIA PEDIATRICA');
ALTER TABLE `gxordenescab`
	CHANGE COLUMN `Codigo_ARE` `Codigo_ARE` VARCHAR(3) NULL DEFAULT NULL AFTER `Fecha_ORD`;
ALTER TABLE `gxordenescab`
	ADD CONSTRAINT `FK_gxordenescab_gxareas` FOREIGN KEY (`Codigo_ARE`) REFERENCES `gxareas` (`Codigo_ARE`);
UPDATE `itreports` SET `SQL_RPT`='Select\r\n LPAD(A.Codigo_ADM,10,\'0\'), P.Razonsocial_DCD, P.NIT_DCD, LPAD(N.Codigo_ORD,10,\'0\'), DATE_FORMAT(N.Fecha_ORD, \'%d/%m/%Y\'),\r\n N.Estado_ORD, B.FechaNac_PAC, L.Nombre_SEX, M.Nombre_TAF, Q.Sigla_TID , C.ID_TER, C.Nombre_TER, Concat(\'{\',N.Codigo_USR,\'} \',O.ID_USR),\r\n E.Codigo_EPS, F.Nombre_TER, G.Codigo_PLA, G.Nombre_PLA, I.Codigo_USR, I.ID_USR, N.Descripcion_ORD, \'\', /* Z.Nombre_ARE, */\r\n K.Nombre_REG, DATE_FORMAT(A.Fecha_ADM, \'%d/%m/%Y\'), TIME_FORMAT(A.Fecha_ADM, \'%H:%i:%s\'), \'D.Codigo_CAM\', \'D.Nombre_CAM\', R.Nombre_RNG\r\nFrom\r\n gxpacientes AS B, czterceros AS C, gxeps AS E, czterceros AS F, gxplanes AS G, cztipoid as Q, itusuarios O, /* gxareas Z, */\r\n itusuarios AS I, gxtipoingreso AS J, gxtiporegimen AS K, gxtiposexo AS L, itconfig AS P, gxrangosalario AS R, \r\n gxtipoafiliacion AS M, gxordenescab N, gxadmision AS A /*Left Join gxcamas AS D On A.Codigo_CAM = D.Codigo_CAM*/ \r\nWhere\r\n A.Codigo_TER = B.Codigo_TER AND B.Codigo_TER = C.Codigo_TER AND Q.Codigo_TID = C.Codigo_TID AND R.Codigo_RNG = B.Codigo_RNG\r\n AND F.Codigo_TER = E.Codigo_TER AND G.Codigo_PLA = A.Codigo_PLA AND trim(A.Codigo_EPS) = trim(E.Codigo_EPS) /* AND Z.Codigo_ARE = N.Codigo_ARE */\r\n AND A.Codigo_USR = I.Codigo_USR AND J.Tipo_ADM = A.Ingreso_ADM AND A.Codigo_ADM = N.Codigo_ADM and A.Estado_ADM<>\'A\'\r\n AND K.Codigo_REG = B.Codigo_REG AND L.Codigo_SEX = B.Codigo_SEX AND M.Codigo_TAF = B.Codigo_TAF AND O.Codigo_USR = N.Codigo_USR\r\n AND LPAD(N.Codigo_ORD,10,\'0\')>=LPAD(\'@CODIGO_INICIAL\',10,\'0\') AND LPAD(N.Codigo_ORD,10,\'0\')<=LPAD(\'@CODIGO_FINAL\',10,\'0\')\r\nOrder By\r\n Codigo_ORD' WHERE  `Codigo_RPT`='ordenesdeservicio' AND `Codigo_DCD`=0;
CREATE TABLE `klplanagencia` (
	`Codigo_PLA` VARCHAR(3) NOT NULL DEFAULT '',
	`Codigo_AGE` VARCHAR(10) NOT NULL DEFAULT '',
	PRIMARY KEY (`Codigo_PLA`, `Codigo_AGE`),
	INDEX `Codigo_PLA` (`Codigo_PLA`),
	INDEX `Codigo_AGE` (`Codigo_AGE`)
)
COLLATE='latin1_swedish_ci'
;
ALTER TABLE `klplanagencia`
	COLLATE='utf8_general_ci',
	ENGINE=InnoDB;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('532', '105', '1', '10', 'Polizas Vigentes', 'email_to_friend.png', 'forms/klpolizasvigentes.php', '1', '1', '1');
INSERT INTO `itreports` (`Codigo_RPT`, `Subtitle_RPT`, `SQL_RPT`) VALUES ('estptesatendidos', NULL, 'Select a.Fecha_HCF, a.Hora_HCF, c.ID_TER, c.Nombre_TER, b.Nombre_HCT, a.Folio_HCF, concat(d.Apellido1_MED, \' \',d.Apellido2_MED,\' \',d.Nombre1_MED,\' \',d.Nombre2_MED), f.Codigo_DGN, f.Descripcion_DGN, h.Nombre_EPS\r\nFrom hcfolios a, hctipos b, czterceros c, gxmedicos d, hcdiagnosticos e, gxdiagnostico f, gxadmision g, gxeps h\r\nWhere a.Codigo_HCT=b.Codigo_HCT and c.Codigo_TER=a.Codigo_TER and d.Codigo_USR=a.Codigo_USR AND e.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=a.Codigo_TER\r\nAND f.Codigo_DGN=e.Codigo_DGN AND g.Codigo_ADM=a.Codigo_ADM AND h.Codigo_EPS=g.Codigo_EPS\r\nand a.Fecha_HCF between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'\r\norder By 1,2');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('533', '106', '2', '2', 'Pacientes Atendidos (Dx)', 'status_away.png', 'reports/estptesatendidos.php', '0');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('estptesatendidos', 'FECHA_INICIAL', 'Fecha Inicial', '1', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('estptesatendidos', 'FECHA_FINAL', 'Fecha Final', '2', 'D');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('534', '91', '2', '2', 'Programación de Cirugías');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('535', '91', '2', '2', 'Salas de Cirugía', 'vbox.png', 'forms/qxsalas.php', '534', '1');
UPDATE `itreportsparam` SET `Search_RPT`='ProfesionalesSalud' WHERE  `Codigo_RPT`='citasprogramadas' AND `Campo_RPT`='MEDICO' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `Subtitle_RPT`='Agenda entre @FECHA_INICIAL y @FECHA_FINAL del profesional con ID No  @MEDICO', `SQL_RPT`='Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT=\'P\' AND Estado_AGE=\'1\' \r\nand c.Fecha_AGE between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\' and e.ID_TER like \'%@MEDICO%\' Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasprogramadas' AND `Codigo_DCD`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('536', '91', '2', '2', 'Grupos de Apoyo', '1.UserSetup.png', 'forms/qxgrpapoyo.php', '534', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('537', '91', '2', '2', 'Motivos de Cancelación', 'cancel.png', 'forms/qxmotcancela.php', '534', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('538', '91', '2', '2', 'Anestesias', 'tag.png', 'forms/qxanestesias.php', '534', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('539', '91', '2', '2', 'Kits Cirugía', 'health.png', 'forms/qxkits.php', '534', '1');
UPDATE `ititems` SET `Icono_ITM`='1.Syringe.png' WHERE  `Codigo_ITM`=538 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('540', '91', '2', '2', 'Programación de Cirugías', '1.History.png', 'forms/qxprogramacion.php', '534', '1');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OptNew_ITM`) VALUES ('541', '91', '2', '2', 'Tipo Especialidades', 'user_medical.png', 'forms/tipoespecialidades.php', '491', '1');
ALTER TABLE `gxespecialidades`
	ADD COLUMN `Codigo_TES` VARCHAR(10) NULL DEFAULT '1' COMMENT 'Tipo Especialidad' AFTER `Nombre_ESP`,
	ADD INDEX `Codigo_TES` (`Codigo_TES`);
CREATE TABLE `gxtipoespecialidad` (
	`Codigo_TES` VARCHAR(10) NOT NULL COMMENT 'Tipo Especialidad' COLLATE 'utf8_general_ci',
	`Nombre_TES` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Estado_TES` CHAR(1) NULL DEFAULT '1' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TES`) USING BTREE,
	INDEX `Estado_TES` (`Estado_TES`) USING BTREE,
	INDEX `Codigo_TES` (`Codigo_TES`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `gxtipoespecialidad` (`Codigo_TES`, `Nombre_TES`) VALUES ('1', 'Médico (a) especialista');
INSERT INTO `gxtipoespecialidad` (`Codigo_TES`, `Nombre_TES`) VALUES ('2', 'Médico (a) general');
INSERT INTO `gxtipoespecialidad` (`Codigo_TES`, `Nombre_TES`) VALUES ('3', 'Enfermera (o)');
INSERT INTO `gxtipoespecialidad` (`Codigo_TES`, `Nombre_TES`) VALUES ('4', 'Auxiliar de enfermería');
INSERT INTO `gxtipoespecialidad` (`Codigo_TES`, `Nombre_TES`) VALUES ('5', 'Otro');
UPDATE `gxespecialidades` SET `Codigo_TES`='1';
UPDATE `gxespecialidades` SET `Codigo_TES`='2' WHERE  `Codigo_ESP`='000';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='055';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='056';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='057';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='058';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='059';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='060';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='061';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='062';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='063';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='064';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='065';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='066';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='067';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='068';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='069';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='071';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='070';
UPDATE `gxespecialidades` SET `Codigo_TES`='3' WHERE  `Codigo_ESP`='073';
UPDATE `gxespecialidades` SET `Codigo_TES`='4' WHERE  `Codigo_ESP`='072';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='079';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='080';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='184';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='185';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='186';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='997';
UPDATE `gxespecialidades` SET `Codigo_TES`='5' WHERE  `Codigo_ESP`='996';
