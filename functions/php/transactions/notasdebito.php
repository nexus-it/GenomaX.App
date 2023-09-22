<?php

include '00trnsctns.php';

	$Consec=LoadConsec("cznotascontablesend", "Codigo_NCT", '0', $conexion, "Codigo_NCT");
	//$SQL="Update gxfacturas set ValTotal_FAC=(ValPaciente_FAC+ValEntidad_FAC)-(ValDcto_FAC)-ValCredito_FAC - ".$_POST['valornc'].", ValCredito_FAC=ValCredito_FAC+".$_POST['valornc']." where Codigo_FAC='".$_POST['factura']."';";
	//EjecutarSQL($SQL, $conexion);
	$SQL="Update czcartera set Saldo_CAR=ValorFac_CAR - ValorDeb_CAR + ValorCre_CAR + ".$_POST['valornc'].", ValorCre_CAR=ValorCre_CAR- ".$_POST['valornc']." where Codigo_FAC='".$_POST['factura']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into cznotascontablesend(Codigo_NCT, Naturaleza_NCT, Descripcion_NCT, Fecha_NCT, TipoDoc_NCT, NumeroDoc_NCT, Codigo_TER, Valor_NCT, Codigo_USR) values(".$Consec.", 'D', '".$_POST['observacion']."', '".$_POST['fecha']."', '01', '".$_POST['factura']."', '".$_POST['codigoter']."', ".$_POST['valornc'].", '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$totalnc=$_POST['controw'];

	

	it_aud('1', 'Notas Debito', 'No '.$Consec);

include '99trnsctns.php';

?>