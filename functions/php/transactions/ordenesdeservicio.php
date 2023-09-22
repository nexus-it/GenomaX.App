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
	$ingreso = $_POST['Ingreso']; // Obtén el ingreso del formulario
    // Elimina los ceros a la izquierda y otros caracteres no numéricos
    $ingreso_limpio = ltrim(preg_replace('/[^0-9]/', '', $ingreso), '0');
    // Agrega la última letra si es parte del valor
    if (preg_match('/[A-Za-z]$/', $ingreso)) {
        $ingreso_limpio .= substr($ingreso, -1);
    }
	$SQL="Replace into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$Consec."', '".$ingreso_limpio."', '".($_POST['fechaord'])." 00:00:00', '".$_POST['area']."', '".$_POST['descripcion']."',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizaord']."')";
	EjecutarSQL($SQL, $conexion);

	$contador=0; 
	while($contador <= $_POST['controw']) {
		$contador++;
		if (isset($_POST['codigoser'.$contador])) {
		$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER, ValorServicio_ORD, ValorEntidad_ORD) Select '".$Consec."', '".$_POST['codigoser'.$contador]."', ".$_POST['cantidadser'.$contador].", '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$_POST['codigoter'.$contador]."', Valor_TAR, Valor_TAR from gxmanualestarifarios c, gxcontratos d, gxadmision e Where d.Codigo_TAR=c.Codigo_TAR and '".TRIM($_POST['contrato'])."'=d.Codigo_EPS and '".$_POST['plan']."'=d.Codigo_PLA and c.Codigo_SER='".$_POST['codigoser'.$contador]."' and date(now()) between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM='".(int)$_POST['Ingreso']."'";
		EjecutarSQL($SQL, $conexion);
		}
	} 
	$SQL="Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR Where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM and a.Codigo_ORD='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
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
					$SQL="Select TRUNCATE(".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*(c.SalarioMinimo_ANY/30)*a.Materiales_SQX/100, -2) From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="4" ) {
					$SQL="Select TRUNCATE(".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*(c.SalarioMinimo_ANY/30)*a.Sala_SQX/100, -2) From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="3" ) {
					$SQL="Select TRUNCATE(".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*(c.SalarioMinimo_ANY/30)*a.Ayudante_SQX/100, -2) From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="2" ) {
					$SQL="Select TRUNCATE(".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*(c.SalarioMinimo_ANY/30)*a.Anestesiologo_SQX/100, -2) From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
					}
					if ($_POST['tipoproc'.$contador]=="1" ) {
					$SQL="Select TRUNCATE(".$_POST['porcproc'.$contador]."*".$_POST['cantproc'.$contador]."*(c.SalarioMinimo_ANY/30)*a.Cirujano_SQX/100, -2) From gxsoatqx as a, gxprocedimientos as b, czsalariomin as c Where b.GRUPOSOAT_PRC =a.Codigo_SQX and c.Codigo_ANY=year(now()) and trim(b.Codigo_SER)='".$_POST['codigoproc1'.$contador]."'";
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