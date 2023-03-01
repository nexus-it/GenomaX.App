UPDATE `itconfig` SET `Version_DCD`='18.12.31.001';
INSERT INTO `czsalariomin` (`Codigo_ANY`, `SalarioMinimo_ANY`, `AuxTransporte_ANY`) VALUES ('2018', '781242', '88211');
INSERT INTO `czsalariomin` (`Codigo_ANY`, `SalarioMinimo_ANY`, `AuxTransporte_ANY`) VALUES ('2017', '737717', '83140');
INSERT INTO `czsalariomin` (`Codigo_ANY`, `SalarioMinimo_ANY`, `AuxTransporte_ANY`) VALUES ('2019', '828116', '97032');
ALTER TABLE `gxmanualestarifarios`	CHANGE COLUMN `FechaIni_TAR` `FechaIni_TAR` DATETIME NOT NULL DEFAULT '0000-00-00' AFTER `Codigo_TAR`, 	CHANGE COLUMN `FechaFin_TAR` `FechaFin_TAR` DATETIME NOT NULL DEFAULT '0000-00-00' AFTER `FechaIni_TAR`;
Update gxmanualestarifarios a Set FechaFin_TAR='2018-12-31 23:59:59' Where a.FechaFin_TAR='2018-12-31';
Update gxmanualestarifarios a Set FechaFin_TAR='2018-12-31 23:59:59' Where a.FechaFin_TAR >='2019-01-01 00:00:00';
Insert Into gxmanualestarifarios(Codigo_DCD,Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Select a.Codigo_DCD,a.Codigo_TAR, '2019-01-01', '2019-12-31 23:59:59', a.Codigo_SER, a.Valor_TAR from gxmanualestarifarios a Where now() between a.FechaIni_TAR and  a.FechaFin_TAR;
