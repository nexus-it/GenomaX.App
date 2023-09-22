<?php

session_start();
include '00trnsctns.php';

	$Consec=LoadConsecFact($conexion, $_POST['sede']);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha generado correctamente la factura '.($Consec);
	}
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);

	$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Codigo_ADM, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC, ValTotal_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Nota_FAC, Month_FAC, Year_FAC, ValIVA_FAC) 
	Values ('".$_POST['sede']."','".$Consec."', '".(int)$_POST['Ingreso']."', '".$_POST["fechafac"]." ".$_POST["horafac"]."', '".$_POST['totalpte']."',  '".$_POST["totalent"]."', '".$_POST["totalent"]."', '".$_POST["contrato"]."', '".$_POST["plan"]."', '".$_SESSION["it_CodigoUSR"]."', '".$_POST["nota"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."', '".$_POST["valoriva"]."')";
	EjecutarSQL($SQL, $conexion);
	/*
	$SQL="Select sum(ValorPaciente_ORD) from gxordenesdet where codigo_ord IN (SELECT codigo_ord FROM gxordenescab WHERE codigo_adm='".(int)$_POST['Ingreso']."' AND estado_ord='1')";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if($row[0] = $_POST['totalpte']) {
			$valtot=$_POST["totalent"];
			$valpte=0;
			$valent=0;
			$porc=0;
			$valpte=$_POST['totalpte'];
			$valent=$valtot-$valpte;
			$sumpcte=0;
			$SQL="Select codigo_ser, sum(Cantidad_ORD), avg(ValorPaciente_ORD), avg(ValorEntidad_ORD)  from gxordenesdet where codigo_ord IN (SELECT codigo_ord FROM gxordenescab WHERE codigo_adm='".(int)$_POST['Ingreso']."' AND estado_ord='1') group by codigo_ser";
			$rexult = mysqli_query($Conn, $SQL);
			while ($rowx = mysqli_fetch_row($rexult)) {
				$cantidadser=$rowx[1];
				$pteser=$rowx[2];
				$entser=$rowx[3];
				$totser=document.getElementById('hdn_totser'+i+'<?php echo $NumWindow; ?>').value;
				$porc=($entser*100)/$valtot;
				$pteser=Math.round($valpte*$porc/100);
				$sumpcte=$sumpcte+$pteser;


				$entser=$entser-$pteser;
				$totser=$entser*$cantidadser;
				document.getElementById('hdn_pteser'+i+'<?php echo $NumWindow; ?>').value=pteser;
				document.getElementById('hdn_entser'+i+'<?php echo $NumWindow; ?>').value=entser;
				document.getElementById('hdn_totser'+i+'<?php echo $NumWindow; ?>').value=totser;
			}
			mysqli_free_result($rexult);
			
		}
	}
	mysqli_free_result($result);
	*/
	$contador=0; 
	$SQL="Update gxadmision Set Estado_ADM='F' Where Codigo_ADM='".(int)$_POST['Ingreso']."';";
	EjecutarSQL($SQL, $conexion);

	// Verifico si se generó la factura del ingreso..
	$SQL="Select count(*) from gxfacturas where Codigo_ADM='".(int)$_POST['Ingreso']."' and Estado_FAC='1'";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if ($row[0]=="0") {
			// se intenta generar nuevamente la factura
			$Consec=LoadConsecFact($conexion, $_POST['sede']);
			$MSG='Se ha generado correctamente la factura '.add_ceros($Consec,10);
			$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Codigo_ADM, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC, ValTotal_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Nota_FAC, Month_FAC, Year_FAC, ValIVA_FAC) Values ('".$_POST['sede']."','".$Consec."', '".(int)$_POST['Ingreso']."', '".$_POST["fechafac"]." ".$_POST["horafac"]."', '".$_POST['totalpte']."',  '".$_POST["totalent"]."', '".$_POST["totalent"]."', '".$_POST["contrato"]."', '".$_POST["plan"]."', '".$_SESSION["it_CodigoUSR"]."', '".$_POST["nota"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."', '".$_POST["valoriva"]."')";
			// error_log("Fecha y hora: ".$SQL);
			EjecutarSQL($SQL, $conexion);
		}
	}
	mysqli_free_result($result);
/*
	$SQL="Insert into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR, Estado_CAR) Values('".$_POST['sede']."', '".$Consec."', '".$_POST["totalent"]."', '".$_POST["totalent"]."','1')";
	EjecutarSQL($SQL, $conexion);
	*/
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['codigoser'.$contador])) {
		//Antes de esto, verificar si la tarifa es soat o es iss, para realizar bien el redondeo
		
			$SQL="Update gxordenesdet Set ValorPaciente_ORD=ROUND(".$_POST['pteser'.$contador]."),  ValorEntidad_ORD=ROUND(".($_POST['totser'.$contador]-$_POST['pteser'.$contador])."), ValorServicio_ORD=ROUND(".$_POST['totser'.$contador].") Where Codigo_ORD='".$_POST['ordenser'.$contador]."' and Codigo_SER='".$_POST['codigoser'.$contador]."' and Codigo_EPS='".$_POST['contrato']."' and Codigo_PLA='".$_POST['plan']."'";
			EjecutarSQL($SQL, $conexion);
		}
	}

	$SQL="Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM AND a.Codigo_ADM IN (".(int)$_POST['Ingreso'].") ;";
	//	EjecutarSQL($SQL, $conexion);
		// error_log($SQL);
	$SQL="UPDATE gxfacturas T1, ( SELECT b.Codigo_ADM, SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total  FROM gxordenesdet a, gxordenescab b where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1'   GROUP BY b.Codigo_ADM ) T2    SET T1.ValTotal_FAC = T2.total- (T1.ValPaciente_FAC + T1.ValCredito_FAC) - T1.ValIVA_FAC, T1.ValEntidad_FAC = T2.total     WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total  AND T1.codigo_adm='".(int)$_POST['Ingreso']."'";
	//	EjecutarSQL($SQL, $conexion);
	
	if ($_POST["reingreso"]=="1") { // Si se realiza reingreso
		$Consecing=LoadConsec("gxadmision", "Codigo_ADM", "0000000000", $conexion, "LPAD(Codigo_ADM,10,'0')");
		$SQL="Insert Into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, Observaciones_ADM, Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, Codigo_USR) Select ".$Consecing.", Codigo_TER, now(), Codigo_EPS, Codigo_PLA,Codigo_CXT, Codigo_FNC, Ingreso_ADM, curdate(), Codigo_CAM, Codigo_DGN, concat('|',Motivo_ADM), Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, '', Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, '".$_SESSION["it_CodigoUSR"]."' from gxadmision x Where x.Estado_ADM='F' and x.Codigo_ADM='".(int)$_POST['Ingreso']."'";
		EjecutarSQL($SQL, $conexion);
		
		it_aud('1', 'Admisiones', 'Reingreso '.$Consecing);
	}

	it_aud('1', 'Facturación Salud', 'Factura por eventos No.'.$Consec);

	InterfaceCNT("Factura", $Consec, $conexion);

include '99trnsctns.php';

?>