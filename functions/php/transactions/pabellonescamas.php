<?php

include '00trnsctns.php';

	$SQL="Select * from gxpabelloncamas Where Codigo_PBC='".$_POST["codigo"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update gxpabelloncamas set Descripcion_PBC='".$_POST["descripcion"]."', Codigo_GRC='".$_POST["grupo"]."'  Where Codigo_PBC='".$_POST["codigo"]."';";
	} else {
		$SQL="Insert Into gxpabelloncamas(Codigo_PBC, Descripcion_PBC, Codigo_GRC) Values('".$_POST["codigo"]."', '".$_POST["descripcion"]."', '".$_POST["grupo"]."');";		
	}
	mysqli_free_result($result);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Pabellon Camas', 'Cod: '.$_POST["codigo"].' - Desc: '.$_POST["descripcion"]);

include '99trnsctns.php';

?>