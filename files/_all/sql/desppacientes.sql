Select b.ID_TER, b.Nombre_TER, concat(c.Fecha_HCF,' ', c.Hora_HCF), j.Codigo_ADM, f.Nombre_ARE, d.Nombre_CAM, k.Nombre_SDE, g.Nombre_USR, m.Nombre_TER, n.Nombre_PLA 
From hcordenesmedica a, czterceros b, hcfolios c, gxcamas d, gxadmision e, gxareas f, itusuarios g, itusuarios h, 
itusuariossedes i, gxadmision j, czsedes k, gxeps l, czterceros m, gxplanes n 
Where n.Codigo_PLA=j.Codigo_PLA and l.Codigo_TER=m.Codigo_TER and k.Codigo_SDE=i.Codigo_SDE and l.Codigo_EPS=j.Codigo_EPS and j.Codigo_ADM=c.Codigo_ADM and i.Codigo_USR=h.Codigo_USR and h.Codigo_USR=e.Codigo_USR and b.Codigo_TER=a.Codigo_TER and 
c.Codigo_TER=b.Codigo_TER and c.Codigo_HCF=a.Codigo_HCF and c.Codigo_USR=g.Codigo_USR and f.Codigo_ARE=c.Codigo_ARE and 
e.Codigo_ADM=c.Codigo_ADM and d.Codigo_CAM=e.Codigo_CAM and a.Estado_HCM in ('O', 'P')
/*and a.Codigo_HCM='.$_GET["CodigoHCM"].'*/
and a.Codigo_HCM='21'