<?php

include '00trnsctns.php';

	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se agregó correctamente la nota aclaratoria al folio '.add_ceros($_POST['folio'],3);
	}
	$SQL="Insert into hcnotas(Nota_HCN, Fecha_HCN, Codigo_TER, Codigo_HCF) Values ('".$_POST['nota']."', '".$_POST['fechahora']."', '".$_POST['codigoter']."', '".$_POST['folio']."');";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Notas Aclaratorias', 'Tercero '.$_POST['codigoter'].' - Folio '.$_POST['folio']);

include '99trnsctns.php';

?>