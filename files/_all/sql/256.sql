Select '2', @rownum:=@rownum+1 AS rownum, d.Sigla_TID, c.ID_TER, b.FechaNac_PAC, case b.Codigo_SEX when 'F' then 'M' else 'H' end as sexo,
 b.Apellido1_PAC, b.Apellido2_PAC, b.Nombre1_PAC, b.Nombre2_PAC, e.CodMin_EPS, f.Codigo256_ARE, a.FechaGraba_CIT, '1', a.Fecha_AGE, a.FechaDeseada_CIT
From (SELECT @rownum:=0) r, gxcitasmedicas a, gxpacientes b, czterceros c, cztipoid d, gxeps e, gxareas f, gxagendacab g
Where a.Codigo_TER=b.Codigo_TER and d.Codigo_TID=c.Codigo_TID and c.Codigo_TER=b.Codigo_TER and e.Codigo_TER=a.TerceroEPS_CIT and g.Codigo_AGE=a.Codigo_AGE and f.Codigo_ARE=g.Codigo_ARE
and f.Codigo256_ARE <>0
Order by a.Fecha_AGE, 
