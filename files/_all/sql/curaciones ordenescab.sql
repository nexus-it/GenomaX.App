Select 'numero', y.Codigo_ADM, y.Fecha_HCF, '0', '', 'ORDEN GENERADA POR ENFERMERIA', y.Codigo_USR 
from hc_ENFERMERIA x, hcfolios y, hctipocuraciones z Where y.Fecha_HCF>'2017-10-31' and z.Codigo_HTC=x.curacion_HC and x.Codigo_HCF=y.Codigo_HCF and x.Codigo_TER=y.Codigo_TER and y.Codigo_ADM not in
(Select a.codigo_adm
from gxordenescab a
where a.descripcion_ord='ORDEN GENERADA POR ENFERMERIA' and a.fecha_ord>='2017-11-04 13:23:10')
order by y.Codigo_ADM, y.Fecha_HCF, y.codigo_usr;
