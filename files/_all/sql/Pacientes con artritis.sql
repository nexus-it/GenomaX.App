SELECT d.ID_TER, d.Nombre_TER, a.Codigo_DGN, a.Descripcion_DGN, c.Fecha_HCF,Nombre_EPS
FROM gxdiagnostico a, hcdiagnosticos b, hcfolios c, czterceros d, gxadmision e, gxeps f
WHERE a.Codigo_DGN=b.Codigo_DGN AND c.Codigo_TER=b.Codigo_TER AND b.Codigo_HCF=c.Codigo_HCF AND d.Codigo_TER=c.Codigo_TER
AND e.Codigo_ADM=c.Codigo_ADM AND e.Codigo_EPS=f.Codigo_EPS AND a.Descripcion_DGN LIKE '%artrit%'