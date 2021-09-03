<?php

include '00trnsctns.php';

	$Consec=LoadConsec("itusuarios", "Codigo_USR", $_POST['codigo'], $conexion, "Codigo_USR");
	if ($Consec!=$_POST['codigo']) {
		$SQL="Insert into itusuarios(Codigo_USR, ID_USR, Nombre_USR, Codigo_PRF, Email_USR, FechaCreacion_USR, Activo_USR) Values ('".$Consec."', '".$_POST['id']."', '".trim($_POST['nombre'])."', '".$_POST['perfil']."', '".$_POST['email']."', curdate(), '".$_POST['estado']."')";

		it_aud('1', 'Usuarios', 'Codigo No. '.$Consec);
	} else {
		$SQL="Update itusuarios Set ID_USR='".$_POST['id']."', Nombre_USR='".trim($_POST['nombre'])."', Codigo_PRF='".$_POST['perfil']."', Email_USR='".$_POST['email']."', Activo_USR='".$_POST['estado']."' Where Codigo_USR='".$Consec."'";

		it_aud('2', 'Usuarios', 'Codigo No. '.$Consec);
	}
	EjecutarSQL($SQL, $conexion);

	if ($_POST["defaultpass"]=="1") {
		$SQL="Update itusuarios Set Clave_USR='10470c3b4b1fed12c3baac014be15fac67c6e815' Where Codigo_USR='".$Consec."'";
		EjecutarSQL($SQL, $conexion);
		it_aud('2', 'Usuarios', 'Clave por defecto. Usuario No. '.$Consec);
	}

		// $SQL="Update itusuarios set Clave_USR=SHA1('".rtrim($_POST["passx"])."') where Codigo_USR= '".$_SESSION["it_CodigoUSR"]."' and Clave_USR = SHA1('".rtrim($_POST["clavex"])."') and Activo_USR='1'";
		// EjecutarSQL($SQL, $conexion);
	
	// GuardarImagen('../../../files/images/users/'.$Consec, $Consec, 'users');

include '99trnsctns.php';

?>