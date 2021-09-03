<?php

include '00trnsctns.php';

	$Consec=LoadConsec("gxegresos", "Codigo_EGR", $_POST['Egreso'], $conexion, "LPAD(Codigo_EGR,10,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente el egreso '.add_ceros($Consec,10);
	}
	
	$SQL="Select Codigo_CAM from gxestancias where Codigo_ADM= '".$_POST['Ingresoh']."' and estado_Est='1'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update gxcamas Set Ocupada_CAM='0' Where Codigo_CAM='".$row[0]."'";
		EjecutarSQL($SQL, $conexion);
		$SQL="Update gxestancias Set FechaFin_EST='".($_POST['fechaegr'])." ".$_POST['horaegr']."' Where Codigo_CAM='".$row[0]."' and Codigo_ADM= '".$_POST['Ingresoh']."' AND FechaFin_EST='0000-00-00 00:00:00' and estado_Est='1'";
		EjecutarSQL($SQL, $conexion);
	}
	mysqli_free_result($result);
	$SQL="Replace into gxegresos(Codigo_EGR, Codigo_ADM, Codigo_EPC, Embarazo_EGR, Fecha_EGR, EstadoPaciente_EGR, FechaNac_EGR, EstNacido_EGR, Estado_EGR) Values ('".$Consec."', '".$_POST['Ingresoh']."', '".$_POST['epicrisis']."', '".$_POST['embarazo']."', '".($_POST['fechaegr'])." ".$_POST['horaegr']."', '".$_POST['estadopac']."', '".($_POST['fechanac'])." 00:00:00', '".$_POST['estadonac']."', '1')";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Egreso', 'Código No.'.$Consec);

include '99trnsctns.php';

?>