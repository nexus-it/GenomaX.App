update hcfolios T1,
	(SELECT b.Codigo_TER AS tercero, b.Folio_HCF AS folio, COUNT(c.Codigo_HCF)+1 AS total
FROM hcfolios b, hcfolios c
WHERE c.Codigo_TER=b.Codigo_TER
AND b.Folio_HCF>=10000
AND b.Fecha_HCF> c.Fecha_HCF
GROUP BY b.codigo_ter, b.Folio_HCF
	) T2
SET T1.Folio_HCF=T2.total
WHERE T1.Codigo_TER=T2.tercero
AND T1.Folio_HCF=T2.folio