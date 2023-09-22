SET @NombreHC='COVID10224';
SET @DescHC='CONSULTA DE PRIMERA VEZ POR MEDICINA GENERAL MUNICIPIO (COVID-19)';
SET @Servixio='10224';
SET @TablaHC='hc_COVID10224';

CREATE TABLE hc_COVID10224 (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`motivoc_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Motivo Consulta' COLLATE 'utf8_general_ci',
	`enfactual_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Enfermedad Actual' COLLATE 'utf8_general_ci',
	`cabycue_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Cabeza y Cuello' COLLATE 'utf8_general_ci',
	`torax_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Torax' COLLATE 'utf8_general_ci',
	`abdomen_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Abdomen' COLLATE 'utf8_general_ci',
	`extrem_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Extremidades' COLLATE 'utf8_general_ci',
	`piel_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Piel' COLLATE 'utf8_general_ci',
	`genital_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Genitales' COLLATE 'utf8_general_ci',
	`orgsentidos_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Organos de los Sentidos' COLLATE 'utf8_general_ci',
	`neurolog_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Neurologico' COLLATE 'utf8_general_ci',
	`sistgeneral_HC` TEXT(65535) NULL DEFAULT NULL COMMENT 'Sistema General' COLLATE 'utf8_general_ci',
	`sistresp_HC` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`sistcardio_HC` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`sistgastro_HC` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`sistgenito_HC` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`sistnerv_HC` TEXT(65535) NULL DEFAULT NULL  COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='CONSULTA DE PRIMERA VEZ POR MEDICINA GENERAL MUNICIPIO (COVID-19)'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `SV_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`, `Codigo_SER`)
 VALUES (@NombreHC, @DescHC, '2', '0', '1', '1', '1', '1', '1', '1', '1', '1', @Servixio);

INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`,   `Lineas_HCC`, `Maximo_HCC`, `Defecto_HCC`, `Image_HCC`,  `Normalizar_HCC`,  `Grupo_HCC`,  `Obligatorio_HCC`, `Parametros_HCC`,  `PyP_HCC`)
SELECT @NombreHC,  `Codigo_HCC`,  `Nombre_HCC`,  `Orden_HCC`,  `Etiqueta_HCC`,  `Tipo_HCC`,  `Largo_HCC`,  `Lineas_HCC`,  `Maximo_HCC`,  `Defecto_HCC`,  `Image_HCC`,  `Normalizar_HCC`,  `Grupo_HCC`,  `Obligatorio_HCC`, `Parametros_HCC`,  `PyP_HCC` FROM `hccampos` WHERE CODIGO_HCT='HC01'

INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Defecto_HCC`, `Grupo_HCC`, `Obligatorio_HCC`) 
VALUES (@NombreHC, 'sistnerv', 'Sistema Nervioso', '15', 'Sistema Nervioso', 'textarea', '2', '5000', 'NIEGA SINTOMATOLOGIA', '12', '1');
