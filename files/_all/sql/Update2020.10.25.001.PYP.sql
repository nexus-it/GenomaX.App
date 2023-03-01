-- NUEVO ENTERPRISE
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 20.11.10.001' ;
ALTER TABLE `itconfig_cx`
	ADD COLUMN `FechaHCCX_XCX` CHAR(1) NULL DEFAULT '0' COMMENT 'Fecha de la HC debe ser la misma de la agendada' AFTER `CitasWeb_XCX`;
UPDATE `hctipos` SET `Icono_HCT`='system_monitor' WHERE  `Codigo_HCT`='EKG';
UPDATE `hctipos` SET `Icono_HCT`='female' WHERE  `Codigo_HCT`='GNCOBST';
UPDATE `hctipos` SET `Icono_HCT`='1.Prescription' WHERE  `Codigo_HCT`='EVOL2';
UPDATE `hctipos` SET `Icono_HCT`='1.Prescription' WHERE  `Codigo_HCT`='HCESP01';
UPDATE `hctipos` SET `Icono_HCT`='1.Prescription' WHERE  `Codigo_HCT`='HCEV01';
UPDATE `hctipos` SET `Icono_HCT`='heart_add' WHERE  `Codigo_HCT`='HPRTSN';
UPDATE `hctipos` SET `Icono_HCT`='user_medical_female' WHERE  `Codigo_HCT`='ENFERMERIA';
UPDATE `hctipos` SET `Icono_HCT`='1.TestTubes' WHERE  `Codigo_HCT`='COOSTOMA01';
UPDATE `hctipos` SET `Icono_HCT`='1.BandAid' WHERE  `Codigo_HCT`='VALHER1';
UPDATE `hctipos` SET `Icono_HCT`='walk' WHERE  `Codigo_HCT`='TFIS1';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10211';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10209';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10210';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10207';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10208';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10206';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10204';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10205';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10202';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10203';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10220';
UPDATE `hctipos` SET `Icono_HCT`='phone_sound' WHERE  `Codigo_HCT`='COVID10219';
UPDATE `ititems` SET `Nombre_ITM`='Atender Pacientes Programados' WHERE  `Codigo_ITM`=444 AND `Codigo_MNU`=100 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;

UPDATE `itreports` SET `Page_RPT`='halfletter' WHERE  `Codigo_RPT`='citasprogramadasusuario' AND `Codigo_DCD`=0;
ALTER TABLE `hcembactual`
	CHANGE COLUMN `Pesoprev_HCA` `Pesoprev_HCA` DECIMAL(10,2) NULL DEFAULT NULL COMMENT 'Peso Previo' AFTER `Multiple_HCA`,
	CHANGE COLUMN `Talla_HCA` `Talla_HCA` DECIMAL(10,2) NULL DEFAULT NULL COMMENT 'Talla' AFTER `Pesoprev_HCA`,
	CHANGE COLUMN `IMC_HCA` `IMC_HCA` DECIMAL(10,2) NULL DEFAULT NULL COMMENT 'I.M.C.' AFTER `Talla_HCA`;
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', FechaNac_PAC as \'FEC NAC.\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', pla.Nombre_PLA AS \'REGIMEN\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n  (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case  when tp.Nombre_HCT IS NULL then \'NO ATENDIDO\' ELSE \'ATENDIDO\' END) END) AS \'ESTADO\', gx.Codigo_DGN as \'Cod. Dx.\', gx.Descripcion_DGN AS \'DIAGNOSTICO\', tp.Nombre_HCT AS \'TIPO HC\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, czterceros d, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v, gxcitasmedicas c \r\nLEFT JOIN gxagendacab b ON c.Codigo_AGE=b.Codigo_AGE\r\nLEFT JOIN czterceros e ON e.Codigo_TER=b.Codigo_TER\r\nLEFT JOIN gxespecialidades f ON f.Codigo_ESP=b.Codigo_ESP\r\nLEFT JOIN gxmedicos med ON med.Codigo_TER=e.Codigo_TER \r\nLEFT JOIN gxadmision ad ON ad.Codigo_TER=c.Codigo_TER AND c.Fecha_AGE=ad.Fecha_ADM \r\nLEFT JOIN gxplanes pla ON ad.Codigo_PLA=pla.Codigo_PLA\r\nLEFT JOIN hcfolios r ON r.Codigo_TER=c.Codigo_TER  AND r.Fecha_HCF=c.Fecha_AGE AND med.Codigo_USR=r.Codigo_USR\r\nLEFT JOIN hcdiagnosticos dx ON dx.Codigo_TER=r.Codigo_TER -- AND r.Codigo_HCF =dx.Codigo_HCF\r\nLEFT JOIN gxdiagnostico gx ON gx.Codigo_DGN=dx.Codigo_DGN\r\nLEFT JOIN hctipos tp ON tp.Codigo_HCT=r.Codigo_HCT\r\n\r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER AND a.Codigo_TER=c.Codigo_TER and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n\r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  \r\n\r\n GROUP BY c.Codigo_CIT\r\n\r\n \r\n Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;

UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', FechaNac_PAC as \'FEC NAC.\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', pla.Nombre_PLA AS \'REGIMEN\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n  (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case  when tp.Nombre_HCT IS NULL then \'NO ATENDIDO\' ELSE \'ATENDIDO\' END) END) AS \'ESTADO\', gx.Codigo_DGN as \'Cod. Dx.\', gx.Descripcion_DGN AS \'DIAGNOSTICO\', tp.Nombre_HCT AS \'TIPO HC\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, czterceros d, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v, gxcitasmedicas c \r\nLEFT JOIN gxagendacab b ON c.Codigo_AGE=b.Codigo_AGE\r\nLEFT JOIN czterceros e ON e.Codigo_TER=b.Codigo_TER\r\nLEFT JOIN gxespecialidades f ON f.Codigo_ESP=b.Codigo_ESP\r\nLEFT JOIN gxmedicos med ON med.Codigo_TER=e.Codigo_TER \r\nLEFT JOIN hcfolios r ON r.Codigo_TER=c.Codigo_TER  AND r.Fecha_HCF=c.Fecha_AGE AND med.Codigo_USR=r.Codigo_USR\r\nLEFT JOIN gxadmision ad ON ad.Codigo_ADM=r.Codigo_ADM\r\nLEFT JOIN gxplanes pla ON ad.Codigo_PLA=pla.Codigo_PLA\r\nLEFT JOIN hcdiagnosticos dx ON dx.Codigo_TER=r.Codigo_TER -- AND r.Codigo_HCF =dx.Codigo_HCF\r\nLEFT JOIN gxdiagnostico gx ON gx.Codigo_DGN=dx.Codigo_DGN\r\nLEFT JOIN hctipos tp ON tp.Codigo_HCT=r.Codigo_HCT\r\n\r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER AND a.Codigo_TER=c.Codigo_TER and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n\r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  \r\n\r\n GROUP BY c.Codigo_CIT\r\n\r\n \r\n Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
ALTER TABLE `hctipos`
	ADD COLUMN `Framingham_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'test de Framingham' AFTER `CtrlPreNat_HCT`;
UPDATE `hctipos` SET `Framingham_HCT`='1' WHERE  `Codigo_HCT`='HPRTSN';
CREATE TABLE `hcframingham` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Sexo_HCA` CHAR(1) NOT NULL DEFAULT 'M' COMMENT 'Sexo',
	`Edad_HCA` INT(11) NOT NULL DEFAULT '20' COMMENT 'Edad',
	`TAsist_HCA` INT(11) NULL DEFAULT NULL COMMENT 'TA Sistolica',
	`ColT_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Colesterol Total',
	`ColHDL_HCA` INT(11) NULL DEFAULT NULL COMMENT 'Colesterol HDL',
	`Medicado_HCA` INT(1) NULL DEFAULT NULL COMMENT 'Medicado HTA',
	`Fuma_HCA` INT(1) NULL DEFAULT NULL COMMENT 'Fumador',
	`Puntos_HCA` INT(1) NULL DEFAULT NULL COMMENT 'Puntos Test',
	`Riesgo_HCA` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Porcentaje Riesgo' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Test de Framingham'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
