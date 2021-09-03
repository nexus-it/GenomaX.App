<?php
   $conexion = mysqli_connect('localhost', 'ihccomco_turnos', 'Clave12345*', );

	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($MyZone, $conexion);
?>