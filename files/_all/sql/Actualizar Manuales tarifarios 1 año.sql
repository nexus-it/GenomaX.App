UPDATE gxmanualestarifarios 
SET fechafin_tar='2020-12-31 23:59:59'
WHERE '2020-12-30' BETWEEN FechaIni_TAR AND FechaFin_TAR;

SELECT a.Codigo_DCD, a.Codigo_TAR, a.FechaIni_TAR, a.FechaFin_TAR, a.Codigo_SER, a.Valor_TAR 
FROM gxmanualestarifarios a
WHERE '2020-12-30' BETWEEN a.FechaIni_TAR AND a.FechaFin_TAR;

INSERT INTO gxmanualestarifarios(Codigo_DCD, Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR )
SELECT a.Codigo_DCD, a.Codigo_TAR, '2021-01-01', '2021-12-31 23:59:59', a.Codigo_SER, a.Valor_TAR 
FROM gxmanualestarifarios a
WHERE '2020-12-30' BETWEEN a.FechaIni_TAR AND a.FechaFin_TAR;
