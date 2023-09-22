<?php

include '00trnsctns.php';

	$SQL="Update gxcitasmedicas Set Confirma_CIT='1', FechaConf_CIT=now(), UsuarioConf_CIT='".$_SESSION["it_CodigoUSR"]."', Nota_CIT=UPPER('".$_POST['nota']."') Where Codigo_CIT='".$_POST['cita']."'";
	EjecutarSQL($SQL, $conexion);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha confirmado correctamente la cita. El profesional asignado podrá visualizar la llegada del paciente.';
		it_aud('2', 'Agenda Médica', 'Confirmación Cita '.$_POST['cita']);
	}

	

include '99trnsctns.php';

?>