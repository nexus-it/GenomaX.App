SET @NombreHC='AUTOPSIA02';
SET @DescHC='AUTOPSIA VERBAL ZONA RURAL (COVID-19)';
SET @Servixio='10234';
SET @TablaHC='hc_AUTOPSIA02';

CREATE TABLE hc_AUTOPSIA02 (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`nota_HC` TEXT(65535)  NULL COMMENT 'Nota ',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`)
)
COMMENT='AUTOPSIA VERBAL ZONA RURAL (COVID-19)'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

INSERT INTO `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `SV_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `AyudasDiag_HCT`, `Qx_HCT`, `Med_HCT`, `Ordenes_HCT`, `Incapacidad_HCT`, `Indicaciones_HCT`, `Codigo_SER`)
 VALUES (@NombreHC, @DescHC, '2', '0', '1', '1', '1', '1', '1', '1', '1', '1', @Servixio);

INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`)
 VALUES (@NombreHC, 'nota', 'Descripción de Atención', '55', 'Descripción de Atención', 'textarea', '4', '10000', '1');



INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('AUTOPSIA01', 'wel1', '1. Posible Manera de Muerte', '1', '1. Posible Manera de Muerte', 'well', '0', '0');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'otracausa', 'Encuentra evidencia si el paciente falleció por lesión, accidente, caída u otra causa', '2', 'Encuentra evidencia si el paciente falleció por lesión, accidente, caída u otra causa', 'select', '2', '1');
UPDATE `hccampos` SET `Nombre_HCC`='Encuentra evidencia si el paciente falleció por lesión, accidente, caída u otra causa', `Etiqueta_HCC`='Encuentra evidencia si el paciente falleció por lesión, accidente, caída u otra causa' WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='otracausa';
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'acctrns', 'Accidente de Tránsito', '3', 'Accidente de Tránsito', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'accdis', 'Accidente por Disparo de Arma de Fuego', '4', 'Accidente por Disparo de Arma de Fuego', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'veneno', 'Envenenamiento o Intoxiocación Accidental', '5', 'Envenenamiento o Intoxiocación Accidental', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'caida', 'Caída Accidental', '6', 'Caída Accidental', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'fuego', 'Exposición a Fuego, Humo, Llamas, Quemadura', '7', 'Exposición a Fuego, Humo, Llamas, Quemadura', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'agua', 'Ahogamiento y Sumersión', '8', 'Ahogamiento y Sumersión', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'suicid', 'Lesiones Autoinflingidas Intencionalmente (Suicidio)', '9', 'Lesiones Autoinflingidas Intencionalmente (Suicidio)', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'homic', 'Agresiones (Homicidio)', '10', 'Agresiones (Homicidio)', 'select', '4', '2', '1');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'natura', 'Desastre Natural (Avalancha, Terremoto, Explosión)', '11', 'Desastre Natural (Avalancha, Terremoto, Explosión)', 'select', '4', '2', '1');
UPDATE `gnx_sdnc`.`hccampos` SET `Nombre_HCC`='Lesiones Autoinflingidas Intencional (Suicidio)' WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='suicid';
UPDATE `gnx_sdnc`.`hccampos` SET `Etiqueta_HCC`='Lesiones Autoinflingidas Intencional (Suicidio)' WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='suicid';
UPDATE `gnx_sdnc`.`hccampos` SET `Nombre_HCC`='Desastre Natural: Avalancha, Terremoto, Explosión', `Etiqueta_HCC`='Desastre Natural: Avalancha, Terremoto, Explosión' WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='natura';
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('AUTOPSIA01', 'wel2', '2. Posibles Nexos Epidemiológicos', '12', '2. Posibles Nexos Epidemiológicos', 'well', '0', '0');
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'famil', '¿Conoce algun familiar y/o amigo cercano del fallecido está o ha estado hospitalizado en el último mes por problemas respiratorios?', '13', '¿Conoce algun familiar y/o amigo cercano del fallecido está o ha estado hospitalizado en el último mes por problemas respiratorios?', 'select', '6', '2', '12');
SELECT `Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Defecto_HCC`, `Image_HCC`, `Normalizar_HCC`, `Grupo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`, `PyP_HCC` FROM `gnx_sdnc`.`hccampos` WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='famil';
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'contac', '¿Conoce si en las últims 2 semanas previas a la muerte, tuvo contacto con una persona con diagnóstico COVID19 o en espera de resultados?', '14', '¿Conoce si en las últims 2 semanas previas a la muerte, tuvo contacto con una persona con diagnóstico COVID19 o en espera de resultados?', 'select', '6', '2', '12');
SELECT `Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Defecto_HCC`, `Image_HCC`, `Normalizar_HCC`, `Grupo_HCC`, `Obligatorio_HCC`, `Parametros_HCC`, `PyP_HCC` FROM `gnx_sdnc`.`hccampos` WHERE  `Codigo_HCT`='AUTOPSIA01' AND `Codigo_HCC`='contac';
INSERT INTO `gnx_sdnc`.`hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('AUTOPSIA01', 'contac2', '¿Conoce si en las últims 2 semanas previas a la muerte, tuvo contacto con una persona con diagnóstico COVID19 tales como hospitales, mercados u otro sitio de aglomeración?', '15', '¿Conoce si en las últims 2 semanas previas a la muerte, tuvo contacto con una persona con diagnóstico COVID19 tales como hospitales, mercados u otro sitio de aglomeración?', 'select', '6', '2', '12');
