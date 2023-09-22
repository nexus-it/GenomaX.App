<?php
 
include '00trnsctns.php';

	$contador=0; 
	$kontador=0;
	$TotalFilas=$_POST['contfila'];
	while($contador <= $TotalFilas) { 
		$contador++;
		$MSG=$_POST['ingreso'.$contador];
		if ($_POST['facturar'.$contador]=="1") {
			$Consec=LoadConsecFact($conexion, $_POST['sede']);
			$kontador++;
			$MSG='Se han generado correctamente las facturas '.$Consec;
			 
			$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Codigo_ADM, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC, ValTotal_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Month_FAC, Year_FAC) Values ('".$_POST['sede']."','".$Consec."', '".$_POST['ingreso'.$contador]."', '".$_POST['fechafac'].' '.date("H:i:s")."', '".$_POST['valorPte'.$contador]."',  '".$_POST["valorEnt".$contador]."',  '".$_POST["valorEnt".$contador]."', '".$_POST["Contrato"]."', '".$_POST["Plan"]."', '".$_SESSION["it_CodigoUSR"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."')";
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxadmision Set Estado_ADM='F' Where LPAD(Codigo_ADM,10,'0')=LPAD('".$_POST['ingreso'.$contador]."',10,'0');";
			EjecutarSQL($SQL, $conexion);

			if ($_POST["reingreso"]=="1") { //Si se realiza reingreso
				$ConsecA=LoadConsec("gxadmision", "Codigo_ADM", "0000000000", $conexion, "LPAD(Codigo_ADM,10,'0')");
				$SQL="Insert Into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, Observaciones_ADM, Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, Codigo_USR) Select ".$ConsecA.", Codigo_TER, now(), Codigo_EPS, Codigo_PLA,Codigo_CXT, Codigo_FNC, Ingreso_ADM, curdate(), Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, '', Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, '".$_SESSION["it_CodigoUSR"]."' from gxadmision x Where x.Estado_ADM='F' and x.Codigo_ADM='".(int)$_POST['ingreso'.$contador]."'";
				EjecutarSQL($SQL, $conexion);
				
				it_aud('1', 'Admisiones', 'Reingreso '.$Consec);
			}
/*
			$SQL="Insert into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR, Estado_CAR) Values('".$_POST['sede']."', '".$Consec."', '".$_POST["valorEnt".$contador]."', '".$_POST["valorEnt".$contador]."','1')";
			EjecutarSQL($SQL, $conexion);
*/
			$SQL="Select a.Codigo_ORD, a.Codigo_SER,  d.Valor_TAR From gxordenesdet a, gxordenescab b, gxadmision c, gxmanualestarifarios d, gxcontratos e Where a.Codigo_ORD=b.Codigo_ORD and c.Codigo_ADM=b.Codigo_ADM and b.Fecha_ORD between d.FechaIni_TAR and d.FechaFin_TAR and d.Codigo_SER=a.Codigo_SER and e.Codigo_EPS=a.Codigo_EPS and e.Codigo_PLA=a.Codigo_PLA and e.Codigo_TAR=d.Codigo_TAR and b.Estado_ORD<>'0' and c.Codigo_ADM='".$_POST['ingreso'.$contador]."'";
			$resulty = mysqli_query($conexion, $SQL);
			while($rowy = mysqli_fetch_row($resulty)) {

				//Antes de esto, verificar si la tarifa es soat o es iss, para realizar bien el redondeo	
			
				$SQL="Update gxordenesdet Set ValorPaciente_ORD=ROUND(0),  ValorEntidad_ORD=ROUND(".$rowy[2]."), ValorServicio_ORD=ROUND(".$rowy[2].") Where Codigo_ORD='".$rowy[0]."' and Codigo_SER='".$rowy[1]."'";
				EjecutarSQL($SQL, $conexion);
			}
			mysqli_free_result($resulty);

			it_aud('1', 'Factura Salud', 'Factura No. '.$Consec.' (FacturaLote)');
		}
	} 	
$MSG=$kontador." de ".$contador;
		

include '99trnsctns.php';

?>