<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['ID_TER'], $conexion, "ID_TER");
	/* $SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion); */
	$SQL="Replace into czterceros(Codigo_TER, ID_TER, DigitoVerif_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Expedicion_TER, Correo_TER, Codigot_DEP, Codigot_MUN, PersonaNatural_TER, RazonSocial_TER, Web_TER, Contacto_TER, RepLegal_TER, Codigo_RGN, IDAnterior_TER, CxC_TER, CxP_TER, Codigo_PAI, RetVentas_TER, Cliente_TER, Proveedor_TER)	Values ('".$Consec."', '".$_POST['ID_TER']."', '".$_POST['DigitoVerif_TER']."', '".$_POST['Nombre_TER']."', '".$_POST['Codigo_TID']."', '".$_POST['Direccion_TER']."', '".$_POST['Telefono_TER']."', '".$_POST['Expedicion_TER']."', '".$_POST['Correo_TER']."', '".$_POST['Codigot_DEP']."', '".$_POST['Codigot_MUN']."', '".$_POST['PersonaNatural_TER']."', '".$_POST['RazonSocial_TER']."', '".$_POST['Web_TER']."', '".$_POST['Contacto_TER']."', '".$_POST['RepLegal_TER']."', '".$_POST['Codigo_RGN']."', '".$_POST['IDAnterior_TER']."', '".substr($_POST['CxC_TER'],0,10)."', '".substr($_POST['CxP_TER'],0,10)."', '".$_POST['Codigo_PAI']."', '".$_POST['RetVentas_TER']."', '".$_POST['Cliente_TER']."', '".$_POST['Proveedor_TER']."' )";
	//echo $SQL;
	// error_log($SQL);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Terceros', 'Código Tercero '.$Consec);

include '99trnsctns.php';

?>