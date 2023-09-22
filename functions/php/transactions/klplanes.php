<?php

include '00trnsctns.php';

	$Consec=LoadConsec("klplanes", "Codigo_PLA", $_POST['plan'], $conexion, "Nombre_PLA");
	$SQL="Delete from klplanes where codigo_pla='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into klplanes(Codigo_PLA, Nombre_PLA, Descripcion_PLA, Estado_PLA) Values('".$Consec."', '".$_POST['plan']."', '".$_POST['descripcion']."', '".$_POST['estado']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from klplanescobertura where codigo_pla='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$totalsv=$_POST['controw'];
	$plaorder=0;
	for ($i = 1; $i <= $totalsv; $i++) {
		if (isset($_POST['cobertura'.$i])) {
			$plaorder++;
			$SQL="Insert Into klplanescobertura(Codigo_PLA, Orden_COB, Nombre_COB, Descripcion_COB, NombreEng_COB, DescripcionEng_COB) values('".$Consec."', '".$plaorder."', '".$_POST['cobertura'.$i]."', '".$_POST['descripcion'.$i]."', '".$_POST['coberturaeng'.$i]."', '".$_POST['descripcioneng'.$i]."')";
			//error_log('kld cobertura plan '.$_POST['plan'].' - '.$SQL);
			EjecutarSQL($SQL, $conexion);
		}
	}

	it_aud('1', 'Planes Klud', 'No. '.$Consec);

include '99trnsctns.php';

?>