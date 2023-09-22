<?php

include '00trnsctns.php';

	$SQL="Select * from gxcamas Where Codigo_CAM='".$_POST["codigo"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update gxcamas set Descripcion_CAM='".$_POST["descripcion"]."', Codigo_PBC='".$_POST["pabellon"]."', Nombre_CAM='".$_POST["nombre"]."', Codigo_ARE='".$_POST["area"]."', Ocupada_CAM='".$_POST["ocupada"]."' , Estado_CAM='".$_POST["estado"]."' Where Codigo_CAM='".$_POST["codigo"]."';";
	} else {
		$SQL="Insert Into gxcamas(Codigo_CAM, Descripcion_CAM, Codigo_PBC, Nombre_CAM, Codigo_ARE, Ocupada_CAM, Estado_CAM) Values('".$_POST["codigo"]."', '".$_POST["descripcion"]."', '".$_POST["pabellon"]."', '".$_POST["nombre"]."', '".$_POST["area"]."', '".$_POST["ocupada"]."', '".$_POST["estado"]."');";		
	}
	mysqli_free_result($result);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Camas', 'Cod: '.$_POST["codigo"].' - Desc: '.$_POST["descripcion"].' - Ocupada: '.$_POST["ocupada"].' - Estado: '.$_POST["estado"]);

include '99trnsctns.php';

?>