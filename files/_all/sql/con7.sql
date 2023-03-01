SET @serv='164294';
SET @fact='MB479';
SET @orden='82469';

INSERT INTO gxtarifaexcepciones(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Valor_TRX)
SELECT b.Codigo_TAR, '2022-01-01', '2022-12-31 23:59:59', 'X', @serv, a.ValTotal_FAC
FROM gxfacturas a, gxcontratos b
WHERE a.Codigo_EPS=b.Codigo_EPS AND a.Codigo_PLA=b.Codigo_PLA
AND a.Codigo_FAC=@fact;

INSERT INTO gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR)
SELECT d.Codigo_TAR, '2022-01-01', '2022-12-31 23:59:59', @serv, c.ValTotal_FAC
FROM gxfacturas c, gxcontratos d
WHERE c.Codigo_EPS=d.Codigo_EPS AND c.Codigo_PLA=d.Codigo_PLA
AND c.Codigo_FAC=@fact;

INSERT INTO gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Autorizacion_ORD, Descripcion_ORD, Codigo_USR)
SELECT @orden, f.codigo_adm, e.Fecha_FAC, 'CSL', f.Autorizacion_ADM, 'CAPITA', f.Codigo_USR
FROM gxfacturas e, gxadmision f
WHERE e.codigo_adm=f.codigo_adm
AND e.Codigo_FAC=@fact;

INSERT INTO gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, CantidadOLD_ORD, ValorEntidad_ORD, ValorServicio_ORD, Codigo_EPS, Codigo_PLA)
SELECT @orden, @serv, 1,1,g.ValTotal_FAC, g.ValTotal_FAC, g.Codigo_EPS, g.Codigo_PLA
FROM gxfacturas g
WHERE g.Codigo_FAC=@fact;