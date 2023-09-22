UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.02.04.001';
INSERT INTO `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`) VALUES ('pagoscartera', 'Pagos recibidos en cartera', 'SELECT a.Codigo_PGS, a.Fecha_PGS, d.Nombre_TER, e.Nombre_FPG, f.Nombre_BCO, a.Total_PGS, a.Observaciones_PGS, a.Codigo_USR, a.Estado_PGS,\r\nb.Codigo_FAC, c.Fecha_FAC, c.Codigo_RAD, c.Fecha_CAR, c.ValorFac_CAR, c.ValorDeb_CAR, c.ValorCre_CAR, c.ValPagos_CAR, c.Saldo_CAR, b.Valor_PGS,  (c.Saldo_CAR - b.Valor_PGS) AS \'VALOR DESPUES DE PAGO\'\r\nFROM czpagosenc a, czpagosdet b, czcartera c, czterceros d, czformasdepago e, czbancos f\r\nWHERE a.Codigo_PGS=b.Codigo_PGS AND b.Codigo_FAC=c.Codigo_FAC AND d.Codigo_TER=a.Codigo_TER AND e.Codigo_FPG=a.Codigo_FPG\r\nAND f.Codigo_BCO=a.Codigo_BCO AND a.Codigo_PGS BETWEEN \'@CODIGO_INICIAL\' AND \'@CODIGO_FINAL\'');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Search_RPT`) VALUES ('pagoscartera', 'CODIGO_INICIAL', 'Codigo Inicial', '1', 'PagosCartera');
INSERT INTO `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Search_RPT`) VALUES ('pagoscartera', 'CODIGO_FINAL', 'Codigo Final', '2', 'PagosCartera');
UPDATE `itreports` SET `Orientacion_RPT`='L' WHERE  `Codigo_RPT`='pagoscartera' AND `Codigo_DCD`=0;
UPDATE `ititems` SET `Enlace_ITM`='forms/res256.php' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='0' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Resolución 0256 de 2016' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OpSave_ITM`='0' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='document_redirect.png' WHERE  `Codigo_ITM`=468 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Activo_ITM`='0' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
CREATE TABLE `itconfig_cl` (
	`ConsecRes256_XCL` INT(11) NULL DEFAULT '01' COMMENT 'Consecutivo Resol. 256'
)
COMMENT='Parametros CALIDAD'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
INSERT INTO `itconfig_cl` (`ConsecRes256_XCL`) VALUES ('0');


UPDATE `ititems` SET `Nombre_ITM`='Resolucion 1552 de 2013', `Enlace_ITM`='forms/res1552.php', `OpSave_ITM`='0', `Activo_ITM`='1' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Resolución 1552 de 2013' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='column_tree.png' WHERE  `Codigo_ITM`=469 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
ALTER TABLE `hcincapacidades`
	CHANGE COLUMN `Observaciones_INC` `Observaciones_INC` TEXT NULL DEFAULT NULL AFTER `Codigo_HTI`;
