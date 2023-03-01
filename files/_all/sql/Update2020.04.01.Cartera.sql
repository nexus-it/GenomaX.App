UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.04.06.001';
ALTER TABLE `gxfacturas`
	ADD INDEX `Fecha_FAC` (`Fecha_FAC`);
INSERT INTO `hcsv1` (`Codigo_SV1`, `Nombre_SV1`) VALUES ('5', 'Signos Vitales Oximetría');
CREATE TABLE `nxs_meet` (
	`Codigo_MET` VARCHAR(50) NOT NULL,
	`Codigo_USR` VARCHAR(4) NOT NULL,
	`Fecha_MET` DATETIME NULL,
	`Ingreso_MET` INT NULL DEFAULT '0',
	PRIMARY KEY (`Codigo_MET`, `Codigo_USR`),
	INDEX `Codigo_MET` (`Codigo_MET`),
	INDEX `Fecha_MET` (`Fecha_MET`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
UPDATE itusuarios a, gxmedicos b, czterceros c SET a.Nombre_USR= c.Nombre_TER WHERE a.Codigo_USR=b.Codigo_USR AND b.Codigo_TER=c.Codigo_TER and a.Nombre_USR='';
CREATE TABLE `nxs_mail` (
	`Codigo_EML` VARCHAR(50) NOT NULL,
	`Username_EML` LONGTEXT NULL DEFAULT NULL,
	`Password_EML` VARCHAR(80) NULL DEFAULT NULL,
	`Usermail_EML` VARCHAR(80) NULL DEFAULT NULL,
	`Username_EM` VARCHAR(80) NULL DEFAULT NULL,
	`Host_EML` VARCHAR(50) NULL DEFAULT 'smtp.gmail.com',
	`Port_EML` VARCHAR(5) NULL DEFAULT '587',
	`SMTPSecure_EML` VARCHAR(5) NULL DEFAULT 'tls',
	`Mailer_EML` VARCHAR(10) NULL DEFAULT 'smtp',
	PRIMARY KEY (`Codigo_EML`)
)
COMMENT='Configuracion y parametros de servidores y cuentas de correo'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `nxs_mail`
	CHANGE COLUMN `Username_EM` `NameMail_EML` VARCHAR(80) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Usermail_EML`;
