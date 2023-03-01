-- NUEVO ENTERPRISE 2021
UPDATE `itconfig` SET `Version_DCD`='[Enterprise] 21.02.02.001' ;

UPDATE `itconfig_fe` SET `ScopeToken_XFE`='WebApi%20offline_access' WHERE  `Codigo_XFE`='Siigo';
UPDATE `itconfig_fe` SET `ScopeToken_XFE`='WebApi%20offline_access' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `UserAPI_XFE`='empresa2%40apionmicrosoft.com', `PasswAPI_XFE`='s112pempresa2%23' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `BodyToken_XFE`='grant_type=password&username=@NombreClave@UserAPI&password=@PaswAPI&scope=@ScopeToken' WHERE  `Codigo_XFE`='Siigo';
UPDATE `itconfig_fe` SET `BodyToken_XFE`='grant_type=password&username=@NombreClave@UserAPI&password=@PaswAPI&scope=@ScopeToken' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `HeaderToken_XFE`='Content-Type: application/x-www-form-urlencoded,Authorization: Basic U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx,Accept: application/json';
ALTER TABLE `itconfig_fe`
	ADD COLUMN `UsuarioAPP_XFE` VARCHAR(100) NULL DEFAULT NULL AFTER `KeyAPI_XFE`;
UPDATE `itconfig_fe` SET `UsuarioAPP_XFE`='251' WHERE  `Codigo_XFE`='SiigoTest';
UPDATE `itconfig_fe` SET `UsuarioAPP_XFE`='382' WHERE  `Codigo_XFE`='Siigo';
UPDATE `czautfacturacion` SET `ClaveTecnica_AFC`='45451' WHERE  `Codigo_AFC`='14' AND `Codigo_DCD`=0;
UPDATE `czautfacturacion` SET `ClaveTecnica_AFC`='78020' WHERE  `Codigo_AFC`='15' AND `Codigo_DCD`=0;
ALTER TABLE `gxeps`
	ADD COLUMN `NameContact_EPS` VARCHAR(50) NULL DEFAULT NULL AFTER `FacXOrd_EPS`,
	ADD COLUMN `LastnameContact_EPS` VARCHAR(50) NULL DEFAULT NULL AFTER `NameContact_EPS`,
	ADD COLUMN `PhoneContact_EPS` VARCHAR(10) NULL DEFAULT NULL AFTER `LastnameContact_EPS`,
	ADD COLUMN `CellContact_EPS` VARCHAR(10) NULL DEFAULT NULL AFTER `PhoneContact_EPS`,
	ADD COLUMN `lContact_EPS` VARCHAR(100) NULL DEFAULT NULL AFTER `CellContact_EPS`;

UPDATE gxeps a, czterceros b
SET a.lContact_EPS=b.Correo_TER, a.PhoneContact_EPS=left(b.Telefono_TER,10), a.CellContact_EPS=left(b.Telefono_TER,10)
WHERE a.Codigo_TER=b.Codigo_TER;

ALTER TABLE `gxeps`
	CHANGE COLUMN `lContact_EPS` `EmailContact_EPS` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `CellContact_EPS`;
