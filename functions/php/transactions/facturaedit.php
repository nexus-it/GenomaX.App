<?php

include '00trnsctns.php';

	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha actualizado correctamente la factura '.$_POST["factura"];
	}
	// Primero actualizamos contrato y plan...
	$SQL="Update gxpacientes set Codigo_EPS='".$_POST["contrato"]."', Codigo_PLA='".$_POST["Plan"]."' Where Codigo_TER in (Select Codigo_TER from gxadmision Where Codigo_ADM='".(int)$_POST['Ingreso']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update gxadmision set Fecha_ADM='".$_POST["fechaadm"]." ".$_POST["horaadm"]."', Codigo_DGN='".$_POST["diagnostico"]."', Codigo_EPS='".$_POST["contrato"]."', Codigo_PLA='".$_POST["Plan"]."' Where Codigo_ADM='".(int)$_POST['Ingreso']."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update gxfacturas set Fecha_FAC='".$_POST["ffactura"]." ".$_POST["horafac"]."', Codigo_EPS='".$_POST["contrato"]."', Codigo_PLA='".$_POST["Plan"]."', Month_FAC='".$_POST["mes"]."', Year_FAC='".$_POST["anyo"]."', Nota_FAC='".$_POST["nota"]."' Where Codigo_ADM='".(int)$_POST['Ingreso']."' and Estado_FAC='1'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update gxordenesdet a, gxordenescab b set Codigo_EPS='".$_POST["contrato"]."', Codigo_PLA='".$_POST["Plan"]."' Where a.Codigo_ORD=b.Codigo_ORD and Codigo_ADM='".(int)$_POST['Ingreso']."'";
	EjecutarSQL($SQL, $conexion);
	// Actualizamos tarifa de servicios
	$SQL="Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM  AND a.Codigo_ADM IN ('".(int)$_POST['Ingreso']."')";
 	EjecutarSQL($SQL, $conexion);
 	// Actualizamos valor de factura a la tarifa
	$SQL="UPDATE gxfacturas T1, ( SELECT b.Codigo_ADM, SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total  FROM gxordenesdet a, gxordenescab b  where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1'   GROUP BY b.Codigo_ADM ) T2    SET T1.ValTotal_FAC = T2.total- T1.ValCredito_FAC , T1.ValEntidad_FAC = T2.total     WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total   AND T1.codigo_adm IN ( '".(int)$_POST['Ingreso']."')";
	EjecutarSQL($SQL, $conexion);
	
	it_aud('2', 'Factura Salud', 'Factura No. '.$Consec);

include '99trnsctns.php';

?>