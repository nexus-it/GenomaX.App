CREATE TABLE `hc_VALHER1` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`localizacion_HC` VARCHAR(255) NULL COMMENT 'Localización',
	`como_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Cómo se adquirió',
	`longitud_HC` VARCHAR(10) NULL DEFAULT '' COMMENT 'Longitud (cm)',
	`anchura_HC` VARCHAR(10) NULL DEFAULT '' COMMENT 'Anchura (cm)',
	`profundidad_HC` VARCHAR(10) NULL DEFAULT '' COMMENT 'Profundidad (cm)',
	`tunelizacion1_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'Tunelización: De',
	`tunelizacion2_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'A',
	`cavidad1_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'Cavidad: De',
	`cavidad2_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'A',
	`tracto1_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'Tracto Sinusal: De',
	`tracto2_HC` VARCHAR(2) NULL DEFAULT '' COMMENT 'A',
	`etiologia_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Etiología',
	`otraetiologia_HC` VARCHAR(50) NULL DEFAULT '' COMMENT 'Otra',
	`clasificacion_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Clasificación',
	`lesion_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Tipo Lesión',
	`fecha_HC` VARCHAR(10) NULL DEFAULT '' COMMENT 'Fecha (observada por 1° vez)',
	`necrotico_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Tejido Necrótico',
	`desbridamiento_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Desbridamiento',
	`escara_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Escara',
	`esfacelo_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Esfacelo',
	`granulacion_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Granulación',
	`epitelizacion_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Epitelización',
	`limpio_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Limpio',
	`hiperg_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Hipergranulación',
	`subcutaneo_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Subcutáneo',
	`tendon_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Tendón',
	`hueso_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Hueso',
	`articular_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Cáps. Articular',
	`ampolla_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Ampolla',
	`exudadocant_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Exudado (Cantidad)',
	`exudadotipo_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Exudado (Tipo)',
	`bordes_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Bordes de la Herida',
	`piel_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Piel Circundante',
	`otrapiel_HC` VARCHAR(50) NULL DEFAULT '' COMMENT 'Otra',
	`infec1_HC` CHAR(2) NULL DEFAULT '' COMMENT 'No estan presentes signos ni síntomas',
	`infec2_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Signos y síntomas presentes',
	`infec3_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Aumento del dolor',
	`infec4_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Eritema',
	`infec5_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Edema',
	`infec6_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Ardor/Calor',
	`infec7_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Exudado purulento',
	`infec8_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Cicatrización retardada',
	`infec9_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Tejido de granulación decolorado',
	`infec10_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Tejido de granulación friable',
	`infec13_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Desintegración de la herida',
	`infec12_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Olor fétido',
	`infec11_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Embolsamiento en la base de la herida',
	`observacion_HC` TEXT NULL  COMMENT 'Observaciones',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`)
)
COMMENT='FORMATO VALORACION DE HERIDA'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
