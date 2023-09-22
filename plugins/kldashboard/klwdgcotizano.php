<?php
	session_start();
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$total=1;
	if ($_SESSION["it_CodigoPRF"]=="0") {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ<>'0'";
	} else {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ<>'0' a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	}
    $result = mysqli_query($conexion, $SQL);
    if($row = mysqli_fetch_array($result)) {
    	$total= $row[0];
    }
    mysqli_free_result($result);

    if ($_SESSION["it_CodigoPRF"]=="0") {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ='0'";
	} else {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ='0' a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	}
    $resultx = mysqli_query($conexion, $SQL);
    if($rowx = mysqli_fetch_array($resultx)) {
    	$total= $rowx[0]*100/$total;
    }
    mysqli_free_result($resultx);
    echo $total;
?>