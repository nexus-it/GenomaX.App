<?php
	session_start();
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

	if ($_SESSION["it_CodigoPRF"]=="0") {
		$SQL="SELECT count(*) FROM klemisiones a, klcotizaciones b WHERE a.Estado_EMI='E' AND a.Codigo_CTZ=b.Codigo_CTZ AND date(NOW()) BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ";
	} else {
		$SQL="SELECT count(*) FROM klemisiones a, klcotizaciones b WHERE a.Estado_EMI='E' AND a.Codigo_CTZ=b.Codigo_CTZ AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' AND date(NOW()) BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ";
	}
    $result = mysqli_query($conexion, $SQL);
    if($row = mysqli_fetch_array($result)) {
    	echo $row[0];
    }
    mysqli_free_result($result);
?>