UPDATE `itconfig` SET `Version_DCD`='18.06.08.001';
INSERT INTO  `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `OptPrinter_ITM`, `OptNew_ITM`, `OptNo_ITM`) VALUES ('465', '93', '6', '2', 'Tratamientos Ordenados por Area', 'reports/hcttosordenados.php', '1', '1', '1');
INSERT INTO  `itreports` (`Codigo_RPT`, `Descripcion_RPT`, `SQL_RPT`, `Orientacion_RPT`) VALUES ('hcttosordenados', 'Tratamientos en un periodo por area', 'Select b.Nombre_REG, d.Sigla_TID, e.ID_TER, c.Apellido1_PAC, c.Apellido2_PAC, c.Nombre1_PAC, c.Nombre2_PAC, TIMESTAMPDIFF(YEAR,c.FechaNac_PAC,a.Fecha_HCF) AS edad, c.Codigo_SEX, e.Direccion_TER, e.Telefono_TER, concat(f.Codigo_DGN), concat(g.Descripcion_DGN), concat( group_concat(j.Nombre_SER), \' - \', group_concat(h.Indicacion_HTT) ), k.Razonsocial_DCD, concat(l.Nombre1_MED,\' \',l.Nombre2_MED,\' \',l.Apellido1_MED,\' \',l.Apellido2_MED), date(m.Fecha_ADM)\r\nFrom hcfolios a, gxtiporegimen b, gxpacientes c, cztipoid d, czterceros e, hcdiagnosticos f, gxdiagnostico g, hctratamiento h, hcordenesmedica i, gxservicios j, itconfig k, gxmedicos l, gxadmision m\r\nWhere a.Codigo_TER=c.Codigo_TER and c.Codigo_REG=b.Codigo_REG and d.Codigo_TID=e.Codigo_TID and e.Codigo_TER=c.Codigo_TER and f.Codigo_TER=a.Codigo_TER and f.Codigo_HCF=a.Codigo_HCF and g.Codigo_DGN=f.Codigo_DGN and h.Codigo_TER=a.Codigo_TER and h.Codigo_HCF=a.Codigo_HCF and i.Codigo_TER=a.Codigo_TER and i.Codigo_HCF=a.Codigo_HCF and j.Codigo_SER=i.Codigo_SER and a.Codigo_USR=l.Codigo_USR and m.Codigo_ADM=a.Codigo_ADM\r\nand a.Codigo_ARE = (\'@AREA\') and a.Fecha_HCF between \'@FECHA_INI 00:00:00\' and \'@FECHA_FIN 23:59:59\'\r\nGroup By b.Nombre_REG, d.Sigla_TID, e.ID_TER, c.Apellido1_PAC, c.Apellido2_PAC, c.Nombre1_PAC, c.Nombre2_PAC,  edad, c.Codigo_SEX, e.Direccion_TER, e.Telefono_TER, concat(f.Codigo_DGN), concat(g.Descripcion_DGN), k.Razonsocial_DCD, concat(l.Nombre1_MED,\' \',l.Nombre2_MED,\' \',l.Apellido1_MED,\' \',l.Apellido2_MED), m.Fecha_ADM', 'L');
INSERT INTO  `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcttosordenados', 'AREA', 'Area', '1', 'L');
INSERT INTO  `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcttosordenados', 'FECHA_INICIAL', 'Fecha Inicial', '2', 'D');
INSERT INTO  `itreportsparam` (`Codigo_RPT`, `Campo_RPT`, `Titulo_RPT`, `Orden_RPT`, `Tipo_RPT`) VALUES ('hcttosordenados', 'FECHA_FINAL', 'Fecha Final', '3', 'D');
UPDATE  `itreportsparam` SET `Tipo_RPT`='S' WHERE  `Codigo_RPT`='hcttosordenados' AND `Campo_RPT`='AREA' AND `Codigo_DCD`=0;
CREATE TABLE `itreportsselects` (	`Codigo_DCD` INT(5) NOT NULL DEFAULT '0',	`Codigo_RPT` VARCHAR(50) NOT NULL DEFAULT '',	`Consulta_RPT` VARCHAR(255) NOT NULL DEFAULT '',	`Comando_RPT` VARCHAR(254) NULL DEFAULT '',	PRIMARY KEY (`Codigo_RPT`, `Codigo_DCD`),	INDEX `Codigo_DCD` (`Codigo_DCD`),	INDEX `Codigo_RPT` (`Codigo_RPT`)) COLLATE='utf8_general_ci' ENGINE=InnoDB;
ALTER TABLE `itreportsselects`	ADD COLUMN `Campo_RPT` VARCHAR(50) NOT NULL DEFAULT '' AFTER `Codigo_RPT`,	DROP PRIMARY KEY,	ADD PRIMARY KEY (`Codigo_RPT`, `Codigo_DCD`, `Campo_RPT`),	ADD INDEX `Campo_RPT` (`Campo_RPT`);
INSERT INTO  `itreportsselects` (`Codigo_RPT`, `Campo_RPT`, `Consulta_RPT`) VALUES ('hcttosordenados', 'AREA', 'Select codigo_are, nombre_are from gxareas where estado_are=\'1\'');
INSERT INTO  `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `Dx_HCT`, `Indicaciones_HCT`, `Img_HCT`) VALUES ('COLPOSC', 'INFORME COLPOSCOPICO', '1', '1', '1', '1');
UPDATE  `hctipos` SET `Indicaciones_HCT`='0' WHERE  `Codigo_HCT`='COLPOSC';
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Maximo_HCC`, `Obligatorio_HCC`) VALUES ('COLPOSC', 'motivo', 'Motivo', '1', 'Motivo', '255', '1');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo01', 'Imagen1', '3', 'Imagen 1', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo02', 'Imagen2', '4', 'Imagen 2', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo03', 'Imagen3', '5', 'Imagen 3', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo04', 'Imagen4', '6', 'Imagen 4', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo05', 'Imagen5', '7', 'Imagen 5', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'imgcolpo06', 'Imagen6', '8', 'Imagen 6', 'image', '4', '0', '2');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'imagenes', '----', '2', '---', 'well', '0', '0');
UPDATE  `hccampos` SET `Etiqueta_HCC`='Agregar Imágenes' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imagenes';
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'descripcion', 'Hallazgos', '9', 'Seleccione Hallazgo', 'well', '0', '0');
UPDATE  `hccampos` SET `Codigo_HCC`='hallazgo', `Tipo_HCC`='select', `Lineas_HCC`='1', `Maximo_HCC`='2' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='descripcion';
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'hallazgo1', 'Colposcopia Normal', '10', 'Colposcopia Normal', 'well', '0', '0');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'colpo_1a', 'A. Epitelio escamoso original', '11', 'A. Epitelio escamoso original', 'check', '4', '2', '10');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'colpo_1b', 'B. Epitelio columnar', '12', 'B. Epitelio columnar', 'check', '4', '2', '10');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'colpo_1c', 'C. Zona de transformacion normal', '13', 'C. Zona de transformación normal', 'check', '4', '2', '10');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'hallazgo2', 'Colposcopia Anormal Fidedigna', '14', 'Colposcopia Anormal Fidedigna', 'well', '0', '0');
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'descripcion', '1', '1NORMAL', 'COLPOSCOPIA NORMAL');
UPDATE  `hccamposlistas` SET `Codigo_HCC`='hallazgo' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='descripcion' AND `Orden_HCC`=1;
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'hallazgo', '2', '2ANORMALF', 'ANORMAL FIDEDIGNA');
UPDATE  `hccamposlistas` SET `Texto_HCC`='COLPOSCOPIA ANORMAL FIDEDIGNA' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=2;
UPDATE  `hccampos` SET `Parametros_HCC`='style="display: none"' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo2';
UPDATE  `hccampos` SET `Parametros_HCC`='onchange="javascript: if (this.value!=\'2ANORMALF\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style.display\',\'none\'); }"' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo';
ALTER TABLE `hccampos`	CHANGE COLUMN `Parametros_HCC` `Parametros_HCC` TEXT NULL DEFAULT NULL AFTER `Obligatorio_HCC`;
UPDATE  `hccampos` SET `Parametros_HCC`='onchange="javascript: if (this.value!=\'1NORMAL\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style.display\',\'block\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style.display\',\'none\'); }"' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo';
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`) VALUES ('COLPOSC', 'colpo_2a', 'Lesion enteramente visible', '15', 'Lesión enteramente visible', 'check', '6', '2', '14');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2b', 'Lesion NO enteramente visible', '16', 'Lesión NO enteramente visible', 'check', '6', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2ba', 'A. Dentro de la zona de transformacion', '17', 'A. Dentro de la zona de transformación', 'check', '6', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb', 'B. Fuera de la zona de transformacion', '18', 'B. Fuera de la zona de transformación', 'check', '6', '2', '14', NULL);
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'hallazgo', '3', '3SOSPCANCER', 'COLPOSCOPIA SOSPECHOSA DE CANCER INVASOR');
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'hallazgo', '4', '4INSATISF', 'COLPOSCOPIA INSATISFACTORIA');
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'hallazgo', '5', '5MISCF', 'IMAGENES MISCELANEAS FIDEDIGNAS');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb1', '1. Epitelio acetoblanco', '19', '1. Epitelio acetoblanco', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb2', '2. Punteado', '20', '2. Punteado', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb3', '3. Mosaico', '21', '3. Mosaico', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb4', '4. Leucoplasi', '22', '4. Leucoplasi', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb5', '5. Epitelio yodonegativo', '23', '5. Epitelio yodonegativo', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb6', '6. Vaso atipico', '24', '6. Vaso atípico', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb1a', 'PLANO', '25', 'PLANO', 'check', '1', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_2bb1b', 'MICROCAPILAR INVOLUTIVO', '26', 'MICROCAPILAR INVOLUTIVO', 'check', '2', '2', '14', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'hallazgo4', 'Colposcopia Insatisfactoria', '27', 'Colposcopia Insatisfactoria', 'well', '0', '0');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_4a', 'Union escamolecular no visible', '28', 'Unión escamolecular no visible', 'check', '4', '2', '27', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_4b', 'Severa inflamacion o severa atrofia', '29', 'Severa inflamación o severa atrofia', 'check', '4', '2', '27', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Grupo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'colpo_4c', 'Cervix no visible', '30', 'Cervix no visible', 'check', '4', '2', '27', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Maximo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'otros', 'Otros', '31', 'Otros', '255', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`) VALUES ('COLPOSC', 'tbiopsia', 'Toma de biopsia', '32', 'Toma de Biopsia', 'select', '4', '2');
UPDATE  `hccampos` SET `Largo_HCC`='2' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='tbiopsia';
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Largo_HCC`, `Maximo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'tbiopsia2', '-', '33', '-', '2', '255', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Largo_HCC`, `Maximo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'tbiopsiaesp', 'Especifique', '34', 'Especifique', '8', '255', NULL);
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'recomendaciones', 'Recomendaciones', '35', 'Recomendaciones', 'textarea', '3', '2000', NULL);
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'tbiopsia', '1', 'NO', 'NO');
INSERT INTO  `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'tbiopsia', '2', 'SI', 'SI');
UPDATE  `hccampos` SET `Parametros_HCC`='style="display:none"' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo2';
UPDATE  `hccampos` SET `Parametros_HCC`='style="display:none"' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo4';
UPDATE  `hccampos` SET `Parametros_HCC`='onchange="javascript: if (this.value==\'1NORMAL\') { $(\'#divhallazgo1.WINDOW.\').css({ display: \'block\' });  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\'); } if (this.value==\'2ANORMALF\') { $(\'#divhallazgo1.WINDOW.\').hide();  $(\'#divhallazgo2.WINDOW.\').css({ display: \'block\' });  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\'); }  if (this.value==\'4INSATISF\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').css({ display: \'block\' }); }   if (this.value==\'5MISCF\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\');}   if (this.value==\'3SOSPCANCER\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\');}  "' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo';
INSERT INTO  `hctipos` (`Codigo_HCT`, `Nombre_HCT`, `Codigo_HCH`, `Epicrisis_HCT`, `SV_HCT`, `Antecedentes_HCT`, `Dx_HCT`, `Indicaciones_HCT`) VALUES ('HCESP01', 'NOTA MEDICA ESPECIALISTA', '1', '1', '1', '1', '1', '1');
INSERT INTO  `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Lineas_HCC`, `Maximo_HCC`, `Obligatorio_HCC`) VALUES ('HCESP01', 'nota', 'Nota Medica', '1', 'Nota Médica', 'textarea', '3', '2500', '1');
CREATE TABLE `hc_COLPOSC` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`motivo_HC` VARCHAR(255) NULL COMMENT 'Motivo',
	`imgcolpo01_HC` BLOB NULL  COMMENT 'Imagen1',
	`imgcolpo02_HC` BLOB NULL  COMMENT 'Imagen2',
	`imgcolpo03_HC` BLOB NULL  COMMENT 'Imagen3',
	`imgcolpo04_HC` BLOB NULL  COMMENT 'Imagen4',
	`imgcolpo05_HC` BLOB NULL  COMMENT 'Imagen5',
	`imgcolpo06_HC` BLOB NULL  COMMENT 'Imagen6',
	`hallazgo_HC` VARCHAR(100) NULL DEFAULT '' COMMENT 'Hallazgos',
	`colpo_1a_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'A. Epitelio escamoso original',
	`colpo_1b_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'B. Epitelio columnar',
	`colpo_1c_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'C. Zona de transformacion normal',
	`colpo_2a_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'Lesion enteramente visible',
	`colpo_2b_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'Lesion NO enteramente visible',
	`colpo_2ba_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'A. Dentro de la zona de transformacion',
	`colpo_2bb_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'B. Fuera de la zona de transformacion',
	`colpo_2bb1_HC` CHAR(1) NULL DEFAULT '0' COMMENT '1. Epitelio acetoblanco',
	`colpo_2bb2_HC` CHAR(1) NULL DEFAULT '0' COMMENT '2. Punteado',
	`colpo_2bb3_HC` CHAR(1) NULL DEFAULT '0' COMMENT '3. Mosaico',
	`colpo_2bb4_HC` CHAR(1) NULL DEFAULT '0' COMMENT '4. Leucoplasi',
	`colpo_2bb5_HC` CHAR(1) NULL DEFAULT '0' COMMENT '5. Epitelio yodonegativo',
	`colpo_2bb6_HC` CHAR(1) NULL DEFAULT '0' COMMENT '6. Vaso atipico',
	`colpo_2bb1a_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'PLANO',
	`colpo_2bb1b_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'MICROCAPILAR INVOLUTIVO',
	`colpo_4a_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'Union escamolecular no visible',
	`colpo_4b_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'Severa inflamacion o severa atrofia',
	`colpo_4c_HC` CHAR(1) NULL DEFAULT '0' COMMENT 'Cervix no visible',
	`otros_HC` VARCHAR(255) NULL DEFAULT '' COMMENT 'Otros',
	`tbiopsia_HC` CHAR(2) NULL DEFAULT '' COMMENT 'Toma de biopsia',
	`tbiopsia2_HC` VARCHAR(255) NULL DEFAULT '' COMMENT 'Toma biopsia +',
	`tbiopsiaesp_HC` VARCHAR(255) NULL DEFAULT '' COMMENT 'Especifique',
	`recomendaciones_HC` TEXT NULL DEFAULT '' COMMENT 'Recomendaciones',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`)
)
COMMENT='FORMATO INFORME COLPOSCOPICO'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `hc_HCESP01` (
	`Codigo_TER` CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci',
	`Codigo_HCF` INT(11) NOT NULL,
	`nota_HC` TEXT NULL  COMMENT 'Nota Medica',
	PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_HCF` (`Codigo_HCF`)
)
COMMENT='FORMATO NOTA MEDICA ESPECIALISTA'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo01';
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo02';
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo03';
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo04';
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo05';
UPDATE `hccampos` SET `Lineas_HCC`='180' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imgcolpo06';
UPDATE `hccampos` SET `Etiqueta_HCC`='Imágenes' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imagenes';
UPDATE `hccampos` SET `Nombre_HCC`='Imagenes' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='imagenes';
UPDATE `hccampos` SET `Largo_HCC`='3' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='colpo_2bb1b';
UPDATE `hccamposlistas` SET `Valor_HCC`='IMAGENES MISCELANEAS FIDEDIGNAS' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=5;
UPDATE `hccamposlistas` SET `Valor_HCC`='COLPOSCOPIA INSATISFACTORIA' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=4;
UPDATE `hccamposlistas` SET `Valor_HCC`='COLPOSCOPIA SOSPECHOSA DE CANCER INVASOR' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=3;
UPDATE `hccamposlistas` SET `Valor_HCC`='COLPOSCOPIA ANORMAL FIDEDIGNA' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=2;
UPDATE `hccamposlistas` SET `Valor_HCC`='COLPOSCOPIA NORMAL' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo' AND `Orden_HCC`=1;
UPDATE `hccampos` SET `Parametros_HCC`='onchange="javascript: if (this.value==\'COLPOSCOPIA NORMAL\') { $(\'#divhallazgo1.WINDOW.\').css({ display: \'block\' });  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\'); } if (this.value==\'COLPOSCOPIA ANORMAL FIDEDIGNA\') { $(\'#divhallazgo1.WINDOW.\').hide();  $(\'#divhallazgo2.WINDOW.\').css({ display: \'block\' });  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\'); }  if (this.value==\'COLPOSCOPIA INSATISFACTORIA\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').css({ display: \'block\' }); }   if (this.value==\'IMAGENES MISCELANEAS FIDEDIGNAS\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\');}   if (this.value==\'COLPOSCOPIA SOSPECHOSA DE CANCER INVASOR\') { $(\'#divhallazgo1.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo2.WINDOW.\').attr(\'style\',\'display:none\');  $(\'#divhallazgo4.WINDOW.\').attr(\'style\',\'display:none\');}  "' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo';
UPDATE `hccampos` SET `Etiqueta_HCC`='Hallazgos' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='hallazgo';
UPDATE `itreportsselects` SET `Consulta_RPT`='Select codigo_are, nombre_are, \'\' from gxareas where estado_are=\'1\'' WHERE  `Codigo_RPT`='hcttosordenados' AND `Codigo_DCD`=0 AND `Campo_RPT`='AREA';
UPDATE `itreportsselects` SET `Consulta_RPT`='Select codigo_are, nombre_are, \' \' from gxareas where estado_are=\'1\'' WHERE  `Codigo_RPT`='hcttosordenados' AND `Codigo_DCD`=0 AND `Campo_RPT`='AREA';
UPDATE `itreports` SET `SQL_RPT`='Select b.Nombre_REG, d.Sigla_TID, e.ID_TER, c.Apellido1_PAC, c.Apellido2_PAC, c.Nombre1_PAC, c.Nombre2_PAC, TIMESTAMPDIFF(YEAR,c.FechaNac_PAC,a.Fecha_HCF) AS edad, c.Codigo_SEX, e.Direccion_TER, e.Telefono_TER, concat(f.Codigo_DGN), concat(g.Descripcion_DGN), concat( group_concat(j.Nombre_SER), \' - \', group_concat(h.Indicacion_HTT) ), k.Razonsocial_DCD, concat(l.Nombre1_MED,\' \',l.Nombre2_MED,\' \',l.Apellido1_MED,\' \',l.Apellido2_MED), date(m.Fecha_ADM)\r\nFrom hcfolios a, gxtiporegimen b, gxpacientes c, cztipoid d, czterceros e, hcdiagnosticos f, gxdiagnostico g, hctratamiento h, hcordenesmedica i, gxservicios j, itconfig k, gxmedicos l, gxadmision m\r\nWhere a.Codigo_TER=c.Codigo_TER and c.Codigo_REG=b.Codigo_REG and d.Codigo_TID=e.Codigo_TID and e.Codigo_TER=c.Codigo_TER and f.Codigo_TER=a.Codigo_TER and f.Codigo_HCF=a.Codigo_HCF and g.Codigo_DGN=f.Codigo_DGN and h.Codigo_TER=a.Codigo_TER and h.Codigo_HCF=a.Codigo_HCF and i.Codigo_TER=a.Codigo_TER and i.Codigo_HCF=a.Codigo_HCF and j.Codigo_SER=i.Codigo_SER and a.Codigo_USR=l.Codigo_USR and m.Codigo_ADM=a.Codigo_ADM\r\nand a.Codigo_ARE = (\'@AREA\') and a.Fecha_HCF between \'@FECHA_INICIAL 00:00:00\' and \'@FECHA_FINAL 23:59:59\'\r\nGroup By b.Nombre_REG, d.Sigla_TID, e.ID_TER, c.Apellido1_PAC, c.Apellido2_PAC, c.Nombre1_PAC, c.Nombre2_PAC,  edad, c.Codigo_SEX, e.Direccion_TER, e.Telefono_TER, concat(f.Codigo_DGN), concat(g.Descripcion_DGN), k.Razonsocial_DCD, concat(l.Nombre1_MED,\' \',l.Nombre2_MED,\' \',l.Apellido1_MED,\' \',l.Apellido2_MED), m.Fecha_ADM' WHERE  `Codigo_RPT`='hcttosordenados' AND `Codigo_DCD`=0;
INSERT INTO `itmodulos` (`Codigo_MOD`, `Codigo_APP`, `Nombre_MOD`, `Descripcion_MOD`, `Icono_MOD`) VALUES ('19', '2', 'Calidad Y Estadística', 'Informes de calidad y estadistica', 'chart_up_color');
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES ('106', '19', '2', 'Archivo');
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES ('107', '19', '2', 'Procesos');
INSERT INTO `itmenu` (`Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_MNU`) VALUES ('108', '19', '2', 'Informes');
UPDATE `hccampos` SET `Orden_HCC`='36' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='recomendaciones';
INSERT INTO `hccampos` (`Codigo_HCT`, `Codigo_HCC`, `Nombre_HCC`, `Orden_HCC`, `Etiqueta_HCC`, `Tipo_HCC`, `Largo_HCC`, `Maximo_HCC`, `Parametros_HCC`) VALUES ('COLPOSC', 'diagnostico', 'Diagnostico', '35', 'Diagnóstico', 'select', '6', '2', NULL);
ALTER TABLE `hc_COLPOSC`	ADD COLUMN `diagnostico` VARCHAR(255) NULL DEFAULT '' COMMENT 'Diagnostico' AFTER `tbiopsiaesp_HC`;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPSOC', 'diagnostico', '1', 'NEGATIVO PARA LESION INTRAEPITELIAL O MALIGNIDAD', 'NEGATIVO PARA LESION INTRAEPITELIAL O MALIGNIDAD');
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'diagnostico', '2', 'CELULAS ENDOCERVICALES ATIPICAS', 'CELULAS ENDOCERVICALES ATIPICAS');
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'NEGATIVO PARA LESION INTRAEPITELIAL O MALIGNIDAD', 'NEGATIVO PARA LESION INTRAEPITELIAL O MALIGNIDAD');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='3', `Valor_HCC`='CELULAS ENDOMETRIALES ATIPICAS', `Texto_HCC`='CELULAS ENDOMETRIALES ATIPICAS' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'CELULAS ENDOMETRIALES ATIPICAS', 'CELULAS ENDOMETRIALES ATIPICAS');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='4', `Valor_HCC`='CELULAS GLANDULARES ATIPICAS (A G C)', `Texto_HCC`='CELULAS GLANDULARES ATIPICAS (A G C)' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'diagnostico', '5', 'ADENOCARCINOMA ENDOCERVICAL IN SITU (A IS)', 'ADENOCARCINOMA ENDOCERVICAL IN SITU (A IS)');
UPDATE `hccamposlistas` SET `Codigo_HCT`='COLPOSC' WHERE  `Codigo_HCT`='COLPSOC' AND `Codigo_HCC`='diagnostico' AND `Orden_HCC`=1;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'ADENOCARCINOMA ENDOCERVICAL IN SITU (A IS)', 'ADENOCARCINOMA ENDOCERVICAL IN SITU (A IS)');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='6', `Valor_HCC`='ADENOCARCINOMA.', `Texto_HCC`='ADENOCARCINOMA.' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
ALTER TABLE `hccamposlistas`	CHANGE COLUMN `Valor_HCC` `Valor_HCC` VARCHAR(255) NULL DEFAULT NULL AFTER `Orden_HCC`,	CHANGE COLUMN `Texto_HCC` `Texto_HCC` VARCHAR(255) NULL DEFAULT NULL AFTER `Valor_HCC`;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'diagnostico', '7', 'CELULAS ESCAMOSAS ATIPICAS DE SIGNIFICADO INDETERMINADO (ASC-US)', 'CELULAS ESCAMOSAS ATIPICAS DE SIGNIFICADO INDETERMINADO (ASC-US)');
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'diagnostico', '8', 'CELULAS ESCAMOSAS ATIPICAS QUE NO PUEDEN EXCLUIR H-S IL (ASC-H)', 'CELULAS ESCAMOSAS ATIPICAS QUE NO PUEDEN EXCLUIR H-S IL (ASC-H)');
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Codigo_HCC`, `Orden_HCC`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'diagnostico', '9', 'LESION ESCAMOSA INTRAEPITELIAL DE BAJO GRADO (L-SIL): (HPV, NIC I, displasia leve)', 'LESION ESCAMOSA INTRAEPITELIAL DE BAJO GRADO (L-SIL): (HPV, NIC I, displasia leve)');
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'LESION ESCAMOSA INTRAEPITELIAL DE BAJO GRADO (L-SIL): (HPV, NIC I, displasia leve)', 'LESION ESCAMOSA INTRAEPITELIAL DE BAJO GRADO (L-SIL): (HPV, NIC I, displasia leve)');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='10', `Valor_HCC`='LESION ESCAMOSA INTRAEPITELIAL DE ALTO GRADO (H-SIL): (Displasia moderada, severa: NIC II y NIC III)', `Texto_HCC`='LESION ESCAMOSA INTRAEPITELIAL DE ALTO GRADO (H-SIL): (Displasia moderada, severa: NIC II y NIC III)' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'LESION ESCAMOSA INTRAEPITELIAL DE ALTO GRADO (H-SIL): (Displasia moderada, severa: NIC II y NIC III)', 'LESION ESCAMOSA INTRAEPITELIAL DE ALTO GRADO (H-SIL): (Displasia moderada, severa: NIC II y NIC III)');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='11', `Valor_HCC`='CARCINOMA ESCAMOLECULAR', `Texto_HCC`='CARCINOMA ESCAMOLECULAR' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
INSERT INTO `hccamposlistas` (`Codigo_HCT`, `Valor_HCC`, `Texto_HCC`) VALUES ('COLPOSC', 'CARCINOMA ESCAMOLECULAR', 'CARCINOMA ESCAMOLECULAR');
UPDATE `hccamposlistas` SET `Codigo_HCC`='diagnostico', `Orden_HCC`='12', `Valor_HCC`='MICRO-ORGANISMOS. CAMBIOS SUGESTIVOS DE VAGINOSIS BACTERIANA', `Texto_HCC`='MICRO-ORGANISMOS. CAMBIOS SUGESTIVOS DE VAGINOSIS BACTERIANA' WHERE  `Codigo_HCT`='COLPOSC' AND `Codigo_HCC`='' AND `Orden_HCC`=0;
ALTER TABLE `hc_COLPOSC`	CHANGE COLUMN `diagnostico` `diagnostico_HC` VARCHAR(255) NULL DEFAULT '' COMMENT 'Diagnostico' AFTER `tbiopsiaesp_HC`;
INSERT INTO `cztipoid` (`Codigo_TID`, `Nombre_TID`, `Sigla_TID`) VALUES ('10', 'Permiso Especial de Permanencia', 'PE');
