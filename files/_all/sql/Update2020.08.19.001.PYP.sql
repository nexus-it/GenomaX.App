UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.08.31.001';
CREATE TABLE `hcriegoobs` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Edad_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Edad' COLLATE 'utf8_general_ci',
	`Paridad_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Paridad' COLLATE 'utf8_general_ci',
	`Aborto_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Aborto habitual / infertilidad' COLLATE 'utf8_general_ci',
	`RetPlac_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Retencion placentaria' COLLATE 'utf8_general_ci',
	`Rnmayor_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Recien nacido > 4000 gr	' COLLATE 'utf8_general_ci',
	`Rnmenor_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Recien nacido < 2500 gr' COLLATE 'utf8_general_ci',
	`HTA_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por embarazo' COLLATE 'utf8_general_ci',
	`Gemelar_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazo gemelar' COLLATE 'utf8_general_ci',
	`Cesprev_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cesarea previa' COLLATE 'utf8_general_ci',
	`Muerteneo_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mortinato / muerte neonatal' COLLATE 'utf8_general_ci',
	`Pdificil_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'T.P. prolongado / parto dificil' COLLATE 'utf8_general_ci',
	`Notas_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Observaciones' COLLATE 'utf8_general_ci',
	`C011_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T1' COLLATE 'utf8_general_ci',
	`C012_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T2' COLLATE 'utf8_general_ci',
	`C013_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T3' COLLATE 'utf8_general_ci',
	`C021_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T1' COLLATE 'utf8_general_ci',
	`C022_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T2' COLLATE 'utf8_general_ci',
	`C023_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T3' COLLATE 'utf8_general_ci',
	`C031_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T1' COLLATE 'utf8_general_ci',
	`C032_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T2' COLLATE 'utf8_general_ci',
	`C033_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T3' COLLATE 'utf8_general_ci',
	`C041_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T1' COLLATE 'utf8_general_ci',
	`C042_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T2' COLLATE 'utf8_general_ci',
	`C043_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T3' COLLATE 'utf8_general_ci',
	`C051_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T1' COLLATE 'utf8_general_ci',
	`C052_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T2' COLLATE 'utf8_general_ci',
	`C053_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T3' COLLATE 'utf8_general_ci',
	`C061_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T1' COLLATE 'utf8_general_ci',
	`C062_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T2' COLLATE 'utf8_general_ci',
	`C063_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T3' COLLATE 'utf8_general_ci',
	`C071_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T1' COLLATE 'utf8_general_ci',
	`C072_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T2' COLLATE 'utf8_general_ci',
	`C073_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T3' COLLATE 'utf8_general_ci',
	`C081_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T1' COLLATE 'utf8_general_ci',
	`C082_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T2' COLLATE 'utf8_general_ci',
	`C083_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T3' COLLATE 'utf8_general_ci',
	`C091_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T1' COLLATE 'utf8_general_ci',
	`C092_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T2' COLLATE 'utf8_general_ci',
	`C093_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T3' COLLATE 'utf8_general_ci',
	`C101_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T1' COLLATE 'utf8_general_ci',
	`C102_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T2' COLLATE 'utf8_general_ci',
	`C103_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T3' COLLATE 'utf8_general_ci',
	`C111_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T1' COLLATE 'utf8_general_ci',
	`C112_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T2' COLLATE 'utf8_general_ci',
	`C113_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T3' COLLATE 'utf8_general_ci',
	`C121_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T1' COLLATE 'utf8_general_ci',
	`C122_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T2' COLLATE 'utf8_general_ci',
	`C123_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T3' COLLATE 'utf8_general_ci',
	`C131_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T1' COLLATE 'utf8_general_ci',
	`C132_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T2' COLLATE 'utf8_general_ci',
	`C133_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T3' COLLATE 'utf8_general_ci',
	`C141_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T1' COLLATE 'utf8_general_ci',
	`C142_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T2' COLLATE 'utf8_general_ci',
	`C143_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T3' COLLATE 'utf8_general_ci',
	`E011_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T1' COLLATE 'utf8_general_ci',
	`E012_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T2' COLLATE 'utf8_general_ci',
	`E013_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T3' COLLATE 'utf8_general_ci',
	`E021_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T1' COLLATE 'utf8_general_ci',
	`E022_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T2' COLLATE 'utf8_general_ci',
	`E023_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T3' COLLATE 'utf8_general_ci',
	`E031_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T1' COLLATE 'utf8_general_ci',
	`E032_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T2' COLLATE 'utf8_general_ci',
	`E033_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T3' COLLATE 'utf8_general_ci',
	`E041_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T1' COLLATE 'utf8_general_ci',
	`E042_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T2' COLLATE 'utf8_general_ci',
	`E043_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T3' COLLATE 'utf8_general_ci',
	`E051_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T1' COLLATE 'utf8_general_ci',
	`E052_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T2' COLLATE 'utf8_general_ci',
	`E053_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T3' COLLATE 'utf8_general_ci',
	`E061_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T1' COLLATE 'utf8_general_ci',
	`E062_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T2' COLLATE 'utf8_general_ci',
	`E063_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T3' COLLATE 'utf8_general_ci',
	`E071_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T1' COLLATE 'utf8_general_ci',
	`E072_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T2' COLLATE 'utf8_general_ci',
	`E073_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T3' COLLATE 'utf8_general_ci',
	`E081_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T1' COLLATE 'utf8_general_ci',
	`E082_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T2' COLLATE 'utf8_general_ci',
	`E083_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T3' COLLATE 'utf8_general_ci',
	`E091_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T1' COLLATE 'utf8_general_ci',
	`E092_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T2' COLLATE 'utf8_general_ci',
	`E093_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T3' COLLATE 'utf8_general_ci',
	`E101_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T1' COLLATE 'utf8_general_ci',
	`E102_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T2' COLLATE 'utf8_general_ci',
	`E103_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T3' COLLATE 'utf8_general_ci',
	`E111_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T1' COLLATE 'utf8_general_ci',
	`E112_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T2' COLLATE 'utf8_general_ci',
	`E113_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T3' COLLATE 'utf8_general_ci',
	`E121_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T1' COLLATE 'utf8_general_ci',
	`E122_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T2' COLLATE 'utf8_general_ci',
	`E123_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T3' COLLATE 'utf8_general_ci',
	`Punt1T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 1',
	`Riesgo1T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 1' COLLATE 'utf8_general_ci',
	`Punt2T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 2',
	`Riesgo2T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 2' COLLATE 'utf8_general_ci',
	`Punt3T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 3',
	`Riesgo3T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 3' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Riesgo Obstetrico'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `hcembactual` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Planeado_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazado Planeado' COLLATE 'utf8_general_ci',
	`Metantc_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Fracaso de metodo anticonceptivo' COLLATE 'utf8_general_ci',
	`Multiple_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazo multiple' COLLATE 'utf8_general_ci',
	`Pesoprev_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Peso Previo',
	`Talla_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Talla',
	`IMC_HCA` INT(11) NULL DEFAULT NULL COMMENT 'I.M.C.',
	`FUR_HCA` DATE NULL DEFAULT '0000-00-00' COMMENT 'F.U.R.',
	`Dudas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Dudas' COLLATE 'utf8_general_ci',
	`FPP_HCA` DATE NULL DEFAULT '0000-00-00' COMMENT 'Fecha probable parto',
	`Antitetan_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Antitetanica previa' COLLATE 'utf8_general_ci',
	`FAntitetan_HCA` DATE NULL DEFAULT '0000-00-00' COMMENT 'Fecha',
	`Intergen_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Periodo intergenesico < 12 meses' COLLATE 'utf8_general_ci',
	`Gsangre_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Grupo sanguineo' COLLATE 'utf8_general_ci',
	`RH_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Factor Rh' COLLATE 'utf8_general_ci',
	`RHSensible_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sensiblizacion Rh' COLLATE 'utf8_general_ci',
	`PreVIH_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consejeria Pre-Test VIH' COLLATE 'utf8_general_ci',
	`Lacmat_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consejeria en lactancia materna' COLLATE 'utf8_general_ci',
	`Edadgest_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Edad gestacional confirmada por' COLLATE 'utf8_general_ci',
	`Numgest_HCA` INT(11) NULL DEFAULT '0' COMMENT 'Numero de gestacion',
	`Fuma_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fuma' COLLATE 'utf8_general_ci',
	`Cigarr_HCA` INT(11) NULL DEFAULT '0' COMMENT 'Cigarrillos dia',
	`Fumpas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fumadora pasiva' COLLATE 'utf8_general_ci',
	`Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Alcohol' COLLATE 'utf8_general_ci',
	`Drogas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Drogas' COLLATE 'utf8_general_ci',
	`Notas_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Observaciones' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Embarazo Actual'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

ALTER TABLE `czradicacionesdet`
	ADD CONSTRAINT `FK_czradicacionesdet_gxfacturas` FOREIGN KEY (`Codigo_FAC`) REFERENCES `gxfacturas` (`Codigo_FAC`) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `czradicacionescab`
	ADD INDEX `Codigo_PLA` (`Codigo_PLA`),
	ADD INDEX `FechaIni_RAD_FechaFin_RAD` (`FechaIni_RAD`, `FechaFin_RAD`);
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v \r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', a.FechaNac_PAC AS \'FEC. NAC.\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case c.Atiende_CIT when \'1\' then \'ATENDIDO\' when \'0\' then \'NO ASISTE\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v \r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
UPDATE `gnx_ircips`.`itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case w.Codigo_HCF when isnull then \'NO ATENDIDO\' ELSE \'ATENDIDO\' END) END) AS \'ESTADO\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, gxagendacab b, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v, gxcitasmedicas c LEFT JOIN hcfolios w ON w.Codigo_TER=c.Codigo_TER AND w.Fecha_HCF=c.Fecha_AGE \r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
ALTER TABLE `hcant_personales`
	CHANGE COLUMN `Patologia_HCA` `Patologia_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Patologicos' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Farmacos_HCA` `Farmacos_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Farmacologicos' COLLATE 'utf8_general_ci' AFTER `Patologia_HCA`,
	CHANGE COLUMN `Quirurgico_HCA` `Quirurgico_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Quirurgicos' COLLATE 'utf8_general_ci' AFTER `Farmacos_HCA`,
	CHANGE COLUMN `Trauma_HCA` `Trauma_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Traumatologicos' COLLATE 'utf8_general_ci' AFTER `Quirurgico_HCA`,
	CHANGE COLUMN `TBC_HCA` `TBC_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'TBC' COLLATE 'utf8_general_ci' AFTER `Trauma_HCA`,
	CHANGE COLUMN `Diabetes_HCA` `Diabetes_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes' COLLATE 'utf8_general_ci' AFTER `TBC_HCA`,
	CHANGE COLUMN `HTA_HCA` `HTA_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hipertension' COLLATE 'utf8_general_ci' AFTER `Diabetes_HCA`,
	CHANGE COLUMN `Preclamsia_HCA` `Preclamsia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Preclamsia' COLLATE 'utf8_general_ci' AFTER `HTA_HCA`,
	CHANGE COLUMN `Eclamsia_HCA` `Eclamsia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Eclamsia' COLLATE 'utf8_general_ci' AFTER `Preclamsia_HCA`,
	CHANGE COLUMN `Qxpelvica_HCA` `Qxpelvica_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cirugia Pelvica' COLLATE 'utf8_general_ci' AFTER `Eclamsia_HCA`,
	CHANGE COLUMN `Infertilidad_HCA` `Infertilidad_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Infertilidad' COLLATE 'utf8_general_ci' AFTER `Qxpelvica_HCA`,
	CHANGE COLUMN `VIH_HCA` `VIH_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'VIH+' COLLATE 'utf8_general_ci' AFTER `Infertilidad_HCA`,
	CHANGE COLUMN `Cardiopatia_HCA` `Cardiopatia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cardiopatia' COLLATE 'utf8_general_ci' AFTER `VIH_HCA`,
	CHANGE COLUMN `Nefropatia_HCA` `Nefropatia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Nefropatia' COLLATE 'utf8_general_ci' AFTER `Cardiopatia_HCA`,
	CHANGE COLUMN `Mola_HCA` `Mola_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mola' COLLATE 'utf8_general_ci' AFTER `Nefropatia_HCA`,
	CHANGE COLUMN `Embectopico_HCA` `Embectopico_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazo Ectopico' COLLATE 'utf8_general_ci' AFTER `Mola_HCA`,
	CHANGE COLUMN `Cifoescoliosis_HCA` `Cifoescoliosis_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cifoescoliosis' COLLATE 'utf8_general_ci' AFTER `Embectopico_HCA`,
	CHANGE COLUMN `Asma_HCA` `Asma_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Asma' COLLATE 'utf8_general_ci' AFTER `Cifoescoliosis_HCA`,
	CHANGE COLUMN `ETS_HCA` `ETS_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Antecedentes de ETS	' COLLATE 'utf8_general_ci' AFTER `Asma_HCA`,
	CHANGE COLUMN `Rinitis_HCA` `Rinitis_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Rinitis' COLLATE 'utf8_general_ci' AFTER `ETS_HCA`,
	CHANGE COLUMN `Conmedgrave_HCA` `Conmedgrave_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Condicion medica grave' COLLATE 'utf8_general_ci' AFTER `Rinitis_HCA`;
ALTER TABLE `hcant_toxicologico`
	CHANGE COLUMN `Fumador_HCA` `Fumador_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fumador / Ex-fumador' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Cigarrdia_HCA` `Cigarrdia_HCA` INT(11) NULL DEFAULT '0' COMMENT 'Cigarrillos al dia' AFTER `Fumador_HCA`,
	CHANGE COLUMN `Anyosfum_HCA` `Anyosfum_HCA` INT(11) NULL DEFAULT '0' COMMENT 'Años fumando' AFTER `Cigarrdia_HCA`,
	CHANGE COLUMN `Paqanyofum_HCA` `Paqanyofum_HCA` INT(11) NULL DEFAULT '0' COMMENT 'Paquetes / Año' AFTER `Anyosfum_HCA`,
	CHANGE COLUMN `Alcohol_HCA` `Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Alcohol' COLLATE 'utf8_general_ci' AFTER `Paqanyofum_HCA`,
	CHANGE COLUMN `Estimula_HCA` `Estimula_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Estmulantes' COLLATE 'utf8_general_ci' AFTER `Alcohol_HCA`,
	CHANGE COLUMN `Otrosanttx_HCA` `Otrosanttx_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Otros Antecedentes  Toxicologicos' COLLATE 'utf8_general_ci' AFTER `Estimula_HCA`;
ALTER TABLE `hcant_alergico`
	CHANGE COLUMN `Alimentos_HCA` `Alimentos_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Alimentos' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Antibioti_HCA` `Antibioti_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Antibioticos' COLLATE 'utf8_general_ci' AFTER `Alimentos_HCA`,
	CHANGE COLUMN `Ambiente_HCA` `Ambiente_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Ambientales	' COLLATE 'utf8_general_ci' AFTER `Antibioti_HCA`,
	CHANGE COLUMN `Otrosalerg_HCA` `Otrosalerg_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Otros ant. alergicos	' COLLATE 'utf8_general_ci' AFTER `Ambiente_HCA`;
ALTER TABLE `hcant_familiar`
	CHANGE COLUMN `fTBC_HCA` `fTBC_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'TBC' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `fDiabetes_HCA` `fDiabetes_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabates' COLLATE 'utf8_general_ci' AFTER `fTBC_HCA`,
	CHANGE COLUMN `fHTA_HCA` `fHTA_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hipertension' COLLATE 'utf8_general_ci' AFTER `fDiabetes_HCA`,
	CHANGE COLUMN `fPreclamsia_HCA` `fPreclamsia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Preclamsia' COLLATE 'utf8_general_ci' AFTER `fHTA_HCA`,
	CHANGE COLUMN `fEclamsia_HCA` `fEclamsia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Eclamsia' COLLATE 'utf8_general_ci' AFTER `fPreclamsia_HCA`,
	CHANGE COLUMN `fCancervix_HCA` `fCancervix_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Cancer de cervix	' COLLATE 'utf8_general_ci' AFTER `fEclamsia_HCA`,
	CHANGE COLUMN `fOtrocanc_HCA` `fOtrocanc_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Otro tipo de cancer' COLLATE 'utf8_general_ci' AFTER `fCancervix_HCA`,
	CHANGE COLUMN `Otrfam_HCA` `Otrfam_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Otros ant. familiares	' COLLATE 'utf8_general_ci' AFTER `fOtrocanc_HCA`,
	CHANGE COLUMN `Otrfimp_HCA` `Otrfimp_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Otos ant. importantes' COLLATE 'utf8_general_ci' AFTER `Otrfam_HCA`;
ALTER TABLE `hcant_ginecobst`
	CHANGE COLUMN `gGravindez_HCA` `gGravindez_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Gravidez' AFTER `Codigo_HCF`,
	CHANGE COLUMN `gPartos_HCA` `gPartos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Partos' AFTER `gGravindez_HCA`,
	CHANGE COLUMN `gVaginal_HCA` `gVaginal_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Vaginales' AFTER `gPartos_HCA`,
	CHANGE COLUMN `gCesareas_HCA` `gCesareas_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Cesareas' AFTER `gVaginal_HCA`,
	CHANGE COLUMN `gAbortos_HCA` `gAbortos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Abortos' AFTER `gCesareas_HCA`,
	CHANGE COLUMN `gEctopicos_HCA` `gEctopicos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Ectopicos' AFTER `gAbortos_HCA`,
	CHANGE COLUMN `gNvivos_HCA` `gNvivos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Nacidos Vivos' AFTER `gEctopicos_HCA`,
	CHANGE COLUMN `gNmuertos_HCA` `gNmuertos_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Nacidos Muertos' AFTER `gNvivos_HCA`,
	CHANGE COLUMN `gViven_HCA` `gViven_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Viven' AFTER `gNmuertos_HCA`,
	CHANGE COLUMN `gNmuertossem1_HCA` `gNmuertossem1_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Muertos Semana 1' AFTER `gViven_HCA`,
	CHANGE COLUMN `gNmuertossem2_HCA` `gNmuertossem2_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Muertos mas de 1 semana	' AFTER `gNmuertossem1_HCA`,
	CHANGE COLUMN `gPesomenor_HCA` `gPesomenor_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Nacido peso menor 2500gr' COLLATE 'utf8_general_ci' AFTER `gNmuertossem2_HCA`,
	CHANGE COLUMN `gMenarca_HCA` `gMenarca_HCA` TEXT(65535) NULL DEFAULT NULL COMMENT 'Menarca' COLLATE 'utf8_general_ci' AFTER `gPesomenor_HCA`,
	CHANGE COLUMN `gMenopausia_HCA` `gMenopausia_HCA` TEXT(65535) NULL DEFAULT NULL COMMENT 'Menopausia' COLLATE 'utf8_general_ci' AFTER `gMenarca_HCA`,
	CHANGE COLUMN `gFUM_HCA` `gFUM_HCA` DATE NULL DEFAULT NULL COMMENT 'F.U.M.	' AFTER `gMenopausia_HCA`,
	CHANGE COLUMN `gFUP_HCA` `gFUP_HCA` DATE NULL DEFAULT NULL COMMENT 'F.U.P.	' AFTER `gFUM_HCA`,
	CHANGE COLUMN `gFUC_HCA` `gFUC_HCA` DATE NULL DEFAULT NULL COMMENT 'Ultima citologia	' AFTER `gFUP_HCA`,
	CHANGE COLUMN `gCitologia_HCA` `gCitologia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Resultado citologia' COLLATE 'utf8_general_ci' AFTER `gFUC_HCA`,
	CHANGE COLUMN `gRelsex_HCA` `gRelsex_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inicio rel. sexuales' COLLATE 'utf8_general_ci' AFTER `gCitologia_HCA`,
	CHANGE COLUMN `gCiclosmenst_HCA` `gCiclosmenst_HCA` TEXT(65535) NULL DEFAULT NULL COMMENT 'Ciclos menstruales' COLLATE 'utf8_general_ci' AFTER `gRelsex_HCA`,
	CHANGE COLUMN `gActsex_HCA` `gActsex_HCA` TEXT(65535) NULL DEFAULT NULL COMMENT 'Actividad sexual' COLLATE 'utf8_general_ci' AFTER `gCiclosmenst_HCA`,
	CHANGE COLUMN `gMetplanif_HCA` `gMetplanif_HCA` CHAR(1) NULL DEFAULT NULL COMMENT 'Metodo de planificacion' COLLATE 'utf8_general_ci' AFTER `gActsex_HCA`;
ALTER TABLE `hcant_ginecobst`
	CHANGE COLUMN `gCitologia_HCA` `gCitologia_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Resultado citologia' COLLATE 'utf8_general_ci' AFTER `gFUC_HCA`,
	CHANGE COLUMN `gMetplanif_HCA` `gMetplanif_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Metodo de planificacion	' COLLATE 'utf8_general_ci' AFTER `gActsex_HCA`;
ALTER TABLE `hcant_ginecobst`
	CHANGE COLUMN `gRelsex_HCA` `gRelsex_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inicio rel. sexuales' COLLATE 'utf8_general_ci' AFTER `gFUC_HCA`;
ALTER TABLE `hcidriesgoesp`
	CHANGE COLUMN `Sospcancer_HCA` `Sospcancer_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sospecha de cancer' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Sangheces_HCA` `Sangheces_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sangre oculta en heces' COLLATE 'utf8_general_ci' AFTER `Sospcancer_HCA`,
	CHANGE COLUMN `Sintresp_HCA` `Sintresp_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sintomatico respiratorio' COLLATE 'utf8_general_ci' AFTER `Sangheces_HCA`,
	CHANGE COLUMN `Maltrato_HCA` `Maltrato_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mujer o menor victima maltrato' COLLATE 'utf8_general_ci' AFTER `Sintresp_HCA`,
	CHANGE COLUMN `Vsexual_HCA` `Vsexual_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Victima de violencia sexual' COLLATE 'utf8_general_ci' AFTER `Maltrato_HCA`,
	CHANGE COLUMN `Previh_HCA` `Previh_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Pre test de VIH' COLLATE 'utf8_general_ci' AFTER `Vsexual_HCA`,
	CHANGE COLUMN `Pstvih_HCA` `Pstvih_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Post test de VIH' COLLATE 'utf8_general_ci' AFTER `Previh_HCA`;
CREATE TABLE `hcriegocv` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Tabaquismo_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Obesidad_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Sedentarismo_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Estress_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Consumosal_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Consumograsa_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Sobrepeso_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Dislipidemia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Observaciones_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Riesgo CardioVascular'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcriegocv`
	CHANGE COLUMN `Observaciones_HCA` `Observaciones_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Dislipidemia_HCA`;
ALTER TABLE `hcriegocv`
	CHANGE COLUMN `Tabaquismo_HCA` `Tabaquismo_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tabaquismo' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Alcohol_HCA` `Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Alcohol' COLLATE 'utf8_general_ci' AFTER `Tabaquismo_HCA`,
	CHANGE COLUMN `Obesidad_HCA` `Obesidad_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Obesidad' COLLATE 'utf8_general_ci' AFTER `Alcohol_HCA`,
	CHANGE COLUMN `Sedentarismo_HCA` `Sedentarismo_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sedentarismo' COLLATE 'utf8_general_ci' AFTER `Obesidad_HCA`,
	CHANGE COLUMN `Estress_HCA` `Estress_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Estress' COLLATE 'utf8_general_ci' AFTER `Sedentarismo_HCA`,
	CHANGE COLUMN `Consumosal_HCA` `Consumosal_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consumo de sal' COLLATE 'utf8_general_ci' AFTER `Estress_HCA`,
	CHANGE COLUMN `Consumograsa_HCA` `Consumograsa_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consumo de grasa' COLLATE 'utf8_general_ci' AFTER `Consumosal_HCA`,
	CHANGE COLUMN `Sobrepeso_HCA` `Sobrepeso_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sobrepeso' COLLATE 'utf8_general_ci' AFTER `Consumograsa_HCA`,
	CHANGE COLUMN `Dislipidemia_HCA` `Dislipidemia_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Dislipidemia' COLLATE 'utf8_general_ci' AFTER `Sobrepeso_HCA`,
	CHANGE COLUMN `Observaciones_HCA` `Observaciones_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Observaciones' COLLATE 'utf8_general_ci' AFTER `Dislipidemia_HCA`;
ALTER TABLE `hcembactual`
	CHANGE COLUMN `Planeado_HCA` `Planeado_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazado Planeado' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Metantc_HCA` `Metantc_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Fracaso de metodo anticonceptivo' COLLATE 'utf8_general_ci' AFTER `Planeado_HCA`,
	CHANGE COLUMN `Multiple_HCA` `Multiple_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazo multiple' COLLATE 'utf8_general_ci' AFTER `Metantc_HCA`,
	CHANGE COLUMN `Pesoprev_HCA` `Pesoprev_HCA` INT NULL DEFAULT NULL COMMENT 'Peso Previo' COLLATE 'utf8_general_ci' AFTER `Multiple_HCA`,
	CHANGE COLUMN `Talla_HCA` `Talla_HCA` INT NULL DEFAULT NULL COMMENT 'Talla' COLLATE 'utf8_general_ci' AFTER `Pesoprev_HCA`,
	CHANGE COLUMN `IMC_HCA` `IMC_HCA` INT NULL DEFAULT NULL COMMENT 'I.M.C.' COLLATE 'utf8_general_ci' AFTER `Talla_HCA`,
	CHANGE COLUMN `FUR_HCA` `FUR_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'F.U.R.' COLLATE 'utf8_general_ci' AFTER `IMC_HCA`,
	CHANGE COLUMN `Dudas_HCA` `Dudas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Dudas' COLLATE 'utf8_general_ci' AFTER `FUR_HCA`,
	CHANGE COLUMN `FPP_HCA` `FPP_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fecha probable parto' COLLATE 'utf8_general_ci' AFTER `Dudas_HCA`,
	CHANGE COLUMN `Antitetan_HCA` `Antitetan_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Antitetanica previa' COLLATE 'utf8_general_ci' AFTER `FPP_HCA`,
	CHANGE COLUMN `FAntitetan_HCA` `FAntitetan_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fecha' COLLATE 'utf8_general_ci' AFTER `Antitetan_HCA`,
	CHANGE COLUMN `Intergen_HCA` `Intergen_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Periodo intergenesico < 12 meses' COLLATE 'utf8_general_ci' AFTER `FAntitetan_HCA`,
	CHANGE COLUMN `Gsangre_HCA` `Gsangre_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Grupo sanguineo' COLLATE 'utf8_general_ci' AFTER `Intergen_HCA`,
	CHANGE COLUMN `RH_HCA` `RH_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Factor Rh' COLLATE 'utf8_general_ci' AFTER `Gsangre_HCA`,
	CHANGE COLUMN `RHSensible_HCA` `RHSensible_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sensiblizacion Rh' COLLATE 'utf8_general_ci' AFTER `RH_HCA`,
	CHANGE COLUMN `PreVIH_HCA` `PreVIH_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consejeria Pre-Test VIH' COLLATE 'utf8_general_ci' AFTER `RHSensible_HCA`,
	CHANGE COLUMN `Lacmat_HCA` `Lacmat_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Consejeria en lactancia materna' COLLATE 'utf8_general_ci' AFTER `PreVIH_HCA`,
	CHANGE COLUMN `Edadgest_HCA` `Edadgest_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Edad gestacional confirmada por' COLLATE 'utf8_general_ci' AFTER `Lacmat_HCA`,
	CHANGE COLUMN `Numgest_HCA` `Numgest_HCA` INT NULL DEFAULT '0' COMMENT 'Numero de gestacion' COLLATE 'utf8_general_ci' AFTER `Edadgest_HCA`,
	CHANGE COLUMN `Fuma_HCA` `Fuma_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fuma' COLLATE 'utf8_general_ci' AFTER `Numgest_HCA`,
	CHANGE COLUMN `Cigarr_HCA` `Cigarr_HCA` INT NULL DEFAULT '0' COMMENT 'Cigarrillos dia' COLLATE 'utf8_general_ci' AFTER `Fuma_HCA`,
	CHANGE COLUMN `Fumpas_HCA` `Fumpas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Fumadora pasiva' COLLATE 'utf8_general_ci' AFTER `Cigarr_HCA`,
	CHANGE COLUMN `Alcohol_HCA` `Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Alcohol' COLLATE 'utf8_general_ci' AFTER `Fumpas_HCA`,
	CHANGE COLUMN `Drogas_HCA` `Drogas_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Drogas' COLLATE 'utf8_general_ci' AFTER `Alcohol_HCA`,
	CHANGE COLUMN `Notas_HCA` `Notas_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Observaciones' COLLATE 'utf8_general_ci' AFTER `Drogas_HCA`;
ALTER TABLE `hcembactual`
	CHANGE COLUMN `Edadgest_HCA` `Edadgest_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Edad gestacional confirmada por' COLLATE 'utf8_general_ci' AFTER `Lacmat_HCA`;
ALTER TABLE `hcembactual`
	CHANGE COLUMN `FUR_HCA` `FUR_HCA` DATE NULL DEFAULT '0' COMMENT 'F.U.R.' COLLATE 'utf8_general_ci' AFTER `IMC_HCA`,
	CHANGE COLUMN `FPP_HCA` `FPP_HCA` DATE NULL DEFAULT '0' COMMENT 'Fecha probable parto' COLLATE 'utf8_general_ci' AFTER `Dudas_HCA`,
	CHANGE COLUMN `FAntitetan_HCA` `FAntitetan_HCA` DATE NULL DEFAULT '0' COMMENT 'Fecha' COLLATE 'utf8_general_ci' AFTER `Antitetan_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `Edad_HCA` `Edad_HCA` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Notas_HCA` `Notas_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Pdificil_HCA`,
	CHANGE COLUMN `Punt1T_HCA` `Punt1T_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `E123_HCA`,
	CHANGE COLUMN `Riesgo1T_HCA` `Riesgo1T_HCA` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Punt1T_HCA`,
	CHANGE COLUMN `Punt2T_HCA` `Punt2T_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Riesgo1T_HCA`,
	CHANGE COLUMN `Riesgo2T_HCA` `Riesgo2T_HCA` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Punt2T_HCA`,
	CHANGE COLUMN `Punt3T_HCA` `Punt3T_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Riesgo2T_HCA`,
	CHANGE COLUMN `Riesgo3T_HCA` `Riesgo3T_HCA` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Punt3T_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `Punt1T_HCA` `Punt1T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 1' AFTER `E123_HCA`,
	CHANGE COLUMN `Riesgo1T_HCA` `Riesgo1T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 1' COLLATE 'utf8_general_ci' AFTER `Punt1T_HCA`,
	CHANGE COLUMN `Punt2T_HCA` `Punt2T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 2' AFTER `Riesgo1T_HCA`,
	CHANGE COLUMN `Riesgo2T_HCA` `Riesgo2T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 2' COLLATE 'utf8_general_ci' AFTER `Punt2T_HCA`,
	CHANGE COLUMN `Punt3T_HCA` `Punt3T_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Puntaje Trimestre 3' AFTER `Riesgo2T_HCA`,
	CHANGE COLUMN `Riesgo3T_HCA` `Riesgo3T_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Riesgo Trimestre 3' COLLATE 'utf8_general_ci' AFTER `Punt3T_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `Edad_HCA` `Edad_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Edad' COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `Paridad_HCA` `Paridad_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Paridad' COLLATE 'utf8_general_ci' AFTER `Edad_HCA`,
	CHANGE COLUMN `Aborto_HCA` `Aborto_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Aborto habitual / infertilidad' COLLATE 'utf8_general_ci' AFTER `Paridad_HCA`,
	CHANGE COLUMN `RetPlac_HCA` `RetPlac_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Retencion placentaria' COLLATE 'utf8_general_ci' AFTER `Aborto_HCA`,
	CHANGE COLUMN `Rnmayor_HCA` `Rnmayor_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Recien nacido > 4000 gr	' COLLATE 'utf8_general_ci' AFTER `RetPlac_HCA`,
	CHANGE COLUMN `Rnmenor_HCA` `Rnmenor_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Recien nacido < 2500 gr' COLLATE 'utf8_general_ci' AFTER `Rnmayor_HCA`,
	CHANGE COLUMN `HTA_HCA` `HTA_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por embarazo' COLLATE 'utf8_general_ci' AFTER `Rnmenor_HCA`,
	CHANGE COLUMN `Gemelar_HCA` `Gemelar_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Embarazo gemelar' COLLATE 'utf8_general_ci' AFTER `HTA_HCA`,
	CHANGE COLUMN `Cesprev_HCA` `Cesprev_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Cesarea previa' COLLATE 'utf8_general_ci' AFTER `Gemelar_HCA`,
	CHANGE COLUMN `Muerteneo_HCA` `Muerteneo_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mortinato / muerte neonatal' COLLATE 'utf8_general_ci' AFTER `Cesprev_HCA`,
	CHANGE COLUMN `Pdificil_HCA` `Pdificil_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'T.P. prolongado / parto dificil' COLLATE 'utf8_general_ci' AFTER `Muerteneo_HCA`,
	CHANGE COLUMN `Notas_HCA` `Notas_HCA` MEDIUMTEXT NULL DEFAULT NULL COMMENT 'Observaciones' COLLATE 'utf8_general_ci' AFTER `Pdificil_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `C011_HCA` `C011_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T1' COLLATE 'utf8_general_ci' AFTER `Notas_HCA`,
	CHANGE COLUMN `C012_HCA` `C012_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T2' COLLATE 'utf8_general_ci' AFTER `C011_HCA`,
	CHANGE COLUMN `C013_HCA` `C013_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Qx. gineco. previa / ectopico T3' COLLATE 'utf8_general_ci' AFTER `C012_HCA`,
	CHANGE COLUMN `C021_HCA` `C021_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T1' COLLATE 'utf8_general_ci' AFTER `C013_HCA`,
	CHANGE COLUMN `C022_HCA` `C022_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T2' COLLATE 'utf8_general_ci' AFTER `C021_HCA`,
	CHANGE COLUMN `C023_HCA` `C023_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. renal cronica T3' COLLATE 'utf8_general_ci' AFTER `C022_HCA`,
	CHANGE COLUMN `C031_HCA` `C031_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T1' COLLATE 'utf8_general_ci' AFTER `C023_HCA`,
	CHANGE COLUMN `C032_HCA` `C032_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T2' COLLATE 'utf8_general_ci' AFTER `C031_HCA`,
	CHANGE COLUMN `C033_HCA` `C033_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes gestacional T3' COLLATE 'utf8_general_ci' AFTER `C032_HCA`,
	CHANGE COLUMN `C041_HCA` `C041_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T1' COLLATE 'utf8_general_ci' AFTER `C033_HCA`,
	CHANGE COLUMN `C042_HCA` `C042_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T2' COLLATE 'utf8_general_ci' AFTER `C041_HCA`,
	CHANGE COLUMN `C043_HCA` `C043_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Diabetes mellitus T3' COLLATE 'utf8_general_ci' AFTER `C042_HCA`,
	CHANGE COLUMN `C051_HCA` `C051_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T1' COLLATE 'utf8_general_ci' AFTER `C043_HCA`,
	CHANGE COLUMN `C052_HCA` `C052_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T2' COLLATE 'utf8_general_ci' AFTER `C051_HCA`,
	CHANGE COLUMN `C053_HCA` `C053_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. cardiaca T3' COLLATE 'utf8_general_ci' AFTER `C052_HCA`,
	CHANGE COLUMN `C061_HCA` `C061_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T1' COLLATE 'utf8_general_ci' AFTER `C053_HCA`,
	CHANGE COLUMN `C062_HCA` `C062_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T2' COLLATE 'utf8_general_ci' AFTER `C061_HCA`,
	CHANGE COLUMN `C063_HCA` `C063_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. infec. aguda (bectaria) T3' COLLATE 'utf8_general_ci' AFTER `C062_HCA`,
	CHANGE COLUMN `C071_HCA` `C071_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T1' COLLATE 'utf8_general_ci' AFTER `C063_HCA`,
	CHANGE COLUMN `C072_HCA` `C072_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T2' COLLATE 'utf8_general_ci' AFTER `C071_HCA`,
	CHANGE COLUMN `C073_HCA` `C073_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Enf. autoinmune T3' COLLATE 'utf8_general_ci' AFTER `C072_HCA`,
	CHANGE COLUMN `C081_HCA` `C081_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T1' COLLATE 'utf8_general_ci' AFTER `C073_HCA`,
	CHANGE COLUMN `C082_HCA` `C082_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T2' COLLATE 'utf8_general_ci' AFTER `C081_HCA`,
	CHANGE COLUMN `C083_HCA` `C083_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Anemia (Hb < 10 g/L) T3' COLLATE 'utf8_general_ci' AFTER `C082_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `C091_HCA` `C091_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T1' COLLATE 'utf8_general_ci' AFTER `C083_HCA`,
	CHANGE COLUMN `C092_HCA` `C092_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T2' COLLATE 'utf8_general_ci' AFTER `C091_HCA`,
	CHANGE COLUMN `C093_HCA` `C093_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Tensión emocional intensa T3' COLLATE 'utf8_general_ci' AFTER `C092_HCA`,
	CHANGE COLUMN `C101_HCA` `C101_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T1' COLLATE 'utf8_general_ci' AFTER `C093_HCA`,
	CHANGE COLUMN `C102_HCA` `C102_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T2' COLLATE 'utf8_general_ci' AFTER `C101_HCA`,
	CHANGE COLUMN `C103_HCA` `C103_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Humor depresivo intenso T3' COLLATE 'utf8_general_ci' AFTER `C102_HCA`,
	CHANGE COLUMN `C111_HCA` `C111_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T1' COLLATE 'utf8_general_ci' AFTER `C103_HCA`,
	CHANGE COLUMN `C112_HCA` `C112_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T2' COLLATE 'utf8_general_ci' AFTER `C111_HCA`,
	CHANGE COLUMN `C113_HCA` `C113_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sínt. neurovegetativos intensos T3' COLLATE 'utf8_general_ci' AFTER `C112_HCA`,
	CHANGE COLUMN `C121_HCA` `C121_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T1' COLLATE 'utf8_general_ci' AFTER `C113_HCA`,
	CHANGE COLUMN `C122_HCA` `C122_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T2' COLLATE 'utf8_general_ci' AFTER `C121_HCA`,
	CHANGE COLUMN `C123_HCA` `C123_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (tiempo) T3' COLLATE 'utf8_general_ci' AFTER `C122_HCA`,
	CHANGE COLUMN `C131_HCA` `C131_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T1' COLLATE 'utf8_general_ci' AFTER `C123_HCA`,
	CHANGE COLUMN `C132_HCA` `C132_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T2' COLLATE 'utf8_general_ci' AFTER `C131_HCA`,
	CHANGE COLUMN `C133_HCA` `C133_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (espacio) T3' COLLATE 'utf8_general_ci' AFTER `C132_HCA`,
	CHANGE COLUMN `C141_HCA` `C141_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T1' COLLATE 'utf8_general_ci' AFTER `C133_HCA`,
	CHANGE COLUMN `C142_HCA` `C142_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T2' COLLATE 'utf8_general_ci' AFTER `C141_HCA`,
	CHANGE COLUMN `C143_HCA` `C143_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Sin soporte familiar (dinero) T3' COLLATE 'utf8_general_ci' AFTER `C142_HCA`,
	CHANGE COLUMN `E011_HCA` `E011_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T1' COLLATE 'utf8_general_ci' AFTER `C143_HCA`,
	CHANGE COLUMN `E012_HCA` `E012_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T2' COLLATE 'utf8_general_ci' AFTER `E011_HCA`,
	CHANGE COLUMN `E013_HCA` `E013_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia <= 20 Sem T3' COLLATE 'utf8_general_ci' AFTER `E012_HCA`,
	CHANGE COLUMN `E021_HCA` `E021_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T1' COLLATE 'utf8_general_ci' AFTER `E013_HCA`,
	CHANGE COLUMN `E022_HCA` `E022_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T2' COLLATE 'utf8_general_ci' AFTER `E021_HCA`,
	CHANGE COLUMN `E023_HCA` `E023_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Hemorragia > 20 Sem T3' COLLATE 'utf8_general_ci' AFTER `E022_HCA`,
	CHANGE COLUMN `E031_HCA` `E031_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T' COLLATE 'utf8_general_ci' AFTER `E023_HCA`;
ALTER TABLE `hcriegoobs`
	CHANGE COLUMN `E031_HCA` `E031_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T1' COLLATE 'utf8_general_ci' AFTER `E023_HCA`,
	CHANGE COLUMN `E032_HCA` `E032_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T2' COLLATE 'utf8_general_ci' AFTER `E031_HCA`,
	CHANGE COLUMN `E033_HCA` `E033_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'E. prolongado (42 Sem) T3' COLLATE 'utf8_general_ci' AFTER `E032_HCA`,
	CHANGE COLUMN `E041_HCA` `E041_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T1' COLLATE 'utf8_general_ci' AFTER `E033_HCA`,
	CHANGE COLUMN `E042_HCA` `E042_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T2' COLLATE 'utf8_general_ci' AFTER `E041_HCA`,
	CHANGE COLUMN `E043_HCA` `E043_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'HTA inducida por emb. T3' COLLATE 'utf8_general_ci' AFTER `E042_HCA`,
	CHANGE COLUMN `E051_HCA` `E051_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T1' COLLATE 'utf8_general_ci' AFTER `E043_HCA`,
	CHANGE COLUMN `E052_HCA` `E052_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T2' COLLATE 'utf8_general_ci' AFTER `E051_HCA`,
	CHANGE COLUMN `E053_HCA` `E053_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RPM T3' COLLATE 'utf8_general_ci' AFTER `E052_HCA`,
	CHANGE COLUMN `E061_HCA` `E061_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T1' COLLATE 'utf8_general_ci' AFTER `E053_HCA`,
	CHANGE COLUMN `E062_HCA` `E062_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T2' COLLATE 'utf8_general_ci' AFTER `E061_HCA`,
	CHANGE COLUMN `E063_HCA` `E063_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Polihidramnios T3' COLLATE 'utf8_general_ci' AFTER `E062_HCA`,
	CHANGE COLUMN `E071_HCA` `E071_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T1' COLLATE 'utf8_general_ci' AFTER `E063_HCA`,
	CHANGE COLUMN `E072_HCA` `E072_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T2' COLLATE 'utf8_general_ci' AFTER `E071_HCA`,
	CHANGE COLUMN `E073_HCA` `E073_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'RCIU T3' COLLATE 'utf8_general_ci' AFTER `E072_HCA`,
	CHANGE COLUMN `E081_HCA` `E081_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T1' COLLATE 'utf8_general_ci' AFTER `E073_HCA`,
	CHANGE COLUMN `E082_HCA` `E082_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T2' COLLATE 'utf8_general_ci' AFTER `E081_HCA`,
	CHANGE COLUMN `E083_HCA` `E083_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Emb multiple T3' COLLATE 'utf8_general_ci' AFTER `E082_HCA`,
	CHANGE COLUMN `E091_HCA` `E091_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T1' COLLATE 'utf8_general_ci' AFTER `E083_HCA`,
	CHANGE COLUMN `E092_HCA` `E092_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T2' COLLATE 'utf8_general_ci' AFTER `E091_HCA`,
	CHANGE COLUMN `E093_HCA` `E093_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Mala presentacion T3' COLLATE 'utf8_general_ci' AFTER `E092_HCA`,
	CHANGE COLUMN `E101_HCA` `E101_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T1' COLLATE 'utf8_general_ci' AFTER `E093_HCA`,
	CHANGE COLUMN `E102_HCA` `E102_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T2' COLLATE 'utf8_general_ci' AFTER `E101_HCA`,
	CHANGE COLUMN `E103_HCA` `E103_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Isoinmunizacion RH T3' COLLATE 'utf8_general_ci' AFTER `E102_HCA`,
	CHANGE COLUMN `E111_HCA` `E111_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T1' COLLATE 'utf8_general_ci' AFTER `E103_HCA`,
	CHANGE COLUMN `E112_HCA` `E112_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T2' COLLATE 'utf8_general_ci' AFTER `E111_HCA`,
	CHANGE COLUMN `E113_HCA` `E113_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Inf. de vias urinarias T3' COLLATE 'utf8_general_ci' AFTER `E112_HCA`,
	CHANGE COLUMN `E121_HCA` `E121_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T1' COLLATE 'utf8_general_ci' AFTER `E113_HCA`,
	CHANGE COLUMN `E122_HCA` `E122_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T2' COLLATE 'utf8_general_ci' AFTER `E121_HCA`,
	CHANGE COLUMN `E123_HCA` `E123_HCA` CHAR(1) NULL DEFAULT '0' COMMENT 'Amenaza parto prematuro T3' COLLATE 'utf8_general_ci' AFTER `E122_HCA`;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `FechaAnula_FAC` `FechaAnula_FAC` DATETIME NULL DEFAULT '0000-00-00 00:00:00' AFTER `UsuarioAnula_FAC`;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `Nota_FAC` `Nota_FAC` TEXT(65535) NULL COLLATE 'utf8_general_ci' AFTER `Tipo_FAC`;
UPDATE `hctipos` SET `Antecedentes_HCT`='0' WHERE  `Codigo_HCT`='HCPSC';
ALTER TABLE `gxcitasmedicas`
	CHANGE COLUMN `Hora_AGE` `Hora_AGE` TIME NOT NULL DEFAULT 0 COLLATE 'utf8_general_ci' AFTER `Fecha_AGE`;
ALTER TABLE `itconfig_hc`
	ADD COLUMN `ShowFechaADM_XHC` INT(11) NULL DEFAULT '1' COMMENT 'Mostrar fecha de admisión' AFTER `MonitorImagenDx_XHC`,
	ADD COLUMN `ShowHoraHCF_XHC` INT(11) NULL DEFAULT '1' COMMENT 'Mostrar Hora del folio' AFTER `ShowFechaADM_XHC`;
