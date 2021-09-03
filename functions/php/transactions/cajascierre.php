<?php

include '00trnsctns.php';

	$SQL="Update czmovcajadiario Set SaldoFinal_MDC=".$_POST['totsaldo'].", FechaCierre_MDC=now(), UsuarioCierre_MDC='".$_SESSION["it_CodigoUSR"]."', Estado_MDC='0' Where Codigo_CJA='".$_POST['idcaja']."' and Consec_CJA='".$_POST["conseccja"]."';";
	EjecutarSQL($SQL, $conexion);
	if ($_POST['optcierre']=="SI") {
		$SQL="Update czmovcajadiario Set BaseApertura_MDC=".$_POST['totsaldo']." Where Codigo_CJA='".$_POST['idcaja']."' and Consec_CJA='".$_POST["conseccja"]."';";
		EjecutarSQL($SQL, $conexion);
	}
	$SQL="Update czcajas Set Abierta_CJA='0' Where Codigo_CJA='".$_POST['idcaja']."';";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Caja', 'Cierre Caja No. '.$_POST['idcaja']);

include '99trnsctns.php';

?>