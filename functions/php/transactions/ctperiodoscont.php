<?php

include '00trnsctns.php';

	$SQL="Delete from czperiodoscont where Codigo_PCT='".trim($_POST['codigo'])."'";
	EjecutarSQL($SQL, $conexion);
	$porcenta=(100+$_POST['variacion'])/100;
	$SQL="Insert Into czperiodoscont(Codigo_PCT, Nombre_PCT, FechaIni_PCT, FechaFin_PCT, Anterior_PCT, Siguiente_PCT, Estado_PCT) 
    Values('".trim($_POST['codigo'])."', '".trim($_POST['nombre'])."', '".$_POST['fechaini']."', '".$_POST['fechafin']." 23:59:59', '".$_POST['periodoant']."', '".$_POST['periodosig']."', '".$_POST['estado']."')";
	EjecutarSQL($SQL, $conexion);
	 
	it_aud('1', 'Periodos Contables', 'Código No.'.trim($_POST['codigo']));

include '99trnsctns.php';

?>