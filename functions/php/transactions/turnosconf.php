<?php

include '00trnsctns.php';

	$SQL="Delete From cztipoturnos Where Codigo_TRN='".$_POST["codigo"]."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert Into cztipoturnos(Codigo_TRN, Estado_TRN, Nombre_TRN, Inicia_TRN, Termina_TRN, TotalHoras_TRN, descanso_TRN) Values('".$_POST["codigo"]."', '".$_POST["estado"]."', '".$_POST["nombre"]."', '".$_POST["horaini"]."', '".$_POST["horafin"]."', ".$_POST["horas"].", ".$_POST["descanso"].")";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Tipo de Turnos', 'Código No. '.$_POST["codigo"]);

include '99trnsctns.php';

?>