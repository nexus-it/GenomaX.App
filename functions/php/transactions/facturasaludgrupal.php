<?php

include '00trnsctns.php';

	$Consec=LoadConsecFact($conexion, $_POST['sede']);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha generado correctamente la factura '.add_ceros($Consec,10);
	}
	$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Fecha_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Tipo_FAC, ValEntidad_FAC, ValTotal_FAC) Values ('".$_POST['sede']."','".$Consec."', curdate(), '".$_POST["Contrato"]."', '".$_POST["Plan"]."', '".$_SESSION["it_CodigoUSR"]."', 'G',  '".$_POST["valfactura"]."',  '".$_POST["valfactura"]."')";
	EjecutarSQL($SQL, $conexion);

	$SQL="Insert into gxfacturasgrupal(Codigo_FAC, FechaIni_FAC, FechaFin_FAC, Codigo_SER, Servicio_FAC, ValServicio_FAC, Cantidad_FAC, ValTotal_FAC) Values ('".$Consec."', '".$_POST["fechaini"]."', '".$_POST["fechafin"]."', '".$_POST["codserv"]."', '".$_POST["nombreserv"]."', '".$_POST["valorservicio"]."',  '".$_POST["cantidad"]."',  '".$_POST["valfactura"]."')";
	EjecutarSQL($SQL, $conexion);

	$contador=0; 
/*	
	$SQL="Insert into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR, Estado_CAR) Values('".$_POST['sede']."', '".$Consec."', '".$_POST["valfactura"]."', '".$_POST["valfactura"]."','1')";
	EjecutarSQL($SQL, $conexion);
	*/
	while($contador <= $_POST['contfila']) { 
		$contador++;
		
		if (isset($_POST['ingreso'.$contador])) {
		
		$SQL="Update gxadmision Set Estado_ADM='F', Codigo_FAC='".$Consec."' Where Codigo_ADM='".$_POST['ingreso'.$contador]."';";
		EjecutarSQL($SQL, $conexion);

		//Antes de esto, verificar si la tarifa es soat o es iss, para realizar bien el redondeo
		
		}
	} 

	it_aud('1', 'Facturación Salud', 'Factura Grupal No. '.$Consec);

include '99trnsctns.php';

?>