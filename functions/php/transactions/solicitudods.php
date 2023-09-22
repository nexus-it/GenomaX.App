<?php

include '00trnsctns.php';

	$Consec=LoadConsec("myodssol", "Codigo_ODS", $_POST['ods'], $conexion, "Codigo_ODS");
	$modo="Insert";
	if ($Consec!=$_POST['ods']) {
		$SQL="Insert into myodssol(Codigo_ODS, Codigo_USR, Titulo_ODS, Solicitud_ODS, Fecha_ODS, FechaReg_ODS) Values ('".$Consec."', '".$_SESSION["it_CodigoUSR"]."', '".trim($_POST['nombreods'])."', '".$_POST['solicitud']."', '".($_POST['fecha'])." ".$_POST['hora']."', '".date("Y-m-d H:i:s")."')";
		if ($MSG=='Datos registrados correctamente. ') {
			$MSG='Se ha registrado correctamente la ODS No. '.add_ceros($Consec,6);
		}
	} else {
		if (isset($_POST['calificacion'])) {
			if ($_POST['estado']=="1") {
				$SQL="Update myodssol Set Estado_ODS='".$_POST['estado']."', Calificacion_ODS=".$_POST['calificacion']*$_POST['estado'].", Observaciones_ODS='".$_POST['textcalif']."' Where Codigo_ODS='".$Consec."'";
				if ($MSG=='Datos registrados correctamente. ') {
					$MSG='Se ha cerrado y calificado la ODS '.add_ceros($Consec,6);
					$modo="Update";
				}
			}
		}
	}
	EjecutarSQL($SQL, $conexion);
	
	$SQL="Select a.Email_USR, b.Email_USR, a.Nombre_USR, b.Nombre_USR From itusuarios a, itusuarios b Where b.ODS_USR='1' and b.Activo_USR='1' and a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$My_Correo=$row[0];
		$ODS_Correo=$row[1];
		$Usuario=$row[2];
		$Destino=$row[3];
		if ($modo=="Insert") {
			$mensaje = '<p>Se ha generado la siguiente solicitud de orden de servicio con fecha <strong>'.$_POST['fecha'].'</strong>: <br><br><em>"'.$_POST['solicitud'].'"</em>.</p><p> Ingrese con su clave a través de la intranet para dar respuesta a la presente solicitud. <a href="http://central/" style="text-decoration:none">Ir a Intranet</a></p><p><strong>Intranet - CEHOCA S.A.S.</strong>';
			$titulo="Solicitud ODS ".$Consec.": ".trim($_POST['nombreods']);
		} else {
			$mensaje = '<p>Se ha cerrado y calificado la orden de servicio '.$Consec.' de fecha <strong>'.$_POST['fecha'].'</strong>: <br><br><em>"'.$_POST['solicitud'].'"</em>.</p><p>Calificación del servicio: '.$_POST['calificacion'].'%</p><p><strong>Intranet - CEHOCA S.A.S.</strong>';
			$titulo="Cerrada ODS ".$Consec.": ".trim($_POST['nombreods']);
		}
		$desde=$Usuario.' <'.$My_Correo.'>';
		$para=$ODS_Correo;
		//$MSG1=$MSG1.' - '.$desde.$Usuario.$para.$Destino.$titulo.$mensaje;
		$MSG1=nxs_mailing($desde, $Usuario, $para, $Destino, $titulo, $mensaje);
	}
	/*
	if ($modo=="Insert") {
		$mensaje = '<p>Se ha generado la siguiente solicitud de orden de servicio con fecha <strong>'.$_POST['fecha'].'</strong>: <br><br><em>"'.$_POST['solicitud'].'"</em>.</p><p> Ingrese con su clave a través de la intranet para dar respuesta a la presente solicitud. <a href="http://Servidor1/" style="text-decoration:none">Ir a Intranet</a></p><p><strong>MyEscala - Intranet Escala Impresores S.A.S.</strong>';
		$titulo="Solicitud ODS ".$Consec.": ".trim($_POST['nombreods']);
	} else {
		$mensaje = '<p>Se ha cerrado y calificado la orden de servicio '.$Consec.' de fecha <strong>'.$_POST['fecha'].'</strong>: <br><br><em>"'.$_POST['solicitud'].'"</em>.</p><p>Calificación del servicio: '.$_POST['calificacion'].'%</p><p><strong>MyEscala - Intranet Escala Impresores S.A.S.</strong>';
		$titulo="Cerrada ODS ".$Consec.": ".trim($_POST['nombreods']);
	}
	$MSG1=nxs_mailing('juan.palacio@cehoca.co', 'Juan Palacio', 'juan.palacio@cehoca.co', 'Juan Palacio', $titulo, $mensaje);
	*/
	mysqli_free_result($result);
	$MSG=$MSG1.'<br>'.$MSG;

	it_aud('1', 'Solicitud ODS', 'Codigo No. '.$Consec);

include '99trnsctns.php';

?>