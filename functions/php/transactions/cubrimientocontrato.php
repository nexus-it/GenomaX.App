<?php

include '00trnsctns.php';

	$SQL="Replace into gxcontratos(Codigo_EPS, Codigo_PLA, Codigo_TAR) Values ('".trim($_POST['codigo'])."', '".$_POST['planeseps']."', '".$_POST['tarifa']."')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Cubrimiento por Contratos', 'Código No.'.$_POST['codigo']);

include '99trnsctns.php';

?>