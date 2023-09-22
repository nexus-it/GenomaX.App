-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.05.10.001' ;
ALTER TABLE `gxpacientes`
	CHANGE COLUMN `EstCivil_PAC` `EstCivil_PAC` VARCHAR(40) NULL DEFAULT 'SOLTERO (A)' COLLATE 'utf8_general_ci' AFTER `FechaNac_PAC`;
ALTER TABLE `gxpacientes`
	ADD COLUMN `Afiliacion_PAC` DATE NULL DEFAULT NULL AFTER `Codigo_SEX`;
UPDATE `ititems` SET `Icono_ITM`='1.LastThreeMonths.png', `Enlace_ITM`='forms/mastercont.php?table=czfuentescont', `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `czfuentescont`
	CHANGE COLUMN `Codigo_FNC` `Codigo_FNC` CHAR(6) NOT NULL COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST,
	CHANGE COLUMN `Nombre_FNC` `Nombre_FNC` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Nombre Comprobante' COLLATE 'utf8_general_ci' AFTER `Codigo_FNC`,
	CHANGE COLUMN `Consec_FNC` `Consec_FNC` CHAR(6) NULL DEFAULT '0' COMMENT 'Consecutivo' COLLATE 'utf8_general_ci' AFTER `Nombre_FNC`;
INSERT INTO `hcodontogramasimbolos` (`Codigo_OGS`, `Descripcion_OGS`, `Estado_OGS`) VALUES ('49', 'DIENTE EXTRAIDO', '1');
ALTER TABLE `hctipocuraciones`
	CHANGE COLUMN `Nombre_HTC` `Nombre_HTC` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci' AFTER `Codigo_HTC`;
UPDATE `ititems` SET `Nombre_ITM`='Facturación de Cuentas Evento' WHERE  `Codigo_ITM`=296 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `hctipocuraciones` SET `Nombre_HTC`='Convencional Baja Complejidad' WHERE  `Codigo_HTC`=1;
UPDATE `hctipocuraciones` SET `Nombre_HTC`='Convencional Mediana Complejidad' WHERE  `Codigo_HTC`=2;
UPDATE `hctipocuraciones` SET `Nombre_HTC`='Convencional Alta Complejidad' WHERE  `Codigo_HTC`=3;
UPDATE `hctipocuraciones` SET `Nombre_HTC`='Con Tecnologia Area General' WHERE  `Codigo_HTC`=4;
INSERT INTO `hctipocuraciones` (`Codigo_HTC`, `Nombre_HTC`, `Codigo_SER`) VALUES ('5', 'Con Tecnologia Area Especial', '8285');
UPDATE `itreports` SET `SQL_RPT`='SELECT concat(c.Codigo_CIT,\'-\',c.Codigo_AGE) AS \'CODIGO CEX\', j.Sigla_TID AS \'TIPO DOC.\', d.ID_TER AS \'IDENTIFICACION\', a.Codigo_SEX AS \'GENERO\', d.Nombre_TER AS \'NOMBRE PACIENTE\', FechaNac_PAC as \'FEC NAC.\', TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS \'EDAD\', \r\n v.Nombre_MUN AS \'MUNICIPIO\', d.Telefono_TER AS \'TELEFONOS\', d.Direccion_TER AS \'DIRECCION\', i.Nombre_EPS AS \'CONTRATO\', pla.Nombre_PLA AS \'REGIMEN\', g.Nombre_ARE AS \'AREA\', h.Nombre_CNS AS \'CONSULTORIO\', c.Hora_AGE AS \'TURNO\', c.Fecha_AGE AS \'FECHA CITA\', c.FechaDeseada_CIT AS \'FECHA DESEADA\' , c.FechaGraba_CIT AS \'FECHA ASIGNACION\', \r\n  (case c.Estado_CIT when \'X\' then \'CANCELADA\' when \'R\' then \'REPROGRAMADA\' ELSE ( case  when tp.Nombre_HCT IS NULL then \'NO ATENDIDO\' ELSE \'ATENDIDO\' END) END) AS \'ESTADO\', gx.Codigo_DGN as \'Cod. Dx.\', gx.Descripcion_DGN AS \'DIAGNOSTICO\', tp.Nombre_HCT AS \'TIPO HC\', \r\n f.Nombre_ESP AS \'ESPECIALIDAD\',e.ID_TER  AS \'ID MEDICO\',e.Nombre_TER  AS \'NOMBRE DEL MEDICO\', case c.TipoConsulta_CIT when \'1\' then \'PRIMERA VEZ\' ELSE \'CONTROL\' END AS \'TIPO CITA\', u.ID_USR AS \'COD. USUARIO\', u.Nombre_USR AS \'NOMBRE USUARIO\'\r\nFrom gxpacientes a, czterceros d, gxareas g, gxconsultorios h, gxeps i, cztipoid j, itusuarios u, czmunicipios v, gxcitasmedicas c \r\nLEFT JOIN gxagendacab b ON c.Codigo_AGE=b.Codigo_AGE\r\nLEFT JOIN czterceros e ON e.Codigo_TER=b.Codigo_TER\r\nLEFT JOIN gxespecialidades f ON f.Codigo_ESP=b.Codigo_ESP\r\nLEFT JOIN gxmedicos med ON med.Codigo_TER=e.Codigo_TER \r\nLEFT JOIN hcfolios r ON r.Codigo_TER=c.Codigo_TER  AND r.Fecha_HCF=c.Fecha_AGE AND med.Codigo_USR=r.Codigo_USR\r\nLEFT JOIN gxadmision ad ON ad.Codigo_ADM=r.Codigo_ADM\r\nLEFT JOIN gxplanes pla ON ad.Codigo_PLA=pla.Codigo_PLA\r\nLEFT JOIN hcdiagnosticos dx ON dx.Codigo_TER=r.Codigo_TER -- AND r.Codigo_HCF =dx.Codigo_HCF\r\nLEFT JOIN hctipoatencion ate ON ate.Codigo_HTA=r.Codigo_HTA\r\nLEFT JOIN gxdiagnostico gx ON gx.Codigo_DGN=dx.Codigo_DGN\r\nLEFT JOIN hctipos tp ON tp.Codigo_HCT=r.Codigo_HCT\r\n\r\nWHERE a.Codigo_MUN=v.Codigo_MUN AND a.Codigo_DEP=v.Codigo_DEP AND a.Codigo_TER=d.Codigo_TER AND a.Codigo_TER=c.Codigo_TER and j.Codigo_TID=d.Codigo_TID AND u.Codigo_USR=c.Codigo_USR\r\nand g.Codigo_ARE=b.Codigo_ARE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS  AND Estado_AGE=\'1\' \r\n\r\n AND @VARFECHA  between \'@FECHA_INICIAL\' and \'@FECHA_FINAL 23:59:59\'  \r\n\r\n GROUP BY c.Codigo_CIT\r\n\r\n \r\n Order By  5,2,3,6,1,7' WHERE  `Codigo_RPT`='citasxdia' AND `Codigo_DCD`=0;
CREATE TABLE `czconceptosretencion` (
	`Codigo_RTE` CHAR(4) NOT NULL COMMENT 'Codigo',
	`Nombre_RTE` VARCHAR(254) NULL DEFAULT NULL COMMENT 'Nombre',
	`BaseMin_RTE` INT NULL DEFAULT '0' COMMENT 'Base Mínima',
	`Tasa_RTE` DECIMAL(10,2) NULL DEFAULT '0' COMMENT 'Tasa %',
	PRIMARY KEY (`Codigo_RTE`),
	INDEX `BaseMin_RTE` (`BaseMin_RTE`)
)
COMMENT='Conceptos de Retencion'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
UPDATE `ititems` SET `Icono_ITM`='document_move.png', `Enlace_ITM`='forms/mastercont.php?table=czconceptosretencion', `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=8 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `czconceptosretencion`
	ADD COLUMN `BaseMinUVT` INT NULL DEFAULT '0' COMMENT 'Base Mínima UVT' AFTER `Nombre_RTE`,
	CHANGE COLUMN `BaseMin_RTE` `BaseMinPesos_RTE` INT(11) NULL DEFAULT '0' COMMENT 'Base Mínima Pesos' AFTER `BaseMinUVT`,
	DROP INDEX `BaseMin_RTE`,
	ADD INDEX `BaseMin_RTE` (`BaseMinPesos_RTE`) USING BTREE;
ALTER TABLE `czconceptosretencion`
	CHANGE COLUMN `BaseMinPesos_RTE` `BaseMinPesos_RTE` INT(11) NULL DEFAULT '0' COMMENT 'Valor Base Mínima' AFTER `BaseMinUVT`,
	ADD COLUMN `TipoBase_RTE` ENUM('PESOS','PORCENTAJE') NULL DEFAULT NULL COMMENT 'Tipo Base' AFTER `BaseMinPesos_RTE`;
ALTER TABLE `czbancos`
	COMMENT='Cuentas de Bancos';
ALTER TABLE `czconceptosretencion`
	ADD COLUMN `Estado_RTE` CHAR(1) NULL DEFAULT '1' COMMENT 'Activo' AFTER `Tasa_RTE`,
	ADD INDEX `Estado_RTE` (`Estado_RTE`);
ALTER TABLE `czconceptosretencion`
	CHANGE COLUMN `Codigo_RTE` `Codigo_RTE` CHAR(6) NOT NULL COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST;
ALTER TABLE `czconceptosretencion`
	CHANGE COLUMN `Nombre_RTE` `Nombre_RTE` VARCHAR(400) NULL DEFAULT NULL COMMENT 'Nombre' COLLATE 'utf8_general_ci' AFTER `Codigo_RTE`;
Insert Into czconceptosretencion() Values ('RTE01', 'Compras generales (declarantes)', '27', '980000 ', 'PESOS', '2.50', '1');
Insert Into czconceptosretencion() Values ('RTE02', 'Compras generales (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE03', 'Compras con tarjeta débito o crédito', '0', '0.00', 'PESOS', '1.50', '1');
Insert Into czconceptosretencion() Values ('RTE04', 'Compras de bienes o productos agrícolas o pecuarios sin procesamiento industrial', '92', '3340000 ', 'PESOS', '1.50', '1');
Insert Into czconceptosretencion() Values ('RTE05', 'Compras de bienes o productos agrícolas o pecuarios con procesamiento industrial (declarantes)', '27', '980000 ', 'PESOS', '2.50', '1');
Insert Into czconceptosretencion() Values ('RTE06', 'Compras de bienes o productos agrícolas o pecuarios con procesamiento industrial declarantes (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE07', 'Compras de café pergamino o cereza', '160', '5809000 ', 'PESOS', '0.50', '1');
Insert Into czconceptosretencion() Values ('RTE08', 'Compras de combustibles derivados del petróleo', '0', '0.00', 'PESOS', '0.10', '1');
Insert Into czconceptosretencion() Values ('RTE09', 'Enajenación de activos fijos de personas naturales (notarías y tránsito son agentes retenedores)', '0', '0.00', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE10', 'Compras de vehículos', '0', '0.00', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE11', 'Compras de bienes raíces cuya destinación y uso sea vivienda de habitación (por las primeras 20000 UVT. es decir hasta $732160000)', '0', '0.00', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE12', 'Compras de bienes raíces cuya destinación y uso sea vivienda de habitación (exceso de las primeras 20000 UVT. es decir superior a $732160.000)', '20000', '726160000 ', 'PESOS', '2.50', '1');
Insert Into czconceptosretencion() Values ('RTE13', 'Compras de bienes raíces cuya destinación y uso sea distinto a vivienda de habitación', '0', '0.00', 'PESOS', '2.50', '1');
Insert Into czconceptosretencion() Values ('RTE14', 'Servicios generales (declarantes)', '4', '145000 ', 'PESOS', '4', '1');
Insert Into czconceptosretencion() Values ('RTE15', 'Servicios generales (no declarantes)', '4', '145000 ', 'PESOS', '6', '1');
Insert Into czconceptosretencion() Values ('RTE16', 'Por emolumentos eclesiásticos (declarantes)', '27', '980000 ', 'PESOS', '4', '1');
Insert Into czconceptosretencion() Values ('RTE17', 'Por emolumentos eclesiásticos (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE18', 'Servicios de transporte de carga', '4', '145000 ', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE19', 'Servicios de transporte nacional de pasajeros por vía terrestre (declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE20', 'Servicios de transporte nacional de pasajeros por vía terrestre (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE21', 'Servicios de transporte nacional de pasajeros por vía aérea o marítima', '4', '145000 ', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE22', 'Servicios prestados por empresas de servicios temporales (sobre AIU)', '4', '145000 ', 'PESOS', '1', '1');
Insert Into czconceptosretencion() Values ('RTE23', 'Servicios prestados por empresas de vigilancia y aseo (sobre AIU)', '4', '145000 ', 'PESOS', '2', '1');
Insert Into czconceptosretencion() Values ('RTE24', 'Servicios integrales de salud prestados por IPS', '4', '145000 ', 'PESOS', '2', '1');
Insert Into czconceptosretencion() Values ('RTE25', 'Servicios de hoteles y restaurantes (declarantes)', '4', '145000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE26', 'Servicios de hoteles y restaurantes (no declarantes)', '4', '145000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE27', 'Arrendamiento de bienes muebles', '0', '0.00', 'PESOS', '4', '1');
Insert Into czconceptosretencion() Values ('RTE28', 'Arrendamiento de bienes inmuebles (declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE29', 'Arrendamiento de bienes inmuebles (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE30', 'Otros ingresos tributarios (declarantes)', '27', '980000 ', 'PESOS', '2.50', '1');
Insert Into czconceptosretencion() Values ('RTE31', 'Otros ingresos tributarios (no declarantes)', '27', '980000 ', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE32', 'Honorarios y comisiones (personas jurídicas)', '0', '0.00', 'PESOS', '11', '1');
Insert Into czconceptosretencion() Values ('RTE33', 'Honorarios y comisiones pagados a personas naturales que suscriban contratos por más de 3300 Uvt o que la sumatoria de los pagos o abonos en cuenta durante el año gravable superen 3300 UVT ($117503000)', '0', '0.00', 'PESOS', '11', '1');
Insert Into czconceptosretencion() Values ('RTE34', 'Honorarios y comisiones (no declarantes)', '0', '0.00', 'PESOS', '10', '1');
Insert Into czconceptosretencion() Values ('RTE35', 'Servicios de licenciamiento o derecho de uso de software', '0', '0.00', 'PESOS', '3.50', '1');
Insert Into czconceptosretencion() Values ('RTE36', 'Intereses o rendimientos financieros', '0', '0.00', 'PESOS', '7', '1');
Insert Into czconceptosretencion() Values ('RTE37', 'Rendimientos financieros provenientes de títulos de renta fija', '0', '0.00', 'PESOS', '4', '1');
Insert Into czconceptosretencion() Values ('RTE38', 'Loterías. rifas. apuestas y similares', '48', '1743000', 'PESOS', '20', '1');
Insert Into czconceptosretencion() Values ('RTE39', 'Retención en colocación independiente de juegos de suerte y azar', '5', '182000', 'PESOS', '3', '1');
Insert Into czconceptosretencion() Values ('RTE40', 'Contratos de construcción y urbanización', '0', '0.00', 'PESOS', '2', '1');
Insert Into czconceptosretencion() Values ('RTE41', 'Pagos o abonos en cuenta por concepto de intereses. comisiones. honorarios. regalías. arrendamientos. compensaciones por servicios personales. o explotación de toda especie de propiedad industrial o del know-how. prestación de servicios. beneficios o regalías provenientes de la propiedad literaria. artística y científica. explotación de películas cinematográficas y explotación de software', '0', '0.00', 'PESOS', '20', '0');
Insert Into czconceptosretencion() Values ('RTE42', 'Pagos o abonos en cuenta por concepto de consultorías. servicios técnicos y de asistencia técnica. prestados por personas no residentes o no domiciliadas en Colombia.', '0', '0.00', 'PESOS', '20', '0');
Insert Into czconceptosretencion() Values ('RTE43', 'Pagos o abonos en cuenta por concepto de rendimientos financieros. realizados a personas no residentes o no domiciliadas en el país. originados en créditos obtenidos en el exterior por término igual o superior a un (1) año o por concepto de intereses o costos financieros del canon de arrendamiento originados en contratos de leasing que se celebre directamente o a través de compañías de leasing con empresas extranjeras sin domicilio en Colombia.', '0', '0.00', 'PESOS', '15', '0');
Insert Into czconceptosretencion() Values ('RTE44', 'Pagos o abonos en cuenta. originados en contratos de leasing sobre naves. helicópteros y/o aerodinos. así como sus partes que se celebren directamente o a través de compañías de leasing. con empresas extranjeras sin domicilio en Colombia', '0', '0.00', 'PESOS', '1', '0');
Insert Into czconceptosretencion() Values ('RTE45', 'Pagos o abonos en cuenta por concepto de rendimientos financieros o intereses. realizados a personas no residentes o no domiciliadas en el país. originados en créditos o valores de contenido crediticio. por término igual o superior a ocho (8) años, destinados a la financiación de proyectos de infraestructura bajo el esquema de Asociaciones Público-Privadas en el marco de la Ley 1508 de 2012', '0', '0.00', 'PESOS', '5', '0');
Insert Into czconceptosretencion() Values ('RTE46', 'Pagos o abonos en cuenta por concepto de prima cedida por reaseguros realizados a personas no residentes o no domiciliadas en el país', '0', '0.00', 'PESOS', '1', '0');
Insert Into czconceptosretencion() Values ('RTE47', 'Pagos o abono en cuenta por concepto de administración o dirección de que trata el artículo 124 del estatuto tributario. realizados a personas no residentes o no domiciliadas en el país', '0', '0.00', 'PESOS', '33', '0');
ALTER TABLE `czcentrocosto`
	CHANGE COLUMN `Codigo_CCT` `Codigo_CCT` CHAR(6) NOT NULL DEFAULT '' COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST,
	CHANGE COLUMN `Nombre_CCT` `Nombre_CCT` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Nombre Centro de Costo' COLLATE 'utf8_general_ci' AFTER `Codigo_CCT`,
	DROP COLUMN `Codigo_DCD`;
UPDATE `ititems` SET `Icono_ITM`='centos.png', `Enlace_ITM`='forms/mastercont.php?table=czcentrocosto', `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=4 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `czbancos`
	CHANGE COLUMN `Codigo_BCO` `Codigo_BCO` CHAR(4) NOT NULL COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST,
	CHANGE COLUMN `Nombre_BCO` `Nombre_BCO` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Nombre' COLLATE 'utf8_general_ci' AFTER `Codigo_BCO`,
	CHANGE COLUMN `TipoCta_BCO` `TipoCta_BCO` ENUM('Ahorros','Corriente') NULL DEFAULT NULL COMMENT 'Tipo de Cuenta' COLLATE 'utf8_general_ci' AFTER `Nombre_BCO`,
	CHANGE COLUMN `CuentaNo_BCO` `CuentaNo_BCO` VARCHAR(20) NULL DEFAULT NULL COMMENT 'Cuenta No.' COLLATE 'utf8_general_ci' AFTER `TipoCta_BCO`,
	ADD COLUMN `Codigo_CTA` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta Contable' AFTER `CuentaNo_BCO`,
	CHANGE COLUMN `Estado_BCO` `Estado_BCO` CHAR(1) NULL DEFAULT '1' COMMENT 'Activo' COLLATE 'utf8_general_ci' AFTER `Codigo_CTA`;
UPDATE `ititems` SET `Icono_ITM`='bank.png', `Enlace_ITM`='forms/mastercont.php?table=czbancos', `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=2 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `czcajas`
	CHANGE COLUMN `Codigo_CJA` `Codigo_CJA` CHAR(4) NOT NULL COMMENT 'Codigo' COLLATE 'utf8_general_ci' FIRST,
	CHANGE COLUMN `Nombre_CJA` `Nombre_CJA` VARCHAR(60) NULL DEFAULT NULL COMMENT 'Nombre Caja' COLLATE 'utf8_general_ci' AFTER `Codigo_CJA`,
	CHANGE COLUMN `SaldoIni_CJA` `SaldoIni_CJA` DECIMAL(14,2) NULL DEFAULT '0.00' COMMENT 'Saldo' AFTER `Nombre_CJA`,
	ADD COLUMN `Codigo_CTA` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta Contable' AFTER `SaldoIni_CJA`,
	CHANGE COLUMN `Abierta_CJA` `Abierta_CJA` CHAR(1) NULL DEFAULT '1' COMMENT 'Abierta' COLLATE 'utf8_general_ci' AFTER `Codigo_CTA`,
	CHANGE COLUMN `Estado_CJA` `Estado_CJA` CHAR(1) NULL DEFAULT '1' COMMENT 'Activa' COLLATE 'utf8_general_ci' AFTER `Abierta_CJA`,
	DROP COLUMN `Codigo_DCD`,
	ADD INDEX `Codigo_CTA` (`Codigo_CTA`);
UPDATE `ititems` SET `Icono_ITM`='safe.png', `Enlace_ITM`='forms/mastercont.php?table=czcajas', `OptPrinter_ITM`='0', `OptNew_ITM`='0', `OptNo_ITM`='0', `OpSave_ITM`='0' WHERE  `Codigo_ITM`=3 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('572', '53', '1', '2', 'Interfaces Contables', 'interface_preferences.png', 'forms/ctinterface.php', '5');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`) VALUES ('573', '53', '1', '2', 'Movimientos Contables', 'sallary_deferrais.png', 'forms/ctinterface.php', '5');
UPDATE `ititems` SET `Enlace_ITM`='forms/ctmovimientos.php', `Padre_ITM`='0' WHERE  `Codigo_ITM`=573 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_ITM`='575' WHERE  `Codigo_ITM`=572 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_ITM`='576' WHERE  `Codigo_ITM`=573 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Catálogo de Cuentas' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
CREATE TABLE `czimpuestos` (
	`Codigo_IVA` CHAR(6) NOT NULL COMMENT 'Codigo',
	`Nombre_IVA` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Nombre',
	`Tipo_IVA` ENUM('IVA','ICO', 'Otro') NULL DEFAULT 'IVA' COMMENT 'Tipo',
	`Porcentaje_IVA` DECIMAL(10,2) NULL DEFAULT '0' COMMENT 'Porcentaje',
	`CodigoV_CTA` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta Ventas',
	`CodigoC_CTA` VARCHAR(10) NULL DEFAULT NULL COMMENT 'Cuenta Compras',
	`Estado_IVA` CHAR(1) NULL DEFAULT '1' COMMENT 'Activo',
	PRIMARY KEY (`Codigo_IVA`),
	INDEX `Estado_IVA` (`Estado_IVA`)
)
COMMENT='Impuestos'
COLLATE='utf8_general_ci'
;
UPDATE `ititems` SET `Codigo_ITM`='578' WHERE  `Codigo_ITM`=576 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_ITM`='577' WHERE  `Codigo_ITM`=575 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_ITM`='576' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('9', '53', '1', '2', 'Conceptos de Retención', 'document_move.png', 'forms/mastercont.php?table=czconceptosretencion', '5', '0');
UPDATE `ititems` SET `Nombre_ITM`='Configuración Impuestos', `Icono_ITM`='coins_in_hand.png' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Enlace_ITM`='forms/mastercont.php?table=czimpuestos' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Nombre_ITM`='Ajustes Contables' WHERE  `Codigo_ITM`=578 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`) VALUES ('579', '53', '1', '2', 'Asientos Contables', 'sallary_deferrais.png', 'forms/ctmovimientos.php');
UPDATE `ititems` SET `Icono_ITM`='column_double.png' WHERE  `Codigo_ITM`=578 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('580', '53', '1', '2', 'Reportes');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('581', '53', '1', '2', 'Información Exógena');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`) VALUES ('582', '53', '1', '2', 'Certificados Retención');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('583', '53', '1', '2', 'Estado de Resultados', 'forms/ctestadosresultados.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('584', '53', '1', '2', 'Balance General', 'forms/ctbalancegeneral.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('585', '53', '1', '2', 'Balance de prueba por Terceros', 'forms/ctbalanceprueba.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('586', '53', '1', '2', 'Auxiliar por Tercero', 'forms/ctauxiliartercero.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('587', '53', '1', '2', 'Libro Diario', 'forms/ctlibrodiario.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('588', '53', '1', '2', 'Libro Mayor', 'forms/ctlibromayor.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('589', '53', '1', '2', 'Reporte Diario de Ventas', 'forms/ctdiarioventas.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('590', '53', '1', '2', 'Impuestos y Retenciones', 'forms/ctimpyret.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Enlace_ITM`, `Padre_ITM`, `OpSave_ITM`) VALUES ('591', '53', '1', '2', 'Movimientos por Cuenta Contable', 'forms/ctmovporcuenta.php', '580', '0');
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OpSave_ITM`) VALUES ('592', '53', '1', '2', 'Movimientos Bancos', 'company_generosity.png', 'forms/ctmovbancos.php', '0');
UPDATE `ititems` SET `Icono_ITM`='ssl_certificates.png', `Enlace_ITM`='forms/ctcertretencion.php' WHERE  `Codigo_ITM`=582 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='table_multiple.png', `Enlace_ITM`='forms/ctexogena.php' WHERE  `Codigo_ITM`=581 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
ALTER TABLE `hcfolios`
	DROP INDEX `Hora_HCF`;
ALTER TABLE `gxmedicos`
	DROP INDEX `RM_MED`;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=411 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='database_table.png' WHERE  `Codigo_ITM`=449 AND `Codigo_MNU`=50 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
ALTER TABLE `gxfacturas`
	CHANGE COLUMN `Nota_FAC` `Nota_FAC` TEXT(65535) NULL COLLATE 'utf8_general_ci' AFTER `Tipo_FAC`;
CREATE TABLE `czmovcontcab` (
	`Consec_CNT` INT NOT NULL,
	`Codigo_FNC` CHAR(6) NULL DEFAULT NULL,
	`Fecha_CNT` DATE NULL DEFAULT NULL,
	`Consec_FNC` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Consecutivo del movimiento por fuente',
	`Referencia_CNT` VARCHAR(50) NULL DEFAULT NULL,
	`Observaciones_CNT` VARCHAR(200) NULL DEFAULT NULL,
	`Total_CNT` DECIMAL(10,2) NULL DEFAULT NULL,
	INDEX `Codigo_FNC_Consec_FNC` (`Codigo_FNC`, `Consec_FNC`),
	INDEX `Fecha_CNT` (`Fecha_CNT`),
	PRIMARY KEY (`Consec_CNT`)
)
COMMENT='Encabezados de Movimientos Contables'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
UPDATE `ititems` SET `Nombre_ITM`='Movimientos Contables', `Enlace_ITM`='forms/ctmovcont.php' WHERE  `Codigo_ITM`=578 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Activo_ITM`='0' WHERE  `Codigo_ITM`=579 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
CREATE TABLE `czmovcontdet` (
	`Consec_CNT` INT NOT NULL,
	`Codigo_TER` INT NOT NULL,
	`Codigo_PUC` INT NOT NULL,
	`Descripcion_CNT` INT NOT NULL,
	`Codigo_CCT` INT NOT NULL,
	`Debito_CNT` DECIMAL(10,2) NOT NULL DEFAULT 0,
	`Credito_CNT` DECIMAL(10,2) NOT NULL DEFAULT 0,
	PRIMARY KEY (`Consec_CNT`, `Codigo_PUC`),
	INDEX `Consec_CNT` (`Consec_CNT`),
	INDEX `Codigo_TER` (`Codigo_TER`),
	INDEX `Codigo_CCT` (`Codigo_CCT`),
	INDEX `Codigo_PUC` (`Codigo_PUC`)
)
COMMENT='Detalle de Asiento Contable'
COLLATE='utf8_general_ci'
;
