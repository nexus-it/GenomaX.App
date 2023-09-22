<?php

include '00trnsctns.php';

	$SQL="Select * from czbodegas Where Codigo_BDG='".$_POST["codigo"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update czbodegas set Responsable_BDG='".$_POST["responsable"]."', Nombre_BDG='".$_POST["nombre"]."', Codigo_SDE='".$_POST["sede"]."', Inventario_BDG='".$_POST["inventario"]."' , Estado_BDG='".$_POST["estado"]."' Where Codigo_BDG='".$_POST["codigo"]."';";
	} else {
		$SQL="Insert Into czbodegas(Codigo_BDG, Responsable_BDG, Nombre_BDG, Codigo_SDE, Inventario_BDG, Estado_BDG) Values('".$_POST["codigo"]."', '".$_POST["responsable"]."', '".$_POST["nombre"]."', '".$_POST["sede"]."', '".$_POST["inventario"]."', '".$_POST["estado"]."');";		
	}
	mysqli_free_result($result);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Bodegas', 'Cod: '.$_POST["codigo"].' - Nombre: '.$_POST["nombre"].' - Estado: '.$_POST["estado"]);

include '99trnsctns.php';

?>