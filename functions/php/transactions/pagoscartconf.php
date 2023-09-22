<?php

include '00trnsctns.php';

	$SQL="Update czpagosenc Set Estado_PGS='2' Where Codigo_PGS='".$_POST['pago']."'";
	EjecutarSQL($SQL, $conexion);
	
	$SQL="Select a.Codigo_FAC, a.Valor_PGS, b.Saldo_CAR From czpagosdet a, czcartera b Where a.Codigo_FAC=b.Codigo_FAC AND Codigo_PGS='".$_POST['pago']."';";
	$result = mysqli_query($conexion, $SQL);
	while ($row = mysqli_fetch_row($result)) {
		$SQL="Update czpagosdet Set Saldo1_PGS=".$row[2].", Saldo2_PGS=".$row[2]."-Valor_PGS Where Codigo_FAC='".$row[0]."' AND Codigo_PGS='".$_POST['pago']."';";
		EjecutarSQL($SQL, $conexion);
		$SQL="Update czcartera Set ValPagos_CAR=ValPagos_CAR+".$row[1].", Saldo_CAR=Saldo_CAR-".$row[1]." Where Codigo_FAC='".$row[0]."';";
		EjecutarSQL($SQL, $conexion);
	}
	mysqli_free_result($result);
	it_aud('2', 'Cartera', 'Confirmacion de Pago No. '.$_POST['pago']);

include '99trnsctns.php';

?>