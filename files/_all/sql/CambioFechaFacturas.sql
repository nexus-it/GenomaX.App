UPDATE gxfacturas 
SET fecha_fac ='2020-12-31'
WHERE fecha_fac >'2020-12-31';
UPDATE gxadmision 
SET fecha_adm ='2020-12-31'
WHERE fecha_adm >'2020-12-31 23:59:59' AND codigo_adm IN (SELECT codigo_adm FROM gxfacturas WHERE estado_fac='1');
UPDATE gxordenescab 
SET fecha_ord ='2020-12-31'
WHERE fecha_ord >'2020-12-31 23:59:59' AND codigo_adm IN (SELECT codigo_adm FROM gxfacturas WHERE estado_fac='1');