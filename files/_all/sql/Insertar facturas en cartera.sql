Insert Into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR)
Select a.Codigo_AFC, a.Codigo_FAC, a.ValEntidad_FAC, a.ValTotal_FAC from gxfacturas a 
where Codigo_ADM in ('19770')