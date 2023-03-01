UPDATE gxpacientes 
SET Codigo_EPS=CONCAT('X', Codigo_EPS)
WHERE Codigo_EPS IN (SELECT Codigo_EPS FROM gxeps WHERE nombre_eps LIKE '%CAJACOP%' AND Codigo_EPS NOT LIKE 'X%');

UPDATE gxordenesdet 
SET Codigo_EPS=CONCAT('X', Codigo_EPS)
WHERE codigo_ord IN (SELECT codigo_ord FROM gxordenescab WHERE codigo_adm IN 
(SELECT codigo_adm FROM gxadmision WHERE fecha_adm>='2022-09-01' and estado_adm ='I' AND  Codigo_EPS IN 
(SELECT Codigo_EPS FROM gxeps WHERE nombre_eps LIKE '%CAJACOP%' AND Codigo_EPS NOT LIKE 'X%')));

UPDATE gxadmision 
SET Codigo_EPS=CONCAT('X', Codigo_EPS)
WHERE fecha_adm>='2022-09-01' and estado_adm ='I' AND  Codigo_EPS IN 
(SELECT Codigo_EPS FROM gxeps WHERE nombre_eps LIKE '%CAJACOP%' AND Codigo_EPS NOT LIKE 'X%');




