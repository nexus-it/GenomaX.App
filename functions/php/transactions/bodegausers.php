<?php

include '00trnsctns.php';

	$SQL="Delete from itusuariosbodegas Where Codigo_BDG='".$_POST["bodega"]."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['controwusr']) { 
		$contador++;
		$SQL="Insert into itusuariosbodegas(Codigo_BDG, Codigo_USR) Values('".$_POST['bodega']."', '".$_POST['codusr'.$contador]."');";
		EjecutarSQL($SQL, $conexion);
	}

	it_aud('2', 'Bodegas', 'Actualizacion Acceso de Usuarios - Bodega: '.$_POST["bodega"]);

include '99trnsctns.php';

?>