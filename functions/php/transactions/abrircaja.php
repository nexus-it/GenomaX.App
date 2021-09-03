<?php

include '00trnsctns.php';

	$SaldoIn=0;
	$CierreAnt=0;
	$SQL="Select BaseApertura_MDC From czmovcajadiario Where Codigo_CJA='".$_POST['caja']."' and Estado_MDC='0' Order By FechaCierre_MDC desc Limit 1";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SaldoIn=$row[0];
		$CierreAnt=1;
	}
	mysqli_free_result($result);
	if ($CierreAnt=0) {
		$SQL="Select SaldoIni_CJA From czcajas Where Codigo_CJA='".$_POST['caja']."'";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$SaldoIn=$row[0];
		}
		mysqli_free_result($result);
	}

	$SQL="Insert Into czmovcajadiario(Codigo_CJA, FechaApertura_MDC, SaldoInicial_MDC, Codigo_USR) values('".$_POST['caja']."', now(), ".$SaldoIn.", '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	if ($SaldoIn>0) {
		$Consec=LoadConsec("czmovcajaenc", "Codigo_MCJ", 'X', $conexion, "Codigo_MCJ");
		$SQL="Insert into czmovcajaenc(Codigo_MCJ, Codigo_CJA, Consec_CJA, Codigo_TER, Codigo_ADM, Fecha_MCJ, Codigo_TMC, Codigo_TIC, Codigo_FAC, Concepto_MCJ, Observaciones_MCJ, Codigo_USR) Select '".$Consec."', '".$_POST['caja']."', Consec_CJA,'0','', now(), 'AJ', 'INGR', '', 'SALDO INICIAL DE CAJA ARRASTRADO DEL CIERRE ANTERIOR', '', '".$_SESSION["it_CodigoUSR"]."' From czmovcajadiario Where Codigo_CJA='".$_POST['caja']."' and Estado_MDC='1' order by Consec_CJA desc limit 1;";
		EjecutarSQL($SQL, $conexion);
		$SQL="Insert into czmovcajadet(Codigo_MCJ, TipoPago_MCJ, Valor_MCJ) values ('".$Consec."', 'EF', ".$SaldoIn.")";
		EjecutarSQL($SQL, $conexion);
	}
	$SQL="Update czcajas Set Abierta_CJA='1' Where Codigo_CJA='".$_POST['caja']."';";
	EjecutarSQL($SQL, $conexion);

	it_aud('2', 'Caja', 'Apertura Caja No. '.$_POST['caja']);

include '99trnsctns.php';

?>