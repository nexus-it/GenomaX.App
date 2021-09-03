<?php

include '00trnsctns.php';

	$MSG="Anulada la póliza ".$_POST['poliza'];
	$SQL="Update klemisiones set Estado_EMI='A', Anula_EMI='".$_SESSION["it_CodigoUSR"]."' where LPAD(Codigo_EMI,6,'0')='".add_ceros($_POST['poliza'],6)."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update klcotizaciones set Estado_CTZ='1' where Codigo_CTZ in (Select Codigo_CTZ from klemisiones where LPAD(Codigo_EMI,6,'0')='".add_ceros($_POST['poliza'],6)."' )";
	EjecutarSQL($SQL, $conexion);

	it_aud('3', 'Emisión de Poliza', 'Poliza No. '.$_POST['poliza']);

include '99trnsctns.php';

?>