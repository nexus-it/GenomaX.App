<?php

include '00trnsctns.php';
	
	$SQL="Delete from lbexamitems where Codigo_EXA='".$_POST['examen1']."';";
	EjecutarSQL($SQL, $conexion);
	$totaItems=$_POST['contaItems'];
	for ($i = 1; $i <= $totaItems; $i++) {
		$SQL="Insert Into lbexamitems(Codigo_EXA, Codigo_ITL, Resultados_EXA) Values ('".$_POST['examen'.$i]."', '".$_POST['examitem'.$i]."', '".$_POST['result'.$i]."');";
		EjecutarSQL($SQL, $conexion);
	}

	it_aud('1', 'Exámenes Dx', 'Exámen No. '.$_POST['examen1']);

include '99trnsctns.php';

?>