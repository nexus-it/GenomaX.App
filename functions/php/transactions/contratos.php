<?php

include '00trnsctns.php';

	$konsec=0;
	$SQL="Select Consecutivo_CNS from itconsecutivos where Tabla_CNS='czterceros' and Campo_CNS='Codigo_TER'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$konsec=$row[0];
	}
	mysqli_free_result($result);
	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['nit'], $conexion, "ID_TER");
	if ($konsec<$Consec) {
		$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['nit'], $conexion, "ID_TER");
		$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('".$Consec."', '".$_POST['nit']."', '".$_POST['nombre']."', 9, '".$_POST['Direccion']."', '".$_POST['Telefonos']."','".$_POST['email']."', '----')";
		error_log($SQL);
		EjecutarSQL($SQL, $conexion);
	} else {
		$SQL="Update czterceros set Nombre_TER='".$_POST['nombre']."', Direccion_TER='".$_POST['Direccion']."', Telefono_TER='".$_POST['Telefonos']."', Correo_TER='".$_POST['email']."' Where Codigo_TER='".$Consec."'";
		EjecutarSQL($SQL, $conexion);
	}
	$CodigoTER=$Consec;
	$Consec=LoadConsec("gxeps", "Codigo_EPS", $_POST['codigo'], $conexion, "Codigo_EPS");
	$SQL="Replace into gxeps(Codigo_EPS, Nombre_EPS, Tipo_EPS, Codigo_TER, Contrato_EPS, FechaIni_EPS, FechaFin_EPS, Observaciones_EPS, Estado_EPS, CodMin_EPS, TipoContrato_EPS, ValorCapita_EPS, FacXOrd_EPS, NameContact_EPS, LastnameContact_EPS, PhoneContact_EPS, CellContact_EPS, EmailContact_EPS, VenceFactura_EPS) Values('".$Consec."', '".$_POST['nombreeps']."', '".$_POST['tipoeps']."', '".$CodigoTER."', '".$_POST['contrato']."', '".($_POST['fechaini'])."', '".($_POST['fechafin'])."', '".$_POST['observaciones']."', '".$_POST['estado']."', '".$_POST['codmin']."', '".$_POST['tipocontrato']."', ".$_POST['valorcapita'].", ".$_POST['facxorden']." , '".$_POST['namecontact']."', '".$_POST['lastnamecontact']."', '".$_POST['phonecontact']."', '".$_POST['cellcontact']."', '".$_POST['emailcontact']."', '".$_POST['facvence']."')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Contratos', 'Código No.'.$Consec);

include '99trnsctns.php';

?>