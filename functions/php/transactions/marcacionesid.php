<?php

include '00trnsctns.php';

	$SQL="Select Fecha_IDM From idmarcaciones a, czterceros c where c.Codigo_TER=a.Codigo_TER and ID_TER='".$_POST['idempleado']."' Order By Fecha_IDM desc Limit 15;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$FechaLimit=$row[0];
	}
	mysqli_free_result($result);
	$SQL="Delete From idmarcaciones Where Fecha_IDM>='".$FechaLimit."' and Codigo_USR<>'-' and Codigo_TER='".$_POST['terceros']."'";
	EjecutarSQL($SQL, $conexion);
	$contador=1;
	while($contador <= $_POST['controw']) { 
		if (isset($_POST['usuario'.$contador])) {
			if ($_POST['usuario'.$contador]!="-") {
				$SQL="Insert into idmarcaciones(Codigo_TER, Codigo_IDF, Fecha_IDM, Codigo_MRC, Codigo_USR) Values ('".$_POST['terceros']."','0', '".($_POST['fecha'.$contador]).' '.$_POST['hora'.$contador]."', '".$_POST['tipomarca'.$contador]."', '".$_POST['usuario'.$contador]."')";
				EjecutarSQL($SQL, $conexion);
			}
		}
		$contador++;
	}

	it_aud('2', 'Marcaciones ID', 'Empleado No. '.$_POST['idempleado']);

include '99trnsctns.php';

?>