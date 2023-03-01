UPDATE gxfacturas T1,
      ( SELECT b.Codigo_ADM,SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total 
 FROM gxordenesdet a,gxordenescab b
 where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1' 

  GROUP BY b.Codigo_ADM ) T2
   SET T1.ValTotal_FAC = T2.total- T1.ValCredito_FAC - T1.ValIVA_FAC ,T1.ValEntidad_FAC = T2.total
    WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total
 --    AND T1.IdFE_FAC ='0'
   AND T1.Fecha_FAC >'2022-01-01'  
-- AND T2.Codigo_ADM IN ('148474')
 AND T1.Codigo_FAC IN ('BA55011','BA60442','BA60443','BA60445','BA60449','BA60457')
 
 