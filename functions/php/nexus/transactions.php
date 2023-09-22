<?php


session_start();
function EjecutarSQL($Cons, $Conn) {
	mysqli_query($Conn, $Cons);	
	$ElErr=mysql_errno($enlace) . ": " . mysql_error($enlace). "\n";
}
function LoadConsec($Tabla, $Campo, $Valor, $Conn, $Campo2) {
	$SQL="Select ".$Campo." from ".$Tabla." Where ".$Campo2."='".$Valor."'";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$Consec=$row[0];
		$SQL="0";
	} else {
		mysqli_free_result($result);
		$SQL="Select Consecutivo_CNS + 1 from itconsecutivos Where Tabla_CNS='".$Tabla."' and Campo_CNS='".$Campo."'";
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
	$SQL="Select Concat(trim(Prefijo_AFC),' ',LPAD(ConsecNow_AFC + 1,10,'0')) from czautfacturacion Where Codigo_AFC='".$sede."' and Estado_AFC='1'";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update czautfacturacion set ConsecNow_AFC=ConsecNow_AFC + 1 Where Codigo_AFC='".$sede."' and Estado_AFC='1'";
		EjecutarSQL($SQL, $Conn);
	}
	return $row[0];
	mysqli_free_result($result);
}
	
include '../../../config.php';
include 'database.php';
include 'auditoria.php';
$MSG='Datos registrados correctamente. ';
$error = 0;
$conexion=Conexion();
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);
$SQL="START TRANSACTION;";
mysqli_query($conexion, $SQL);


$SQL="COMMIT;";
mysqli_query($conexion, $SQL);

echo $MSG;
?>