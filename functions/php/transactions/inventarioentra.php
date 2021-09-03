<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czinventradascab", "Codigo_ENT", $_POST['orden'], $conexion, "Codigo_ENT");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente la entrada a inventario '.add_ceros($Consec,10);
	}
	$SQL="Delete From czinventradasdet Where Codigo_ENT='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Replace into czinventradascab(Codigo_ENT, Fecha_ENT, FechaInspeccion_ENT, Proveedor_ENT, Observaciones_ENT, Codigo_CMP, Codigo_BDG, Estado_ENT, Codigo_USR)  Select '".$Consec."', '".($_POST['fechaent'])." 00:00:00', '".($_POST['fechainsp'])." 00:00:00', Codigo_TER, '".$_POST['observacion']."', '".$_POST['compra']."', '".$_POST['bodega']."', '1', '".$_SESSION["it_CodigoUSR"]."' From czterceros Where ID_TER='".$_POST['idproveedor']."'";
	EjecutarSQL($SQL, $conexion);
/*
	$contador=0; 
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['codigoser'.$contador])) {
		$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA) Values ('".$Consec."', '".$_POST['codigoser'.$contador]."', ".$_POST['cantidadser'.$contador].", '".TRIM($_POST['contrato'])."', '".$_POST['plan']."')";
		EjecutarSQL($SQL, $conexion);
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

	}		*/

	it_aud('1', 'Inventario', 'Entrada No. '.$Consec);

include '99trnsctns.php';

?>