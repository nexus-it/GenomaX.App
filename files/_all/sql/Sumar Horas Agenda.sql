
UPDATE gxagendadet 
SET hora_age=ADDDATE(hora_age,  INTERVAL '0 1' hour_minute) 
WHERE codigo_age IN ( SELECT codigo_age FROM gxagendacab WHERE codigo_ter IN (5221) AND estado_age='1' AND fechaini_age >='2020-11-30') AND fecha_age >='2020-12-01' AND fecha_age<='2021-01-20' AND fecha_age<>'2021-01-14'
