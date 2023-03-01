UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.05.15.001';
CREATE TABLE `gxpaquetes` (
	`Codigo_SER` VARCHAR(6) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Nombre_PQT` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Codigo_PQT` VARCHAR(6) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`Cantidad_PQT` INT(10) UNSIGNED NULL DEFAULT '0',
	PRIMARY KEY (`Codigo_SER`) USING BTREE,
	UNIQUE INDEX `Codigo_SER` (`Codigo_SER`) USING BTREE,
	INDEX `Codigo_PQT` (`Codigo_SER`) USING BTREE
)
COMMENT='Contenido de los Paquetes de servicio'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `gxpaquetes`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_SER`, `Codigo_PQT`) USING BTREE,
	DROP INDEX `Codigo_SER`,
	ADD UNIQUE INDEX `Codigo_SER` (`Codigo_SER`, `Codigo_PQT`) USING BTREE,
	ADD INDEX `Codigo_PQT2` (`Codigo_PQT`);
ALTER TABLE `gxpaquetes`
	DROP COLUMN `Nombre_PQT`;
ALTER TABLE `gxprocedimientos`
	ADD COLUMN `PuntosSOAT_PRC` DECIMAL(10,2) UNSIGNED NULL DEFAULT '0' AFTER `GRUPOSOAT_PRC`;
ALTER TABLE `gxservicios`
	CHANGE COLUMN `SexoM_SER` `SexoM_SER` CHAR(1) NULL DEFAULT '1' COLLATE 'utf8_general_ci' AFTER `EdadMaxima_SER`,
	CHANGE COLUMN `SexoF_SER` `SexoF_SER` CHAR(1) NULL DEFAULT '1' COLLATE 'utf8_general_ci' AFTER `SexoM_SER`;
UPDATE `gxservicios` SET `SexoM_SER`='1';
UPDATE `gxservicios` SET `SexoF_SER`='1';
UPDATE `gxservicios` SET `EdadMaxima_SER`='43800';
CREATE TABLE `nxs_videologin` (
	`Codigo_LGN` INT NOT NULL,
	`Nombre_LGN` VARCHAR(50) NULL DEFAULT NULL,
	`Actual_LGN` CHAR(1) NULL DEFAULT '0',
	`Estado_LGN` CHAR(1) NULL DEFAULT '1',
	PRIMARY KEY (`Codigo_LGN`),
	UNIQUE INDEX `Nombre_LGN` (`Nombre_LGN`),
	INDEX `Estado_LGN` (`Estado_LGN`),
	INDEX `Actual_LGN` (`Actual_LGN`)
)
COMMENT='Videos habilitados en el Login'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('1', 'bcklogin01.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('2', 'bcklogin02.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('3', 'bcklogin03.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('4', 'bcklogin04.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('5', 'bcklogin05.webm');
UPDATE `nxs_videologin` SET `Actual_LGN`='1' WHERE  `Codigo_LGN`=3;
