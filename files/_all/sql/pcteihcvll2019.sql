SELECT DISTINCT  c.ID_TER, c.Nombre_TER
FROM hcfolios a, gxadmision b, czterceros c
WHERE a.Codigo_ADM=b.Codigo_ADM AND a.Codigo_TER=c.Codigo_TER
AND YEAR( a.Fecha_HCF)='2019' AND MONTH(a.Fecha_HCF) IN ('10','11', '12')
AND b.Codigo_SDE='VLL'