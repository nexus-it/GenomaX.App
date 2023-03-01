-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Update_DCD`='21.12.04.001' ;
DELETE FROM gxfacturas WHERE codigo_fac LIKE 'SETP%';
ALTER TABLE `gxmedicamentos`
	ADD COLUMN `Inventario_MED` CHAR(1) NULL DEFAULT '1' AFTER `Dispositivo_MED`,
	ADD INDEX `Inventario_MED` (`Inventario_MED`);
INSERT INTO `czconceptossal` (`Codigo_CSA`, `Nombre_CSA`) VALUES ('5', 'ENTREGA DE INSUMOS');
CREATE TABLE `czinvmovcab` (
	`Codigo_IMV` INT NOT NULL,
	`Tipo_IMV` ENUM('E','S','T') NULL DEFAULT NULL,
	`Codigo_CMV` CHAR(4) NULL DEFAULT NULL,
	`Fecha_IMV` DATETIME NULL DEFAULT NULL,
	`Codigo_TER` CHAR(10) NULL DEFAULT NULL,
	`Codigo_BDG` CHAR(4) NULL DEFAULT NULL,
	`Bodega2_BDG` CHAR(4) NULL DEFAULT NULL,
	`Observaciones_IMV` TEXT NULL DEFAULT NULL,
	`Codigo_USR` VARCHAR(4) NULL DEFAULT NULL,
	`Estado_IMV` CHAR(1) NULL DEFAULT '1',
	`Anula_USR` VARCHAR(4) NULL DEFAULT NULL,
	`FecAnula_IMV` DATETIME NULL DEFAULT NULL,
	`MotivoAnula_IMV` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_IMV`),
	INDEX `Tipo_IMV` (`Tipo_IMV`),
	INDEX `Estado_IMV` (`Estado_IMV`),
	INDEX `Codigo_CMV` (`Codigo_CMV`),
	INDEX `Fecha_IMV` (`Fecha_IMV`),
	INDEX `Codigo_BDG` (`Codigo_BDG`),
	INDEX `Codigo_TER` (`Codigo_TER`)
)
COMMENT='Movimientos en Inventario - Cabecera'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
DROP TABLE `itreportsparam`;
DROP TABLE `itreportsperfiles`;
DROP TABLE `itreportsselects`;
DROP TABLE `itreports`;
DROP TABLE `itreportslistas`;
DROP TABLE `itreportsmodulos`;
ALTER TABLE `czmovcontdet`
	CHANGE COLUMN `Debito_CNT` `Debito_CNT` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `Codigo_CCT`,
	CHANGE COLUMN `Credito_CNT` `Credito_CNT` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `Debito_CNT`;
ALTER TABLE `czmovcontcab`
	CHANGE COLUMN `Total_CNT` `Total_CNT` DECIMAL(15,2) NULL DEFAULT NULL AFTER `Observaciones_CNT`;
ALTER TABLE `czmovcontdet`
	CHANGE COLUMN `Codigo_TER` `Codigo_TER` VARCHAR(10) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Codigo_CNT`,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_CNT`, `Codigo_CTA`, `Codigo_TER`) USING BTREE;
ALTER TABLE `hctipos`
	ADD COLUMN `ValHeridas_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Cargar Valoracion de Heridas' AFTER `Odontograma_HCT`;
UPDATE `hctipos` SET `ValHeridas_HCT`='0';
UPDATE `hctipos` SET `ValHeridas_HCT`='1' WHERE  `Codigo_HCT`='VALHER1';
CREATE TABLE `hcubicanatom` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`PosX_HUA` INT(11)  NOT NULL,
	`PosY_HUA` INT(11)   NOT NULL,
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Ubicaciones Anatomicas de la Valoracion de Heridas'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hc_valher1`
	DROP COLUMN `image1_HC`,
	DROP COLUMN `image2_HC`;
ALTER TABLE `hcubicanatom`
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`, `PosX_HUA`, `PosY_HUA`) USING BTREE,
	DROP INDEX `Codigo_TER`,
	ADD INDEX `Codigo_TER` (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	DROP INDEX `Codigo_HCF`,
	ADD INDEX `Codigo_HCF` (`Codigo_HCF`, `Codigo_TER`) USING BTREE;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `Fecha_FAC` `Fecha_FAC` DATETIME NOT NULL DEFAULT '0000-00-00' AFTER `IdFE_FAC`;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `IdFE_FAC` `IdFE_FAC` VARCHAR(100) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Codigo_ADM`;
DELIMITER $$
CREATE FUNCTION ObtenNumeros(cadena VARCHAR(50)) 
RETURNS INT
BEGIN
    DECLARE EncuentraNumero VARCHAR(50);
    DECLARE CualNumero VARCHAR(50) DEFAULT '';
    DECLARE ObtenCaracter VARCHAR(1);
    DECLARE Cuanto INTEGER DEFAULT 1;

    IF LENGTH(cadena) > 0 THEN
        WHILE(Cuanto <= LENGTH(cadena)) DO
            SET ObtenCaracter = SUBSTRING(cadena, Cuanto, 1);
            SET EncuentraNumero = FIND_IN_SET(ObtenCaracter, '0,1,2,3,4,5,6,7,8,9'); 
            IF EncuentraNumero > 0 THEN
                SET CualNumero = CONCAT(CualNumero, ObtenCaracter);
            END IF;
            SET Cuanto = Cuanto + 1;
        END WHILE;
        RETURN CAST(CualNumero AS UNSIGNED);
    ELSE
        RETURN 0;
    END IF;    
END$$
DELIMITER;


SET @numero='00:00';
create table gxagendahoras as Select @numero:= ADDTIME(@numero, '00:05:00') AS horaagenda FROM gxagendadet a
WHERE  @numero<='23:55';
ALTER TABLE `gxagendahoras`
	CHANGE COLUMN `horaagenda` `horaagenda` VARCHAR(29) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci' FIRST;
ALTER TABLE `gxagendahoras`
	CHANGE COLUMN `horaagenda` `horaagenda` TIME NULL DEFAULT NULL COLLATE 'latin1_swedish_ci' FIRST;

ALTER TABLE `gxcitasmedicas`
	ADD COLUMN `Codigo_SER` CHAR(6) NULL DEFAULT '' AFTER `TipoConsulta_CIT`;
ALTER TABLE `itconfig_cx`
	ADD COLUMN `MensajeCita_XCX` TEXT(10000) NULL AFTER `FechaHCCX_XCX`;
UPDATE `itconfig_cx` SET `MensajeCita_XCX`='Hola {PACIENTE}, {IPS} te confirma que tu cita de {ESPECIALIDAD} se programó para el {FECHA}, {HORA} con {MEDICO} en {AREA}: {DIRECCION}, Tel: {TELEFONO}. \r\n(Modalidad: {MODALIDAD}).';


ALTER TABLE `gxservicios`
	CHANGE COLUMN `Nombre_SER` `Nombre_SER` TEXT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_SER`;

ALTER TABLE `gxprocedimientos`
	CHANGE COLUMN `Nombre_PRC` `Nombre_PRC` TEXT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_SER`;
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
	
	
INSERT INTO `cztipoid` (`Codigo_TID`, `Nombre_TID`, `Sigla_TID`) VALUES ('13', 'Permiso Temporal', 'PT');




ALTER TABLE `gxcontratos`
	ADD CONSTRAINT `FK_gxcontratos_gxplanes` FOREIGN KEY (`Codigo_PLA`) REFERENCES `gxplanes` (`Codigo_PLA`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	ADD CONSTRAINT `FK_gxcontratos_gxeps` FOREIGN KEY (`Codigo_EPS`) REFERENCES `gxeps` (`Codigo_EPS`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	ADD CONSTRAINT `FK_gxcontratos_gxtarifas` FOREIGN KEY (`Codigo_TAR`) REFERENCES `gxtarifas` (`Codigo_TAR`) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `gxfacturas`
	ADD CONSTRAINT `FK_gxfacturas_gxeps` FOREIGN KEY (`Codigo_EPS`) REFERENCES `gxeps` (`Codigo_EPS`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	ADD CONSTRAINT `FK_gxfacturas_gxplanes` FOREIGN KEY (`Codigo_PLA`) REFERENCES `gxplanes` (`Codigo_PLA`) ON UPDATE NO ACTION ON DELETE NO ACTION;
ALTER TABLE `gxordenesdet`
	ADD CONSTRAINT `FK_gxordenesdet_gxeps` FOREIGN KEY (`Codigo_EPS`) REFERENCES `gxeps` (`Codigo_EPS`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	ADD CONSTRAINT `FK_gxordenesdet_gxplanes` FOREIGN KEY (`Codigo_PLA`) REFERENCES `gxplanes` (`Codigo_PLA`) ON UPDATE NO ACTION ON DELETE NO ACTION;

CREATE TABLE `gnx_futvis`.`cznotascontablesdet_d` (
	`Codigo_NCT` INT(11) NOT NULL,
	`Codigo_SER` VARCHAR(6) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_CCT` VARCHAR(3) NULL DEFAULT '1' COMMENT 'Centro Costo' COLLATE 'utf8_general_ci',
	`Codigo_CUE` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta Contable' COLLATE 'utf8_general_ci',
	`Naturaleza_NCT` CHAR(1) NULL DEFAULT 'C' COLLATE 'utf8_general_ci',
	`ValorDet_NCT` DECIMAL(12,2) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_NCT`, `Codigo_SER`) USING BTREE,
	INDEX `Codigo_NCT` (`Codigo_NCT`) USING BTREE,
	INDEX `Codigo_SER` (`Codigo_SER`) USING BTREE,
	INDEX `Codigo_CUE` (`Codigo_CUE`) USING BTREE,
	INDEX `Codigo_CCT` (`Codigo_CCT`) USING BTREE,
	INDEX `Naturaleza_NCT` (`Naturaleza_NCT`) USING BTREE
)
 COLLATE 'utf8_general_ci' ENGINE=InnoDB ROW_FORMAT=Compact COMMENT='Detalle de notas debito';
