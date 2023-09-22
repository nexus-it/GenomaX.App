<?php

include '00trnsctns.php';

	$citaant=$_POST['cita'];
	$SQL="Update gxcitasmedicas Set Estado_CIT='R', NotaCancela_CIT='".$_POST['notarep']."' Where Codigo_CIT='".$citaant."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update gxagendadet Set Estado_AGE='0' where Codigo_AGE='".$_POST['theagenda']."' and Estado_AGE='1' and Fecha_AGE='".$_POST['fecha']."' and Hora_AGE='".$_POST['hora']."';";
	$SQL="Update gxagendadet a, gxcitasmedicas b Set Estado_AGE='0' WHERE a.Codigo_AGE=b.Codigo_AGE and Estado_AGE='1' AND a.Fecha_AGE=b.Fecha_AGE AND a.Hora_AGE=b.Hora_AGE AND b.Codigo_CIT='".$citaant."'";
	EjecutarSQL($SQL, $conexion);
	$totalcitasdia=$_POST['controwcitas'];
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['paciente'.$i]!="") {
			$SQL="Select count(*) From czterceros Where ID_TER='".$_POST['paciente'.$i]."'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$Consec=LoadConsec("gxcitasmedicas", "Codigo_CIT", "X", $conexion, "Codigo_CIT");
				$SQL="Insert Into gxcitasmedicas (Codigo_CIT, Codigo_AGE, Codigo_TER, Fecha_AGE, Hora_AGE, FechaDeseada_CIT, FechaGraba_CIT, Codigo_USR, Estado_CIT, Nota_CIT) Select '".$Consec."', '".$_POST['agenda'.$i]."', a.Codigo_TER, '".$_POST['fecha'.$i]."', '".$_POST['hora'.$i]."', '".$_POST['fecha']."', curdate(), '".$_SESSION["it_CodigoUSR"]."', 'P', '".$_POST['notica']."' From czterceros a where a.ID_TER='".$_POST['paciente'.$i]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Update gxagendadet Set Estado_AGE='1' where Codigo_AGE='".$_POST['agenda'.$i]."' and Fecha_AGE='".$_POST['fecha'.$i]."' and Hora_AGE='".$_POST['hora'.$i]."' and Estado_AGE='0';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Insert Into gxcitasreprogramadas(CodigoAnt_CXR, CodigoAct_CXR) Values('".$citaant."', '".$Consec."')";
				EjecutarSQL($SQL, $conexion);
				if ($MSG=='Datos registrados correctamente. ') {
					$MSG='Se ha reprogramado correctamente la cita '.$Consec;
					it_aud('2', 'Agenda Médica', 'Reprogramación de Cita '.$citaant.'. Nueva cita: '.$Consec);
				}
			} 
			mysqli_free_result($result);
		}
	}

include '99trnsctns.php';

?>