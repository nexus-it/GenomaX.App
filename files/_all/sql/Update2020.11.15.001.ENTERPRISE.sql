-- NUEVO ENTERPRISE
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.01.05.001' ;
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', concat(c.Nota_CIT,\' \',c.NotaCancela_CIT) AS \'OBSERVACIONES\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u\r\nWhere a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n\r\nAND d.ID_TER=\'@PACIENTE\'  Order By  5,2,3,6,1,7\r\n' WHERE  `Codigo_RPT`='citasxpcte' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='Select b.Codigo_FAC, CONCAT(e.Sigla_TID,\' \', c.ID_TER), c.Nombre_TER, DATE_FORMAT(b.Fecha_FAC, \'%d/%m/%Y\'), b.ValEntidad_FAC \r\nFrom czradicacionesdet as a, gxfacturas as b, czterceros as c, gxadmision AS d, cztipoid AS e \r\nWhere  trim(a.Codigo_FAC)=trim(b.Codigo_FAC) and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=b.Codigo_ADM AND e.Codigo_TID=c.Codigo_TID and \r\nLPAD(a.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \r\nUnion\r\nSelect g.Codigo_FAC, concat(e.FechaIni_FAC, \' - \', e.FechaFin_FAC), e.Servicio_FAC, DATE_FORMAT(g.Fecha_FAC, \'%d/%m/%Y\'), g.ValEntidad_FAC \r\nFrom czradicacionesdet as w, gxfacturas as g, gxfacturascapita as e \r\nWhere  trim(w.Codigo_FAC)=trim(g.Codigo_FAC) and g.Codigo_FAC=e.Codigo_FAC and \r\nLPAD(w.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \r\nOrder By 1' WHERE  `Codigo_RPT`='radicaciones' AND `Codigo_DCD`=0;
ALTER TABLE `hcsv2`
	ADD COLUMN `Tipo_HSV` VARCHAR(50) NULL DEFAULT 'text' AFTER `Calculo_HSV`;
UPDATE `hcsv2` SET `Tipo_HSV`='number' WHERE  `Codigo_HSV`='02';
UPDATE `hcsv2` SET `Tipo_HSV`='number' WHERE  `Codigo_HSV`='03';
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Descripcion_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `Dx_HCT`, `Med_HCT`, `Activo_HCT`, `Icono_HCT`) VALUES ('FORMMEDICA', 'FORMULACION DE MEDICAMENTOS', 'FORMULACION DE MEDICAMENTOS', '1', '1', '1', '1', 'X', '1.Pills');
UPDATE `ititems` SET `Enlace_ITM`='forms/hc.php?FormatoHC=FORMMEDICA' WHERE  `Codigo_ITM`=375 AND `Codigo_MNU`=91 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
CREATE TABLE `hc_formmedica` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='FORMULA MEDICAMENTOS'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hctipos`
	ADD COLUMN `RipsAC_HCT` CHAR(1) NOT NULL DEFAULT '1' COMMENT 'Mostrar en RIPS de Consulta' AFTER `SexoF_HCT`,
	ADD INDEX `RipsAC_HCT` (`RipsAC_HCT`);


ALTER TABLE `hcriegoobs`
	ADD COLUMN `C144_HCA` CHAR(1) NULL DEFAULT '0' COMMENT '¿DURANTE EL ULTIMO AÑO ha sido humillada, menospreciada, insultada o amenzada por su pareja?' AFTER `C143_HCA`,
	ADD COLUMN `C145_HCA` CHAR(1) NULL DEFAULT '0' COMMENT '¿DURANTE EL ULTIMO AÑO fue golpeada, bofeteada, pateada o lastimada físicamente de otra manera?' AFTER `C144_HCA`,
	ADD COLUMN `C146_HCA` CHAR(1) NULL DEFAULT '0' COMMENT '¿DESDE QUE ESTA EN GESTION ha sido golpeada, bofeteada, pateada o lastimada físicamente de otra manera?' AFTER `C145_HCA`,
	ADD COLUMN `C147_HCA` CHAR(1) NULL DEFAULT '0' COMMENT '¿DURANTE EL ULTIMO AÑO fue forzada a tener relaciones sexuales?' AFTER `C146_HCA`;
ALTER TABLE `hcframingham`
	CHANGE COLUMN `Medicado_HCA` `Medicado_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Medicado HTA' AFTER `ColHDL_HCA`,
	CHANGE COLUMN `Fuma_HCA` `Fuma_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Fumador' AFTER `Medicado_HCA`,
	CHANGE COLUMN `Puntos_HCA` `Puntos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntos Test' AFTER `Fuma_HCA`;
CREATE TABLE `hctfg` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Sexo_HCA` VARCHAR(50) NOT NULL DEFAULT 'M' COMMENT 'Sexo' COLLATE 'utf8_general_ci',
	`Edad_HCA` INT(11) NOT NULL DEFAULT '20' COMMENT 'Edad',
	`Creatinina_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Creatinina',
	`Raza_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Afroamericano',
	`Puntos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Filtrado glomerular',
	`Riesgo_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Valoración' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Clasificación TFG'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hctfg`
	CHANGE COLUMN `Sexo_HCA` `Sexotfg_HCA` VARCHAR(50) NOT NULL DEFAULT 'M' COMMENT 'Sexo' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Edad_HCA` `Edadtfg_HCA` INT(11) NOT NULL DEFAULT '20' COMMENT 'Edad' AFTER `Sexotfg_HCA`,
	CHANGE COLUMN `Creatinina_HCA` `Creatininatfg_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Creatinina' AFTER `Edadtfg_HCA`,
	CHANGE COLUMN `Raza_HCA` `Razatfg_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Afroamericano' AFTER `Creatininatfg_HCA`,
	CHANGE COLUMN `Puntos_HCA` `Puntostfg_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Filtrado glomerular' AFTER `Razatfg_HCA`,
	CHANGE COLUMN `Riesgo_HCA` `Riesgotfg_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Valoración' COLLATE 'utf8_general_ci' AFTER `Puntostfg_HCA`;
ALTER TABLE `hctfg`
	CHANGE COLUMN `Puntostfg_HCA` `TFGtfg_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Filtrado glomerular' AFTER `Razatfg_HCA`,
	CHANGE COLUMN `Riesgotfg_HCA` `Valoraciontfg_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Valoración' COLLATE 'utf8_general_ci' AFTER `TFGtfg_HCA`;
ALTER TABLE `hcframingham`
	CHANGE COLUMN `Sexo_HCA` `Sexofr_HCA` VARCHAR(50) NOT NULL DEFAULT 'M' COMMENT 'Sexo' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Edad_HCA` `Edadfr_HCA` INT(11) NOT NULL DEFAULT '20' COMMENT 'Edad' AFTER `Sexofr_HCA`,
	CHANGE COLUMN `TAsist_HCA` `TAsistfr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'TA Sistolica' AFTER `Edadfr_HCA`,
	CHANGE COLUMN `ColT_HCA` `ColTfr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Colesterol Total' AFTER `TAsistfr_HCA`,
	CHANGE COLUMN `ColHDL_HCA` `ColHDLfr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Colesterol HDL' AFTER `ColTfr_HCA`,
	CHANGE COLUMN `Medicado_HCA` `Medicadofr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Medicado HTA' AFTER `ColHDLfr_HCA`,
	CHANGE COLUMN `Fuma_HCA` `Fumafr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Fumador' AFTER `Medicadofr_HCA`,
	CHANGE COLUMN `Puntos_HCA` `Puntosfr_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntos Test' AFTER `Fumafr_HCA`,
	CHANGE COLUMN `Riesgo_HCA` `Riesgofr_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Porcentaje Riesgo' COLLATE 'utf8_general_ci' AFTER `Puntosfr_HCA`;
CREATE TABLE `hcpqservicios` (
	`Codigo_PQT` VARCHAR(20) NOT NULL,
	`Orden_PQT` INT NULL,
	`Codigo_SER` VARCHAR(6) NOT NULL,
	PRIMARY KEY (`Codigo_PQT`, `Codigo_SER`),
	INDEX `Orden_PQT` (`Orden_PQT`)
)
COMMENT='Paquetes de Servicios Agrupados'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`) VALUES ('Laboratorios RCV 1', '1', '811');
ALTER TABLE `hcpqservicios`
	ADD COLUMN `Mide_PQT` CHAR(50) NULL DEFAULT '0' AFTER `Codigo_SER`;
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '2', '1014', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '3', '1011', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '4', '1012', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '5', '1062', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '6', '971', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '7', '1035', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '8', '922', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '10', '1020', '1');
INSERT INTO `hcpqservicios` (`Codigo_PQT`, `Orden_PQT`, `Codigo_SER`, `Mide_PQT`) VALUES ('Laboratorios RCV 1', '9', '1050', '1');
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 889);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1053);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 924);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1450);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1037);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1050);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1002);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 8209);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 972);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1107);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1019);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1000);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1030);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 987);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1009);
Insert Into hcpqservicios(Codigo_PQT, Orden_PQT, Codigo_SER) Values('Laboratorios RCV 2', 1, 1058);
UPDATE `hcpqservicios` SET `Codigo_SER`='973' WHERE  `Codigo_PQT`='Laboratorios RCV 1' AND `Codigo_SER`='971';
UPDATE `hcpqservicios` SET `Codigo_SER`='971' WHERE  `Codigo_PQT`='Laboratorios RCV 2' AND `Codigo_SER`='972';
UPDATE `hcpqservicios` SET `Codigo_SER`='972' WHERE  `Codigo_PQT`='Laboratorios RCV 1' AND `Codigo_SER`='973';
CREATE TABLE `hclabsrcv` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Codigo_SER` VARCHAR(6) NOT NULL COLLATE 'utf8_general_ci',
	`Valor_LAB` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`Fecha_LAB` DATE NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `Codigo_SER`, `Fecha_LAB`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE,
	INDEX `Codigo_SER` (`Codigo_SER`) USING BTREE,
	INDEX `Fecha_LAB` (`Fecha_LAB`) USING BTREE
)
COMMENT='Laboratorios de RCV'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('569', '106', '2', '2', 'Factores de RCV', 'database_table.png', 'reports/fiercv.php', '529', '0');
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('fiercv', 'Esquema de Información Factores de Riesgo Cardio Vascular', 'Informe entre @FECHA_INICIAL y @FECHA_FINAL ', 'SELECT \'\' AS \'No\', MONTH(a.Fecha_HCF) AS \'MES DE ATENCIÓN\', a.Fecha_HCF AS \'FECHA DE ATENCIÓN\', \r\nb.Codigo_DEP AS \'DEPARTAMENTO\', b.Codigo_MUN AS \'MUNICIPIO\', d.Sigla_TID AS \'TIPO DE IDENTIDAD\', c.ID_TER AS \'NÚMERO DE IDENTIDAD\',\r\nb.Codigo_PLA AS \'RÉGIMEN\', b.Nombre1_PAC AS \'PRIMER NOMBRE\', b.Nombre2_PAC AS \'SEGUNDO NOMBRE\', b.Apellido1_PAC as \'PRIMER APELLIDO\', b.Apellido2_PAC AS \'SEGUNDO APELLIDO\', 	\r\nb.FechaNac_PAC AS \'FECHA DE NACIMIENTO\', TIMESTAMPDIFF(YEAR,b.FechaNac_PAC,a.Fecha_HCF) AS \'EDAD\', b.Codigo_SEX AS \'SEXO\', c.Direccion_TER AS \'DIRECCION\', b.Barrio_PAC AS \'BARRIO\', c.Telefono_TER AS \'TELEFONO\'\r\n, CONCAT(e.Razonsocial_DCD,\' Sede \', q.Nombre_SDE) AS \'IPS DE ATENCIÓN PRIMARIA\', \r\ncase when r.Codigo_DGN LIKE \'E10%\' Then \r\n	case when r.CodigoR_DGN LIKE \'I%\' then \'HTA + DM Tipo I\'\r\n	ELSE \'Diabetes Mellitus Tipo I\' END\r\n when r.Codigo_DGN LIKE \'E11%\' Then \r\n	case when r.CodigoR_DGN LIKE \'I%\' then \'HTA + DM Tipo II\'\r\n	ELSE \'Diabetes Mellitus Tipo II\' END\r\n when r.Codigo_DGN LIKE \'I%\' then\r\n   case when r.CodigoR_DGN LIKE \'E10%\' then \'HTA + DM Tipo I\'\r\n   when r.CodigoR_DGN LIKE \'E11%\' then \'HTA + DM Tipo II\'\r\n   ELSE \'Hipertensión Arterial\' end\r\nEND AS \'DIAGNÓSTICO\',\r\nt.FechaIng_PRG AS \'FECHA DE DIAGNÓSTICO \', \'\' AS \'DIAGNÓSTICO SECUNDARIO - COMPLICACIONES PRESENTADAS\', \'\' AS \'CUÁL?\',\r\nv04.Valor_HSV AS \'PESO (kgs)\', v05.Valor_HSV AS \'TALLA\', v07.Valor_HSV AS \'IMC\', case  when v07.Valor_HSV < 18.5 then \'BAJO PESO\' when v07.Valor_HSV BETWEEN 18.5 AND 24.99 then \'NORMAL\' when v07.Valor_HSV BETWEEN 25 AND 29.99 then \'SOBREPESO\' when v07.Valor_HSV BETWEEN 30 AND 34.99 then \'OBESIDAD TIPO I\' when v07.Valor_HSV BETWEEN 35 AND 39.99 then \'OBESIDAD TIPO II\' ELSE \'OBESIDAD TIPO III\' END as \'CLASIFICACIÓN IMC\',\r\nv13.Valor_HSV AS \'SISTÓLICA\', v13.Valor_HSV AS \'DIASTÓLICA\',\r\n/*\r\ncase when isnull(clb1.Resultados_EXA)  then \'\' else alb1.Fecha_EXA END AS \'GLICEMIA\', clb1.Resultados_EXA AS \'GLICEMIA\', \r\ncase when isnull(clb2.Resultados_EXA) then \'\' else alb2.Fecha_EXA END AS \'CREATININA\', clb2.Resultados_EXA AS \'CREATININA\', \r\n*/\r\n/* case when isnull(group_concat(concat(dlb3.Nombre_ITL, \': \', clb3.Resultados_EXA) then \'\' else alb3.Fecha_EXA END AS \'PROTEINURIA\', group_concat(concat(dlb3.Nombre_ITL, \': \', clb3.Resultados_EXA AS \'PROTEINURIA\', */\r\n/*\r\n\'\' AS \'PROTEINURIA\', \'\' AS \'PROTEINURIA\',\r\ncase when isnull(clb4.Resultados_EXA) then \'\' else alb4.Fecha_EXA END AS \'COLESTEROL TOTAL\', clb4.Resultados_EXA AS \'COLESTEROL TOTAL\',\r\ncase when isnull(clb5.Resultados_EXA) then \'\' else alb5.Fecha_EXA END AS \'HDL\', clb5.Resultados_EXA AS \'HDL\',\r\ncase when isnull(clb6.Resultados_EXA) then \'\' else alb6.Fecha_EXA END AS \'LDL\', clb6.Resultados_EXA AS \'LDL\',\r\ncase when isnull(clb7.Resultados_EXA) then \'\' else alb7.Fecha_EXA END AS \'TRIGLICERIDOS\', clb7.Resultados_EXA AS \'TRIGLICERIDOS\',\r\ncase when isnull(clb8.Resultados_EXA) then \'\' else alb8.Fecha_EXA END AS \'HEMOGLOBINA GLICOSILADA\', clb8.Resultados_EXA AS \'HEMOGLOBINA GLICOSILADA\',\r\ncase when isnull(clb9.Resultados_EXA) then \'\' else alb9.Fecha_EXA END AS \'PTH\', clb9.Resultados_EXA AS \'PTH\',\r\ncase when isnull(clb10.Resultados_EXA) then \'\' else alb10.Fecha_EXA END AS \'ALBUMINURIA \', clb10.Resultados_EXA AS \'ALBUMINURIA \',\r\ncase when isnull(clb11.Resultados_EXA) then \'\' else alb11.Fecha_EXA END AS \'CREATINURIA	\', clb11.Resultados_EXA AS \'CREATINURIA	\',\r\n \'\' AS \'RELACIÓN ALBUMINURIA/CREATINURIA\', \'\' AS \'RELACIÓN ALBUMINURIA/CREATINURIA\',\r\n*/\r\n\r\ngroup_concat(CONCAT(\' \',z.Nombre_SER, \': \', lb1.Fecha_SLB, \'= \', clb1.Resultados_EXA)) AS \'EXAMENES\',\r\n\r\ncase when a.Folio_HCF=\'1\' then \'1 VEZ\' ELSE \'CONTROL\' END AS \'1 VEZ O CONTROL\'\r\n\r\nFROM gxpacientes b, czterceros c, cztipoid d, itconfig e, czsedes q, gxareas i, gxeps j, hcdiagnosticos r, gxprgmpctes t, \r\nhcsignosvitales v04, hcsignosvitales v05,  hcsignosvitales v07, hcsignosvitales v13, hcfolios a , gxservicios z,\r\nlbsolicitudes lb1, lbexamenes alb1 LEFT JOIN lbexamitems clb1 ON clb1.Codigo_EXA=alb1.Codigo_EXA /* ,\r\n lbsolicitudes lb2, lbexamenes alb2 LEFT JOIN lbexamitems clb2 ON clb2.Codigo_EXA=alb2.Codigo_EXA , */\r\n /* LEFT JOIN lbsolicitudes lb3 ON lb3.Codigo_TER=a.Codigo_TER AND lb3.Codigo_ARE=a.Codigo_ARE LEFT JOIN lbexamenes alb3 ON alb3.Codigo_SLB=lb3.Codigo_SLB LEFT JOIN lbexamitems clb3 ON clb3.Codigo_EXA=alb3.Codigo_EXA LEFT JOIN lbitemslab dlb3 ON dlb3.Codigo_ITL=clb3.Codigo_ITL */\r\n/* lbsolicitudes lb4, lbexamenes alb4 LEFT JOIN lbexamitems clb4 ON clb4.Codigo_EXA=alb4.Codigo_EXA ,\r\nlbsolicitudes lb5, lbexamenes alb5 LEFT JOIN lbexamitems clb5 ON clb5.Codigo_EXA=alb5.Codigo_EXA ,\r\nlbsolicitudes lb6, lbexamenes alb6 LEFT JOIN lbexamitems clb6 ON clb6.Codigo_EXA=alb6.Codigo_EXA , \r\nlbsolicitudes lb7, lbexamenes alb7 LEFT JOIN lbexamitems clb7 ON clb7.Codigo_EXA=alb7.Codigo_EXA ,\r\nlbsolicitudes lb8, lbexamenes alb8 LEFT JOIN lbexamitems clb8 ON clb8.Codigo_EXA=alb8.Codigo_EXA ,\r\nlbsolicitudes lb9, lbexamenes alb9 LEFT JOIN lbexamitems clb9 ON clb9.Codigo_EXA=alb9.Codigo_EXA ,\r\nlbsolicitudes lb10, lbexamenes alb10 LEFT JOIN lbexamitems clb10 ON clb10.Codigo_EXA=alb10.Codigo_EXA ,\r\nlbsolicitudes lb11, lbexamenes alb11 LEFT JOIN lbexamitems clb11 ON clb11.Codigo_EXA=alb11.Codigo_EXA  */\r\n/* LEFT JOIN lbsolicitudes lb12 ON lb12.Codigo_TER=a.Codigo_TER AND lb12.Codigo_ARE=a.Codigo_ARE AND lb12.Fecha_SLB=a.Fecha_HCF LEFT JOIN lbexamenes alb12 ON alb12.Codigo_SLB=lb12.Codigo_SLB  LEFT JOIN lbexamitems clb12 ON clb12.Codigo_EXA=alb12.Codigo_EXA LEFT JOIN lbitemslab dlb12 ON dlb12.Codigo_ITL=clb12.Codigo_ITL LEFT JOIN lbitemsref rlb12 ON rlb12.Codigo_SER=alb12.Codigo_SER AND rlb12.Codigo_ITL=clb12.Codigo_ITL */\r\n\r\nWHERE a.Codigo_TER=b.Codigo_TER AND c.Codigo_TER=b.Codigo_TER AND c.Codigo_TID=d.Codigo_TID \r\nAND i.Codigo_ARE=a.Codigo_ARE AND j.Codigo_EPS=b.Codigo_EPS AND t.Codigo_TER=a.Codigo_TER AND t.Codigo_PRG=\'RCV\'\r\nAND q.Codigo_SDE=i.Codigo_SDE AND r.Codigo_TER=a.Codigo_TER AND r.Codigo_HCF=a.Codigo_HCF AND v04.Codigo_TER=a.Codigo_TER AND v04.Codigo_HCF=a.Codigo_HCF\r\nAND v05.Codigo_TER=a.Codigo_TER AND v05.Codigo_HCF=a.Codigo_HCF AND v07.Codigo_TER=a.Codigo_TER AND v07.Codigo_HCF=a.Codigo_HCF\r\nAND v13.Codigo_TER=a.Codigo_TER AND v13.Codigo_HCF=a.Codigo_HCF AND v13.Codigo_HSV=\'13\' \r\nAND v05.Codigo_HSV=\'05\' AND v04.Codigo_HSV=\'04\' AND v07.Codigo_HSV=\'07\'\r\n\r\nAND z.Codigo_SER=alb1.Codigo_SER\r\n\r\nand lb1.Codigo_TER=a.Codigo_TER AND lb1.Codigo_ARE=a.Codigo_ARE AND date(lb1.Fecha_SLB)=a.Fecha_HCF AND alb1.Codigo_SLB=lb1.Codigo_SLB\r\n/* AND lb2.Codigo_TER=a.Codigo_TER AND lb2.Codigo_ARE=a.Codigo_ARE AND date(lb2.Fecha_SLB)=a.Fecha_HCF AND alb2.Codigo_SLB=lb2.Codigo_SLB\r\nAND lb4.Codigo_TER=a.Codigo_TER AND lb4.Codigo_ARE=a.Codigo_ARE AND date(lb4.Fecha_SLB)=a.Fecha_HCF AND alb4.Codigo_SLB=lb4.Codigo_SLB \r\nAND lb5.Codigo_TER=a.Codigo_TER AND lb5.Codigo_ARE=a.Codigo_ARE AND date(lb5.Fecha_SLB)=a.Fecha_HCF AND alb5.Codigo_SLB=lb5.Codigo_SLB  \r\nand lb6.Codigo_TER=a.Codigo_TER AND lb6.Codigo_ARE=a.Codigo_ARE AND date(lb6.Fecha_SLB)=a.Fecha_HCF AND alb6.Codigo_SLB=lb6.Codigo_SLB  \r\nAND lb7.Codigo_TER=a.Codigo_TER AND lb7.Codigo_ARE=a.Codigo_ARE AND date(lb7.Fecha_SLB)=a.Fecha_HCF AND alb7.Codigo_SLB=lb7.Codigo_SLB  \r\nand lb8.Codigo_TER=a.Codigo_TER AND lb8.Codigo_ARE=a.Codigo_ARE AND date(lb8.Fecha_SLB)=a.Fecha_HCF AND alb8.Codigo_SLB=lb8.Codigo_SLB  \r\nAND lb9.Codigo_TER=a.Codigo_TER AND lb9.Codigo_ARE=a.Codigo_ARE AND date(lb9.Fecha_SLB)=a.Fecha_HCF AND alb9.Codigo_SLB=lb9.Codigo_SLB  \r\nAND lb10.Codigo_TER=a.Codigo_TER AND lb10.Codigo_ARE=a.Codigo_ARE AND date(lb10.Fecha_SLB)=a.Fecha_HCF AND alb10.Codigo_SLB=lb10.Codigo_SLB  \r\nAND lb11.Codigo_TER=a.Codigo_TER AND lb11.Codigo_ARE=a.Codigo_ARE AND date(lb11.Fecha_SLB)=a.Fecha_HCF AND alb11.Codigo_SLB=lb11.Codigo_SLB  \r\n*/\r\n/*\r\nAND alb1.Codigo_ser=\'1035\' \r\nAND alb2.Codigo_ser=\'1020\' \r\nAND alb4.Codigo_ser=\'1014\' \r\nAND alb5.Codigo_ser=\'1011\' \r\nAND alb6.Codigo_ser=\'1012\' \r\nAND alb7.Codigo_ser=\'1062\' \r\nAND alb8.Codigo_ser IN (\'971\', \'972\') \r\nAND alb9.Codigo_ser=\'935\'  \r\nAND alb10.Codigo_ser IN(\'1002\', \'1003\')\r\nAND alb11.Codigo_ser=\'1016\' */\r\n/* AND alb12.Codigo_ser=\'1016\' */\r\n \r\nAND alb1.Codigo_ser IN (\'1035\', \'1020\', \'1014\', \'1011\', \'1012\',\'1062\', \'971\', \'972\', \'935\', \'1002\',\'1003\',\'1016\') \r\n\r\n AND j.Codigo_TER=\'@ENTIDAD\' AND i.Codigo_SDE=\'@SEDE\' AND a.Fecha_HCF BETWEEN \'@FECHA_INICIAL\' AND \'@FECHA_FINAL 23:59:59\' \r\n\r\nGROUP BY a.Codigo_TER\r\n;\r\n\r\n', 'L');
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Codigo_TID AS \'Tipo ID\', a.ID_TER AS \'No ID\', TIMESTAMPDIFF(YEAR,b.FechaNac_PAC,d.Fecha_HCF) AS \'Edad\', b.Codigo_SEX AS \'Sexo\',\r\ne.Tabaquismo_HCA AS \'Tabaquismo\', e.Sedentarismo_HCAas \'Sedentarismo\', e.Consumograsa_HCA AS \'Consumo de Grasa\', e.Alcohol_HCA AS \'Alcohol\', e.Estress_HCA AS \'Estress\', e.Sobrepeso_HCA AS \'Sobrepeso\',\r\ne.Obesidad_HCA AS \'Obesidad\', e.Consumosal_HCA AS \'Consumo de Sal\', e.Dislipidemia_HCA AS \'Dislipidemia\', e.Observaciones_HCA AS \'Observaciones\'\r\nFROM czterceros a, gxpacientes b, hcfolios d, hcriegocv e, gxeps f, gxareas g\r\nWHERE a.Codigo_TER=b.Codigo_TER AND b.Codigo_TER=d.Codigo_TER AND d.Codigo_TER=e.Codigo_TER AND e.Codigo_HCF=d.Codigo_HCF\r\nAND f.Codigo_EPS=d.Codigo_TER AND g.Codigo_ARE=d.Codigo_ARE\r\nAND  d.Fecha_HCF  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  \r\nAND  f.Codigo_TER=\'@ENTIDAD\' AND g.Codigo_SDE=\'@SEDE\' ' WHERE  `Codigo_RPT`='fiercv' AND `Codigo_DCD`=0;
INSERT INTO `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('fiercv', 'ENTIDAD', 'SELECT Codigo_TER, Nombre_TER FROM czterceros WHERE Codigo_TER in (Select Codigo_TER from gxeps where Codigo_EPS in (Select distinct Codigo_EPS from gxagendacab)) Order By 2;');
INSERT INTO `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('fiercv', 'SEDE', 'Select Codigo_SDE, NOmbre_SDE From czsedes Where Estado_SDE=\'1\' Order By 2;');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('fiercv', 'ENTIDAD', 'Entidad', '4', 'S');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('fiercv', 'FECHA_FINAL', 'Fecha Final', '3', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('fiercv', 'FECHA_INICIAL', 'Fecha Inicial', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('fiercv', 'SEDE', 'Sede', '5', 'S');
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Codigo_TID AS \'Tipo ID\', a.ID_TER AS \'No ID\', TIMESTAMPDIFF(YEAR,b.FechaNac_PAC,d.Fecha_HCF) AS \'Edad\', b.Codigo_SEX AS \'Sexo\',\r\ne.Tabaquismo_HCA AS \'Tabaquismo\', e.Sedentarismo_HCA as \'Sedentarismo\', e.Consumograsa_HCA AS \'Consumo de Grasa\', e.Alcohol_HCA AS \'Alcohol\', e.Estress_HCA AS \'Estress\', e.Sobrepeso_HCA AS \'Sobrepeso\',\r\ne.Obesidad_HCA AS \'Obesidad\', e.Consumosal_HCA AS \'Consumo de Sal\', e.Dislipidemia_HCA AS \'Dislipidemia\', e.Observaciones_HCA AS \'Observaciones\'\r\nFROM czterceros a, gxpacientes b, hcfolios d, hcriegocv e, gxeps f, gxareas g, gxadmision h\r\nWHERE a.Codigo_TER=b.Codigo_TER AND b.Codigo_TER=d.Codigo_TER AND d.Codigo_TER=e.Codigo_TER AND e.Codigo_HCF=d.Codigo_HCF\r\nAND f.Codigo_EPS=h.Codigo_EPS AND g.Codigo_ARE=d.Codigo_ARE AND h.Codigo_ADM=d.Codigo_ADM AND d.Codigo_HCT=\'HPRTSN\'\r\nAND  d.Fecha_HCF  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  \r\nAND  f.Codigo_TER=\'@ENTIDAD\' AND g.Codigo_SDE=\'@SEDE\'' WHERE  `Codigo_RPT`='fiercv' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='Select b.Codigo_FAC, CONCAT(e.Sigla_TID,\' \', c.ID_TER), c.Nombre_TER, DATE_FORMAT(b.Fecha_FAC, \'%d/%m/%Y\'), (b.ValEntidad_FAC - b.ValCredito_FAC) AS total\r\nFrom czradicacionesdet as a, gxfacturas as b, czterceros as c, gxadmision AS d, cztipoid AS e \r\nWhere  trim(a.Codigo_FAC)=trim(b.Codigo_FAC) and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=b.Codigo_ADM AND e.Codigo_TID=c.Codigo_TID and \r\nLPAD(a.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \r\nUnion\r\nSelect g.Codigo_FAC, concat(e.FechaIni_FAC, \' - \', e.FechaFin_FAC), e.Servicio_FAC, DATE_FORMAT(g.Fecha_FAC, \'%d/%m/%Y\'), g.ValEntidad_FAC \r\nFrom czradicacionesdet as w, gxfacturas as g, gxfacturascapita as e \r\nWhere  trim(w.Codigo_FAC)=trim(g.Codigo_FAC) and g.Codigo_FAC=e.Codigo_FAC and \r\nLPAD(w.Codigo_RAD,10,\'0\')=LPAD(\'@CODIGO_INICIAL\',10,\'0\') \r\nOrder By 1' WHERE  `Codigo_RPT`='radicaciones' AND `Codigo_DCD`=0;

INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `Subtitle_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('altocosto', 'Informe Cuentas Alto Costo', 'Informe entre @FECHA_INICIAL y @FECHA_FINAL ', 'SELECT distinct \'\', \'\', Sigla_TID, ID_TER, Fecha_HCF, \'\', Nombre_ESP, \'\', \'\', Codigo_DGN, CodigoR_DGN\r\nFROM gxpacientes a, czterceros b, cztipoid c,  gxespecialidades i, gxmedicos j, gxmedicosesp k,\r\n hcfolios d LEFT JOIN hcdiagnosticos h ON h.Codigo_TER=d.Codigo_TER AND h.Codigo_HCF=d.Codigo_HCF\r\nWHERE a.Codigo_TER=b.Codigo_TER AND d.Codigo_TER=b.Codigo_TER AND c.Codigo_TID=b.Codigo_TID AND i.Codigo_ESP=k.Codigo_ESP AND k.Codigo_TER=j.Codigo_TER\r\n AND j.Codigo_USR=d.Codigo_USR\r\nAND d.Fecha_HCF >= \'@FECHA_INICIAL\' AND d.Fecha_HCF <= \'@FECHA_FINAL 23:59:59\' AND a.Codigo_EPS=\'@ENTIDAD\'\r\n', 'L');
UPDATE `itreports` SET `SQL_RPT`='SELECT DISTINCT c.Sigla_TID AS \'Tipo Documento\', a.ID_TER AS \'Numero Documento\', \'Fecha Expedicion\', CONCAT(b.Nombre1_PAC,\' \', b.Nombre2_PAC) AS \'Nombres\',\r\nCONCAT(b.Apellido1_PAC,\' \',b.Apellido2_PAC) AS \'Apellidos\', d.Nombre_PLA AS \'Regimen\', b.FechaNac_PAC AS \'Fecha Nacimiento\', e.Nombre_DEP AS \'Departamento\',\r\nf.Nombre_MUN AS \'Municipio\', b.EstCivil_PAC AS \'Estado Civil\', b.Codigo_ZNA AS \'Zona\', a.Direccion_TER AS \'Direccion\', a.Telefono_TER AS \'Telefonos\', a.Correo_TER AS \'Correo\'\r\nFROM czterceros a, gxpacientes b, cztipoid c, gxplanes d, czdepartamentos e, czmunicipios f, hcfolios g, gxadmision h, gxareas i, gxeps j\r\nWHERE a.Codigo_TER=b.Codigo_TER AND c.Codigo_TID=a.Codigo_TID AND d.Codigo_PLA=b.Codigo_PLA AND e.Codigo_DEP=b.Codigo_DEP AND f.Codigo_DEP=e.Codigo_DEP AND f.Codigo_MUN=b.Codigo_MUN\r\nAND h.Codigo_ADM=g.Codigo_ADM AND i.Codigo_ARE=g.Codigo_ARE AND j.Codigo_EPS=h.Codigo_EPS\r\nAND g.Codigo_TER=a.Codigo_TER AND g.Fecha_HCF BETWEEN \'@FECHA_INICIAL\' AND \'@FECHA_FINAL 23:59:59\' \r\nAND j.Codigo_TER=\'@ENTIDAD\' AND i.Codigo_SDE=\'@SEDE\';' WHERE  `Codigo_RPT`='altocosto' AND `Codigo_DCD`=0;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('570', '106', '2', '2', 'Cuentas Alto Costo', 'database_table.png', 'reports/altocosto.php', '529', '0');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('altocosto', 'ENTIDAD', 'Entidad', '4', 'S');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('altocosto', 'FECHA_FINAL', 'Fecha Final', '3', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('altocosto', 'FECHA_INICIAL', 'Fecha Inicial', '2', 'D');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('altocosto', 'SEDE', 'Sede', '5', 'S');
INSERT INTO `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('altocosto', 'ENTIDAD', 'SELECT Codigo_TER, Nombre_TER FROM czterceros WHERE Codigo_TER in (Select Codigo_TER from gxeps where Codigo_EPS in (Select distinct Codigo_EPS from gxagendacab)) Order By 2;');
INSERT INTO `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('altocosto', 'SEDE', 'Select Codigo_SDE, NOmbre_SDE From czsedes Where Estado_SDE=\'1\' Order By 2;');

INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Descripcion_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `SV_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`, `Img_HCT`) VALUES ('ONCO1', 'HISTORIA CLINICA ONCOLOGICA', 'HISTORIA CLINICA ONCOLOGICA', '2', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
UPDATE `itreports` SET `SQL_RPT`='SELECT a.Codigo_TER AS \'CodTer\', e.ID_TER AS \'Tercero\', a.Fecha_LAB AS \'FecSolicitud\', d.CUPS_PRC AS \'CUPS\', d.Nombre_PRC AS \'Servicio\', a.Fecha_LAB AS \'FecExa\', a.Valor_LAB AS \'Resultado\'\r\nFROM hclabsrcv a, czterceros e, gxprocedimientos d, gxareas f, hcfolios b \r\nWHERE a.Codigo_TER=e.Codigo_TER AND a.Codigo_SER=d.Codigo_SER AND b.Codigo_TER=a.Codigo_TER AND b.Codigo_HCF=a.Codigo_HCF AND b.Codigo_ARE=f.Codigo_ARE\r\nAND a.Codigo_ser IN (\'1035\', \'1020\', \'1014\', \'1011\', \'1012\',\'1062\', \'971\', \'972\', \'935\', \'1002\',\'1003\',\'1016\') \r\nAND f.Codigo_SDE=\'@SEDE\' AND a.Fecha_LAB BETWEEN \'@FECHA_INICIAL\' AND \'@FECHA_FINAL 23:59:59\' ;' WHERE  `Codigo_RPT`='inf_rcvlabs' AND `Codigo_DCD`=0;
