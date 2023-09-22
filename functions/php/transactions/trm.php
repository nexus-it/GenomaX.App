<?php

include '00trnsctns.php';

	$SQL="Delete from cztrm Where Moneda_TRM='US' and Fecha_TRM=date(now());";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into cztrm(Fecha_TRM, Moneda_TRM, Valor_TRM) Values(date(now()), 'US',".$_POST['valor'].");";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'T.R.M.', 'US - '.$_POST['valor']);

include '99trnsctns.php';

?>