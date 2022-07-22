<?php

include '00trnsctns.php';

	$Consec=LoadConsec("gxordenescab", "Codigo_ORD", $_POST['orden'], $conexion, "LPAD(Codigo_ORD,10,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la orden de servicio '.add_ceros($Consec,10);
	}
	$SQL="Delete From gxordenesdet Where Codigo_ORD='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From gxprocedimientosdet Where Codigo_ORD='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Replace into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$Consec."', '".(int)$_POST['Ingreso']."', '".($_POST['fechaord'])."', '".$_POST['area']."', '".$_POST['descripcion']."',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizaord']."')";
	echo $SQL."<br><br>";
	EjecutarSQL($SQL, $conexion);

	$contador=0; 
	if(isset($_POST['obj'])){
		
		foreach($_POST['obj'] as $row){
			//echo $row['TipoArticulo']."<br>";
			$codigoser = $row['cod_servicio'];
			$cantidadser = $row['cant'];
			$contrato = '1';
			$plan = '4';
			$codigoter = '7';
			$Valor_TAR = $row['vlr_u'];
			$SQL="SELECT a.Codigo_SER, a.Valor_TAR from gxmanualestarifarios a, gxprocedimientos b WHERE a.Codigo_SER=b.Codigo_SER AND a.Codigo_TAR='3' AND NOW() BETWEEN a.FechaIni_TAR AND a.FechaFin_TAR AND b.CUPS_PRC='".$row['cod_servicio']."' UNION SELECT d.Codigo_SER, d.Valor_TAR from gxmanualestarifarios d, gxmedicamentos e WHERE d.Codigo_SER=e.Codigo_SER AND d.Codigo_TAR='3' AND NOW() BETWEEN d.FechaIni_TAR AND d.FechaFin_TAR AND e.CUPS_MED='".$row['cod_servicio']."'";
			$resultc = mysqli_query($conexion, $SQL);
			if($rowc = mysqli_fetch_row($resultc)) {
				$codigoser = $rowc[0];
				$Valor_TAR = $rowc[1];
			}
			mysqli_free_result($result);
			
			$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER, ValorServicio_ORD, ValorEntidad_ORD) values ( '".$Consec."', '".$codigoser."', ".$cantidadser.", '1', '4', '".$codigoter."', ".$Valor_TAR.", ".$Valor_TAR." ) " ;
			echo $SQL."<br><br>";
			EjecutarSQL($SQL, $conexion);
		}		
	}else{
		while($contador <= $_POST['controw']) {
			$contador++;
			if (isset($_POST['codigoser'.$contador])) {
			$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER, ValorServicio_ORD, ValorEntidad_ORD) Select '".$Consec."', '".$_POST['codigoser'.$contador]."', ".$_POST['cantidadser'.$contador].", '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$_POST['codigoter'.$contador]."', Valor_TAR, Valor_TAR from gxmanualestarifarios c, gxcontratos d, gxadmision e Where d.Codigo_TAR=c.Codigo_TAR and '".TRIM($_POST['contrato'])."'=d.Codigo_EPS and '".$_POST['plan']."'=d.Codigo_PLA and c.Codigo_SER='".$_POST['codigoser'.$contador]."' and date(now()) between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM='".(int)$_POST['Ingreso']."'";
			EjecutarSQL($SQL, $conexion);
			}
		} 
	}	
	if (isset($_POST['cantporctotal'])) {
		$contador=1;
		while($contador <= $_POST['cantporctotal']) { 
			$SQL="Select b.Tipo_TAR From gxcontratos as a, gxtarifas as b Where a.Codigo_TAR=b.Codigo_TAR and a.Codigo_EPS='".TRIM($_POST['contrato'])."' and a.Codigo_PLA='".$_POST['plan']."'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$TipoManual=$row[0];
				mysqli_free_result($result);
				if ($TipoManual=='ISS2001') { //SI EL MANUAL TARIFARIO ES ISS2001
			
					if ($_POST['tipoproc'.$contador]=="4" || $_POST['tipoproc'.$contador]=="5") {
					$SQL="Select (".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*a.Valor_TAR)/100 From gxmanualestarifarios as a, gxcontratos as c Where c.Codigo_EPS='".TRIM($_POST['contrato'])."' and c.Codigo_PLA='".$_POST['plan']."' and a.Codigo_SER='".$_POST['codigoproc2'.$contador]."' and a.FechaIni_TAR <=CURDATE() and a.FechaFin_TAR>=CURDATE() and c.Codigo_TAR=a.Codigo_TAR";
					} else {
					$SQL="Select (".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*a.Valor_TAR)*b.UVR_PRC/100 From gxmanualestarifarios as a, gxprocedimientos as b, gxcontratos as c Where c.Codigo_EPS='".TRIM($_POST['contrato'])."' and c.Codigo_PLA='".$_POST['plan']."' and a.Codigo_SER='".$_POST['codigoproc2'.$contador]."' and b.Codigo_SER='".$_POST['codigoproc1'.$contador]."'  and a.FechaIni_TAR <=CURDATE() and a.FechaFin_TAR>=CURDATE()  and c.Codigo_TAR=a.Codigo_TAR"; 
					}
				} else { //SI EL MANUAL TARIFARIO ES SOAT
					if ($_POST['tipoproc'.$contador]=="5" ) {
					$SQL="Select ".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*TRUNCATE((c.SalarioMinimo_ANY/30), -2)*a.Materiales_SQX/100 From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="4" ) {
					$SQL="Select ".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*TRUNCATE((c.SalarioMinimo_ANY/30), -2)*a.Sala_SQX/100 From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="3" ) {
					$SQL="Select ".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*TRUNCATE((c.SalarioMinimo_ANY/30), -2)*a.Ayudante_SQX/100 From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="2" ) {
					$SQL="Select ".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*TRUNCATE((c.SalarioMinimo_ANY/30), -2)*a.Anestesiologo_SQX/100 From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="1" ) {
					$SQL="Select ".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*TRUNCATE((c.SalarioMinimo_ANY/30), -2)*a.Cirujano_SQX/100 From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
				}
			}
			
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$SQL="Insert into gxprocedimientosdet(Codigo_ORD, Codigo_SER, Evento_PRD, Codigo2_SER, Tipo_PRD, Cantidad_PRD, Porcentaje_PRD, Valor_SER) Values ('".$Consec."', '".$_POST['codigoproc1'.$contador]."', '".TRIM($_POST['evento'.$contador])."', '".$_POST['codigoproc2'.$contador]."', '".$_POST['tipoproc'.$contador]."', ".$_POST['cantproc'.$contador].", ".$_POST['porcproc'.$contador].", ".$row[0].")";
				EjecutarSQL($SQL, $conexion);
			}
			$contador++;
		} 	
	}

	it_aud('1', 'Ordenes de Servicios', 'Código No.'.$Consec);

include '99trnsctns.php';

?>
