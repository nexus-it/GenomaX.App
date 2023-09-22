<?php

include '00trnsctns.php';

	$totalcitasdia=$_POST['controwcitas'];
	for ($i = 1; $i <= $totalcitasdia; $i++) {
		if ($_POST['paciente'.$i]!="") {
			$SQL="Select count(*) From czterceros Where ID_TER='".$_POST['paciente'.$i]."'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Select Estado_AGE from gxagendadet where Codigo_AGE='".$_POST['agenda'.$i]."' and Fecha_AGE='".$_POST['fecha'.$i]."' and Hora_AGE='".$_POST['hora'.$i]."' and Estado_AGE='0'";
				$resultx = mysqli_query($conexion, $SQL);
				if($rowx = mysqli_fetch_row($resultx)) {
					$Consec=LoadConsec("gxcitasmedicas", "Codigo_CIT", "X", $conexion, "Codigo_CIT");
					$SQL="Insert Into gxcitasmedicas (Codigo_CIT, Codigo_AGE, Codigo_TER, Fecha_AGE, Hora_AGE, FechaDeseada_CIT, FechaGraba_CIT, Codigo_USR, Estado_CIT, TipoConsulta_CIT, Nota_CIT, Codigo_TAH) Select '".$Consec."', '".$_POST['agenda'.$i]."', a.Codigo_TER, '".$_POST['fecha'.$i]."', '".$_POST['hora'.$i]."', '".$_POST['fecha']."', curdate(), '".$_SESSION["it_CodigoUSR"]."', 'P', '".$_POST['primeravez']."', '".$_POST['nota']."', '".$_POST['tipoatencion']."' From czterceros a where a.ID_TER='".$_POST['paciente'.$i]."';";
					EjecutarSQL($SQL, $conexion);
					$SQL="Update gxagendadet Set Estado_AGE='1' where Codigo_AGE='".$_POST['agenda'.$i]."' and Fecha_AGE='".$_POST['fecha'.$i]."' and Hora_AGE='".$_POST['hora'.$i]."' and Estado_AGE='0';";
					EjecutarSQL($SQL, $conexion);
					if ($MSG=='Datos registrados correctamente. ') {
						$MSG='Se ha programado correctamente la cita '.$Consec;
						it_aud('1', 'Agenda Médica', 'Asignación Cita '.$Consec);
					}
				} else {
					$MSG='El cupo ya fue asignado con anterioridad. Asigne un nuevo horario al paciente.';
				}
			}
			mysqli_free_result($result);
		}
	}

	

include '99trnsctns.php';

?>