Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e
Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR
where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER 
AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM -- and e.Estado_ADM='F'
--  AND a.Fecha_ORD>='2022-01-13' AND b.Codigo_EPS IN (5,6) 
--  AND c.Codigo_SER IN (8279)  
-- AND a.Fecha_ORD between '2021-12-01'  and '2022-01-31'
 AND a.Codigo_ADM IN ('49')
-- AND a.Descripcion_ORD='Orden Automatica Recuperacion'
-- AND a.Codigo_ORD='371';


