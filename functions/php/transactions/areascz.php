<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czareas", "Codigo_ARE", $_POST['codigo'], $conexion, "Codigo_ARE");
	$SQL="Select a.Codigo_TER From czterceros a, czempleados b Where a.Codigo_TER=b.Codigo_TER and ID_TER='".trim($_POST['idempleado'])."'";
	$result = mysqli_query($conexion, $SQL);
	$CodigoTER='0';
	while($row = mysqli_fetch_row($result)) {
		$CodigoTER=$row[0];
	}
	mysqli_free_result($result);
	$SQL="Select Codigo_ARE From czareas Where Codigo_ARE='".$Consec."'";
	$resultz = mysqli_query($conexion, $SQL);
	if($rowz = mysqli_fetch_row($resultz)) {
		$SQL="Update czareas Set Nombre_ARE='".$_POST['nombre']."', Codigo_CCT='".trim($_POST['cc'])."', Codigo_TER='".$CodigoTER."', Estado_ARE='".trim($_POST['estado'])."' Where Codigo_ARE='".$Consec."'";
	}
	else{
		$SQL="Insert into czareas(Codigo_ARE, Nombre_ARE, Codigo_CCT, Codigo_TER, Estado_ARE) Values ('".$Consec."', '".$_POST['nombre']."', '".trim($_POST['cc'])."', '".$CodigoTER."', '".trim($_POST['estado'])."')";
	}
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czareasterceros Where Codigo_ARE='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['contro']) { 
		$contador++;
		if (isset($_POST['codemple'.$contador])) {
			$SQL="Insert into czareasterceros(Codigo_TER, Codigo_ARE ) Select Codigo_TER, '".$Consec."' From czempleados Where ID_EMP='".$_POST['codemple'.$contador]."'";
			EjecutarSQL($SQL, $conexion);
		}
	}

	it_aud('1', 'Areas', 'Código No. '.$Consec);

include '99trnsctns.php';

?>