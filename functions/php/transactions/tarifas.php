<?php

include '00trnsctns.php';
	if ($_POST['tipo']!="Z") {
		$SQL="Delete from gxtarifaexcepciones where codigo_tar='".trim($_POST['tarifa'])."' and Tipo_TRX='".trim($_POST['tipo'])."' and Codigo_TRX in (".trim($_POST['codigo']).") and now() between FechaINI_TAR and FechaFin_TAR";
		EjecutarSQL($SQL, $conexion); 
	}
	if ($_POST['tbase']!="-") {
		if ($_POST['tipo']=="0") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Replace Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Values('".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', '".$_POST['codigo']."', '".$_POST['tbase']."', ".$porcenta.")";	
		}
		if ($_POST['tipo']=="9") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Replace Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Select '".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', Codigo_CFC, '".$_POST['tbase']."', ".$porcenta." from gxconceptosfactura Where Codigo_CFC in (".$_POST['codigo'].")";
		}
		if ($_POST['tipo']=="X") {
			$porcenta=(100+$_POST['valor'])/100;
			$SQL="Replace Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Values('".trim($_POST['tarifa'])."', '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', '".$_POST['tipo']."', '".$_POST['codigo']."', '', ".$_POST['valor'].")";
		}
		if ($_POST['tipo']=="Z") {
			$SQL="Update gxmanualestarifarios a set FechaFin_TAR='".trim($_POST['fechafin'])." 23:59:59' WHERE  a.Codigo_TAR='".trim($_POST['tarifa'])."' and DATE_SUB('".trim($_POST['fechaini'])."',INTERVAL 1 MONTH) BETWEEN a.FechaIni_TAR AND a.FechaFin_TAR ORDER BY a.FechaINI_TAR ASC";
			EjecutarSQL($SQL, $conexion);	
			$SQL="Replace Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) SELECT distinct a.codigo_tar, '".trim($_POST['fechaini'])."', '".trim($_POST['fechafin'])." 23:59:59', a.Tipo_TRX, a.Codigo_TRX, a.Tarifa_TRX, a.Valor_TRX FROM gxtarifaexcepciones a WHERE a.Codigo_TAR='".trim($_POST['tarifa'])."' and DATE_SUB('".trim($_POST['fechaini'])."',INTERVAL 1 MONTH) BETWEEN a.FechaINI_TAR AND a.FechaFin_TAR ";
		}
		EjecutarSQL($SQL, $conexion);
	}
	if ($_POST['tipo']!="Z") {
		UpdtTarifasNow(trim($_POST['tarifa']), $conexion);
	}
	 
	it_aud('1', 'Excepcion Manual Tarifario', $_POST['tipo'].' Tarifa No.'.trim($_POST['tarifa']).' - Código No.'.trim($_POST['codigo']).' {'.$_POST['tbase'].'}');

include '99trnsctns.php';

?>