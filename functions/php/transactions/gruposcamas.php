<?php

include '00trnsctns.php';

	$SQL="Select * from gxgrupocamas Where Codigo_GRC='".$_POST["codigo"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update gxgrupocamas set Descripcion_GRC='".$_POST["descripcion"]."'  Where Codigo_GRC='".$_POST["codigo"]."';";
	} else {
		$SQL="Insert Into gxgrupocamas(Codigo_GRC, Descripcion_GRC) Values('".$_POST["codigo"]."', '".$_POST["descripcion"]."');";		
	}
	mysqli_free_result($result);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Grupos Camas', 'Cod: '.$_POST["codigo"].' - Desc: '.$_POST["descripcion"]);

include '99trnsctns.php';

?>