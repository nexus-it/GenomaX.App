Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(f.Fecha_ORD,'%d/%m/%Y'),',',trim(f.Autorizacion_ORD),',', trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', c.Codigo_DGN,',', c.Codigo_DGN,',', '',',', '',',', '1',',', REPLACE(format(ROUND(g.ValorServicio_ORD*g.Cantidad_ORD),0), ',',''),',',
replace(format(ROUND(g.ValorPaciente_ORD*g.Cantidad_ORD),0), ',',''),',', replace(format(ROUND(g.ValorEntidad_ORD*g.Cantidad_ORD), 0), ',','') )
From gxfacturas as a, gxfacturaconf as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j
Where  a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER 
and j.Codigo_CFC='01' and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and trim(i.Codigo_FAC)=trim(a.Codigo_FAC) and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' 
and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')
Union 
Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(f.Fecha_ORD,'%d/%m/%Y'),',',trim(f.Autorizacion_ORD),',', 
trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', c.Codigo_DGN,',', c.Codigo_DGN,',', '',',', '',',', '1',',', REPLACE(format(ROUND(0),0), ',',''),',', replace(format(ROUND(0),0), ',',''),',', replace(format(ROUND(0), 0), ',','') )
From gxfacturas as a, gxfacturaconf as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j
Where  a.Codigo_FAC=c.Codigo_FAC and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=c.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER 
and j.Codigo_CFC='01' and g.Codigo_EPS=c.Codigo_EPS and g.Codigo_PLA=c.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and trim(i.Codigo_FAC)=trim(a.Codigo_FAC) and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' 
and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')

