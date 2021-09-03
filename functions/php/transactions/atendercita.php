<?php

include '00trnsctns.php';

	$SQL="Update gxcitasmedicas Set Atiende_CIT='1', FechaAtiende_CIT=now() Where Codigo_CIT='".$_POST['cita']."'";
	EjecutarSQL($SQL, $conexion);

	it_aud('2', 'Agenda Médica', 'Atención de Cita '.$_POST['cita']);

include '99trnsctns.php';

?>