<?php

include '00trnsctns.php';

	$Consec=LoadConsec("gxadmision", "Codigo_ADM", $_POST['Ingreso'], $conexion, "LPAD(Codigo_ADM,10,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente el ingreso '.add_ceros($Consec,10);
	}	
	$SQL="Select Codigo_TER, '' from czterceros where ID_TER= '".$_POST['paciente']."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Select Codigo_ADM from gxadmision where Codigo_ADM='".$Consec."';";
		$resultd = mysqli_query($conexion, $SQL);
		$FechaFin=$_POST['fecfin'];
		$FechaAutoriz=$_POST['fecautorizacion'];
		$FechaRem=$_POST['fecremision'];
		$FechaHosp=$_POST['fechahosp'];
		if ($FechaHosp=="") { $FechaHosp="0000-00-00"; }
		if ($FechaFin=="") { $FechaFin="0000-00-00"; }
		if ($FechaAutoriz=="") { $FechaAutoriz="0000-00-00"; }
		if ($FechaRem=="") { $FechaRem="0000-00-00"; }
		if($rowd = mysqli_fetch_row($resultd)) {
			$SQL="Update gxadmision Set Codigo_TER='".$row[0]."', Fecha_ADM='".($_POST['fechaadm'])." ".$_POST['horaadm']."', Codigo_EPS='".trim($_POST['Contrato'])."', Codigo_PLA='".trim($_POST['Plan'])."', Codigo_CXT='".$_POST['riesgo']."', Codigo_FNC='".$_POST['finconsulta']."', Ingreso_ADM='".$_POST['TipoIng']."', FechaHosp_ADM='".($FechaHosp)."', Codigo_CAM='".$_POST['cama']."', Codigo_DGN='".$_POST['diagnostico']."', ValorRemitido_ADM='".$_POST['remitido']."', Remision_ADM='".$_POST['remision']."', FechaRemision_ADM='".($FechaRem)."', IPS_ADM='".$_POST['ips']."', Motivo_ADM='".$_POST['motivo']."', Acudiente_ADM='".$_POST['acudiente']."', Direccion_ADM='".$_POST['direccion']."', Telefono_ADM='".$_POST['telefono']."', Autorizacion_ADM='".$_POST['autorizacion']."', FechaAutorizacion_ADM='".($FechaAutoriz)."', Observaciones_ADM='".$_POST['observacion']."', Codigo_USR='".$_SESSION["it_CodigoUSR"]."', UsuarioAnula_USR='', Estado_ADM='I', Copago_ADM='".$_POST['copago']."', Cuota_ADM='".$_POST['cuota']."', FechaFin_ADM='".($FechaFin)."', Codigo_SDE='".$_POST['sede']."', Codigo_PTT='".$_POST['tipopct']."', Codigo_CIT='".$_POST['citax']."'  Where Codigo_ADM='".$Consec."';";
			
			EjecutarSQL($SQL, $conexion);
			it_aud('2', 'Admisiones', 'Ingreso No.'.$Consec);
		} else {
			$SQL="Insert into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, ValorRemitido_ADM, Remision_ADM, FechaRemision_ADM, IPS_ADM, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Autorizacion_ADM, FechaAutorizacion_ADM, Observaciones_ADM, Codigo_USR, UsuarioAnula_USR, Estado_ADM, Copago_ADM, Cuota_ADM, FechaFin_ADM, Codigo_SDE, Codigo_PTT, Codigo_CIT) Values ('".$Consec."', '".$row[0]."', now(), '".trim($_POST['Contrato'])."', '".$_POST['Plan']."', '".$_POST['riesgo']."', '".$_POST['finconsulta']."', '".$_POST['TipoIng']."', '".($FechaHosp)."', '".$row[1]."', '".$_POST['diagnostico']."', '".$_POST['remitido']."', '".$_POST['remision']."', '".($FechaRem)."', '".$_POST['ips']."', '".$_POST['motivo']."', '".$_POST['acudiente']."', '".$_POST['direccion']."', '".$_POST['telefono']."', '".$_POST['autorizacion']."', '".($FechaAutoriz)."', '".$_POST['observacion']."', '".$_SESSION["it_CodigoUSR"]."', '', 'I', '".$_POST['copago']."', '".$_POST['cuota']."', '".($FechaFin)."', '".$_POST['sede']."', '".$_POST['tipopct']."', '".$_POST['citax']."')";
			
			EjecutarSQL($SQL, $conexion);
			it_aud('1', 'Admisiones', 'Ingreso No.'.$Consec);
		}
		$SQL="Replace into gxadmcovid19(Codigo_ADM, Codigo_CVD, Codigo_CVG, Estado_CVD) Values ('".$Consec."', '".($_POST['covid19'])."', '".($_POST['covid19gr'])."', ".($_POST['escovid']).");";
		
		EjecutarSQL($SQL, $conexion);
		if ($_POST['hosp']=="1") {
			$SQL="Replace into gxestancias(Codigo_ADM, Codigo_CAM, FechaIni_EST, Codigo_USR) Values ('".$Consec."', '".$_POST['cama']."', '".($_POST['fechahosp'])." ".$_POST['horaadm']."','".$_SESSION["it_CodigoUSR"]."')";
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxcamas Set Ocupada_CAM='1' Where Codigo_CAM='".$_POST['cama']."'";
			EjecutarSQL($SQL, $conexion);
		} 
		
		mysqli_free_result($resultd);
		/*
		$SQL="Delete from gxadmcovid19 where Codigo_ADM='".$Consec."';";
		
		EjecutarSQL($SQL, $conexion);
		*/
		
		
	}
	mysqli_free_result($result);

	

include '99trnsctns.php';

?>