<?php

include '00trnsctns.php';

	$SQL="Delete from gxtarifas where codigo_tar='".trim($_POST['codigo'])."'";
	EjecutarSQL($SQL, $conexion);
	$porcenta=(100+$_POST['variacion'])/100;
	$SQL="Insert Into gxtarifas(Codigo_TAR, Nombre_TAR, Tipo_TAR, Base_TAR, Variacion_TAR) Values('".trim($_POST['codigo'])."', '".trim($_POST['nombre'])."', '".$_POST['tipo']."', '".$_POST['base']."', ".$porcenta.")";
	EjecutarSQL($SQL, $conexion);
	
	UpdtTarifasNow(trim($_POST['codigo']), $conexion);
	 
	it_aud('1', 'Manuales Tarifarios', 'Código No.'.trim($_POST['codigo']));

include '99trnsctns.php';

?>