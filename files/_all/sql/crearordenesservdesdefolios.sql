
SET @numero=0;

INSERT INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Codigo_USR)
SELECT @numero:=@numero+1, b.Codigo_ADM, b.FechaReg_HCF, b.Codigo_ARE, b.Codigo_USR
FROM hcfolios b
WHERE b.Codigo_ADM IN (select codigo_adm FROM gxadmision)
;

Update itconsecutivos SET `Consecutivo_CNS`=@numero WHERE  `Campo_CNS`='Codigo_ORD' AND `Tabla_CNS`='gxordenescab' AND `Codigo_DCD`=0;

INSERT INTO gxordenesdet(codigo_ord, codigo_ser, Cantidad_ORD, CantidadOLD_ORD, ValorPaciente_ORD, ValorEntidad_ORD,  ValorServicio_ORD, codigo_eps, codigo_pla, codigo_ter)
SELECT distinct c.Codigo_ORD, a.Codigo_SER, 1, 1, 0, 0, 0, '1', '2', 1
FROM hctipos a, hcfolios b, gxordenescab c
WHERE a.Codigo_HCT=b.Codigo_HCT AND b.Codigo_ADM=c.Codigo_ADM;

INSERT INTO gxordenesdet(codigo_ord, codigo_ser, Cantidad_ORD, CantidadOLD_ORD, ValorPaciente_ORD, ValorEntidad_ORD,  ValorServicio_ORD, codigo_eps, codigo_pla, codigo_ter)
SELECT distinct c.Codigo_ORD, a.Codigo_SER, a.Cantidad_HCS, a.Cantidad_HCS, 0, 0, 0, '1', '2', 1
FROM hcordenesdx a, hcfolios b, gxordenescab c
WHERE a.Codigo_TER=b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND b.Codigo_ADM=c.Codigo_ADM;


INSERT INTO gxordenesdet(codigo_ord, codigo_ser, Cantidad_ORD, CantidadOLD_ORD, ValorPaciente_ORD, ValorEntidad_ORD,  ValorServicio_ORD, codigo_eps, codigo_pla, codigo_ter)
SELECT distinct c.Codigo_ORD, a.Codigo_SER, sum(a.Cantidad_HCM), sum(a.Cantidad_HCM), 0, 0, 0, '1', '2', 1
FROM hcordenesmedica a, hcfolios b, gxordenescab c
WHERE a.Codigo_TER=b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND b.Codigo_ADM=c.Codigo_ADM
GROUP BY c.Codigo_ORD, a.Codigo_SER;