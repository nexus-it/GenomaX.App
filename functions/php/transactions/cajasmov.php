<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czmovcajaenc", "Codigo_MCJ", 'X', $conexion, "Codigo_MCJ");
	$SQL="Insert into czmovcajaenc(Codigo_MCJ, Codigo_CJA, Consec_CJA, Codigo_TER, Codigo_ADM, Fecha_MCJ, Codigo_TMC, Codigo_TIC, Codigo_FAC, Concepto_MCJ, Observaciones_MCJ, Codigo_USR) Values ('".$Consec."', '".$_POST['idcaja']."','".$_POST['conseccja']."', '".$_POST['tercero']."', LPAD('".$_POST['ingreso']."',10,'0'), now(), '".$_POST['tipmov']."', '".$_POST['tiping']."', '', '".$_POST['concepto']."', '".$_POST['nota']."', '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czmovcajadet(Codigo_MCJ, TipoPago_MCJ, Valor_MCJ) values ('".$Consec."', 'EF', ".$_POST['valor'].")";
	EjecutarSQL($SQL, $conexion);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha realizado correctamente el movimiento de caja '.add_ceros($Consec,10);
		it_aud('1', 'Caja', 'Movimento Caja No. '.$Consec);
	}

	
include '99trnsctns.php';

?>