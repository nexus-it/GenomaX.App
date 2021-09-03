<?php

include '00trnsctns.php';

	$citaant=$_POST['cita'];
	$SQL="Update gxcitasmedicas Set Estado_CIT='X', Codigo_MTC='".$_POST['motivo']."', NotaCancela_CIT='".$_POST['nota']."' Where Codigo_CIT='".$citaant."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update gxagendadet Set Estado_AGE='0' where Codigo_AGE='".$_POST['theagenda']."' and Estado_AGE='1' and Fecha_AGE='".$_POST['fecha']."' and Hora_AGE='".substr($_POST['hora'],0,5)."';";
	EjecutarSQL($SQL, $conexion);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha cancelado correctamente la cita '.$_POST['cita'];
		it_aud('3', 'Agenda Médica', 'Cancelación de Cita '.$_POST['cita']);
	}



include '99trnsctns.php';

?>