INSERT INTO hcctrlprentl(Codigo_TER, Codigo_HCF, Numero_HCA, Fecha_HCA, Semanas_HCA, Peso_HCA, Talla_HCA, IMC_HCA, Clasifimceg_HCA, TA_HCA, Alturauter_HCA, Amenorrea_HCA, FCF_HCA, Presfetal_HCA, Movfetal_HCA, Valcuelute_HCA, Edemas_HCA, Monfetal_HCA, Examamas_HCA, Exagenit_HCA, Hospprev_HCA)
SELECT a.Codigo_TER, a.Codigo_HCF, a.Folio_HCF, a.Fecha_HCF, case when (ROUND(DATEDIFF(a.Fecha_HCF,b.FUR_HCA)/30)*3.89) <=42 then (ROUND(DATEDIFF(a.Fecha_HCF,b.FUR_HCA)/30)*3.89) ELSE '0' end , b.Pesoprev_HCA, b.Talla_HCA, b.IMC_HCA, 'N', c.Valor_HSV, 'NO SE EXAMINA POR LA TELECONSULTA', '0', 'NO SE EXAMINA POR LA TELECONSULTA','', '','','','','','','0' 
FROM hcfolios a, hcembactual b, hcsignosvitales c
WHERE a.Codigo_TER=b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_HCT='GNCOBST'
AND a.Codigo_TER=c.Codigo_TER AND a.Codigo_HCF=c.Codigo_HCF AND c.Codigo_HSV='01'
AND CONCAT(a.Codigo_TER,'-',a.Codigo_HCF) NOT IN (SELECT CONCAT(codigo_ter,'-', codigo_hcf) FROM hcctrlprentl)


-- DESCRIBE hcctrlparaobs



SELECT d.*
FROM hcfolios c, hcctrlparaobs d
WHERE c.Codigo_TER=d.Codigo_TER AND c.Codigo_HCF=d.Codigo_HCF
AND c.Codigo_HCT='GNCOBST'