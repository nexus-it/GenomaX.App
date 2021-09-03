<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idproveedor'], $conexion, "ID_TER");
	$SQL="Delete From czproveedores Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER, RazonSocial_TER, DigitoVerif_TER) Values ('".$Consec."', '".$_POST['idproveedor']."', '".trim($_POST['ncomercial'])."', ".$_POST['tipoid'].", '".$_POST['Direccion']."', '".$_POST['Telefonos']."','".$_POST['email']."', '".$_POST['expedicion']."', '".$_POST['rsocial']."', '".$_POST['id']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czproveedores(Codigo_TER, Nombre1_PRV, Nombre2_PRV, Apellido1_PRV, Apellido2_PRV, Codigo_PAI, Codigo_DEP, Codigo_MUN, Representante_PRV, Contacto_PRV, Cargo_PRV, Estado_PRV) Values('".$Consec."', '".trim($_POST['nombre1'])."', '".trim($_POST['nombre2'])."', '".trim($_POST['apellido1'])."', '".trim($_POST['apellido2'])."', '".$_POST['pais']."', '".$_POST['Departamento']."', '".$_POST['Municipio']."', '".$_POST['replegal']."', '".$_POST['contacto']."', '".trim($_POST['cargo'])."', '".$_POST['estado']."')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Proveedores', 'Tercero No. '.$Consec);

include '99trnsctns.php';

?>