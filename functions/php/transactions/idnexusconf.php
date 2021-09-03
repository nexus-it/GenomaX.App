<?php

include '00trnsctns.php';

	$SQL="Delete From idconfig;";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into idconfig(MaxFinger_IDC, Umbral_IDC) Values ('".$_POST['maxfingerst']."', '".$_POST['umbralt']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From idtipomarcacion;";
	EjecutarSQL($SQL, $conexion);
	$contador=1; 
	while($contador <= 5) { 
		$SQL="Insert into idtipomarcacion(Codigo_MRC, Nombre_MRC, Tipo_MRC, Estado_MRC) Values ('".$_POST['codigo'.$contador]."', '".$_POST['descripcion'.$contador]."', '".$_POST['tipo'.$contador]."', '".$_POST['estado'.$contador]."')";
		EjecutarSQL($SQL, $conexion);
		$contador++;
	}

	it_aud('2', 'ID Config', 'Configuracion Parametros');

include '99trnsctns.php';

?>