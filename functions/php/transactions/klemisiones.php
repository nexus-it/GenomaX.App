<?php

include '00trnsctns.php';

	$Consec=LoadConsec("klemisiones", "Codigo_EMI", '0', $conexion, "Codigo_EMI");
	$paddy=$_POST['voucher'].str_pad($Consec, 5, "0", STR_PAD_LEFT);
	$SQL="Insert into klemisiones(Codigo_EMI, Codigo_CTZ, Fecha_EMI, Voucher_EMI, Codigo_USR, Estado_EMI, Prefijo_EMI) Values('".$Consec."', '".intval(trim($_POST['cotizacion']))."', now(), '".$paddy."', '".$_SESSION["it_CodigoUSR"]."', 'E', '".$_SESSION['Kl_Prefijo']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update klcotizaciones set voucher_CTZ='".$paddy."', Estado_CTZ='E' Where Codigo_CTZ='".intval(trim($_POST['cotizacion']))."';";
	EjecutarSQL($SQL, $conexion);
	$ConsecPoliza=$Consec;
	$MSG=$ConsecPoliza;

	it_aud('1', 'Emisión Poliza', 'Consecutivo No. '.$ConsecPoliza);

include '99trnsctns.php';

?>