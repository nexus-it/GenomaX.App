<?php
	header ("Expires: Thu, 21 Nov 1979 23:59:00 GMT"); //la pagina expira en una fecha pasada
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
	header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
	header ("Pragma: no-cache"); 
	

//if (!(isset($_SESSION["DB_NAME"]))) {
//	if ($_SESSION["DB_SUFFIX"]!="0") {
//		define('DB_NAME', DB_NAMEX.$_SESSION["DB_SUFFIX"]);
//		define('DB_USER', DB_USERX.$_SESSION["DB_SUFFIX"]);
//	} else {
//		define('DB_NAME', DB_NAMEX);
//		define('DB_USER', DB_USERX);
//	}
//} else {
		$_GET["nxsdb"]=$_GET["suffixdb"];
		/*define('DB_NAME', $_SESSION["DB_NAME"]);
		define('DB_USER', $_SESSION["DB_USER"]);*/
	define(DB_SUFFIX, $_GET["suffixdb"]);

	$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conexion) {
		header('Location: 404.shtml');
	    /* echo "Conexion fallida (settings).".$_SESSION["DB_SUFFIX"].' '.DB_HOST.' '.DB_USER.' '.DB_NAME; */
	    exit;
	}


	$Appis=NEXUS_APP;
	/*
	$SQL="Select Codigo_APP from itaplicaciones where Activo_APP=1;";
	$result0 = mysqli_query($conexion, $SQL);
	if($row0 = mysqli_fetch_row($result0)) {
		$Appis=$row0[0];
	} else {
		$Appis=1;
	}
	mysqli_free_result($result0);

	define('NEXUS_APP', $Appis);
	*/
	$_SESSION["NEXUS_APP"]=NEXUS_APP;
	$SQL="Select Theme_APP, Nombre_APP from nxs_gnx.itaplicaciones where Codigo_APP='".NEXUS_APP."';";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$_SESSION["THEME_DEFAULT"]=$row[0];
		define ('THEME_DEFAULT',$_SESSION["THEME_DEFAULT"]);
		$_SESSION["NOMBRE_APP"]=$row[1];
		define ('NOMBRE_APP',$_SESSION["NOMBRE_APP"]);
	} else {
		define('THEME_DEFAULT', 'ghenx');
		$_SESSION["THEME_DEFAULT"]=THEME_DEFAULT;
		$_SESSION["NOMBRE_APP"]='GenomaX';
		define ('NOMBRE_APP',$_SESSION["NOMBRE_APP"]);
	}
	mysqli_free_result($result);

	$_SESSION["DB_NAME"]=DB_NAME;
	$_SESSION["DB_USER"]=DB_USER;
	$_SESSION["DB_PASSWORD"]=DB_PASSWORD;
	$_SESSION["DB_HOST"]=DB_HOST;
	$_SESSION["DB_TIMEZONE"]=DB_TIMEZONE;

	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);

	$_GET["nxsdb"]=$_GET["suffixdb"];
	if(!isset($_SESSION["it_user"]))
	{
		header('Location: login.php');
	}
	else
	{
		include 'functions/php/nexus/pagina.php';
		include 'themes/'.$_SESSION["THEME_DEFAULT"].'/index.php';
	}
?>