<?php

include '00trnsctns.php';

	$SQL="Update czterceros Set ID_Ter='".$_POST['idreal']."', IDAnterior_TER='".$_POST['paciente']."' Where ID_Ter='".$_POST['paciente']."'";
	EjecutarSQL($SQL, $conexion);
	it_aud('2', 'Tercero ID', 'Anterior: '.$_POST['paciente'].' - Actual: '.$_POST['idreal']);

include '99trnsctns.php';

?>