<?php
include '00trnsctns.php';

	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la solicitud de devolucion del ingreso '.add_ceros($_POST['solicitud'],10);
	}

	$contador=0; 
	while($contador <= $_POST['controwMed']) { 
		
			$SQL="Update czinvsolfarmacia Set  Devolucion_ISF = ".$_POST['cantdev'.$contador].", DetDev_ISF = '".$_POST['cajadetalle']."' Where LPAD(Codigo_ADM,10,'0')=LPAD('".$_POST['solicitud']."',10,'0') and Codigo_SER='".$_POST['codmed'.$contador]."';";
			//print_r($SQL);//exit();
			EjecutarSQL($SQL, $conexion);
		

		$contador++; 
	}

	it_aud('1', 'Inventario', 'Solicitud Farmacia No. '.$_POST['solicitud']);

include '99trnsctns.php';

?>