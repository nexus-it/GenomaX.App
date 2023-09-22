<?php

include '00trnsctns.php';

	$Consec=LoadConsec("klplanes", "Codigo_PLA", $_POST['plan'], $conexion, "Nombre_PLA");
	$totalsv=365;
	for ($i = 1; $i <= $totalsv; $i++) {
		$ValDia=0;
		if ($_POST['dia'.$i]!="") {
			$ValDia=$_POST['dia'.$i];
		}
		$SQL="Select Hijos_PLA from klplanesprecios where Codigo_PLA='".$Consec."' and Dias_PLA=".$i.";";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$SQL="Update klplanesprecios set Hijos_PLA=".$ValDia." where Codigo_PLA='".$Consec."' and Dias_PLA=".$i.";";
		} else {
			$SQL="Insert Into klplanesprecios(Codigo_PLA, Dias_PLA, individual_PLA, Pareja_PLA, Hijos_PLA) values('".$Consec."', ".$i.", 0, 0, ".$ValDia.")";
		}
		mysqli_free_result($result);
		EjecutarSQL($SQL, $conexion);
	}

	it_aud('1', 'Modalidad Familia', 'No. '.$Consec);

include '99trnsctns.php';

?>