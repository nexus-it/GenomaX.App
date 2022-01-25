<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czradicacionescab", "Codigo_RAD", $_POST['radicacion'], $conexion, "LPAD(Codigo_RAD,10,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la radicacion de cuentas '.add_ceros($Consec,10);
	}
	if ($_POST['radicacion']==$Consec) {
		$SQL="Update czcartera set Estado_CAR='1' Where Codigo_FAC in (Select Codigo_FAC From czradicacionesdet Where Codigo_RAD='".$Consec."');";
		EjecutarSQL($SQL, $conexion);
		$SQL="Delete From czradicacionesdet Where Codigo_RAD='".$Consec."';";
		EjecutarSQL($SQL, $conexion);
		$SQL="Delete From czradicacionescab Where Codigo_RAD='".$Consec."';";
		EjecutarSQL($SQL, $conexion);
	}
	$SQL="Insert into czradicacionescab(Codigo_RAD, Codigo_EPS, Codigo_PLA, FechaIni_RAD, FechaFin_RAD, Fecha_RAD, Codigo_USR) Values ('".$Consec."', '".$_POST['Contrato']."', '".$_POST['Plan']."', '".($_POST['fecini'])." 00:00:00', '".($_POST['fecfin'])." 23:59:59', '".($_POST['fecrad'])." 00:00:00', '".$_SESSION["it_CodigoUSR"]."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czradicacionesdet(Codigo_RAD, Codigo_FAC) SELECT distinct '".$Consec."', codigo_fac FROM  gxfacturas WHERE TRIM( codigo_fac ) IN (".$_POST['Facturas'].")";
	// error_log($SQL);
	EjecutarSQL($SQL, $conexion);
	$SQL="Update czcartera set Estado_CAR='2' Where TRIM( codigo_fac ) IN (".$_POST['Facturas'].")";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Radicaciones', 'Remisión No. '.$Consec);

include '99trnsctns.php';

?>