<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czmyturnosenc", "Codigo_TUR", $_POST['nombre'], $conexion, "Nombre_TUR");
	$SQL="Delete from czmyturnosenc Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="INSERT INTO czmyturnosenc (Codigo_TUR, Nombre_TUR, Fecha_TUR, FechaIni_TUR, FechaFin_TUR, Observaciones_TUR, Codigo_USR) VALUES ('".$Consec."', '".$_POST['nombre']."', curdate(), '".($_POST['fechaini'])."', '".($_POST["fechafin"])."', '".$_POST['observaciones']."', '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from czmyturnosdet Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$contador=1;
	while($contador <= $_POST['controw']) { 
		if (isset($_POST['codarea'.$contador])) {
				$SQL="INSERT INTO czmyturnosdet (Codigo_TRN, Codigo_TUR, Codigo_TER, Tipo_TUR, Codigo_ARE, Orden_TUR) VALUES ('".$_POST['turno1'.$contador]."', '".$Consec."', '".$_POST['empleado1'.$contador]."', '1', '".$_POST['codarea'.$contador]."', '".$contador."');";
				EjecutarSQL($SQL, $conexion);
				$SQL="INSERT INTO czmyturnosdet (Codigo_TRN, Codigo_TUR, Codigo_TER, Tipo_TUR, Codigo_ARE, Orden_TUR) VALUES ('".$_POST['turno2'.$contador]."', '".$Consec."', '".$_POST['empleado2'.$contador]."', '2', '".$_POST['codarea'.$contador]."', '".$contador."');";
				EjecutarSQL($SQL, $conexion);
		}
		$contador++;
	}

	$Consec=LoadConsec("czturnosenc", "Codigo_TUR", $_POST['nombre'], $conexion, "Nombre_TUR");
	$SQL="Delete from czturnosenc Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="INSERT INTO czturnosenc (Codigo_TUR, Nombre_TUR, Fecha_TUR, Observaciones_TUR, Codigo_USR) VALUES ('".$Consec."', '".$_POST['nombre']."', curdate(), '".$_POST['observaciones']."', '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from czturnosdet Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	
	$contador=1;
	while($contador <= $_POST['controw']) { 
		if (isset($_POST['codarea'.$contador])) {
		
			$DiaActual = new DateTime(($_POST['fechaini']));
			$DiaFinal = new DateTime(($_POST['fechafin']));
			while ($DiaActual <= $DiaFinal) {
				if ($_POST['empleado1'.$contador]!="") {
					$SQL="INSERT INTO czturnosdet (Codigo_TRN, Codigo_TUR, Codigo_TER, Fecha_TUR) VALUES ('".$_POST['turno1'.$contador]."', '".$Consec."', '".$_POST['empleado1'.$contador]."', '".$DiaActual->format('Y-m-d')."');";
					EjecutarSQL($SQL, $conexion);
				}
				if ($_POST['empleado2'.$contador]!="") {
					$SQL="INSERT INTO czturnosdet (Codigo_TRN, Codigo_TUR, Codigo_TER, Fecha_TUR) VALUES ('".$_POST['turno2'.$contador]."', '".$Consec."', '".$_POST['empleado2'.$contador]."', '".$DiaActual->format('Y-m-d')."');";
					EjecutarSQL($SQL, $conexion);
				}
				$DiaActual->add(new DateInterval('P1D'));
			}
		}
		$contador++;
	}	

	it_aud('1', 'MyTurnos', 'Codigo No. '.$Consec);

include '99trnsctns.php';

?>