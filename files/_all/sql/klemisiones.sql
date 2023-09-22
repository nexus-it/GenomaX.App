select b.Prefijo_EMI, b.Codigo_EMI, b.Fecha_EMI, b.Codigo_CTZ, c.Nombre_TER, d.Nombre_AGE, e.Nombre_PLA, b.Voucher_EMI, a.Edad_CTZ, a.Modalidad_CTZ, a.FechaIni_CTZ, a.FechaFin_CTZ, a.Dias_CTZ, g.Nombre_DST, h.Nombre_DST, a.Dolares_CTZ, a.Pesos_CTZ, a.Descuento_CTZ, a.Total_CTZ,
 concat(f.ID_USR, '[', f.Nombre_USR, ']')
from klcotizaciones a, klemisiones b, czterceros c, klagencias d, klplanes e, itusuarios f, kldestinos g, kldestinos h
where a.Codigo_DCD=b.Codigo_DCD and a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_AGE=d.Codigo_AGE
 and a.Codigo_PLA=e.Codigo_PLA and f.Codigo_USR=b.Codigo_USR and g.Codigo_DST=a.Procedencia_CTZ and h.Codigo_DST=a.Codigo_DST
 and b.Estado_EMI<>'A' and b.Fecha_EMI between '@FECHA_INI 00:00:00' and '@FECHA_FIN 23:59:59'
 ORDER BY 3