<?php

include '00trnsctns.php';

	$AgndAnt="0";
	$SQL="Select Codigo_AGE From gxagendacab Where Codigo_TER='".$_POST['tercero']."' and FechaIni_AGE = '".$_POST['fechalun']."' and FechaFin_AGE='".$_POST['fechasab']."' and Estado_AGE='1' and Codigo_ARE='".$_POST['area']."'";
	$result = mysqli_query($conexion, $SQL);
	$Consec="0";
	if($row = mysqli_fetch_row($result)) {
		$AgndAnt=$row[0];
		$Consec=$AgndAnt;
	} 
	mysqli_free_result($result);
	// $Consec=LoadConsec("gxagendacab", "Codigo_AGE", $_POST['codage'], $conexion, "Codigo_AGE");
	// $SQL="Update gxagendacab Set Codigo_AGE='0' Where Codigo_TER='".$_POST['tercero']."' and FechaIni_AGE = '".$_POST['fechalun']."' and FechaFin_AGE='".$_POST['fechasab']."' and Codigo_ARE='".$_POST['area']."';";
	// EjecutarSQL($SQL, $conexion);
	// Si no existe el consecutivo de agenda, creo la nueva
	if ($Consec=="0") {
		$Consec=LoadConsec("gxagendacab", "Codigo_AGE", $_POST['codage'], $conexion, "Codigo_AGE");
		$SQL="Insert into gxagendacab(Codigo_AGE, Codigo_TER, Codigo_ESP, Codigo_ARE, Codigo_CNS, Tiempo_AGE, FechaIni_AGE, FechaFin_AGE, FechaGraba_AGE, Codigo_USR, Estado_AGE) VALUES ('".$Consec."', '".$_POST['tercero']."','".$_POST['especialidad']."','".$_POST['area']."','".$_POST['consultorio']."','".$_POST['minutos']."','".$_POST['fechalun']."','".$_POST['fechasab']."', curdate(), '".$_SESSION["it_CodigoUSR"]."', '1');";
		EjecutarSQL($SQL, $conexion);
	}
	//Si existen programaciones anteriormente con estas fechas, se actualizan
	$totalcitasdia=$_POST['controwlun'];
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['lun'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechalun']."','".$_POST['luntime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['mar'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechamar']."','".$_POST['martime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
			
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['mie'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechamie']."','".$_POST['mietime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['jue'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechajue']."','".$_POST['juetime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['vie'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechavie']."','".$_POST['vietime'.$i]."','0');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['sab'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechasab']."','".$_POST['sabtime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	it_aud('1', 'Agenda Médica', 'Creación de agenda médica No.'.$Consec);


$FecIniX=date("d-m-Y",strtotime($_POST['fechasab']."+ 2 days"));
$FecFinX=date("d-m-Y",strtotime($_POST['fechasab']."+ 8 days"));
error_log($_POST['fechalun'].' => '.$_POST['fechasab']);
error_log($FecIniX.' => '.$FecFinX);
error_log($_POST["fext"]);
while ($_POST['fechasab']<$_POST['fext']) {

		$AgndAnt="0";
	$SQL="Select Codigo_AGE From gxagendacab Where Codigo_TER='".$_POST['tercero']."' and FechaIni_AGE = '".$_POST['fechalun']."' and FechaFin_AGE='".$_POST['fechasab']."' and Estado_AGE='1' and Codigo_ARE='".$_POST['area']."'";
	$result = mysqli_query($conexion, $SQL);
	$Consec="0";
	if($row = mysqli_fetch_row($result)) {
		$AgndAnt=$row[0];
		$Consec=$AgndAnt;
	} 
	mysqli_free_result($result);
	// $Consec=LoadConsec("gxagendacab", "Codigo_AGE", $_POST['codage'], $conexion, "Codigo_AGE");
	// $SQL="Update gxagendacab Set Codigo_AGE='0' Where Codigo_TER='".$_POST['tercero']."' and FechaIni_AGE = '".$_POST['fechalun']."' and FechaFin_AGE='".$_POST['fechasab']."' and Codigo_ARE='".$_POST['area']."';";
	// EjecutarSQL($SQL, $conexion);
	// Si no existe el consecutivo de agenda, creo la nueva
	if ($Consec=="0") {
		$Consec=LoadConsec("gxagendacab", "Codigo_AGE", $_POST['codage'], $conexion, "Codigo_AGE");
		$SQL="Insert into gxagendacab(Codigo_AGE, Codigo_TER, Codigo_ESP, Codigo_ARE, Codigo_CNS, Tiempo_AGE, FechaIni_AGE, FechaFin_AGE, FechaGraba_AGE, Codigo_USR, Estado_AGE) VALUES ('".$Consec."', '".$_POST['tercero']."','".$_POST['especialidad']."','".$_POST['area']."','".$_POST['consultorio']."','".$_POST['minutos']."','".$_POST['fechalun']."','".$_POST['fechasab']."', curdate(), '".$_SESSION["it_CodigoUSR"]."', '1');";
		EjecutarSQL($SQL, $conexion);
	}
	//Si existen programaciones anteriormente con estas fechas, se actualizan
	$totalcitasdia=$_POST['controwlun'];
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['lun'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechalun']."','".$_POST['luntime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechalun']."' and Hora_AGE='".$_POST['luntime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['mar'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechamar']."','".$_POST['martime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
			
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechamar']."' and Hora_AGE='".$_POST['martime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['mie'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechamie']."','".$_POST['mietime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechamie']."' and Hora_AGE='".$_POST['mietime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['jue'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechajue']."','".$_POST['juetime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechajue']."' and Hora_AGE='".$_POST['juetime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['vie'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechavie']."','".$_POST['vietime'.$i]."','0');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechavie']."' and Hora_AGE='".$_POST['vietime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['sab'.$i.'chk']=="1") {
			$StateAgnd="0";
			$SQL="Select Codigo_CIT From gxcitasmedicas Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_CIT='P'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$AgndAnt."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_CIT='P'";
				EjecutarSQL($SQL, $conexion);
				$StateAgnd="1";
			}
			mysqli_free_result($result);
			$SQL="Insert into gxagendadet(Codigo_AGE, Fecha_AGE, Hora_AGE, Estado_AGE) VALUES ('".$Consec."', '".$_POST['fechasab']."','".$_POST['sabtime'.$i]."','".$StateAgnd."');";
			EjecutarSQL($SQL, $conexion);
		} else {
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fechasab']."' and Hora_AGE='".$_POST['sabtime'.$i]."' and Estado_AGE='0';";
			EjecutarSQL($SQL, $conexion);
		}
	}
	it_aud('1', 'Agenda Médica', 'Creación de agenda médica No.'.$Consec);

}

include '99trnsctns.php';

?>