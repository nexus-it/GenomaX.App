<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idempleado'], $conexion, "ID_TER");
	$SQL="Delete From czempleados Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Select * From czterceros Where Codigo_TER='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	// TERCEROS
	if ($row = mysqli_fetch_row($result)) {
		$SQL="Update czterceros set Nombre_TER='".trim($_POST['nombre1'])." ".trim($_POST['nombre2'])." ".trim($_POST['apellido1'])." ".trim($_POST['apellido2'])."', Direccion_TER='".$_POST['Direccion']."', Telefono_TER='".$_POST['Telefonos']."', Correo_TER='".$_POST['email']."', Codigo_TID='".$_POST['tipoid']."', Expedicion_TER='".$_POST['expedicion']."' Where Codigo_TER='".$Consec."';";
		EjecutarSQL($SQL, $conexion);		
	} else {
		$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('".$Consec."', '".$_POST['idempleado']."', '".trim($_POST['nombre1'])." ".trim($_POST['nombre2'])." ".trim($_POST['apellido1'])." ".trim($_POST['apellido2'])."', ".$_POST['tipoid'].", '".$_POST['Direccion']."', '".$_POST['Telefonos']."','".$_POST['email']."', '".$_POST['expedicion']."')";
		EjecutarSQL($SQL, $conexion);	
	}
	$SQL="Insert into czempleados(Codigo_TER, ID_EMP, Nombre1_EMP, Nombre2_EMP, Apellido1_EMP, Apellido2_EMP, FechaNac_EMP, EstCivil_EMP, Codigo_SEX, Codigo_DEP, Codigo_MUN, Barrio_EMP, Estado_EMP, Codigo_TCL, SalarioAct_EMP, FechaIng_EMP, Observaciones_EMP, FechaRet_EMP, Codigo_CRG, Codigo_SDE) Values('".$Consec."', '".$_POST['id']."', '".trim($_POST['nombre1'])."', '".trim($_POST['nombre2'])."', '".trim($_POST['apellido1'])."', '".trim($_POST['apellido2'])."', '".($_POST['fechanac'])."', '".$_POST['EstCivil']."', '".$_POST['Sexo']."', '".$_POST['Departamento']."', '".$_POST['Municipio']."', '".trim($_POST['Barrio'])."', '".$_POST['estado']."', '".$_POST['tipocon']."', ".$_POST['salario'].", '".($_POST['fechaing'])."', '".trim($_POST['observaciones'])."', '".($_POST['fecharet'])."', '".$_POST['cargo']."', '".$_POST['sede']."')";
	EjecutarSQL($SQL, $conexion);
	GuardarImagen('../../../files/images/terceros/'.$Consec, $Consec, 'terceros');

	it_aud('1', 'Empleados', 'Tercero No. '.$Consec);

include '99trnsctns.php';

?>