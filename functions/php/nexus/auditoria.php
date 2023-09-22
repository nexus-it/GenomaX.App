<?php

error_reporting(E_ERROR | E_PARSE);
session_start();

function it_aud($Actividad, $Registro, $Descripcion) {
	if (isset($_ENV["COMPUTERNAME"])) {
		$Equipo=$_ENV["COMPUTERNAME"];
	} else {
		$Equipo="Web Remoto";
	}
//	echo $Equipo;
	$SQL="Insert into itauditoria(Codigo_USR, Fecha_AUD, Codigo_ACT, Codigo_APP, Registro_AUD, Descripcion_AUD, BrowserName_AUD, BrowserVersion_AUD, Plataforma_AUD, Equipo_AUD, Direccion_AUD) 
	Values('".$_SESSION["it_CodigoUSR"]."',now(), '".$Actividad."', '".$_SESSION["NEXUS_APP"]."', '".$Registro."', '".$Descripcion."', '".$_SESSION["it_browsername"]."', '".$_SESSION["it_browserversion"]."', '".$_SESSION["it_plataforma"]."', '".$Equipo."', '".$_SERVER['REMOTE_ADDR']."')";
//	echo $SQL;
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);
	mysqli_query($conexion, $SQL);

}
?>