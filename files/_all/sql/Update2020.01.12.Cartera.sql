UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.01.12.01';
Delete FROM itperfilplugins;
RENAME TABLE `itperfilplugins` TO `itperfildashboard`;
ALTER TABLE `itperfildashboard`
	CHANGE COLUMN `Codigo_PLG` `Codigo_DSH` INT(2) NULL DEFAULT NULL AFTER `Codigo_PRF`;
ALTER TABLE `itperfildashboard`
	CHANGE COLUMN `Codigo_PRF` `Codigo_PRF` INT(2) NOT NULL FIRST,
	CHANGE COLUMN `Codigo_DSH` `Codigo_DSH` INT(2) NOT NULL AFTER `Codigo_PRF`,
	DROP INDEX `Codigo_PRF_Codigo_PLG`,
	ADD PRIMARY KEY (`Codigo_PRF`, `Codigo_DSH`);
INSERT INTO itperfildashboard (codigo_prf, codigo_dsh) SELECT DISTINCT '0', codigo_dsh FROM itdashboard;
INSERT INTO itperfildashboard (codigo_prf, codigo_dsh) SELECT DISTINCT '1', codigo_dsh FROM itdashboard;
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('7', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('7', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('8', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('8', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('16', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('16', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('17', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('17', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('18', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('18', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('21', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('21', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('25', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('25', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('26', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('26', '91');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('28', '100');
INSERT INTO `itperfildashboard` (`Codigo_PRF`, `Codigo_DSH`) VALUES ('28', '91');
UPDATE hccampos SET hccampos.Maximo_HCC=5000 WHERE hccampos.Maximo_HCC >= 1000;
DELETE FROM czcartera;
ALTER TABLE `czcartera`
	ADD COLUMN `Codigo_EPS` VARCHAR(10) NOT NULL DEFAULT '' AFTER `Codigo_FAC`,
	ADD COLUMN `Codigo_PLA` VARCHAR(2) NOT NULL DEFAULT '' AFTER `Codigo_EPS`,
	ADD COLUMN `Fecha_FAC` DATE NOT NULL AFTER `Codigo_PLA`,
	ADD COLUMN `Codigo_RAD` CHAR(10) NOT NULL DEFAULT '' AFTER `Fecha_FAC`,
	ADD COLUMN `Fecha_CAR` DATE NOT NULL AFTER `Codigo_RAD`,
	CHANGE COLUMN `Estado_CAR` `Estado_CAR` CHAR(1) NOT NULL DEFAULT '1' COMMENT '1:Radicado Confirmado; ' AFTER `Saldo_CAR`,
	ADD INDEX `Codigo_EPS` (`Codigo_EPS`),
	ADD INDEX `Codigo_PLA` (`Codigo_PLA`),
	ADD INDEX `FechaConf_RAD` (`Fecha_CAR`);
DELETE FROM `czradicacionesdet` WHERE TRIM(Codigo_FAC)='';
UPDATE czradicacionesdet T1, ( SELECT Codigo_FAC, Codigo_AFC FROM gxfacturas WHERE estado_fac='1' ) T2 SET T1.Codigo_AFC= T2.Codigo_AFC WHERE T1.Codigo_FAC=T2.Codigo_FAC;
INSERT INTO czcartera(Codigo_DCD, Codigo_AFC, Codigo_FAC, Codigo_EPS, Codigo_PLA, Fecha_FAC, Codigo_RAD, Fecha_CAR, ValorFac_CAR, ValorDeb_CAR, ValorCre_CAR, Saldo_CAR, Estado_CAR) SELECT b.Codigo_DCD, c.Codigo_AFC, a.Codigo_FAC, a.Codigo_EPS, a.Codigo_PLA, a.Fecha_FAC, b.Codigo_RAD, b.FechaConf_RAD, a.ValEntidad_FAC, 0, a.ValCredito_FAC, a.ValTotal_FAC, '1' FROM gxfacturas a, czradicacionescab b, czradicacionesdet c WHERE a.Codigo_FAC=c.Codigo_FAC AND a.Codigo_AFC=c.Codigo_AFC AND b.Codigo_RAD=c.Codigo_RAD AND b.Codigo_DCD=a.Codigo_DCD AND a.Estado_FAC='1' AND b.Estado_RAD='2';
