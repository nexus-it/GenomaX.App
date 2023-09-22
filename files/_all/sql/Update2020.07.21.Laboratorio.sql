UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.07.28.001';
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Descripcion_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `SV_HCT`, `Glasgow_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `PyP_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Insumos_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`) VALUES ('GNCOBST', 'HISTORIA CLINICA GINECO-OBSTETRICA', 'HISTORIA CLINICA GINECO-OBSTETRICA', '2', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Descripcion_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `SV_HCT`, `Glasgow_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `PyP_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Insumos_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`) VALUES ('HPRTSN', 'HISTORIA CLINICA HIPERTENSION', 'HISTORIA CLINICA HIPERTENSION', '2', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
ALTER TABLE `hctipos`
	ADD COLUMN `RiesgoEspecif_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `DescQx_HCT`,
	ADD COLUMN `AntGineObs_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `RiesgoEspecif_HCT`,
	ADD COLUMN `EmbarazoAct_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `AntGineObs_HCT`,
	ADD COLUMN `RiesgoObst_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `EmbarazoAct_HCT`,
	ADD COLUMN `RiesgoCardV_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `RiesgoObst_HCT`,
	ADD COLUMN `CtrlParacObs_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `RiesgoCardV_HCT`,
	ADD COLUMN `CtrlHiperTen_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `CtrlParacObs_HCT`,
	ADD COLUMN `CtrlPreNat_HCT` CHAR(1) NOT NULL DEFAULT '0' AFTER `CtrlHiperTen_HCT`;
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`) VALUES ('GNCOBST', 'motivoc', 'Motivo de Consulta', '1', 'Motivo de Consulta', 'textarea', '2', '5000', '1');
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`) VALUES ('GNCOBST', 'enfactual', 'Enfermedad Actual', '2', 'Enfermedad Actual', 'textarea', '3', '5000', '1');
UPDATE `hctipos` SET `RiesgoEspecif_HCT`='1', `AntGineObs_HCT`='1', `EmbarazoAct_HCT`='1', `RiesgoObst_HCT`='1', `CtrlParacObs_HCT`='1', `CtrlPreNat_HCT`='1' WHERE  `Codigo_HCT`='GNCOBST';
ALTER TABLE `hctipos`
	ADD COLUMN `SexoM_HCT` CHAR(1) NOT NULL DEFAULT '1' AFTER `Activo_HCT`,
	ADD COLUMN `SexoF_HCT` CHAR(1) NOT NULL DEFAULT '1' AFTER `SexoM_HCT`,
	ADD INDEX `SexoM_HCT` (`SexoM_HCT`),
	ADD INDEX `SexoF_HCT` (`SexoF_HCT`);
UPDATE `hctipos` SET `SexoM_HCT`='0' WHERE  `Codigo_HCT`='GNCOBST';
UPDATE `hctipos` SET `Glasgow_HCT`='0' WHERE  `Codigo_HCT`='GNCOBST';
UPDATE `hctipos` SET `Insumos_HCT`='0' WHERE  `Codigo_HCT`='GNCOBST';
UPDATE `hctipos` SET `Insumos_HCT`='0' WHERE  `Codigo_HCT`='HPRTSN';
UPDATE `hctipos` SET `Nombre_HCT`='HISTORIA CLINICA ENFERMEDADES CRONICAS', `RiesgoEspecif_HCT`='1', `RiesgoCardV_HCT`='1', `CtrlHiperTen_HCT`='1' WHERE  `Codigo_HCT`='HPRTSN';
ALTER TABLE `hcsv2`
	CHANGE COLUMN `Prefijo_HSV` `Prefijo_HSV` CHAR(8) NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Vinculado_HSV`,
	CHANGE COLUMN `Sufijo_HSV` `Sufijo_HSV` CHAR(8) NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Prefijo_HSV`;
UPDATE `hcsv2` SET `Prefijo_HSV`='De Pie' WHERE  `Codigo_HSV`='11';
UPDATE `hcsv2` SET `Sigla_HSV`='TA', `Prefijo_HSV`='Acostado' WHERE  `Codigo_HSV`='12';
UPDATE `hcsv2` SET `Sigla_HSV`='TA ', `Prefijo_HSV`='Sentado' WHERE  `Codigo_HSV`='13';
UPDATE `hcsv2` SET `Sigla_HSV`='TA' WHERE  `Codigo_HSV`='11';
UPDATE `hctipos` SET `SV_HCT`='4' WHERE  `Codigo_HCT`='HPRTSN';
UPDATE `hctipos` SET `Descripcion_HCT`='HISTORIA CLINICA CARDIOVASCULAR' WHERE  `Codigo_HCT`='HPRTSN';
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('11', '4', '1');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('12', '4', '2');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('13', '4', '3');
INSERT INTO `hcsv2` (`Codigo_HSV`, `Nombre_HSV`, `Sigla_HSV`, `Min_HSV`, `Max_HSV`, `Vinculado_HSV`, `Sufijo_HSV`) VALUES ('16', 'Circunferencia Abdominal', 'Circ. Abdominal', '0', '300', '', 'cms');
INSERT INTO `hcsv3` (`Codigo_HSV`, `Codigo_SV1`, `Orden_HSV`) VALUES ('16', '4', '11');
INSERT INTO hccampos(Codigo_HCT, Codigo_HCC, Nombre_HCC, Orden_HCC, Etiqueta_HCC, Tipo_HCC, Largo_HCC, Lineas_HCC, Maximo_HCC, Defecto_HCC, Normalizar_HCC, Grupo_HCC, Obligatorio_HCC, Parametros_HCC, PyP_HCC ) SELECT 'HPRTSN', a.Codigo_HCC, a.Nombre_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC, a.Lineas_HCC, a.Maximo_HCC, a.Defecto_HCC, a.Normalizar_HCC, a.Grupo_HCC, a.Obligatorio_HCC, a.Parametros_HCC, a.PyP_HCC FROM hccampos a WHERE a.Codigo_HCT='HC01';
CREATE TABLE `hcant_personales` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Consec_HCA` INT(11) NOT NULL,
	`Codigo_HCA` CHAR(3) NOT NULL COLLATE 'utf8_general_ci',
	`Patologia_HCA` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Farmacos_HCA` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Quirurgico_HCA` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Trauma_HCA` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`TBC_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Diabetes_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`HTA_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Preclamsia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Eclamsia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Qxpelvica_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Infertilidad_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`VIH_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Cardiopatia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Nefropatia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Mola_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Embectopico_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Cifoescoliosis_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Asma_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`ETS_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Rinitis_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Conmedgrave_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Antecedentes Personales de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcant_personales`
	DROP COLUMN `Consec_HCA`,
	DROP COLUMN `Codigo_HCA`;
CREATE TABLE `hcant_toxicologico` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Fumador_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Cigarrdia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Anyosfum_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Paqanyofum_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Alcohol_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`Estimula_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Otrosanttx_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Antecedentes Toxicologicos de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcant_toxicologico`
	CHANGE COLUMN `Cigarrdia_HCA` `Cigarrdia_HCA` INT NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Fumador_HCA`,
	CHANGE COLUMN `Anyosfum_HCA` `Anyosfum_HCA` INT NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Cigarrdia_HCA`,
	CHANGE COLUMN `Paqanyofum_HCA` `Paqanyofum_HCA` INT NULL DEFAULT '0' COLLATE 'utf8_general_ci' AFTER `Anyosfum_HCA`;
CREATE TABLE `hcant_alergico` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`Alimentos_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Antibioti_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Ambiente_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Otrosalerg_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Antecedentes Alergicos de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `hcant_familiar` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`fTBC_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`fDiabetes_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`fHTA_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`fPreclamsia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`fEclamsia_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`fCancervix_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`fOtrocanc_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Otrfam_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`Otrfimp_HCA` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Antecedentes Familiares de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `hcant_ginecobst` (
	`Codigo_TER` VARCHAR(10) NOT NULL COLLATE 'utf8_general_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`gGravindez_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gPartos_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gVaginal_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gCesareas_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gAbortos_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gEctopicos_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gNvivos_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gNmuertos_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gViven_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gNmuertossem1_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gNmuertossem2_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`gPesomenor_HCA` CHAR(1) NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`) USING BTREE,
	INDEX `Codigo_TER` (`Codigo_TER`) USING BTREE,
	INDEX `Codigo_HCF` (`Codigo_HCF`) USING BTREE
)
COMMENT='Antecedentes Gineco Obstetricos de HC'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `hcant_ginecobst`
	CHANGE COLUMN `gGravindez_HCA` `gGravindez_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `Codigo_HCF`,
	CHANGE COLUMN `gPartos_HCA` `gPartos_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gGravindez_HCA`,
	CHANGE COLUMN `gVaginal_HCA` `gVaginal_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gPartos_HCA`,
	CHANGE COLUMN `gCesareas_HCA` `gCesareas_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gVaginal_HCA`,
	CHANGE COLUMN `gAbortos_HCA` `gAbortos_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gCesareas_HCA`,
	CHANGE COLUMN `gEctopicos_HCA` `gEctopicos_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gAbortos_HCA`,
	CHANGE COLUMN `gNvivos_HCA` `gNvivos_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gEctopicos_HCA`,
	CHANGE COLUMN `gNmuertos_HCA` `gNmuertos_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gNvivos_HCA`,
	CHANGE COLUMN `gViven_HCA` `gViven_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gNmuertos_HCA`,
	CHANGE COLUMN `gNmuertossem1_HCA` `gNmuertossem1_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gViven_HCA`,
	CHANGE COLUMN `gNmuertossem2_HCA` `gNmuertossem2_HCA` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `gNmuertossem1_HCA`,
	ADD COLUMN `gMenarca_HCA` TEXT NULL DEFAULT NULL AFTER `gPesomenor_HCA`,
	ADD COLUMN `gMenopausia_HCA` TEXT NULL DEFAULT NULL AFTER `gMenarca_HCA`;
ALTER TABLE `hcant_ginecobst`
	ADD COLUMN `gFUM_HCA` DATE NULL DEFAULT NULL AFTER `gMenopausia_HCA`,
	ADD COLUMN `gFUP_HCA` DATE NULL DEFAULT NULL AFTER `gFUM_HCA`,
	ADD COLUMN `gFUC_HCA` DATE NULL DEFAULT NULL AFTER `gFUP_HCA`,
	ADD COLUMN `gCitologia_HCA` CHAR(1) NULL DEFAULT '0' AFTER `gFUC_HCA`,
	ADD COLUMN `gRelsex_HCA` CHAR(1) NULL DEFAULT '0' AFTER `gCitologia_HCA`,
	ADD COLUMN `gCiclosmenst_HCA` TEXT NULL DEFAULT NULL AFTER `gRelsex_HCA`,
	ADD COLUMN `gActsex_HCA` TEXT NULL DEFAULT NULL AFTER `gCiclosmenst_HCA`,
	ADD COLUMN `gMetplanif_HCA` CHAR(1) NULL DEFAULT NULL AFTER `gActsex_HCA`;
