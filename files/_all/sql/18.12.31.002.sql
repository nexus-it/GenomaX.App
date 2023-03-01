UPDATE `itconfig` SET `Version_DCD`='18.12.31.002';
Delete from gxmanualestarifarios  where FechaIni_TAR> FechaFin_TAR;
INSERT INTO `gxrangoactual` (`Codigo_RNG`, `Codigo_ANY`, `Cuota_MOD`, `Porcentaje_COP`, `Maximo_COP`, `MaxAnual`) VALUES ('1', '2019', '3200.00', '11.50', '237669', '57.50');
INSERT INTO `gxrangoactual` (`Codigo_RNG`, `Codigo_ANY`, `Cuota_MOD`, `Porcentaje_COP`, `Maximo_COP`, `MaxAnual`) VALUES ('2', '2019', '12700.00', '17.30', '952333', '230.00');
INSERT INTO `gxrangoactual` (`Codigo_RNG`, `Codigo_ANY`, `Cuota_MOD`, `Porcentaje_COP`, `Maximo_COP`, `MaxAnual`) VALUES ('3', '2019', '33500.00', '11.50', '1904667', '57.50');
