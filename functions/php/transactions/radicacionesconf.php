<?php

include '00trnsctns.php';

	$Consec=(int)$_POST['radicacion'];
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la confirmacion de la radicacion '.add_ceros($Consec,10);
	}
	$SQL="Update czradicacionescab set FechaConf_RAD ='".($_POST['fecrad'])." 00:00:00', Radicado_RAD='".$_POST['numrad']."', UsuarioConf_USR='".$_SESSION["it_CodigoUSR"]."', Estado_RAD='2' Where Codigo_RAD='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czradicacionesdet Where Codigo_RAD='".$Consec."' and TRIM( codigo_fac ) Not IN (".$_POST['Facturas'].")";
	EjecutarSQL($SQL, $conexion);
	$SQL="INSERT INTO czcartera(Codigo_DCD, Codigo_AFC, Codigo_FAC, Codigo_EPS, Codigo_PLA, Fecha_FAC, Codigo_RAD, Fecha_CAR, ValorFac_CAR, ValorDeb_CAR, ValorCre_CAR, Saldo_CAR, Estado_CAR) SELECT b.Codigo_DCD, c.Codigo_AFC, a.Codigo_FAC, a.Codigo_EPS, a.Codigo_PLA, a.Fecha_FAC, b.Codigo_RAD, b.FechaConf_RAD, a.ValEntidad_FAC, 0, a.ValCredito_FAC, a.ValTotal_FAC, '1' FROM gxfacturas a, czradicacionescab b, czradicacionesdet c WHERE a.Codigo_FAC=c.Codigo_FAC AND a.Codigo_AFC=c.Codigo_AFC AND b.Codigo_RAD=c.Codigo_RAD AND b.Codigo_DCD=a.Codigo_DCD AND a.Estado_FAC='1' AND b.Estado_RAD='2' and b.Codigo_RAD='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	
	it_aud('2', 'Radicaciones', 'Confirmación Radicación No. '.$Consec);

include '99trnsctns.php';

?>