select *
from gxmedicos , gxmedicosx 
where gxmedicos.Codigo_TER=gxmedicosx.Codigo_TER
and gxmedicosx.Firma_MED is  null and gxmedicos.Firma_MED is not null