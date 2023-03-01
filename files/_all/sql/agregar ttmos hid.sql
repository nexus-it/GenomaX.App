Select distinct concat('Replace Into hctratamiento(Codigo_TER, Codigo_HCF, Codigo_HTT, Indicacion_HTT) Values(\'', b.Codigo_TER,'\', ', b.Codigo_HCF,', ', c.Codigo_HTT,', \'', c.Indicacion_HTT, '\');')
From gxadmision a, hcfolios b, hctratamiento c, hcfolios d, hctipos e
Where a.Codigo_ADM=b.Codigo_ADM and b.Codigo_TER=c.Codigo_TER and c.Codigo_HCF=d.Codigo_HCF and d.Codigo_TER=b.Codigo_TER and e.Codigo_HCT=b.Codigo_HCT and  e.Codigo_HCT=d.Codigo_HCT and 
e.Indicaciones_HCT='1' and month(d.Fecha_HCF)='05' and year(d.Fecha_HCF)='2018' and b.Fecha_HCF >='2018-06-02' and
a.Codigo_ADM not in (
Select u.Codigo_ADM
From hcfolios u, hctratamiento v
Where v.Codigo_TER=u.Codigo_TER and v.Codigo_HCF=u.Codigo_HCF and u.Fecha_HCF >='2018-06-02'
)