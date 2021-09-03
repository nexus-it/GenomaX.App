<?php
	session_start();
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

	if ($_SESSION["it_CodigoPRF"]=="0") {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ='1' and a.Codigo_CTZ NOT IN ( SELECT b.Codigo_CTZ FROM klemisiones b WHERE b.Estado_EMI<>'A')";
	} else {
		$SQL="SELECT COUNT(*) FROM klcotizaciones a WHERE NOW() <= a.FechaIni_CTZ AND a.Estado_CTZ='1' AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' AND a.Codigo_CTZ NOT IN ( SELECT b.Codigo_CTZ FROM klemisiones b WHERE b.Estado_EMI<>'A')";
	}
    $result = mysqli_query($conexion, $SQL);
    if($row = mysqli_fetch_array($result)) {
    	echo $row[0];
    }
    mysqli_free_result($result);
?>