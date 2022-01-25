<?php
include '00trnsctns.php';

	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la solicitud '.add_ceros($_POST['solicitud'],10);
	}
	$contador=0; 
	while($contador <= $_POST['controwMed']) { 
		if ($_POST['cantdespmed'.$contador]>0) {
			//SE ACTUALIZA LA SOLICITUD Y LA FORMULA MEDICA
			// error_log($_POST['obsmed'.$contador]);
			if ($_POST['obsmed'.$contador]=="** INSUMO **") {
				$SQL="Insert Into czinvsolfarmacia(Codigo_TER, Codigo_HCF, Codigo_ISF, Codigo_SER, Fecha_ISF, Hora_ISF, Codigo_ADM, Codigo_ARE, Formula_ISF, Cantidad_ISF, Pendiente_ISF, Codigo_USR, Estado_ISF, Ordena_ISF) Select Codigo_TER, Codigo_HCF, Codigo_ISF, '".$_POST['codmed'.$contador]."', Fecha_ISF, Hora_ISF, Codigo_ADM, Codigo_ARE, '".$_POST['obsmed'.$contador]."', '".$_POST['cantdespmed'.$contador]."', '".$_POST['cantdespmed'.$contador]."', '".$_SESSION["it_CodigoUSR"]."', 'S', Ordena_ISF from czinvsolfarmacia Where Codigo_ISF='".$_POST['solicitud']."' limit 1;";
				EjecutarSQL($SQL, $conexion);
			}
			$SQL="Update czinvsolfarmacia Set Estado_ISF='S', Pendiente_ISF = Pendiente_ISF - ".$_POST['cantdespmed'.$contador]." Where Codigo_ISF='".$_POST['solicitud']."' and Codigo_SER='".$_POST['codmed'.$contador]."';";
			$SQL="Update czinvsolfarmacia Set Estado_ISF='S', Codigo_USR='".$_SESSION["it_CodigoUSR"]."' Where Codigo_ISF='".$_POST['solicitud']."' and Codigo_SER='".$_POST['codmed'.$contador]."';";
			EjecutarSQL($SQL, $conexion);
		}
		$contador++; 
	}

	it_aud('1', 'Inventario', 'Solicitud Farmacia No. '.$_POST['solicitud']);

include '99trnsctns.php';

?>