<?php

include '00trnsctns.php';

	$SQL="Delete From czsalariosemp Where Codigo_TER='".$_POST["terceros"]."';";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['fechaini'.$contador])) {
			$SQL="Insert into czsalariosemp(Codigo_TER, Valor_SLR, FechaIni_SLR, FechaFin_SLR) Values ('".$_POST['terceros']."', '".$_POST['valorslr'.$contador]."', '".($_POST['fechaini'.$contador])."', '0000-00-00')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	$SQL="Select Valor_SLR, FechaIni_SLR From czsalariosemp Where Codigo_TER='".$_POST["terceros"]."' Order By FechaIni_SLR desc";
	$result = mysqli_query($conexion, $SQL);
	$FechaFin='0000-00-00';
	$contador=0; 
	while($row = mysqli_fetch_row($result)) {
		$contador++;
		if ($contador==1) {
			$SQL="Update czempleados set SalarioAct_EMP=".$row[0]." where Codigo_TER='".$_POST["terceros"]."';";
			EjecutarSQL($SQL, $conexion);
		}
		if ($contador==2) {
			$SQL="Update czempleados set SalarioAnt_EMP=".$row[0]." where Codigo_TER='".$_POST["terceros"]."';";
			EjecutarSQL($SQL, $conexion);
		}
		$SQL="Update czsalariosemp set FechaFin_SLR='".$FechaFin."' Where Codigo_TER='".$_POST["terceros"]."' and FechaIni_SLR='".$row[1]."';";
		EjecutarSQL($SQL, $conexion);
		$FechaFin=$row[1];
	}

	it_aud('1', 'Salarios Empleados', 'Tercero'.$_POST["terceros"]);

include '99trnsctns.php';

?>