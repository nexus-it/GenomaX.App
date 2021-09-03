<?php

include '00trnsctns.php';

	$SQL="Select * from gxconsultorios Where Codigo_CNS='".$_POST["codigo"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update gxconsultorios set Nombre_CNS='".$_POST["nombre"]."', Descripcion_CNS='".$_POST["descripcion"]."', Codigo_ARE='".$_POST["area"]."', Triage_CNS='".$_POST["triage"]."', Urgencias_CNS='".$_POST["urgencia"]."' , Estado_CNS='".$_POST["estado"]."' Where Codigo_CNS='".$_POST["codigo"]."';";
	} else {
		$SQL="Insert Into gxconsultorios(Codigo_CNS, Nombre_CNS, Descripcion_CNS, Codigo_ARE, Triage_CNS, Urgencias_CNS, Estado_CNS) Values('".$_POST["codigo"]."', '".$_POST["nombre"]."', '".$_POST["descripcion"]."', '".$_POST["area"]."', '".$_POST["triage"]."', '".$_POST["urgencia"]."', '".$_POST["estado"]."');";		
	}
	error_log($SQL);
	mysqli_free_result($result);
	EjecutarSQL($SQL, $conexion);
	
	it_aud('1', 'Consultorios', 'Cod: '.$_POST["codigo"].' - Desc: '.$_POST["descripcion"].' - Nombre: '.$_POST["nombre"].' - Estado: '.$_POST["estado"]);

include '99trnsctns.php';

?>