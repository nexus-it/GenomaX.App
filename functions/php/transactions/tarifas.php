<?php

include '00trnsctns.php';

	$SQL="Delete from gxtarifaexcepciones where codigo_tar='".trim($_POST['tarifa'])."' and Tipo_TRX='".trim($_POST['tipo'])."' and Codigo_TRX in (".trim($_POST['codigo']).") and now() between FechaINI_TAR and FechaFin_TAR";
	EjecutarSQL($SQL, $conexion);
	if ($_POST['tbase']!="-") {
		if ($_POST['tipo']=="0") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Insert Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Values('".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', '".$_POST['codigo']."', '".$_POST['tbase']."', ".$porcenta.")";	
		}
		if ($_POST['tipo']=="9") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Insert Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Select '".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', Codigo_CFC, '".$_POST['tbase']."', ".$porcenta." from gxconceptosfactura Where Codigo_CFC in (".$_POST['codigo'].")";
		}
		if ($_POST['tipo']=="X") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Insert Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Values('".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', '".$_POST['codigo']."', '', ".$_POST['valor'].")";
		}
		EjecutarSQL($SQL, $conexion);
	}
	
	UpdtTarifasNow(trim($_POST['tarifa']), $conexion);
	 
	it_aud('1', 'Excepcion Manual Tarifario', $_POST['tipo'].' Tarifa No.'.trim($_POST['tarifa']).' - Código No.'.trim($_POST['codigo']).' {'.$_POST['tbase'].'}');

include '99trnsctns.php';

?>