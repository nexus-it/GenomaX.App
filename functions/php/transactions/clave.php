<?php

include '00trnsctns.php';

	$SQL="Select ID_USR from itusuarios where Codigo_USR= '".$_SESSION["it_CodigoUSR"]."' and Clave_USR = SHA1('".rtrim($_POST["clavex"])."') and Activo_USR='1'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update itusuarios set Clave_USR=SHA1('".rtrim($_POST["passx"])."') where Codigo_USR= '".$_SESSION["it_CodigoUSR"]."' and Clave_USR = SHA1('".rtrim($_POST["clavex"])."') and Activo_USR='1'";
		EjecutarSQL($SQL, $conexion);
		$MSG='Su clave fue actualizada exitosamente.';
		$AudAction='Sucess';
	} else {
		$MSG=' La clave suministrada no corresponde a la actual.';
		$AudAction='Fail';
	}
	mysqli_free_result($result);
	it_aud('2', 'Clave', $AudAction);

include '99trnsctns.php';

?>