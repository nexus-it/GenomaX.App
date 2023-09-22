<?php

include '00trnsctns.php';

	$totalcitasdia=$_POST['contage'];
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST["agnd".$i]=="1") {
			$AgndAnt="0";
			$SQL="Select Codigo_AGE From gxagendacab Where Codigo_TER='".$_POST['prof2']."' and '".$_POST['fecha'.$i]."' between FechaIni_AGE  and FechaFin_AGE and Estado_AGE='1' and Codigo_ARE='".$_POST['area'.$i]."'";
			// error_log($SQL);
			$result = mysqli_query($conexion, $SQL);
			$Consec="0";
			if($row = mysqli_fetch_row($result)) {
				$AgndAnt=$row[0];
				$Consec=$AgndAnt;
			} 
			mysqli_free_result($result);
			if ($AgndAnt=="0") {
				$Consec=LoadConsec("gxagendacab", "Codigo_AGE", $_POST['codage'], $conexion, "Codigo_AGE");
				$AgndAnt=$Consec;
				$SQL="Insert into gxagendacab(Codigo_AGE, Codigo_TER, Codigo_ESP, Codigo_ARE, Codigo_CNS, Tiempo_AGE, FechaIni_AGE, FechaFin_AGE, FechaGraba_AGE, Codigo_USR, Estado_AGE) SELECT '".$Consec."', '".$_POST['prof2']."', a.Codigo_ESP, a.Codigo_ARE, a.Codigo_CNS, a.Tiempo_AGE, a.FechaIni_AGE, a.FechaFin_AGE, a.FechaGraba_AGE, a.Codigo_USR, a.Estado_AGE FROM gxagendacab a where Codigo_AGE='".$_POST['agenda'.$i]."';";
				// error_log($SQL);
				EjecutarSQL($SQL, $conexion);
			}
			$SQL="Delete from gxagendadet Where Codigo_AGE='".$Consec."' and Fecha_AGE='".$_POST['fecha'.$i]."' and Hora_AGE='".$_POST['hora'.$i]."'";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxagendadet Set Codigo_AGE='".$Consec."' Where Codigo_AGE='".$_POST['agenda'.$i]."' and Fecha_AGE='".$_POST['fecha'.$i]."' and Hora_AGE='".$_POST['hora'.$i]."'";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxcitasmedicas Set Codigo_AGE='".$Consec."' Where Codigo_CIT='".$_POST['cita'.$i]."';";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
		}

	}
	it_aud('1', 'Traslado Agenda', 'Profesionales: Origen '.$_POST['prof1'].' - Destino'.$_POST['prof2']);

include '99trnsctns.php';

?>