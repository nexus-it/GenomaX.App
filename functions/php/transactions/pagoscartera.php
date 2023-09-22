<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czpagosenc", "Codigo_PGS", $_POST['CodPago'], $conexion, "Codigo_PGS");
	$SQL="Delete from czpagosdet Where Codigo_PGS='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from czpagosenc Where Codigo_PGS='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert Into czpagosenc (Codigo_PGS, Fecha_PGS, Codigo_TER, Codigo_FPG, Codigo_BCO, Total_PGS, Observaciones_PGS, FechaReg_PGS, Codigo_USR) Select '".$Consec."', '".$_POST['CodFec']."', Codigo_TER, '".$_POST['CodFPG']."', '".$_POST['CodBCO']."', ".$_POST['CodTotal'].", '".$_POST['CodObs']."', now(), '".$_SESSION["it_CodigoUSR"]."' From czterceros Where ID_TER='".$_POST['CodTer']."';";
	EjecutarSQL($SQL, $conexion);
	$sumPago=0;

	for ($i=1; $i <=$_POST['FacPagos'] ; $i++) { 
		$SQL="Insert Into czpagosdet(Codigo_PGS, Codigo_FAC, Saldo1_PGS, Valor_PGS, Saldo2_PGS) Values('".$Consec."', '".$_POST['LaFaktura'.$i]."', 0, ".$_POST['Valor'.$i].", 0);";
		EjecutarSQL($SQL, $conexion);
		$sumPago=$sumPago+$_POST['Valor'.$i]; 
	}
	
	$SQL="Update czpagosenc Set Total_PGS=".$sumPago." Where Codigo_PGS='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	
	$MSG="Debe confirmar el pago para que sea reflejado en Cartera / Contabilidad. Se ha generado el consecutivo de pagos recibidos No. ".$Consec."";
	
	it_aud('1', 'Cartera', 'Recepcion No. '.$Consec);

include '99trnsctns.php';

?>