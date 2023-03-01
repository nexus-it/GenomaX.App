ALTER TABLE `itconfig`
	CHANGE COLUMN `Version_DCD` `Version_DCD` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Updatelink_DCD`,
	ADD COLUMN `Plan_DCD` VARCHAR(10) NULL DEFAULT NULL AFTER `Version_DCD`,
	ADD COLUMN `Update_DCD` CHAR(14) NULL DEFAULT NULL AFTER `Plan_DCD`;
UPDATE `kld_axis`.`itconfig` SET `Version_DCD`='Enterprise', `Plan_DCD`='Pro', `Update_DCD`='21.11.05.031' WHERE  `Licencia_DCD`='037632a4c6ab9014691a8b67a70ffdc315443dae' AND `NIT_DCD`='901073245-9 ' AND `Codigo_DCD`=1;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `Fecha_FAC` `Fecha_FAC` DATETIME NOT NULL DEFAULT '0000-00-00' AFTER `IdFE_FAC`;
CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STR`(
	`x` VARCHAR(255),
	`delim` VARCHAR(12),
	`pos` INT
)
RETURNS varchar(255) CHARSET latin1
LANGUAGE SQL
NOT DETERMINISTIC
CONTAINS SQL
SQL SECURITY DEFINER
COMMENT ''
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       CHAR_LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, "");
       
UPDATE itpermisos SET `Codigo_ITM`='610' WHERE  `Codigo_ITM`=387;
UPDATE itpermisos SET `Codigo_ITM`='611' WHERE  `Codigo_ITM`=388;
UPDATE itpermisos SET `Codigo_ITM`='612' WHERE  `Codigo_ITM`=389;
UPDATE itpermisos SET `Codigo_ITM`='613' WHERE  `Codigo_ITM`=390;
UPDATE itpermisos SET `Codigo_ITM`='614' WHERE  `Codigo_ITM`=391;
UPDATE itpermisos SET `Codigo_ITM`='615' WHERE  `Codigo_ITM`=392;
UPDATE itpermisos SET `Codigo_ITM`='616' WHERE  `Codigo_ITM`=393;
UPDATE itpermisos SET `Codigo_ITM`='617' WHERE  `Codigo_ITM`=395;
UPDATE itpermisos SET `Codigo_ITM`='618' WHERE  `Codigo_ITM`=396;
UPDATE itpermisos SET `Codigo_ITM`='619' WHERE  `Codigo_ITM`=397;
UPDATE itpermisos SET `Codigo_ITM`='620' WHERE  `Codigo_ITM`=398;
UPDATE itpermisos SET `Codigo_ITM`='621' WHERE  `Codigo_ITM`=399;
UPDATE itpermisos SET `Codigo_ITM`='622' WHERE  `Codigo_ITM`=401;
UPDATE itpermisos SET `Codigo_ITM`='623' WHERE  `Codigo_ITM`=402;
UPDATE itpermisos SET `Codigo_ITM`='624' WHERE  `Codigo_ITM`=403;
UPDATE itpermisos SET `Codigo_ITM`='625' WHERE  `Codigo_ITM`=404;
UPDATE itpermisos SET `Codigo_ITM`='626' WHERE  `Codigo_ITM`=416;
UPDATE itpermisos SET `Codigo_ITM`='627' WHERE  `Codigo_ITM`=418;
UPDATE itpermisos SET `Codigo_ITM`='628' WHERE  `Codigo_ITM`=432;
UPDATE itpermisos SET `Codigo_ITM`='629' WHERE  `Codigo_ITM`=479;
UPDATE itpermisos SET `Codigo_ITM`='630' WHERE  `Codigo_ITM`=532;

-- File Manager
CREATE TABLE `itfilemanager` (
	`Codigo_PFM` CHAR(5) NULL DEFAULT '0B' COMMENT 'Codigo del Plan File Manager',
	`Estado_PFM` CHAR(1) NULL DEFAULT '0'
)
COMMENT='Adminsitrador de archivos, documentos, espacio en disco'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `itfilecategories` (
	`Codigo_CFM` CHAR(5) NOT NULL,
	`Nombre_CFM` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_CFM`)
)
COMMENT='Categorias para agrupar los archivos'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `itfilecategories` (`Codigo_CFM`, `Nombre_CFM`) VALUES ('1', 'Autorizaciones');
INSERT INTO `itfilecategories` (`Codigo_CFM`, `Nombre_CFM`) VALUES ('2', 'Identificación');
CREATE TABLE `itfiles` (
	`Codigo_TER` CHAR(6) NOT NULL,
	`Nombre_FFM` VARCHAR(250) NULL DEFAULT NULL,
	`Codigo_CFM` CHAR(6) NULL DEFAULT NULL,
	`Fecha_FFM` DATE NULL,
	`Id_FFM` CHAR(50) NOT NULL,
	PRIMARY KEY (`Codigo_TER`, `Id_FFM`),
	INDEX `Codigo_CFM` (`Codigo_CFM`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Id_FFM` (`Id_FFM`)
)
COMMENT='Archivos Guardados'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `itfiles`
	ADD COLUMN `SizeKb_FFM` INT NOT NULL DEFAULT 0 AFTER `Id_FFM`;

ALTER TABLE `klemisiones`
	ADD COLUMN `FechaStandBy_EMI` DATE NULL DEFAULT NULL AFTER `FechaAnula_EMI`,
	ADD COLUMN `ObsStandBy_EMI` TEXT NULL AFTER `FechaStandBy_EMI`,
	ADD INDEX `FechaStandBy_EMI` (`FechaStandBy_EMI`);
ALTER TABLE `klplanescobertura`
	ADD COLUMN `NombreEng_COB` VARCHAR(60) NOT NULL AFTER `Nombre_COB`,
	ADD COLUMN `DescripcionEng_COB` VARCHAR(60) NULL DEFAULT NULL AFTER `Descripcion_COB`;

Update klplanescobertura set NombreEng_COB='GLOBAL ASSISTANCE BENEFIT' Where Nombre_COB='BENEFICIO DE ASISTENCIA GLOBAL';
Update klplanescobertura set NombreEng_COB='ACCIDENTAL DEATH DUE TO PUBLIC TRANSPORTATION' Where Nombre_COB='MUERTE ACCIDENTAL POR TRANSPORTE PUBLICO';
Update klplanescobertura set NombreEng_COB='REPATRIATION OF MORTAL REMAINS' Where Nombre_COB='REPATRIACION DE RESTOS MORTALES ';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES PER ACCIDENT' Where Nombre_COB='GASTOS MEDICOS POR ACCIDENTE';
Update klplanescobertura set NombreEng_COB='FIRST MEDICAL CARE FOR PRE-EXISTING ILLNESS' Where Nombre_COB='PRIMERA ATENCION MEDICA POR ENFERMEDAD PREEXISTENTE';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES FOR URGENCIES OR MEDICAL EMERGENCIES' Where Nombre_COB='GASTOS MEDICOS POR URGENCIAS O EMERGENCIAS MEDICAS';
Update klplanescobertura set NombreEng_COB='COVID-19 COVERAGE' Where Nombre_COB='COBERTURA COVID-19';
Update klplanescobertura set NombreEng_COB='MEDICATIONS FOR OUTPATIENT ASSISTANCE' Where Nombre_COB='MEDICAMENTOS POR ASISTENCIAS AMBULATORIAS ';
Update klplanescobertura set NombreEng_COB='HOSPITALIZATION EXPENSES' Where Nombre_COB='GASTOS POR HOSPITALIZACION';
Update klplanescobertura set NombreEng_COB='SANITARY REPATRIATION' Where Nombre_COB='REPATRIACION SANITARIA ';
Update klplanescobertura set NombreEng_COB='DENTAL EXPENSES' Where Nombre_COB='GASTOS ODONTOLOGICOS ';
Update klplanescobertura set NombreEng_COB='HOTEL COVERAGE FOR CONVALESCENCE' Where Nombre_COB='COBERTURA HOTEL POR CONVALECENCIA ';
Update klplanescobertura set NombreEng_COB='ADVANCE OF BONDS' Where Nombre_COB='ADELANTO DE FIANZAS ';
Update klplanescobertura set NombreEng_COB='FLIGHT CANCELLATION' Where Nombre_COB='CANCELACION DE VUELO ';
Update klplanescobertura set NombreEng_COB='LOSS AND LOCATION OF LUGGAGE' Where Nombre_COB='PERDIDA Y LOCALIZACION DE EQUIPAJE ';
Update klplanescobertura set NombreEng_COB='ATTENTION BY SPECIALIST' Where Nombre_COB='ATENCION POR ESPECIALISTA';
Update klplanescobertura set NombreEng_COB='PRACTICE OF SPORTS' Where Nombre_COB='PRACTICA DE DEPORTES ';
Update klplanescobertura set NombreEng_COB='PREGNANCY STATUS UNTIL WEEK 24' Where Nombre_COB='ESTADO DE EMBARAZO HASTA LA SEMANA 24';
Update klplanescobertura set NombreEng_COB='TRANSFER OF 1 FAMILY MEMBER' Where Nombre_COB='TRASLADO DE 1 FAMILIAR';
Update klplanescobertura set NombreEng_COB='ACCOMPANIMENT OF ADULTS AND MINORS' Where Nombre_COB='ACOMPAÑAMIENTO DE MAYORES Y MENORES ';
Update klplanescobertura set NombreEng_COB='SANITARY TRANSFERS' Where Nombre_COB='TRASLADOS SANITARIOS ';
Update klplanescobertura set NombreEng_COB='URGENT MSN TRANSMISSION' Where Nombre_COB='TRASMISION MSN URGENTES ';
Update klplanescobertura set NombreEng_COB='THEFT OR LOST DOCUMENTS' Where Nombre_COB='ROBO O PERDIDA DE DOCUMENTOS ';
Update klplanescobertura set NombreEng_COB='LOST GRAVES AT HOME' Where Nombre_COB='SINIESTROS GRAVES EN DOMICILIO';
Update klplanescobertura set NombreEng_COB='CIVIL LIABILITY' Where Nombre_COB='RESPONSABILIDAD CIVIL ';
Update klplanescobertura set NombreEng_COB='BAGGAGE DELAY COMPENSATION (24 HOURS)' Where Nombre_COB='COMPENSACION POR DEMORA DE EQUIPAJE  (24 HORAS)';
Update klplanescobertura set NombreEng_COB='TOTAL OR PERMANENT DISABILITY' Where Nombre_COB='INVALIDEZ TOTAL O PERMANENTE ';
Update klplanescobertura set NombreEng_COB='AGE LIMIT COVERAGE 100% OF BENEFITS' Where Nombre_COB='LIMITE DE EDAD COBERTURA 100% DE BENEFICIOS ';
Update klplanescobertura set NombreEng_COB='AGE LIMIT COVERAGE 50% OF BENEFITS' Where Nombre_COB='LIMITE DE EDAD COBERTURA 50% DE BENEFICIOS';
Update klplanescobertura set NombreEng_COB='COVID 19 COVERAGE' Where Nombre_COB='COBERTURA COVID 19';
Update klplanescobertura set NombreEng_COB='CANCELLATION OF FLIGHTS' Where Nombre_COB='CANCELACION DE VUELOS ';
Update klplanescobertura set NombreEng_COB='ACCOMPANIMENT OF MINORS AND OLDER' Where Nombre_COB='ACOMPAÑAMIENTO DE MENORES Y MAYORES ';
Update klplanescobertura set NombreEng_COB='SANITARY TRANSFERS' Where Nombre_COB='TRASLADO SANITARIOS ';
Update klplanescobertura set NombreEng_COB='URGENT MSN TRANSMISSION' Where Nombre_COB='TRANSMISION DE MSN URGENTE ';
Update klplanescobertura set NombreEng_COB='BAGGAGE DELAY COMPENSATION (24 HOURS)' Where Nombre_COB='COMPENSACION POR DEMORA DE EQUIPAJE (24 HORAS)';
Update klplanescobertura set NombreEng_COB='AGE LIMIT COVERAGE 100% BENEFITS' Where Nombre_COB='LIMITE DE EDAD COBERTURA 100% BENEFICIOS ';
Update klplanescobertura set NombreEng_COB='AGE LIMIT COVERAGE 50% BENEFITS' Where Nombre_COB='LIMITE DE EDAD COBERTURA 50% BENEFICIOS ';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES FOR URGENCIES OR MEDICAL EMERGENCIES' Where Nombre_COB='GASTOS MEDICOS  POR URGENCIAS O EMERGENCIAS MEDICAS ';
Update klplanescobertura set NombreEng_COB='URGENT MSN TRANSMISSION' Where Nombre_COB='TRASMISION DE MSN URGENTE ';
Update klplanescobertura set NombreEng_COB='SINISTER TOMB AT HOME' Where Nombre_COB='SINIESTRO GRAVE EN DOMICILIO ';
Update klplanescobertura set NombreEng_COB='TRANSFER OF A FAMILY MEMBER' Where Nombre_COB='TRASLADO DE UN FAMILIAR ';
Update klplanescobertura set NombreEng_COB='SINISTER GRAVES IN HOME' Where Nombre_COB='SINIESTRO GRAVES EN DOMICILIO ';
Update klplanescobertura set NombreEng_COB='PHYSICIANS FOR OUTPATIENT ASSISTANCE' Where Nombre_COB='MEDICOS POR ASISTENCIAS AMBULATORIAS ';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES FOR URGENCIES AND MEDICAL EMERGENCIES' Where Nombre_COB='GASTOS MEDICOS POR URGENCIAS Y EMERGENCIAS MEDICAS ';
Update klplanescobertura set NombreEng_COB='BAGGAGE DELAY COMPENSATION' Where Nombre_COB='COMPENSACION DEMORA DE EQUIPAJE ';
Update klplanescobertura set NombreEng_COB='ONLY APPLIES TO OVER 2 UP TO 70 YEARS OLD' Where Nombre_COB='SOLO APLICA A MAYORES DE 2 HASTA LOS 70 AÑOS ';
Update klplanescobertura set NombreEng_COB='BAGGAGE DELAY COMPENSATION' Where Nombre_COB='COMPENSACION POR DEMORA DE EQUIPAJE ';
Update klplanescobertura set NombreEng_COB='GLOBAL ASSISTANCE BENEFIT' Where Nombre_COB='BENEFICIO ASISTENCIA GLOBAL ';
Update klplanescobertura set NombreEng_COB='ACCIDENTAL DEATH DUE TO PUBLIC TRANSIT' Where Nombre_COB='MUERTE ACCIDENTAL POR TRANSITO PUBLICO ';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES FOR URGENCIES AND VITAL MEDICAL EMERGENCIES' Where Nombre_COB='GASTOS MEDICOS POR URGENCIAS Y EMERGENCIAS MEDICAS VITALES';
Update klplanescobertura set NombreEng_COB='PREGNANCY STATUS UP TO WEEK 24' Where Nombre_COB='ESTADO DE EMBARAZO HASTA SEMANA 24';
Update klplanescobertura set NombreEng_COB='SANITARY TRANSFER' Where Nombre_COB='TRASLADO SANITARIO';
Update klplanescobertura set NombreEng_COB='TRANSMISSION OF URGENT MANAGEMENTS' Where Nombre_COB='TRANSMISION DE MANSAJES URGENTES';
Update klplanescobertura set NombreEng_COB='EQUIPMENT DELAY COMPENSATION (96 HOURS)' Where Nombre_COB='COMPENSACION POR DEMORA DE EQUIPAJE (96 HORAS)';
Update klplanescobertura set NombreEng_COB='MEDICAL EXPENSES DUE TO ACCIDENTS' Where Nombre_COB='GASTOS MEDICOS POR ACCIDENTES';
Update klplanescobertura set NombreEng_COB='DENTAL EXPENSES IN CASE OF ACCIDENTS' Where Nombre_COB='GASTOS ODONTOLOGICOS EN CASO DE ACCIDENTES';
Update klplanescobertura set NombreEng_COB='TRANSMISSION OF URGENT MESSAGES' Where Nombre_COB='TRASMISION DE MENSAJES URGENTES ';
Update klplanescobertura set NombreEng_COB='THEFT AND LOSS OF DOCUMENTS' Where Nombre_COB='ROBO Y PERDIDA DE DOCUMENTOS ';
Update klplanescobertura set NombreEng_COB='ATTENTION BY SPECIALISTS' Where Nombre_COB='ATENCION POR ESPECIALISTAS';
Update klplanescobertura set NombreEng_COB='TRANSMISSION OF URGENT MESSAGES' Where Nombre_COB='TRANSMISION DE MENSAJES URGENTES ';
Update klplanescobertura set NombreEng_COB='EXPENSES FOR HOSPITALIZATION UP TO 45 DAYS' Where Nombre_COB='GASTOS POR HOSPITALIZACION HASTA 45 DIAS ';
Update klplanescobertura set NombreEng_COB='HOTEL COVERAGE FOR CONVALESCENCE UP TO 45 DAYS' Where Nombre_COB='COBERTURA HOTEL POR CONVALECENCIA HASTA 45 DIAS ';
Update klplanescobertura set NombreEng_COB='BAGGAGE DELAY COMPENSATION (96) HOURS' Where Nombre_COB='COMPENSACION POR DEMORA DE EQUIPAJE (96) HORAS';
Update klplanescobertura set NombreEng_COB='VALID TOTAL OR PERMANENT' Where Nombre_COB='VALIDES TOTAL O PERMANENTE ';
Update klplanescobertura set NombreEng_COB='HOTEL COVERAGE FOR CONVALESCENCE' Where Nombre_COB='COBERTURA HOTEL POR CONVALECENCA ';
Update klplanescobertura set NombreEng_COB='LOSS AND LOCATION OF EQUIPMENT' Where Nombre_COB='PERDIDA Y LOCALIZACION DE EQUIPAJES';
Update klplanescobertura set NombreEng_COB='URGENT MSN TRANSMISSION' Where Nombre_COB='TRANSMISION DE MSN URGENTES';
Update klplanescobertura set NombreEng_COB='DEPOSIT ADVANCE' Where Nombre_COB='ADELANTO DE FIANZA ';
Update klplanescobertura set NombreEng_COB='WEEK STATUS THROUGH WEEK 24' Where Nombre_COB='ESTADO DE SEMANA HASTA LA SEMANA 24';
Update klplanescobertura set NombreEng_COB='URGENT MSN TRANSMISSION' Where Nombre_COB='TRASMISION MSN URGENTE ';
Update klplanescobertura set NombreEng_COB='COMPENSATION FOR DELAYED BAGGAGE (24 HOURS)' Where Nombre_COB='COMPENSACION POR MORA DE EQUIPAJE (24 HORAS)';
Update klplanescobertura set NombreEng_COB='MEDICATIONS FOR OUTPATIENT ASSISTANCE' Where Nombre_COB='MEDICAMENTOS POR  ASISTENCIAS AMBULATORIAS ';
Update klplanescobertura set NombreEng_COB='EXPENSES FOR URGENCIES OR MEDICAL EMERGENCIES' Where Nombre_COB='GASTOS POR URGENCIAS O EMERGENCIAS MEDICAS ';
Update klplanescobertura set NombreEng_COB='TOTAL AND PERMANENT DISABILITY' Where Nombre_COB='INVALIDEZ TOTAL Y PERMANENTE ';
Update klplanescobertura set NombreEng_COB='LOST LOCATION OF LUGGAGE ' Where Nombre_COB='PERDIDA DE LOCALIZACION DE EQUIPAJE ';

UPDATE klplanescobertura SET DescripcionEng_COB=Descripcion_COB;
CREATE TABLE `itconfig_kld` (
	`DiasVence_KLD` INT NULL DEFAULT '15'
)
COMMENT='Parametros klud'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

UPDATE `itconfig` SET `Direccion_DCD`='Avenida Cra 7 # 67-28 Of. 202' WHERE  `Licencia_DCD`='037632a4c6ab9014691a8b67a70ffdc315443dae' AND `NIT_DCD`='901073245-9 ' AND `Codigo_DCD`=1;
UPDATE `itconfig` SET `Telefonos_DCD`='+57 601 7907790 | +57 316 7129236' WHERE  `Licencia_DCD`='037632a4c6ab9014691a8b67a70ffdc315443dae' AND `NIT_DCD`='901073245-9 ' AND `Codigo_DCD`=1;
