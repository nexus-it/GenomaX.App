<?php

include '00trnsctns.php';

	$SQL="Insert Into nxs_meet(Codigo_MET, Codigo_USR, Fecha_MET, Ingreso_MET) values('".$_POST['channel']."', '".$_SESSION["it_CodigoUSR"]."', now(), '1');";
	EjecutarSQL($SQL, $conexion);

	$SQL="Insert Into nxs_meet(Codigo_MET, Codigo_USR, Fecha_MET, Ingreso_MET) Select '".$_POST['channel']."', Codigo_USR, now(), '0' From itusuarios Where Codigo_USR in (".$_POST["uxuarios"].");";
	EjecutarSQL($SQL, $conexion);
	it_aud('1', 'NXS.Meet', 'Session '.$_POST['channel']." Users: ".$_POST["uxuarios"]);

include '99trnsctns.php';

?>