<?php

include '00trnsctns.php';

	$SQL="Delete From czcargoemp Where Codigo_TER='".$_POST["terceros"]."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['fechaini'.$contador])) {
			$SQL="Insert into czcargoemp(Codigo_CRG, Codigo_TER, FechaIni_CRG, FechaFin_CRG) Values ('".$_POST['codcargo'.$contador]."', '".$_POST['terceros']."', '".($_POST['fechaini'.$contador])."', '0000-00-00')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	$SQL="Select Codigo_CRG, FechaIni_CRG From czcargoemp Where Codigo_TER='".$_POST["terceros"]."' Order By FechaIni_CRG desc";
	$result = mysqli_query($conexion, $SQL);
	$FechaFin='0000-00-00';
	$contador=0; 
	while($row = mysqli_fetch_row($result)) {
		$contador++;
		$SQL="Update czcargoemp set FechaFin_CRG='".$FechaFin."' Where Codigo_TER='".$_POST["terceros"]."' and FechaIni_CRG='".$row[1]."';";
		EjecutarSQL($SQL, $conexion);
		$FechaFin=$row[1];
	}

	it_aud('1', 'Cargos Empleados', 'Tercero'.$_POST["terceros"]);

include '99trnsctns.php';

?>