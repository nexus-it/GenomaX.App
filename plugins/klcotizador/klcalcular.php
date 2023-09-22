<?php

session_start();
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	
	$SQL="SELECT ".$_POST["nxsmod"]." FROM klplanesprecios WHERE Dias_PLA='".$_POST["nxsdias"]."' AND Codigo_PLA='".$_POST["nxsplan"]."'";
	$resultx = mysqli_query($conexion, $SQL);
    while ($rowx = mysqli_fetch_array($resultx)) {
    	echo $rowx[0];
    } 
    mysqli_free_result($resultx);
?>