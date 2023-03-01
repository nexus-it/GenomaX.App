<?php

session_start();
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

	$SQL="Select Sum(Individual_PLA), Sum(Pareja_PLA), Sum(Hijos_PLA) from klplanesprecios where Codigo_PLA='".$_POST["Plan"]."'";
    $result = mysqli_query($conexion, $SQL);
    if($row = mysqli_fetch_array($result)) {
    	if($row[0]!="0"){
			echo '
	    <option value="Individual_PLA" >Individual</option>';
	  	}
	  	if($row[1]!="0"){
			echo '
		<option value="Pareja_PLA" >Pareja</option>';
	  	}
	  	if($row[2]!="0"){
			echo '
	    <option value="Hijos_PLA" >Familia</option>';
	  	}
    }
    mysqli_free_result($result);
?>