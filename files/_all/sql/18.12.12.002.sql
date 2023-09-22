UPDATE `itconfig` SET `Version_DCD`='18.12.14.001';
UPDATE `itplugins` SET `Nombre_PLG`='Facturado Mensual x Entidad ' WHERE  `Codigo_PLG`=1;
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-01-01');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-01-07');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-03-25');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-04-18');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-04-19');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-05-01');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-06-03');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-06-24');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-07-01');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-07-20');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-08-07');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-08-19');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-10-14');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-11-04');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-11-11');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-12-08');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2019-12-25');
INSERT INTO `czfestivos` (`DiaFest_FST`) VALUES ('2020-01-01');
INSERT INTO `itplugins` (`Codigo_PLG`, `Nombre_PLG`, `Ruta_PLG`) VALUES ('2', 'Radicado Mensual x Entidad', 'radentmens');
CREATE TABLE `itperfilplugins` (	`Codigo_PRF` INT(2) NULL,	`Codigo_PLG` INT(2) NULL,	INDEX `Codigo_PRF` (`Codigo_PRF`),	INDEX `Codigo_PLG` (`Codigo_PLG`),	INDEX `Codigo_PRF_Codigo_PLG` (`Codigo_PRF`, `Codigo_PLG`) ) COMMENT='Visualizacion de Plugins por Perfil de Usuario' COLLATE='utf8_general_ci' ENGINE=InnoDB;
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('1', '1');
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('1', '2');
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('1', '3');
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('7', '4');
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('7', '5');
INSERT INTO `itperfilplugins` (`Codigo_PRF`, `Codigo_PLG`) VALUES ('1', '6');
INSERT INTO `itplugins` (`Codigo_PLG`, `Nombre_PLG`, `Ruta_PLG`) VALUES ('3', 'Admisiones Vs Facturado Del Mes', 'admfactmes');
INSERT INTO `itplugins` (`Codigo_PLG`, `Nombre_PLG`, `Ruta_PLG`) VALUES ('4', 'Pacientes Programados Vs Atendidos', 'ptesprogatend');
INSERT INTO `itplugins` (`Codigo_PLG`, `Nombre_PLG`, `Ruta_PLG`) VALUES ('5', 'Atenciones Diarias', 'atencdiaria');
