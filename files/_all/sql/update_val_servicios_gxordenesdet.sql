Update gxordenesdet a, gxordenescab b, gxadmision c, gxmanualestarifarios d, gxcontratos e 
Set a.ValorEntidad_ORD=d.Valor_TAR, a.ValorServicio_ORD=d.Valor_TAR 
Where a.Codigo_ORD=b.Codigo_ORD and c.Codigo_ADM=b.Codigo_ADM 
 and b.Fecha_ORD between d.FechaIni_TAR and d.FechaFin_TAR 
 and d.Codigo_SER=a.Codigo_SER and e.Codigo_EPS=a.Codigo_EPS 
 and e.Codigo_PLA=a.Codigo_PLA and e.Codigo_TAR=d.Codigo_TAR 
 and b.Estado_ORD<>'0' 