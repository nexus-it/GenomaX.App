-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.02.01.001' ;

INSERT INTO `czsalariomin` (`Codigo_ANY`, `SalarioMinimo_ANY`, `AuxTransporte_ANY`) VALUES ('2021', '908526', '106454');
UPDATE `gxrangoactual` SET `Cuota_MOD`='3500.00' WHERE  `Codigo_RNG`='1' AND `Codigo_ANY`='2021';
UPDATE `gxrangoactual` SET `Cuota_MOD`='14000.00' WHERE  `Codigo_RNG`='2' AND `Codigo_ANY`='2021';
UPDATE `gxrangoactual` SET `Cuota_MOD`='36800.00' WHERE  `Codigo_RNG`='3' AND `Codigo_ANY`='2021';
UPDATE `gxrangoactual` SET `Maximo_COP`='260747' WHERE  `Codigo_RNG`='1' AND `Codigo_ANY`='2021';
UPDATE `gxrangoactual` SET `Maximo_COP`='1044805' WHERE  `Codigo_RNG`='2' AND `Codigo_ANY`='2021';
UPDATE `gxrangoactual` SET `Maximo_COP`='2089610' WHERE  `Codigo_RNG`='3' AND `Codigo_ANY`='2021';
ALTER TABLE `gxprgrmesp`
	ENGINE=InnoDB;
ALTER TABLE `gxprgmpctes`
	ENGINE=InnoDB;
ALTER TABLE `czautfacturacion`
	CHANGE COLUMN `Tipo_AFC` `Tipo_AFC` CHAR(1) NULL DEFAULT '2' COMMENT '1: Manual; 2: Por computador; 3: Electrónica; 4: Contingencia' COLLATE 'utf8_general_ci' AFTER `Descripcion_AFC`;
ALTER TABLE `itconfig_fc`
	ADD COLUMN `APIRestFE_XFC` VARCHAR(50) NOT NULL DEFAULT 'Siigo' COMMENT 'Conexion API Para Fact Electronica' COLLATE 'utf8_general_ci' AFTER `ShowFechaVence_XFC`;
CREATE TABLE `itconfig_fe` (
	`Codigo_XFE` VARCHAR(50) NOT NULL,
	`URL_XFE` VARCHAR(150) NULL DEFAULT NULL,
	`Estado_XFE` CHAR(1) NULL DEFAULT '1',
	PRIMARY KEY (`Codigo_XFE`)
)
COMMENT='Configuracion API Facturas Electronicas'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `itconfig_fe`
	ADD COLUMN `NombreClave_XFE` VARCHAR(100) NULL DEFAULT NULL AFTER `URL_XFE`,
	ADD COLUMN `UserAPI_XFE` VARCHAR(100) NULL DEFAULT NULL AFTER `NombreClave_XFE`,
	ADD COLUMN `PasswAPI` VARCHAR(100) NULL DEFAULT NULL AFTER `UserAPI_XFE`,
	ADD COLUMN `KeyAPI` VARCHAR(100) NULL DEFAULT NULL AFTER `PasswAPI`;

INSERT INTO `itconfig_fe` (`Codigo_XFE`) VALUES ('Siigo');
UPDATE `itconfig_fe` SET `NombreClave_XFE`='SALUDDOMICILIARIAINTEGRALDELCARIBESAS', `UserAPI_XFE`='SALUDD36791@apionmicrosoft.com', `PasswAPI`='.8/t-}£`>A', `KeyAPI`='33dff35ec7d4473ab90213ea79379b68' WHERE  `Codigo_XFE`='Siigo';
UPDATE `itconfig_fe` SET `URL_XFE`='http://siigoapi.azure-api.net/siigo/api/v1/' WHERE  `Codigo_XFE`='Siigo';

UPDATE `ititems` SET `Codigo_APP`='2' WHERE  `Codigo_ITM`=1 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53' WHERE  `Codigo_ITM`=1 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2' WHERE  `Codigo_ITM`=2 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2' WHERE  `Codigo_ITM`=4 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2' WHERE  `Codigo_ITM`=7 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2' WHERE  `Codigo_ITM`=8 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2' WHERE  `Codigo_ITM`=9 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2', `Nombre_ITM`='Configuración' WHERE  `Codigo_ITM`=5 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `ititems` SET `Padre_ITM`='5' WHERE  `Codigo_ITM`=4 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='5' WHERE  `Codigo_ITM`=2 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Padre_ITM`='5' WHERE  `Codigo_ITM`=1 AND `Codigo_MNU`=53 AND `Codigo_MOD`=1 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Codigo_MNU`='53', `Codigo_APP`='2', `Padre_ITM`='5' WHERE  `Codigo_ITM`=3 AND `Codigo_MNU`=1 AND `Codigo_MOD`=1 AND `Codigo_APP`=1;
UPDATE `hctipos` SET `Icono_HCT`='document_comment_above' WHERE  `Codigo_HCT`='HC01';
UPDATE `itreports` SET `SQL_RPT`='Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, \n b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, c.Fecha_FAC, c.ValPaciente_FAC, \n c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, CONCAT(e.ID_TER,\'-\',e.DigitoVerif_TER), e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, \n LPAD(f.Codigo_ADM,10,\'0\'), CONCAT(h.Sigla_TID,\' \', g.ID_TER), g.Nombre_TER, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD, g.Direccion_TER, g.Telefono_TER, Barrio_PAC, Nombre_MUN, x.Codigo_DGN, x.Descripcion_DGN, Prefijo_AFC, ValCredito_FAC, date(f.fecha_adm), f.FechaFin_ADM, d.contrato_eps, d.nombre_eps, d.Tipo_EPS, FacXOrd_EPS, Tipo_AFC  \nFrom itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, czterceros g, cztipoid h, gxplanes i, gxpacientes p, czmunicipios m, gxdiagnostico x \nWhere x.Codigo_DGN=f.Codigo_DGN and m.Codigo_MUN=p.Codigo_MUN and m.Codigo_DEP=p.Codigo_DEP and c.Codigo_AFC = b.Codigo_AFC and \np.Codigo_TER=g.Codigo_TER and d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_ADM =c.Codigo_ADM \n and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA\n and c.Codigo_FAC>=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_INICIAL\',10,\'0\')) and c.Codigo_FAC<=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_FINAL\',10,\'0\'));' WHERE  `Codigo_RPT`='facturasaluddet' AND `Codigo_DCD`=0;
ALTER TABLE `czautfacturacion`
	CHANGE COLUMN `ClaveTecnica_AFC` `ClaveTecnica_AFC` VARCHAR(150) NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `Fecha_AFC`;
CREATE TABLE `gxfacturaselectronicas` (
	`Codigo_FAC` VARCHAR(15) NOT NULL,
	`Codigo_AFC` VARCHAR(2) NULL DEFAULT NULL,
	`Estado_FAC` VARCHAR(2) NULL DEFAULT NULL,
	PRIMARY KEY (`Codigo_FAC`),
	INDEX `Codigo_AFC` (`Codigo_AFC`)
)
COMMENT='Guarda las facturas que se han enviado al proveedor autorizado de FE'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
ALTER TABLE `itconfig_fe`
	ADD COLUMN `URLToken_XFE` VARCHAR(150) NOT NULL AFTER `Codigo_XFE`,
	ADD COLUMN `BodyToken_XFE` VARCHAR(300) NOT NULL AFTER `URLToken_XFE`,
	ADD COLUMN `HeaderToken_XFE` VARCHAR(300) NOT NULL AFTER `BodyToken_XFE`;
UPDATE `itconfig_fe` SET `URLToken_XFE`='https://siigonube.siigo.com:50050/connect/token', `BodyToken_XFE`='grant_type=password&username=@NombreClave\\@UserAPI&password=@PaswAPI&scope=@ScopeToken' WHERE  `Codigo_XFE`='Siigo';
UPDATE `itconfig_fe` SET `HeaderToken_XFE`='\'Content-Type: application/x-www-form-urlencoded\', \'Authorization: Basic U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx\',\'Accept: application/json\'' WHERE  `Codigo_XFE`='Siigo';
ALTER TABLE `itconfig_fe`
	ADD COLUMN `ScopeToken_XFE` VARCHAR(50) NOT NULL AFTER `HeaderToken_XFE`;
UPDATE `itconfig_fe` SET `ScopeToken_XFE`='WebApi offline_access' WHERE  `Codigo_XFE`='Siigo';
ALTER TABLE `itconfig_fe`
	CHANGE COLUMN `PasswAPI` `PasswAPI_XFE` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `UserAPI_XFE`,
	CHANGE COLUMN `KeyAPI` `KeyAPI_XFE` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `PasswAPI_XFE`;
INSERT INTO `itconfig_fe` (`Codigo_XFE`, `URLToken_XFE`, `BodyToken_XFE`, `HeaderToken_XFE`, `ScopeToken_XFE`, `URL_XFE`, `NombreClave_XFE`, `UserAPI_XFE`, `PasswAPI_XFE`, `KeyAPI_XFE`, `Estado_XFE`) VALUES ('SiigoTest', 'https://siigonube.siigo.com:50050/connect/token', 'grant_type=password&username=@NombreClave\\@UserAPI&password=@PaswAPI&scope=@ScopeToken', '\'Content-Type: application/x-www-form-urlencoded\',\r\n    \'Authorization: Basic U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx\',\r\n    \'Accept: application/json\'', 'WebApi offline_access', 'http://siigoapi.azure-api.net/siigo/api/v1/', 'EMPRESA2CAPACITACION', 'empresa2@apionmicrosoft.com', 's112pempresa2#', '184165d1878e45f2910bc99e870ac781', '0');
