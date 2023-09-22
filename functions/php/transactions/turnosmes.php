<?php

include '00trnsctns.php';

	$NombrePlantilla="Mes-".$_POST['anyo']."-".$_POST['mes']."-".$_POST['areas']."-".$_POST['contrato'];
	$Consec=LoadConsec("czturnosenc", "Codigo_TUR", $NombrePlantilla, $conexion, "Nombre_TUR");
	$SQL="Delete from czturnosenc Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="INSERT INTO czturnosenc (Codigo_TUR, Nombre_TUR, Fecha_TUR, Observaciones_TUR, Codigo_USR) VALUES ('".$Consec."', '".$NombrePlantilla."', curdate(), '".$_POST['observaciones']."', '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from czturnosdet Where Codigo_TUR='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="SELECT distinct A.Codigo_TER FROM czempleados A, czterceros B, czareasterceros C WHERE A.Codigo_TER=B.Codigo_TER AND A.Codigo_TER=C.Codigo_TER AND C.Codigo_ARE='".$_POST['areas']."' AND Codigo_TCL='".$_POST['contrato']."' AND Estado_EMP='1';";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$NumDia=0;
		while (UltimoDia($_POST['anyo'], $_POST['mes'])> $NumDia) {
			$NumDia++;
			$SQL="INSERT INTO czturnosdet (Codigo_TRN, Codigo_TUR, Codigo_TER, Fecha_TUR) VALUES ('".$_POST['dia'.$NumDia.'_'.rtrim($row[0])]."', '".$Consec."', '".$row[0]."', '".$_POST['anyo']."-".$_POST['mes']."-".$NumDia."');";
			EjecutarSQL($SQL, $conexion);
		}
	}
	mysqli_free_result($result);

	it_aud('1', 'Turnos Mes', 'Codigo No. '.$Consec);

include '99trnsctns.php';

?>