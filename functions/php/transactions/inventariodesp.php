<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czinvsalidascab", "Codigo_SAL","0", $conexion, "Codigo_SAL");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente el despacho a pacientes '.add_ceros($Consec,10);
	}
	$SQL="Insert into czinvsalidascab(Codigo_SAL, Codigo_CSA, Fecha_SAL, Observaciones_SAL, Codigo_SOL, Codigo_TER, Codigo_HCF, Estado_SAL, Codigo_USR) Values ('".$Consec."', '2', Now(),'".$_POST['nota']."', '".$_POST['solicitud']."', '".$_POST['codter']."', '".$_POST['foliohc']."', '1', '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['controwMed']) { 
		if (isset($_POST['codmed'.$contador])) {
			if ($_POST['cantdespmed'.$contador]>0) {
				$SQL="Insert Into czinvsalidasdet(Codigo_SAL, Codigo_BDG, Codigo_SER, Nota_SAL, Cantidad_SAL) Values ('".$Consec."', '".$_POST['bodega'.$contador]."','".$_POST['codmed'.$contador]."', '".$_POST['obsmed'.$contador]."', '".$_POST['cantdespmed'.$contador]."');";
				EjecutarSQL($SQL, $conexion);
				//SE ACTUALIZA LA SOLICITUD Y LA FORMULA MEDICA
				$SQL="Update hcordenesmedica Set Pendiente_HCM = Pendiente_HCM - ".$_POST['cantdespmed'.$contador]." Where Codigo_HCM='".$_POST['solicitud']."' and Codigo_SER='".$_POST['codmed'.$contador]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Update czinvsolfarmacia Set Pendiente_ISF = Pendiente_ISF - ".$_POST['cantdespmed'.$contador]." Where Codigo_ISF='".$_POST['solicitud']."' and Codigo_SER='".$_POST['codmed'.$contador]."';";
				EjecutarSQL($SQL, $conexion);
				//DESPACHAR AL INGRESO DEL PACIENTE
				$SQL="Select * from hcmedpacientes Where Codigo_ADM='".$_POST['admision']."' and Codigo_SER='".$_POST['codmed'.$contador]."'";
				$result = mysqli_query($conexion, $SQL);
				if ($row = mysqli_fetch_row($result)) {
					$SQL="Update hcmedpacientes Set Cantidad_HMP=Cantidad_HMP + ".$_POST['cantdespmed'.$contador].", Prescripcion_HMP= Prescripcion_HMP Where Codigo_ADM='".$_POST['admision']."' and Codigo_SER='".$_POST['codmed'.$contador]."'";
				} else {
					$SQL="Insert Into hcmedpacientes(Codigo_ADM, Codigo_SER, Prescripcion_HMP, Cantidad_HMP, Aplicado_HMP) Values ('".$_POST['admision']."','".$_POST['codmed'.$contador]."', '".$_POST['obsmed'.$contador]."', '".$_POST['cantdespmed'.$contador]."', 0);";
				}
				EjecutarSQL($SQL, $conexion);
				
			}
		}
		$contador++;
	}

	it_aud('1', 'Inventario', 'Salida No. '.$Consec);

include '99trnsctns.php';

?>