<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idpaciente'], $conexion, "ID_TER");
	$SQL="Delete From gxpacientes Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Expedicion_TER, Correo_TER, Codigot_DEP, Codigot_MUN, PersonaNatural_TER) Values ('".$Consec."', '".$_POST['idpaciente']."', '".$_POST['nombre1']." ".$_POST['nombre2']." ".$_POST['apellido1']." ".$_POST['apellido2']."', ".$_POST['tipoid'].", '".$_POST['Direccion']."', '".$_POST['Telefonos']."', '".$_POST['expedicion']."', '".$_POST['correo']."', '".$_POST['Departamento']."', '".$_POST['Municipio']."', '1')";
	// error_log($SQL);
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into gxpacientes(Codigo_TER, Nombre1_PAC, Nombre2_PAC, Apellido1_PAC, Apellido2_PAC, FechaNac_PAC, EstCivil_PAC, Codigo_SEX, Codigo_DEP, Codigo_MUN, Barrio_PAC, Codigo_ZNA, Madre_PAC, Padre_PAC, Codigo_REG, Codigo_TAF, Codigo_EPS, Codigo_PLA, Codigo_RNG, Empresa_PAC, Actividad_PAC, Estado_PAC, Parentesco_PAC) Values('".$Consec."', '".$_POST['nombre1']."', '".$_POST['nombre2']."', '".$_POST['apellido1']."', '".$_POST['apellido2']."', '".($_POST['fechanac'])."', '".$_POST['EstCivil']."', '".$_POST['Sexo']."', '".$_POST['Departamento']."', '".$_POST['Municipio']."', '".$_POST['Barrio']."', '".$_POST['zona']."', '".$_POST['Madre']."', '".$_POST['Padre']."', '".$_POST['TipoPaciente']."', '".$_POST['TipoAfiliado']."', '".$_POST['Contrato']."', '".$_POST['Plan']."', '".$_POST['Rango']."', '".$_POST['Empresa']."', '".$_POST['Actividad']."', '1', '".$_POST['email']."')";
	// error_log($SQL);
	EjecutarSQL($SQL, $conexion);
	$SQL="UPDATE gxpacientes a SET a.Nombre1_PAC=TRIM(a.Nombre1_PAC), a.Nombre2_PAC=TRIM(a.Nombre2_PAC), a.Apellido1_PAC=TRIM(a.Apellido1_PAC), a.Apellido2_PAC=TRIM(a.Apellido2_PAC) WHERE Codigo_TER='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Pacientes', 'Código Tercero '.$Consec);

include '99trnsctns.php';

?>