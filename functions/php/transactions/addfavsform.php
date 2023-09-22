<?php

include '00trnsctns.php';

	$SQL="Select Contador_FAV from itfavoritos Where Codigo_ITM='".$_POST['item']."' and Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update itfavoritos Set Contador_FAV=Contador_FAV+1 Where Codigo_ITM='".$_POST['item']."' and Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	} else {
		$SQL="Insert Into itfavoritos(Codigo_ITM, Codigo_USR, Contador_FAV) Values('".$_POST['item']."', '".$_SESSION["it_CodigoUSR"]."', 1)";
	}
	EjecutarSQL($SQL, $conexion);

	//it_aud('1', 'Caja', 'Cierre Caja No. '.$_POST['idcaja']);

include '99trnsctns.php';

?>