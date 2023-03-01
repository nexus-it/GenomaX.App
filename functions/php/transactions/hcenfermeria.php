<?php

include '00trnsctns.php';

	$SQL="Select max(Cast(Codigo_HCF as decimal(2)))  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
	$SQL="Select max(Folio_HCF)  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if($row[0]==null) {
			$XFolio="1";
		} else {
			$XFolio=$row[0];
		}
	} else {
		$XFolio="1";
	}
	mysqli_free_result($result);
	$SQL="Select max(Codigo_HCF)  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if($row[0]==null) {
			$ElFolio="1";
		} else {
			$ElFolio=$row[0];
		}
	} else {
		$ElFolio="1";
	}
	mysqli_free_result($result);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se generado el folio '.add_ceros($XFolio,5);
	}
	//Generamos registro del nuevo folio
	$SQL="Insert Into hcfolios(Codigo_TER, Codigo_HCT, Codigo_HCF, Fecha_HCF, Hora_HCF, Codigo_ADM, Codigo_ARE, Codigo_USR, FechaReg_HCF, Folio_HCF) Values ('".$_POST['codigoter']."', 'ENFERMERIA', '".$ElFolio."', '".($_POST['fecha'])."', '".substr($_POST['hora'],0,5)."', '".$_POST['ingreso']."', '".$_POST['area']."', '".$_SESSION["it_CodigoUSR"]."', now(), '".$XFolio."')";
	EjecutarSQL($SQL, $conexion);
	//REGISTRO DE ENFERMERIA
	$SQL="Insert Into hc_enfermeria(Codigo_TER, Codigo_HCF, nota_HC, dispositivo_HC) Values ('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['notaenf']."', '".$_POST['dispositivo']."')";
	EjecutarSQL($SQL, $conexion);
	// SIGNOS VITALES
	$totalsv=12;
	for ($i = 1; $i <= $totalsv; $i++) {
		if (isset($_POST['codsv'.$i])) {
			$SQL="Insert Into hcsignosvitales(Codigo_TER, Codigo_HCF, Codigo_HSV, Valor_HSV, Fecha_HSV, Hora_HSV) values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['codsv'.$i]."', '".$_POST['valorsv'.$i]."', '".($_POST['fecha'])."', '".substr($_POST['hora'],0,5)."')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	
	// APLICACION DE MEDICAMENTOS

	it_aud('1', 'Registro de Enfermería', 'Tercero '.$_POST['codigoter'].' - Folio Int. '.$ElFolio);

include '99trnsctns.php';

?>