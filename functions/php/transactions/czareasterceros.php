<?php

include '00trnsctns.php';

	$SQL="Delete From czareasterceros Where Codigo_TER='".$_POST["terceros"]."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['codarea'.$contador])) {
			$SQL="Insert into czareasterceros(Codigo_ARE, Codigo_TER) Values ('".$_POST['codarea'.$contador]."', '".$_POST['terceros']."')";
			EjecutarSQL($SQL, $conexion);
		}
	}

	it_aud('1', 'Areas Terceros', 'Tercero'.$_POST["terceros"]);

include '99trnsctns.php';

?>