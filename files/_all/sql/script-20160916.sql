INSERT INTO `hcsv1` (`Codigo_SV1`, `Nombre_SV1`) VALUES ('0', 'Signos Vitales Enfermeria');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`) VALUES ('01', '0');
UPDATE `hcsv3` SET `Orden_HSV`=1 WHERE  `Codigo_HSV`='01' AND `Codigo_SV1`='0';
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('02', '0', 2);
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('03', '0', 3);
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('06', '0', 4);
/* ----------------------------------- */
UPDATE `itaplicaciones` SET `Descripcion_APP`='Domiciliaria' WHERE  `Codigo_APP`=2;
INSERT INTO `itmodulos` (`Codigo_MOD`, `Codigo_APP`, `Nombre_MOD`, `Descripcion_MOD`, `Activo_MOD`, `Icono_MOD`) VALUES (18, 2, 'Agenda Medica', 'Modulo Contable', 0, 'participation_rate');
UPDATE `itmodulos` SET `Descripcion_MOD`='Consulta Externa', `Activo_MOD`=1 WHERE  `Codigo_MOD`=18 AND `Codigo_APP`=2;
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES (100, 18, 2, 'Archivo');
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES (101, 18, 2, 'Procesos');
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES (102, 18, 2, 'Informes');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES (383, 100, 18, 2, 'Profesionales de la Salud', '1.UserSetup.png', 'forms/medicos.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES (384, 100, 18, 2, 'Pacientes', '1.PatientMale.png', 'forms/pacientes.php');
/*----------------------------------------------*/
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES (385, 51, 3, 2, 'Notas Crédito', 'money_add.png', 'forms/notascredito.php');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES (386, 51, 3, 2, 'Notas Débito', 'money_delete.png', 'forms/notasdebito.php');
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_ISF' AND `Tabla_CNS`='czinvsolfarmacia' AND `Codigo_DCD`=0;
delete from itauditoria;
CREATE TABLE `itconfig_hc` ( 	`OrdMedInv_XHC` CHAR(1) NULL DEFAULT '1' COMMENT 'Realizar solicitud de medicamentos a farmacia desde ordenes medicas', 	`OrdMedFac_XHC` CHAR(1) NULL DEFAULT '0' COMMENT 'Realizar orden de servicio en facturacion desde ordenes medicas', 	`AplMedFac_XHC` CHAR(1) NULL DEFAULT '1' COMMENT 'Realizar orden de servicio en facturacion desde aplicacion de medicamentos', 	INDEX `OrdMedInv_XHC` (`OrdMedInv_XHC`), 	INDEX `OrdMedFac_XHC` (`OrdMedFac_XHC`), 	INDEX `AplMedFac_XHC` (`AplMedFac_XHC`) ) COMMENT='Parametros HC'  COLLATE='utf8_general_ci' ENGINE=InnoDB ;
INSERT INTO `itconfig_hc` (`OrdMedInv_XHC`) VALUES ('0');
UPDATE `itconfig_hc` SET `OrdMedInv_XHC`='1' WHERE  `OrdMedInv_XHC`='0' AND `OrdMedFac_XHC`='0' AND `AplMedFac_XHC`='1' LIMIT 1;
ALTER TABLE `gxadmision` ADD COLUMN `Codigo_SDE` CHAR(1) NULL DEFAULT '0' AFTER `Cuota_ADM`;
ALTER TABLE `gxadmision` CHANGE COLUMN `Codigo_SDE` `Codigo_SDE` CHAR(4) NULL DEFAULT '0' AFTER `Cuota_ADM`;
ALTER TABLE `czcargos` 	DROP COLUMN `Codigo_ARE`, 	DROP INDEX `Codigo_ARE`, 	DROP FOREIGN KEY `FK_czcargos_czareas`;
/*----------------------------------------------*/
INSERT INTO `itconsecutivos` (`Codigo_CNS`, `Tabla_CNS`, `Campo_CNS`, `Consecutivo_CNS`, `Descripcion_CNS`) VALUES ('28', 'czinvsalidascab', 'Codigo_SAL', '0', 'Salidas de Almacen');
CREATE TABLE `itusuariosbodegas` ( `Codigo_DCD` INT(5) NULL DEFAULT '0',`Codigo_BDG` CHAR(4) NOT NULL DEFAULT '0',`Codigo_USR` VARCHAR(4) NOT NULL,INDEX `Codigo_DCD` (`Codigo_DCD`),PRIMARY KEY (`Codigo_BDG`, `Codigo_USR`),INDEX `Codigo_BDG` (`Codigo_BDG`),INDEX `Codigo_USR` (`Codigo_USR`)) COMMENT='Acceso de Usuarios a las bodegas' COLLATE='utf8_general_ci' ENGINE=InnoDB;
Insert into itusuariosbodegas(codigo_bdg, codigo_usr) select '01', codigo_usr from itusuarios;
CREATE TABLE `czinvsalidasdet` (	`Codigo_DCD` INT(5) NULL,	`Codigo_SAL` CHAR(6) NOT NULL,	`Codigo_SER` VARCHAR(6) NOT NULL,	`Cantidad_SAL` INT NULL,	PRIMARY KEY (`Codigo_SAL`, `Codigo_SER`),	INDEX `Codigo_DCD` (`Codigo_DCD`),	INDEX `Codigo_SAL` (`Codigo_SAL`),	INDEX `Codigo_SER` (`Codigo_SER`)) COLLATE='utf8_general_ci' ENGINE=InnoDB;
ALTER TABLE `czinvsalidasdet` 	CHANGE COLUMN `Codigo_DCD` `Codigo_DCD` INT(5) NULL DEFAULT '0' FIRST, 	ADD COLUMN `Nota_SAL` VARCHAR(255) NOT NULL AFTER `Codigo_SER`; 
ALTER TABLE `czinvsalidasdet` 	ADD COLUMN `Codigo_BDG` CHAR(4) NOT NULL AFTER `Codigo_SAL`,	DROP PRIMARY KEY,	ADD PRIMARY KEY (`Codigo_SAL`, `Codigo_SER`, `Codigo_BDG`),	ADD INDEX `Codigo_BDG` (`Codigo_BDG`);
CREATE TABLE `hcmedpacientes` (	`Codigo_DCD` INT(5) NOT NULL,	`Codigo_ADM` VARCHAR(10) NOT NULL,	`Codigo_SER` VARCHAR(6) NOT NULL,	`Prescripcion_HMP` VARCHAR(255) NULL,	`Cantidad_HMP` INT NULL,	`Aplicado_HMP` INT NULL DEFAULT '0',	`Estado_HMP` CHAR(1) NULL DEFAULT '1',	PRIMARY KEY (`Codigo_DCD`, `Codigo_ADM`, `Codigo_SER`),	INDEX `Estado_HMP` (`Estado_HMP`),	INDEX `Codigo_ADM` (`Codigo_ADM`),	INDEX `Codigo_SER` (`Codigo_SER`),	INDEX `Codigo_DCD` (`Codigo_DCD`)) COMMENT='Medicamentos e Insumos Asignados a Pacientes' COLLATE='utf8_general_ci' ENGINE=InnoDB;
ALTER TABLE `itusuarios`	CHANGE COLUMN `Clave_USR` `Clave_USR` VARCHAR(255) NULL DEFAULT '10470c3b4b1fed12c3baac014be15fac67c6e815' AFTER `Nombre_USR`;
/*----------------------------------------------*/
