<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idpaciente'], $conexion, "ID_TER");

	$SQL="Select * From czterceros Where Codigo_TER='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result)) 
	{
		$SQL="Update czterceros Set Nombre_TER='".$_POST['nombre1']." ".$_POST['nombre2']." ".$_POST['apellido1']." ".$_POST['apellido2']."' Where Codigo_TER='".$Consec."';";
	} else {
 		$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID) Values ('".$Consec."', '".$_POST['idpaciente']."', '".$_POST['nombre1']." ".$_POST['nombre2']." ".$_POST['apellido1']." ".$_POST['apellido2']."', 1)";
	}
	mysqli_free_result($result); 
	EjecutarSQL($SQL, $conexion);

	$SQL="Select * From gxpacientes Where Codigo_TER='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result)) 
	{
		$SQL="Update gxpacientes Set Nombre1_PAC='".$_POST['nombre1']."', Nombre2_PAC='".$_POST['nombre2']."', Apellido1_PAC='".$_POST['apellido1']."', Apellido2_PAC='".$_POST['apellido2']."', Codigo_EPS='".$_POST['entidad']."', Estado_PAC='1' Where Codigo_TER='".$Consec."';";
	} else {
 		$SQL="Insert into gxpacientes(Codigo_TER, Nombre1_PAC, Nombre2_PAC, Apellido1_PAC, Apellido2_PAC, FechaNac_PAC, EstCivil_PAC, Codigo_SEX, Codigo_DEP, Codigo_MUN, Barrio_PAC, Codigo_ZNA, Madre_PAC, Padre_PAC, Codigo_REG, Codigo_TAF, Codigo_EPS, Codigo_PLA, Codigo_RNG, Empresa_PAC, Actividad_PAC, Estado_PAC, Parentesco_PAC) Values('".$Consec."', '".$_POST['nombre1']."', '".$_POST['nombre2']."', '".$_POST['apellido1']."', '".$_POST['apellido2']."', '1900-01-01', 'SOLTERO (A)', 'F', '47', '001', '', 'U', '', '', '1', '1', '".$_POST['entidad']."', '1', '1', '', '', '1', '')";
	}
	mysqli_free_result($result);  
	EjecutarSQL($SQL, $conexion);
	
	$ConsecTer=$Consec;
	$Consec=LoadConsec("gxturnos", "Codigo_TRN", '0', $conexion, "Codigo_TRN");
	$SQL="Insert Into gxturnos(Codigo_TRN, Codigo_TER, Fecha_TRN, Codigo_EPS, Codigo_SDE, Codigo_ARE, Codigo_TPC, Codigo_TPR) Values (".$Consec.",'".$ConsecTer."', now(), '".$_POST['entidad']."', '".$_POST['sede']."', '".$_POST['area']."', '".$_POST['tipopcte']."', '".$_POST['proceso']."')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Control Turnos', 'Código Tercero '.$Consec);

include '99trnsctns.php';

?>