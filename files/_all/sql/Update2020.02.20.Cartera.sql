UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.02.25.00XYrde7wwyw';
UPDATE `ititems` SET `Padre_ITM`='339' WHERE  `Codigo_ITM`=520 AND `Codigo_MNU`=59 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `AyudasDiag_HCT`, `Qx_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`, `Img_HCT`) VALUES ('HCPSC', 'HISTORIA CLINICA PSICOLOGIA', '2', '1', '1', '1', '1', '1', '1');
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'motivoc', 'Motivo de Consulta', '1', 'Motivo de Consulta', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Normalizar_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'antecedentes', 'Antecedentes', '2', 'Antecedentes', 'well', '0', '0', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'antpersonal', 'Antecedentes Personales', '3', 'Antecedentes Personales', 'textarea', '6', '2', '5000', '2', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'antfamiliar', 'Antecedentes Familiares', '4', 'Antecedentes Familiares', 'textarea', '6', '2', '5000', '2', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'areajuste', 'Areas de Ajuste', '5', 'Areas de Ajuste', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'comfamil', 'Composicion Familiar', '6', 'Composicion Familiar', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'madre', 'Madre', '7', 'Madre', 'textarea', '6', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'padre', 'Padre', '8', 'Padre', 'textarea', '6', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'emocional', 'Emocional', '9', 'Emocional', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'despsicom', 'Desarrollo Psicomotriz', '10', 'Desarrollo Psicomotriz', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'evolmedic', 'Evolución Médica', '10', 'Desarrollo Psicomotriz', 'textarea', '2', '5000', '1', NULL);
UPDATE `hccampos` SET `Orden_HCC`='11', `Etiqueta_HCC`='Evolución Médica' WHERE  `Codigo_HCT`='HCPSC' AND `Codigo_HCC`='evolmedic';
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'valpsico', 'Valoración Psicológica', '12', 'Valoración Psicológica', 'textarea', '2', '5000', '1', NULL);
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`) VALUES ('HCPSC', 'plan', 'Plan y/o Conducta', '13', 'Plan y/o Conducta', 'textarea', '2', '5000', '1', NULL);
CREATE TABLE `hc_HCPSC` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`motivoc_HC` TEXT NULL COMMENT 'Motivo Consulta',
	`antpersonal_HC` TEXT NULL COMMENT 'Antecedentes Personales',
	`antfamiliar_HC` TEXT NULL COMMENT 'Antecedentes Familiares',
	`areajuste_HC` TEXT NULL COMMENT 'Areas de Ajuste',
	`comfamil_HC` TEXT NULL COMMENT 'Composicion Familiar',
	`madre_HC` TEXT NULL COMMENT 'Madre',
	`padre_HC` TEXT NULL COMMENT 'Padre',
	`emocional_HC` TEXT NULL COMMENT 'Emocional',
	`despsicom_HC` TEXT NULL COMMENT 'Desarrollo Psicomotriz',
	`evolmedic_HC` TEXT NULL COMMENT 'Evolución Médica',
	`valpsico_HC` TEXT NULL COMMENT 'Valoración Psicológica',
	`plan_HC` TEXT NULL COMMENT 'Plan y/o Conducta',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`)
)
COMMENT='FORMATO HC PSICOLOGICA'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `czpagosenc`
	CHANGE COLUMN `Total_PGS` `Total_PGS` DECIMAL(15,2) NULL DEFAULT NULL AFTER `Codigo_BCO`;
UPDATE `ititems` SET `Enlace_ITM`='forms/nxsfactsede.php' WHERE  `Codigo_ITM`=407 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Enlace_ITM`='forms/nxsfactperiodo.php' WHERE  `Codigo_ITM`=407 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=408 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=407 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Enlace_ITM`='forms/nxsfactmesames.php' WHERE  `Codigo_ITM`=408 AND `Codigo_MNU`=44 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
