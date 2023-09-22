<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czcargos", "Codigo_CRG", $_POST['codigo'], $conexion, "Codigo_CRG");
	$SQL="Replace into czcargos(Codigo_CRG, Nombre_CRG, Descripcion_CRG, Dependencia_CRG, Codigo_NVL, Codigo_ARE, Estado_CRG) Values ('".$Consec."', '".$_POST['nombre']."', '".$_POST['decripcion']."', '".$_POST['depende']."', '".$_POST['nivel']."', '".$_POST['area']."', '".$_POST['estado']."')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Cargos', 'Código No. '.$Consec);

include '99trnsctns.php';

?>