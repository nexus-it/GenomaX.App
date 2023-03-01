UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.20.001';
INSERT INTO `czformasdepago` (`Codigo_FPG`, `Nombre_FPG`, `Banco_FPG`, `Cuenta_FPG`, `Documento_FPG`) VALUES ('TR', 'TRANSFERENCIA', '1', '1', '1');
CREATE TABLE `czbancos` (
	`Codigo_BCO` CHAR(4) NOT NULL,
	`Nombre_BCO` VARCHAR(50) NULL DEFAULT NULL,
	`TipoCta_BCO` ENUM('Cuenta de Ahorros','Cuenta Corriente') NULL DEFAULT NULL,
	`CuentaNo_BCO` VARCHAR(20) NULL DEFAULT NULL,
	`Estado_BCO` CHAR(1) NULL DEFAULT '1',
	PRIMARY KEY (`Codigo_BCO`),
	INDEX `TipoCta_BCO_CuentaNo_BCO` (`TipoCta_BCO`, `CuentaNo_BCO`),
	INDEX `Estado_BCO` (`Estado_BCO`),
	INDEX `Codigo_BCO` (`Codigo_BCO`)
)
COMMENT='CUENTAS DE BANCOS'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `czpagosenc` (
	`Codigo_PGS` VARCHAR(10) NOT NULL,
	`Fecha_PGS` DATE NULL DEFAULT NULL,
	`Codigo_TER` VARCHAR(10) NULL DEFAULT NULL,
	`Codigo_FPG` CHAR(4) NULL DEFAULT NULL,
	`Codigo_BCO` CHAR(4) NULL DEFAULT NULL,
	`Total_PGS` DECIMAL(10,2) NULL DEFAULT NULL,
	`Observaciones_PGS` TEXT NULL DEFAULT NULL,
	`FechaReg_PGS` DATETIME NULL DEFAULT NOW(),
	`Codigo_USR` VARCHAR(4) NULL DEFAULT NULL,
	`Estado_PGS` CHAR(1) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_PGS`),
	INDEX `Fecha_PGS` (`Fecha_PGS`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Estado_PGS` (`Estado_PGS`)
)
COMMENT='Pagos y Abonos de facturas Recibidos'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `itconsecutivos` (`Codigo_CNS`, `Tabla_CNS`, `Campo_CNS`, `Consecutivo_CNS`, `Descripcion_CNS`) VALUES ('39', 'czbancos', 'Codigo_BCO', '0', 'Consecutivos de bancos');
INSERT INTO `itconsecutivos` (`Codigo_CNS`, `Tabla_CNS`, `Campo_CNS`, `Consecutivo_CNS`, `Descripcion_CNS`) VALUES ('40', 'czpagosenc', 'Codigo_PGS', '499', 'Consecutivos de pagos en cartera');
