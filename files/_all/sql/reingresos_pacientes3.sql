SET @numero=30032;
SET @usuario='157';
SET @fechaADM='2019-01-01';
SET @fechafac='2018-12-28';

Insert Into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, Observaciones_ADM, Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, Codigo_USR)
Select @numero:=@numero+1, Codigo_TER, @fechaADM, Codigo_EPS, Codigo_PLA, '13', '10', Ingreso_ADM, @fechaADM, Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, Observaciones_ADM, Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, @usuario
from gxadmision x Where x.Estado_ADM='F' and x.Codigo_ADM in
(Select codigo_adm
from gxfacturas a
where a.Fecha_FAC=@fechafac and a.Estado_FAC='1');

Update itconsecutivos SET `Consecutivo_CNS`=@numero WHERE  `Campo_CNS`='Codigo_ADM' AND `Tabla_CNS`='gxadmision' AND `Codigo_DCD`=0;