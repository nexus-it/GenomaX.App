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
	$SQL="Insert Into hc_ENFERMERIA(Codigo_TER, Codigo_HCF, nota_HC, curacion_HC) Values ('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['notaenf']."', '".$_POST['curaciones']."')";
	EjecutarSQL($SQL, $conexion);
	// SIGNOS VITALES
	$totalsv=12;
	for ($i = 1; $i <= $totalsv; $i++) {
		if (isset($_POST['codsv'.$i])) { 
			$SQL="Insert Into hcsignosvitales(Codigo_TER, Codigo_HCF, Codigo_HSV, Valor_HSV, Fecha_HSV, Hora_HSV) values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['codsv'.$i]."', '".$_POST['valorsv'.$i]."', '".($_POST['fecha'])."', '".substr($_POST['hora'],0,5)."')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	// CURACIONES
	$CodMED="0";
	$SQL="Select Codigo_TER from gxmedicos Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	$resultMEd = mysqli_query($conexion, $SQL);
	if($rowMed = mysqli_fetch_row($resultMEd)) {
		$CodMED=$rowMed[0];
	}
	mysqli_free_result($resultMEd);
	$OrdenCurac='0';
	$SQL="Select OrdCuraFac_XHC, OrdDispFac_XHC From itconfig_hc";
	$resultmx = mysqli_query($conexion, $SQL);
	while($rowmx = mysqli_fetch_row($resultmx)) {
		$OrdenCurac=$rowmx[0];
	}
	mysqli_free_result($resultmx);
	if ($OrdenCurac=='1') {
		if ($_POST['curaciones']!='0') {
			$Consec=LoadConsec("gxordenescab", "Codigo_ORD", "0000000000", $conexion, "LPAD(Codigo_ORD,10,'0')");
			$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$Consec."', '".(int)$_POST['ingreso']."', now(), '".$_POST['area']."', 'ORDEN GENERADA POR ENFERMERIA-CURACIONES',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizacion']."')";
			EjecutarSQL($SQL, $conexion);
			$SQL="Insert Into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER) Select '".$Consec."', Codigo_SER, 1, '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$CodMED."'  From hctipocuraciones where Codigo_HTC ='".$_POST['curaciones']."'";
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxordenesdet b, gxmanualestarifarios c, gxcontratos d Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where b.Codigo_ORD='".$Consec."' and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER and date(now()) between c.FechaIni_TAR and c.FechaFin_TAR";
			EjecutarSQL($SQL, $conexion);
		}
	}
	
	// APLICACION DE MEDICAMENTOS

	it_aud('1', 'Curación', 'Tercero '.$_POST['codigoter'].' - Folio Int. '.$ElFolio);

include '99trnsctns.php';

?>