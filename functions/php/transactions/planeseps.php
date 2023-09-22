<?php

include '00trnsctns.php';

	$SQL="Delete From gxplanes Where Codigo_PLA='".$_POST['codigo']."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into gxplanes(Codigo_PLA, Nombre_PLA, Estado_PLA) VALUES ('".$_POST['codigo']."','".$_POST['nombre']."','".$_POST['estado']."');";
	EjecutarSQL($SQL, $conexion);
	it_aud('2', 'Planes EPS', $_POST['codigo']);

include '99trnsctns.php';

?>