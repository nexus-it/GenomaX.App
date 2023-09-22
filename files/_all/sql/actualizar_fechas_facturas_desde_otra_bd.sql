update ihccomco_test.gxfacturas origen, ihccomco_ihc.gxfacturas destino 
set destino.Fecha_FAC=origen.Fecha_FAC 
where destino.Codigo_FAC=origen.Codigo_FAC and destino.Codigo_AFC=origen.Codigo_AFC