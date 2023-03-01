<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);

?>
<div class="row well well-sm">
	<div class="col-md-offset-2 col-md-8" id="grpsede<?php echo $NumWindow; ?>" name="grpsede<?php echo $NumWindow; ?>">
		<a class="btn btn-success btn-lg btn-block" href="http://192.168.1.76:8080/application/forms/calltriageshow.php?v=<?php echo $NumWindow; ?>" onclick="window.open(this.href,'nxstriage','width=1000,height=500,status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no'); return false" role="button">Iniciar <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></a>
	</div>
</div>
