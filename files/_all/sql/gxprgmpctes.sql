INSERT INTO gxprgmpctes(Codigo_PRG, Codigo_TER, FechaIng_PRG)
SELECT 'RCV', Codigo_TER, Fecha_HCF
FROM hcfolios a
WHERE a.Codigo_HCT='HPRTSN'
AND CONCAT('RCV',a.Codigo_TER) NOT IN (SELECT CONCAT(Codigo_PRG, Codigo_TER) FROM gxprgmpctes)
GROUP BY codigo_ter
HAVING MIN(a.Fecha_HCF)