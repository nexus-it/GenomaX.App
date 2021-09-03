<?php

include '00trnsctns.php';
	$MSG="Datos Ingresados.";
	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idempleado'], $conexion, "ID_TER");
	$SQL="Select * From czterceros Where Codigo_TER='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	// TERCEROS
	if ($row = mysqli_fetch_row($result)) {
		$SQL="Update czterceros set Nombre_TER='".trim($_POST['nombre1'])." ".trim($_POST['nombre2'])." ".trim($_POST['apellido1'])." ".trim($_POST['apellido2'])."', Direccion_TER='".$_POST['Direccion']."', Telefono_TER='".$_POST['Telefonos']."', Correo_TER='".$_POST['Mail']."' Where Codigo_TER='".$Consec."';";
		EjecutarSQL($SQL, $conexion);		
	} else {
		$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER) Values ('".$Consec."', '".$_POST['idempleado']."', '".trim($_POST['nombre1'])." ".trim($_POST['nombre2'])." ".trim($_POST['apellido1'])." ".trim($_POST['apellido2'])."', ".$_POST['tipoid'].", '".$_POST['Direccion']."', '".$_POST['Telefonos']."','".$_POST['email']."')";
		EjecutarSQL($SQL, $conexion);
	}
	$SQL="Select * From czempleados Where Codigo_TER='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	// EMPLEADOS
	if ($row = mysqli_fetch_row($result)) {
		$SQL="Update czempleados set Nombre1_EMP='".trim($_POST['nombre1'])."', Nombre2_EMP='".trim($_POST['nombre2'])."', Apellido1_EMP='".trim($_POST['apellido1'])."', Apellido2_EMP='".trim($_POST['apellido2'])."', FechaNac_EMP='".($_POST['fechanac'])."', Codigo_SEX='".$_POST['Sexo']."' Where Codigo_TER='".$Consec."'";
		EjecutarSQL($SQL, $conexion);
	} else {
		$SQL="Insert into czempleados(Codigo_TER, ID_EMP, Nombre1_EMP, Nombre2_EMP, Apellido1_EMP, Apellido2_EMP, FechaNac_EMP, EstCivil_EMP, Codigo_SEX, Codigo_DEP, Codigo_MUN, Barrio_EMP,  Estado_EMP, Codigo_TCL, SalarioAct_EMP, FechaIng_EMP, Observaciones_EMP, FechaRet_EMP, Codigo_CRG, Codigo_SDE) Values('".$Consec."', '".$_POST['id']."', '".trim($_POST['nombre1'])."', '".trim($_POST['nombre2'])."', '".trim($_POST['apellido1'])."', '".trim($_POST['apellido2'])."', '".($_POST['fechanac'])."', '', '".$_POST['Sexo']."', '08', '001', '--', '1', '01', 0, '0000-00-00', '', '0000-00-00', '0', '0')";
		EjecutarSQL($SQL, $conexion);
	}
	// USUARIOS
	$ConsecTer=$Consec;
	$Consec=LoadConsec("itusuarios", "Codigo_USR", $_POST['usuario'], $conexion, "ID_USR");
	$SQL="Select * From itusuarios Where Codigo_USR='".$Consec."'";
	$result = mysqli_query($conexion, $SQL);
	$NewUsr='0';
	if ($row = mysqli_fetch_row($result)) {
		$SQL="Update itusuarios Set ID_USR='".$_POST['usuario']."', Nombre_USR='".trim($_POST['nommedico'])."', Codigo_PRF='".$_POST['perfil']."', Email_USR='".$_POST['Mail']."', Activo_USR='1'	Where Codigo_USR='".$Consec."'";
	} else {
		$SQL="Insert into itusuarios(Codigo_USR, ID_USR, Nombre_USR, Codigo_PRF, Email_USR, FechaCreacion_USR, Activo_USR) Values ('".$Consec."', '".$_POST['usuario']."', '".trim($_POST['nommedico'])."', '".$_POST['perfil']."', '".$_POST['mail']."', curdate(), '1')";
		$NewUsr='1';
	}
	EjecutarSQL($SQL, $conexion);
	// CLAVE
	if ($NewUsr=='1') {
		if (isset($_POST["pass"])) {
			if ($_POST["pass"]!="") {
				if ($_POST['defaultpass']) {
					$SQL="Select PassDefault_DCD from itconfig";
					$resultxz = mysqli_query($conexion, $SQL);
					if ($rowxz = mysqli_fetch_row($resultxz)) {
						$SQL="Update itusuarios set Clave_USR='".rtrim($rowxz[0])."' where Codigo_USR= '".$Consec."' and Activo_USR='1'";
					}
				} else {
					$SQL="Update itusuarios set Clave_USR=SHA1('".rtrim($_POST["pass"])."') where Codigo_USR= '".$Consec."' and Activo_USR='1'";
				}
				EjecutarSQL($SQL, $conexion);
			}
		}
	}
	// MEDICOS
	$SQL="Delete From gxmedicos Where Codigo_TER='".$ConsecTer."'";
	$SQL="Select * From gxmedicos Where Codigo_TER='".$ConsecTer."'";
	$result = mysqli_query($conexion, $SQL);
	// TERCEROS
	if ($row = mysqli_fetch_row($result)) {
		$SQL="Update gxmedicos set RM_MED='".$_POST['tp']."', Nombre1_MED='".trim($_POST['nombre1'])."', Nombre2_MED='".trim($_POST['nombre2'])."', Apellido1_MED='".trim($_POST['apellido1'])."', Apellido2_MED='".trim($_POST['apellido2'])."', Codigo_USR='".$Consec."' Where Codigo_TER='".$ConsecTer."';";
	} else {
		$SQL="Insert into gxmedicos(Codigo_TER, RM_MED, Nombre1_MED, Nombre2_MED, Apellido1_MED, Apellido2_MED, Codigo_USR) Values('".$ConsecTer."', '".$_POST['tp']."', '".trim($_POST['nombre1'])."','".trim($_POST['nombre2'])."', '".trim($_POST['apellido1'])."', '".trim($_POST['apellido2'])."','".$Consec."' )";
	}
	EjecutarSQL($SQL, $conexion);
	// ESPECIALIDADES
	$SQL="Delete From gxmedicosesp Where Codigo_TER='".$ConsecTer."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into gxmedicosesp(Codigo_TER, Codigo_ESP, Tipo_ESP) Values('".$ConsecTer."', '".$_POST['espe1']."', '1')";
	EjecutarSQL($SQL, $conexion);
	if ($_POST['espe2']!="XXX") {
		$SQL="Insert into gxmedicosesp(Codigo_TER, Codigo_ESP, Tipo_ESP) Values('".$ConsecTer."', '".$_POST['espe2']."', '2')";
		EjecutarSQL($SQL, $conexion);
	}
	if ($_POST['espe3']!="XXX") {
		$SQL="Insert into gxmedicosesp(Codigo_TER, Codigo_ESP, Tipo_ESP) Values('".$ConsecTer."', '".$_POST['espe3']."', '3')";
		EjecutarSQL($SQL, $conexion);
	}
	// ACCESO FORMATOS HC
	$SQL="Delete From hcusuarioshc Where Codigo_USR='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into hcusuarioshc(Codigo_USR, Codigo_HCT) Select '".$Consec."', Codigo_HCT From hctipos where Codigo_HCT in (".$_POST["formatoshc"].")";
	EjecutarSQL($SQL, $conexion);
	// ACCESO AREAS
	$SQL="Delete From itusuariosareas Where Codigo_USR='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into itusuariosareas(Codigo_USR, Codigo_ARE) Select '".$Consec."', Codigo_ARE From gxareas where Codigo_ARE in (".$_POST["accesosareas"].")";
	EjecutarSQL($SQL, $conexion);
	//FIRMA JPG
	$imgtemp='../../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/'.session_id().'.jpg';
	// Si existe archivo temporal
	if(is_file($imgtemp)) {
		/*
		$urly= explode('functions/php/transactions/medicos.php', $_SERVER['REQUEST_URI'], 2);
		$urljpg='http://'.$_SERVER["SERVER_NAME"] .$urly[0].'files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/'.session_id().'.jpg';
		$image = imagecreatefromjpeg($urljpg);
		ob_start();
		imagejpeg($image);
		$jpg = ob_get_contents();
		ob_end_clean();
		$jpg = str_replace('##','##',mysqli_escape_string($jpg));
		*/
		$jpg=mysqli_real_escape_string($conexion,file_get_contents($imgtemp));
		$SQL="Update gxmedicos Set Firma_MED='".$jpg."' Where Codigo_TER='".$ConsecTer."'";
		EjecutarSQL($SQL, $conexion);
	}
	it_aud('1', 'Médicos', 'Usuario No. '.$Consec);

include '99trnsctns.php';

?>