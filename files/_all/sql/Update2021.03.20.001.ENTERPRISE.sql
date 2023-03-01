-- NUEVO ENTERPRISE 2021

UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.03.20.100' ;
ALTER TABLE `czautfacturacion`
	ADD COLUMN `IdFormSiigo_AFC` VARCHAR(50) NULL DEFAULT '' AFTER `ClaveTecnica_AFC`;
/* UPDATE czautfacturacion SET idformsiigo_afc=clavetecnica_afc; */
UPDATE `czautfacturacion` SET `ClaveTecnica_AFC`='';
ALTER TABLE `gxfacturas`
	ADD INDEX `IdFE_FAC` (`IdFE_FAC`);
ALTER TABLE `gxfacturaselectronicas`
	CHANGE COLUMN `IdFE_FAC` `IdFE_FAC` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Codigo_FAC`,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_FAC`, `IdFE_FAC`) USING BTREE;
ALTER TABLE `hccampos`
	CHANGE COLUMN `Maximo_HCC` `Maximo_HCC` INT(11) NULL DEFAULT '0' AFTER `Lineas_HCC`;
ALTER TABLE `hccampos`
	CHANGE COLUMN `Tipo_HCC` `Tipo_HCC` ENUM('text','textarea','check','well','image','select','date','time','label','details') NULL DEFAULT 'text' COLLATE 'latin1_swedish_ci' AFTER `Etiqueta_HCC`;
ALTER TABLE `hccampos`
	CHANGE COLUMN `Tipo_HCC` `Tipo_HCC` ENUM('text','textarea','check','well','image','select','date','time','label','collapse') NULL DEFAULT 'text' COLLATE 'latin1_swedish_ci' AFTER `Etiqueta_HCC`;
ALTER TABLE `gxservicios`
	ADD COLUMN `xPortSiigo_SER` CHAR(1) NULL DEFAULT '0' AFTER `Complejidad_SER`;
ALTER TABLE `czradicacionesdet`
	DROP FOREIGN KEY `FK_czradicacionesdet_gxfacturas`;

