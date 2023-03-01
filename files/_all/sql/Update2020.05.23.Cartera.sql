UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.05.31.009';
UPDATE `ititems` SET `Nombre_ITM`='Pacientes por Diagnóstico', `Enlace_ITM`='forms/nxsstatptesdx.php', `Padre_ITM`='528' WHERE  `Codigo_ITM`=533 AND `Codigo_MNU`=106 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
ALTER TABLE `gxbdcontratos`
	CHANGE COLUMN `Contrato_EPS` `Codigo_EPS` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci' FIRST,
	DROP PRIMARY KEY,
	ADD PRIMARY KEY (`Codigo_TER`, `Codigo_EPS`, `FechaIni_BDP`, `FechaFin_BDP`) USING BTREE,
	DROP INDEX `Contrato_EPS`,
	ADD INDEX `Contrato_EPS` (`Codigo_EPS`) USING BTREE;
ALTER TABLE `hctipos`
	ADD COLUMN `DescQx_HCT` CHAR(1) NOT NULL DEFAULT '0' COMMENT 'Es modelo de desc. quirurgica?' AFTER `Odontograma_HCT`;
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `SV_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`, `DescQx_HCT`, `Img_HCT`) VALUES ('QX001', 'DESCRIPCION QUIRURGICA', '2', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
ALTER TABLE `hccampos`
	CHANGE COLUMN `Nombre_HCC` `Nombre_HCC` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_HCC`,
	CHANGE COLUMN `Etiqueta_HCC` `Etiqueta_HCC` VARCHAR(255) NULL DEFAULT ' ' COLLATE 'latin1_swedish_ci' AFTER `Orden_HCC`;
ALTER TABLE `hccampos`
	CHANGE COLUMN `Tipo_HCC` `Tipo_HCC` ENUM('text','textarea','check','well','image','select','date','time', 'label') NULL DEFAULT 'text' COLLATE 'latin1_swedish_ci' AFTER `Etiqueta_HCC`;
