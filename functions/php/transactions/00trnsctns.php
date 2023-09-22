<?php

session_start();

function logError($cons, $msg, $Conn) {
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($Conn, $MyZone);

	$SQL="Insert into itxerror(xdate, xtime, xsql, xerror) values(DATE(NOW()), TIME(NOW()), '".str_replace("'","\'",$cons)."', '".str_replace("'","\'",$msg)."')";
	$pos= stripos($cons, "itxerror");
	if ($pos === false) {
		EjecutarSQL($SQL,$Conn);
	}
}
function EjecutarSQL($Cons, $Conn) {
	$Flag=0;
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($Conn, $MyZone);
	if(mysqli_query($Conn, $MyZone)) {
		$Flag=1;
	  } else {
        //error_log("NXS_ERROR: No se ejecuto $Cons. " . mysqli_error($Conn));
		logError($Cons, mysqli_error($Conn), $Conn);
    }
	$Flag=0;
	if(mysqli_query($Conn, $Cons)) {
		$Flag=1;
	  } else {
        //error_log("NXS_ERROR: No se ejecuto $Cons. " . mysqli_error($Conn));
		logError($Cons, mysqli_error($Conn), $Conn);
    }
}
function LoadConsec($Tabla, $Campo, $Valor, $Conn, $Campo2) {
	$SQL="Select ".$Campo." from ".$Tabla." Where ".$Campo2."='".$Valor."'";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$Consec=$row[0];
		$SQL="0";
	} else {
		mysqli_free_result($result);
		$SQL="Select Consecutivo_CNS + 1 from itconsecutivos Where Tabla_CNS='".$Tabla."' and Campo_CNS='".$Campo."' FOR UPDATE";
		$result = mysqli_query($Conn, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$SQL="Update itconsecutivos set Consecutivo_CNS=Consecutivo_CNS + 1 Where Tabla_CNS='".$Tabla."' and Campo_CNS='".$Campo."'";
			EjecutarSQL($SQL, $Conn);
			$SQL="1";
		}
	}
	return $row[0];
	mysqli_free_result($result);
}
function LoadConsecFact($Conn, $sede) {
	$Conn->autocommit(FALSE);
	mysqli_begin_transaction($Conn, MYSQLI_TRANS_START_READ_WRITE);
	if (!(is_null($_SESSION["SiigoToken"]))) {
		$SQL=substr('tmp'.uniqid(), 0, 15);;
		return $SQL;
	} else {
		$SQL="Select Concat(trim(Prefijo_AFC),Separador_AFC,trim(LPAD(ConsecNow_AFC + 1,10,Ceros_AFC))), (ConsecNow_AFC + 1) from czautfacturacion Where Codigo_AFC='".$sede."' and Estado_AFC='1' FOR UPDATE";
		$result = mysqli_query($Conn, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$SQL="Update czautfacturacion set ConsecNow_AFC=".$row[1]." Where Codigo_AFC='".$sede."' and Estado_AFC='1'";
			EjecutarSQL($SQL, $Conn);
		}
		return $row[0];
		mysqli_free_result($result);
	}
	mysqli_commit($Conn);
	$Conn->autocommit(TRUE);
}
function UpdtTarifasNow($CodigoTar, $Conn) {
	$FecIni=date("Y").'-01-01';
	$FecFin=date("Y")."-12-31 23:59:59";
	$VariacionTAR="";
	$SQL="Select Base_TAR from gxtarifas where Codigo_TAR='".$CodigoTar."'";
	// error_log($SQL);
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$VariacionTAR=$row[0];
	}
	mysqli_free_result($result);
	if ($VariacionTAR!="") {
		$SQL="Delete From gxmanualestarifarios Where Codigo_TAR='".$CodigoTar."' and now() between Fechaini_Tar and fechafin_tar";
		EjecutarSQL($SQL, $Conn);
		$SQL="Insert Into gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Select distinct '".$CodigoTar."', '".$FecIni."', '".$FecFin."', Codigo_SER, Valor_TAR* Variacion_TAR From gxtarifas a, gxmanualestarifarios b Where a.Codigo_TAR='".$CodigoTar."' and b.Codigo_TAR=Base_TAR";
		EjecutarSQL($SQL, $Conn);
	}
	$SQL="Select Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX from gxtarifaexcepciones where Codigo_TAR='".$CodigoTar."' and now() between Fechaini_Tar and fechafin_tar order by 4";
	
	$result = mysqli_query($Conn, $SQL);
	while($row = mysqli_fetch_row($result)) {
		if($row[3]=="0") {
			$SQL="Delete From gxmanualestarifarios Where Codigo_TAR='".$CodigoTar."' and codigo_ser in ( select codigo_ser from gxprocedimientos where CUPS_PRC like '".$row[4]."%') and now() between Fechaini_Tar and fechafin_tar ";
			
			EjecutarSQL($SQL, $Conn);
			$SQL="Insert Into gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Select distinct '".$row[0]."', '".$row[1]."', '".$row[2]."', a.Codigo_SER, (Valor_TAR*".$row[6].") From gxprocedimientos a, gxmanualestarifarios b Where b.Codigo_TAR='".$row[5]."' and b.Codigo_SER=a.Codigo_SER and a.CUPS_PRC like '".$row[4]."%'";
		} else {
			if ($row[3]=="9") {
				$SQL="Delete From gxmanualestarifarios Where Codigo_TAR='".$CodigoTar."' and codigo_ser in (Select Codigo_SER from gxservicios where Codigo_CFC='".$row[4]."') and now() between Fechaini_Tar and fechafin_tar ";
				EjecutarSQL($SQL, $Conn);
				$SQL="Insert Into gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Select '".$row[0]."', '".$row[1]."', '".$row[2]."', a.Codigo_SER, (Valor_TAR*".$row[6].") From gxservicios a, gxmanualestarifarios b Where b.Codigo_TAR='".$row[5]."' and b.Codigo_SER=a.Codigo_SER and a.Codigo_CFC = '".$row[4]."'";
			} else {
				$SQL="Delete From gxmanualestarifarios Where Codigo_TAR='".$CodigoTar."' and codigo_ser ='".$row[4]."' and now() between Fechaini_Tar and fechafin_tar ";
				EjecutarSQL($SQL, $Conn);
				$SQL="Insert Into gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Values('".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[4]."', ".$row[6].")";
			}
		}
		
		EjecutarSQL($SQL, $Conn);
	}
	mysqli_free_result($result);
}
	
include '../../../config.php';
include '../nexus/database.php';
include '../nexus/auditoria.php';
include '_ctinterface.php';
if (!(is_null($_SESSION["SiigoToken"]))) {
	include '../nexus/nxs_api_siigo.php';
}
$MSG='Datos registrados correctamente. ';
$error = 0;
$conexion=Conexion();
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);
/*$SQL="START TRANSACTION;";
mysqli_query($conexion, $SQL);
*/
// creamos una bandera
$result_transaccion = true;
mysqli_autocommit($conexion,FALSE);
mysqli_begin_transaction($conexion, MYSQLI_TRANS_START_READ_WRITE);
 
?>