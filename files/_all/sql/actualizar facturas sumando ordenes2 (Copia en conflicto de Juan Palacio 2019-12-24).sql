UPDATE gxfacturas T1,
      ( SELECT b.Codigo_ADM, SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total 
 FROM gxordenesdet a, gxordenescab b
 where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1'
  GROUP BY b.Codigo_ADM ) T2
   SET T1.ValTotal_FAC = T2.total- T1.ValCredito_FAC , T1.ValEntidad_FAC = T2.total
    WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total
  AND T1.Codigo_ADM=23325
 