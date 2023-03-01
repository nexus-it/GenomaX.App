<?php

include '00trnsctns.php';

	$Consec=LoadConsec("cznotascontablesenc", "Codigo_NCT", '0', $conexion, "Codigo_NCT");
	$SQL="Update gxfacturas set ValTotal_FAC=(ValPaciente_FAC+ValEntidad_FAC)-(ValDcto_FAC)-ValCredito_FAC - ".$_POST['valornc'].", ValCredito_FAC=ValCredito_FAC+".$_POST['valornc']." where Codigo_FAC='".$_POST['factura']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update czcartera set Saldo_CAR=ValorFac_CAR + ValorDeb_CAR - ValorCre_CAR - ".$_POST['valornc'].", ValorCre_CAR=ValorCre_CAR+ ".$_POST['valornc']." where Codigo_FAC='".$_POST['factura']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into cznotascontablesenc(Codigo_NCT, Naturaleza_NCT, Descripcion_NCT, Fecha_NCT, TipoDoc_NCT, NumeroDoc_NCT, Codigo_TER, Valor_NCT, Codigo_USR) values(".$Consec.", 'C', '".$_POST['observacion']."', '".$_POST['fecha']."', '01', '".$_POST['factura']."', '".$_POST['codigoter']."', ".$_POST['valornc'].", '".$_SESSION["it_CodigoUSR"]."');";
	EjecutarSQL($SQL, $conexion);
	$totalnc=$_POST['controw'];
	for ($i = 1; $i <= $totalnc; $i++) {
		if (isset($_POST['cantserv'.$i])) {
			if ($_POST['cantserv'.$i]!='0') {
				//Detalle NC
				$SQL="Insert Into cznotascontablesdet(Codigo_NCT, Codigo_SER, Codigo_CCT, Codigo_CUE, Naturaleza_NCT, ValorDet_NCT) values('".$Consec."', '".$_POST['servicio'.$i]."', '1', '000000000', 'D', '".$_POST['totserv'.$i]."')";
				EjecutarSQL($SQL, $conexion);
				//Actualizar Ordenes e servicio
				$CantServi=$_POST['cantserv'.$i];
				$SQL="Select a.Codigo_ORD, Cantidad_ORD, Codigo_SER from gxordenesdet a, gxordenescab b, gxfacturas c where a.Codigo_ORD=b.Codigo_ORD and b.Codigo_ADM=c.Codigo_ADM and b.Estado_ORD<>'0' and c.Codigo_FAC='".$_POST['factura']."' and Codigo_SER='".$_POST['servicio'.$i]."' order by Cantidad_ORD desc";
				$resulty = mysqli_query($conexion, $SQL);
				while($rowy = mysqli_fetch_row($resulty)) {
					if ($CantServi>0) {
						if ($CantServi>=$rowy[1]) {
							$SQL="Update gxordenesdet set Cantidad_ORD='0' where Codigo_ORD='".$rowy[0]."' and Codigo_SER='".$rowy[2]."'";
							$CantServi=$CantServi-$rowy[1];
						} else {
							$SQL="Update gxordenesdet set Cantidad_ORD=Cantidad_ORD - (".$CantServi.") where Codigo_ORD='".$rowy[0]."' and Codigo_SER='".$rowy[2]."'";
							$CantServi=0;
						}
						EjecutarSQL($SQL, $conexion);
					}
				}
			}
		}
	}

	it_aud('1', 'Notas Crédito', 'No '.$Consec);

include '99trnsctns.php';

?>