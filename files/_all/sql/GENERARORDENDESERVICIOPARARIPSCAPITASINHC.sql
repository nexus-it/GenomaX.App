set @numero= 5114 ;

Insert Into gxordenescab
Select '0', @numero:=@numero+1, a.Codigo_ADM, a.Fecha_ADM, 'ODO', a.Autorizacion_ADM, 'ORDEN ODONTOLOGICA GENERADA PARA RIPS', a.Codigo_USR, '1', NULL, NULL from gxadmision a where a.Codigo_FAC in 
(' 0000002306', ' 0000002309', ' 0000002312', ' 0000002315', ' 0000002318', ' 0000002321', ' 0000002324');

Update itconsecutivos SET `Consecutivo_CNS`=@numero WHERE  `Campo_CNS`='Codigo_ORD' AND `Tabla_CNS`='gxordenescab' AND `Codigo_DCD`=0;


Insert Into gxordenesdet
Select b.Codigo_ORD, '5680', 1,1,0,0,0, a.Codigo_EPS, a.Codigo_PLA, '3'   from gxordenescab b, gxadmision a where b.Codigo_ADM = a.Codigo_ADM and a.Codigo_FAC in 
(' 0000002306', ' 0000002309', ' 0000002312', ' 0000002315', ' 0000002318', ' 0000002321', ' 0000002324') and b.Descripcion_ORD='ORDEN ODONTOLOGICA GENERADA PARA RIPS';