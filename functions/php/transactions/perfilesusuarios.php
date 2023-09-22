<?php

include '00trnsctns.php';

	$Consec=LoadConsec("itperfiles", "Codigo_PRF", $_POST['perfil'], $conexion, "Codigo_PRF");
	$SQL="Replace into itperfiles(Codigo_PRF, Nombre_PRF, Activo_PRF) Values ('".$Consec."', '".$_POST['nombreperfil']."', '".trim($_POST['estado'])."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From itpermisos Where Codigo_PRF='".$Consec."'";
	EjecutarSQL($SQL, $conexion);

	$SQL="Select distinct b.Codigo_ITM, Padre_ITM From ".$_SESSION['DB_NXS'].".ititems b, ".$_SESSION['DB_NXS'].".itaplicaciones c Where b.Codigo_APP=c.Codigo_APP and c.Activo_APP='1'";
	$result = mysqli_query($conexion, $SQL);
	$CodigoTER='0';
	while($row = mysqli_fetch_row($result)) {
		if (isset($_POST['permiso'.$row[0]])) {
			if ($_POST['permiso'.$row[0]]=='1') {
				$SQL="Insert into itpermisos(Codigo_PRF, Codigo_ITM) Values ('".$Consec."', '".$row[0]."')";
				//error_log($SQL);
				EjecutarSQL($SQL, $conexion);
				if ($row[1]!="0") {
					$SQL="Delete from itpermisos Where Codigo_PRF='".$Consec."' and Codigo_ITM='".$row[1]."'";
					EjecutarSQL($SQL, $conexion);
					$SQL="Insert into itpermisos(Codigo_PRF, Codigo_ITM) Values ('".$Consec."', '".$row[1]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	}
	mysqli_free_result($result); 
	// $SQL="Insert Into itpermisos(Codigo_PRF, Codigo_ITM) Select distinct '".$Consec."', a.Padre_ITM ititems a Where a.Codigo_ITM in b.Codigo_ITM and ";

	it_aud('1', 'Perfiles Usuarios', 'Código No. '.$Consec);

include '99trnsctns.php';

?>