Select d.*
From gxfacturas a, gxadmision b, gxordenescab c, gxordenesdet d
Where a.Codigo_ADM=b.Codigo_ADM and a.Codigo_DCD=b.Codigo_DCD and a.Codigo_ADM=c.Codigo_ADM and c.Codigo_ORD=d.Codigo_ORD and 
a.Codigo_FAC='BAQ 0000005083'