<?php

include '00trnsctns.php';

	$Consec=LoadConsec("klplanes", "Codigo_PLA", $_POST['plan'], $conexion, "Nombre_PLA");
	$SQL="Select count(*) from kldestinos;";
	$resultd = mysqli_query($conexion, $SQL);
	if($rowd = mysqli_fetch_row($resultd)) {
		$totalsv=$rowd[0];
	}
	mysqli_free_result($resultd);
	$SQL="Delete from klplanesdestinos where codigo_pla='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	for ($i = 1; $i <= $totalsv; $i++) {
		if ($_POST['paiz'.$i]=="1") {
			$SQL="Insert Into klplanesdestinos(Codigo_PLA, Codigo_DST) values('".$Consec."', '".$i."')";
			EjecutarSQL($SQL, $conexion);
		}
	}

	it_aud('1', 'Planes Destinos', 'Plan No. '.$Consec);

include '99trnsctns.php';

?>