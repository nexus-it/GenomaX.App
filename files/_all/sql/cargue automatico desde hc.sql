SET @numero=730;

SET @tercero='3773';

-- ------ medicamentos
REPLACE INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT @numero+ a.Codigo_HCF, b.Codigo_ADM, b.Fecha_HCF, b.Codigo_ARE, c.Autorizacion_ADM, 'ORDEN AUTOMATICA DE HC', b.Codigo_USR 
FROM hcordenesmedica a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero  AND (@numero+ a.Codigo_HCF) NOT IN (SELECT codigo_ord FROM gxordenescab);

REPLACE INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT @numero+ a.Codigo_HCF, a.Codigo_SER, a.Cantidad_HCM, a.Cantidad_HCM, 0,0,c.Codigo_EPS, c.Codigo_PLA
FROM hcordenesmedica a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero;

-- --------- DX

REPLACE INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT @numero+ a.Codigo_HCF, b.Codigo_ADM, b.Fecha_HCF, b.Codigo_ARE, c.Autorizacion_ADM, 'ORDEN AUTOMATICA DE HC', b.Codigo_USR 
FROM hcordenesdx a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero AND (@numero+ a.Codigo_HCF) NOT IN (SELECT codigo_ord FROM gxordenescab);

REPLACE INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT @numero+ a.Codigo_HCF, a.Codigo_SER, a.Cantidad_HCS, a.Cantidad_HCS, 0,0,c.Codigo_EPS, c.Codigo_PLA
FROM hcordenesdx a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero;

-- --------- qx

REPLACE INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT @numero+ a.Codigo_HCF, b.Codigo_ADM, b.Fecha_HCF, b.Codigo_ARE, c.Autorizacion_ADM, 'ORDEN AUTOMATICA DE HC', b.Codigo_USR 
FROM hcordenesqx a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero AND (@numero+ a.Codigo_HCF) NOT IN (SELECT codigo_ord FROM gxordenescab);

REPLACE INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT @numero+ a.Codigo_HCF, a.Codigo_SER, a.Cantidad_HCS, a.Cantidad_HCS, 0,0,c.Codigo_EPS, c.Codigo_PLA
FROM hcordenesqx a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero;

-- ------ insumos


REPLACE INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT @numero+ a.Codigo_HCF, b.Codigo_ADM, b.Fecha_HCF, b.Codigo_ARE, c.Autorizacion_ADM, 'ORDEN AUTOMATICA DE HC', b.Codigo_USR 
FROM hcordenesins a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero AND (@numero+ a.Codigo_HCF) NOT IN (SELECT codigo_ord FROM gxordenescab);

REPLACE INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT @numero+ a.Codigo_HCF, a.Codigo_SER, a.Cantidad_SER, a.Cantidad_SER, 0,0,c.Codigo_EPS, c.Codigo_PLA
FROM hcordenesins a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= @tercero;



-- --------- serv
/*
REPLACE INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT 105+ a.Codigo_HCF, b.Codigo_ADM, b.Fecha_HCF, b.Codigo_ARE, c.Autorizacion_ADM, 'ORDEN AUTOMATICA DE HC', b.Codigo_USR 
FROM hcordenesservicios a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= '3774' AND (105+ a.Codigo_HCF) NOT IN (SELECT codigo_ord FROM gxordenescab);

REPLACE INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT 105+ a.Codigo_HCF, a.Codigo_SER, a.Cantidad_HCS, a.Cantidad_HCS, 0,0,c.Codigo_EPS, c.Codigo_PLA
FROM hcordenesservicios a, hcfolios b, gxadmision c
WHERE c.Codigo_ADM=b.Codigo_ADM AND b.Codigo_TER=a.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF
AND a.Codigo_TER= '3774';
*/