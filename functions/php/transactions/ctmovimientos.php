<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czmovcontcab", "Codigo_CNT", $_POST['asiento'], $conexion, "Codigo_CNT");
	$SQL="Delete From czmovcontcab Where Codigo_CNT='".$Consec."';";
	if ($_POST['consecutivo']!="") {
		$Consec2=$_POST['consecutivo'];
	} else  {
		$Consec2=$Consec;
	}
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert Into czmovcontcab(Codigo_CNT, Codigo_FNC, Fecha_CNT, Consec_FNC, Referencia_CNT, Observaciones_CNT, Total_CNT) values ('".$Consec."', '".$_POST['fuente']."', '".$_POST['fecha']."', '".$Consec2."', '".$_POST['referencia']."', '".$_POST['observaciones']."', '".$_POST['total']."');";
	error_log($SQL);
	
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czmovcontdet Where Codigo_CNT='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['totalrows']) { 
		$contador++;
		$tercer="";
		$SQL="Select Codigo_TER from czterceros Where ID_Ter='".$_POST['tercero'.$contador]."'";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_row($result)) {
			$tercer=$row[0];
		}
		mysqli_free_result($result);
		$SQL="Insert into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Values('".$Consec."', '".$tercer."', '".$_POST['cuenta'.$contador]."', '".$_POST['descripcion'.$contador]."', '".$_POST['ccosto'.$contador]."', '".$_POST['debito'.$contador]."', '".$_POST['credito'.$contador]."' )";
		error_log($SQL);
		EjecutarSQL($SQL, $conexion);
	}

	it_aud('1', 'Asiento Contable', 'Mov No. '.$Consec.' Doc. '.$_POST['fuente'].'-'.$_POST['consecutivo']);
	$MSG=$Consec;

include '99trnsctns.php';

?>