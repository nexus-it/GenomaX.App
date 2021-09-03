<?php

include '00trnsctns.php';

	$SQL="Delete from myodsres Where Codigo_ODS='".$_POST['ods']."'";
	EjecutarSQL($SQL, $conexion);
	$primero=1;
	$contador=1;
	while($contador <= $_POST['controw']) { 
		if (isset($_POST['tarea'.$contador])) {
			if ($primero==1) {
				$FechaProg=($_POST['fecha'.$contador]).' '.$_POST['hora'.$contador];
				if ($_POST['tarea'.$contador]=="FECHA DE PROGRAMACIÓN DE SERVICIO: ".$_POST['fechaprog']." A LAS ".$_POST['horaprog']) {
					$FechaProg=($_POST['fechaprog']).' '.$_POST['horaprog'];
				}
				$SQL="Update myodssol Set Clasificacion_ODS='".$_POST['clasificacion']."', FechaProg_ODS='".$FechaProg."', Responde_ODS='".$_SESSION["it_CodigoUSR"]."' Where Codigo_ODS='".$_POST['ods']."'";
				EjecutarSQL($SQL, $conexion);
			}
			$SQL="Insert into myodsres(Codigo_ODS, Tarea_ODS, FechaTarea_ODS, Codigo_USR) Values ('".$_POST['ods']."', '".$_POST['tarea'.$contador]."', '".($_POST['fecha'.$contador]).' '.$_POST['hora'.$contador]."', '".$_SESSION["it_CodigoUSR"]."')";
			EjecutarSQL($SQL, $conexion);
			$primero=0;
		}
		$contador++;
	}
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha dado respuesta a la ODS '.add_ceros($_POST['ods'],6);
	}

	$SQL="Select a.Email_USR, b.Email_USR, a.Nombre_USR, b.Nombre_USR From itusuarios a, itusuarios b, myodssol c Where b.ODS_USR='1' and b.Activo_USR='1' and a.Codigo_USR=c.Codigo_USR and c.Codigo_ODS='".$_POST['ods']."'";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$My_Correo=$row[0];
		$ODS_Correo=$row[1];
		$Usuario=$row[3];
		$Destino=$row[2];
		$mensaje = '<p>Se ha generado respuesta a su solicitud de orden de servicio <strong>'.$_POST['ods'].'</strong> de fecha <strong>'.$_POST['fecha'].'</strong>: <br><br><em>"'.$_POST['solicitud'].'"</em>.</p><p> Ingrese con su clave a través de la intranet para calificar el servicio prestado. <a href="http://Servidor1/" style="text-decoration:none">Ir a Intranet</a></p><p><strong>MyEscala - Intranet Escala Impresores S.A.S.</strong>';
		$desde=$Usuario.' <'.$ODS_Correo.'>';
		$titulo="Respuesta ODS ".$_POST['ods'].": ".trim($_POST['nombreods']);
		$para=$My_Correo;
		$MSG1=nxs_mailing($desde, $Usuario, $para, $Destino, $titulo, $mensaje);
	}
	mysqli_free_result($result);
	$MSG=$MSG1.'<br>'.$MSG;

	it_aud('1', 'Respuesta ODS', 'Codigo No. '.$_POST['ods']);

include '99trnsctns.php';

?>