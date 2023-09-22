-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Update_DCD`='21.08.18.001' ;
TRUNCATE `czinvsolfarmacia`;
ALTER TABLE `czinvsolfarmacia`
	CHANGE COLUMN `Estado_ISF` `Estado_ISF` CHAR(1) NULL DEFAULT 'S' COMMENT 'P:Pendiente; S:Solicitado; D:Despachado' COLLATE 'utf8_general_ci' AFTER `Codigo_USR`;
ALTER TABLE `czinvsolfarmacia`
	ADD COLUMN `Ordena_ISF` VARCHAR(4) NULL DEFAULT NULL AFTER `Codigo_USR`,
	ADD INDEX `Ordena_ISF` (`Ordena_ISF`);
UPDATE `itmenu` SET `Nombre_MNU`='Inventario', `FontLogo_MNU`='fa fa-cubes' WHERE  `Codigo_MNU`=97 AND `Codigo_APP`=2 AND `Codigo_MOD`=2;
