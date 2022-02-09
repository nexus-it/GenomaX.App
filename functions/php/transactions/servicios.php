<?php

include '00trnsctns.php';

	$Consec=LoadConsec("gxservicios", "Codigo_SER", $_POST['codigo'], $conexion, "LPAD(Codigo_SER,6,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente el servicio!';
	}
	$SQL="Replace into gxservicios(Codigo_SER, Nombre_SER, Tipo_SER, Codigo_CFC, EdadMinima_SER, EdadMaxima_SER, SexoM_SER, SexoF_SER, Complejidad_SER, Estado_SER) Values ('".$Consec."', '".$_POST['nombre']."', '".$_POST['tiposervicio']."', '".$_POST['conceptofact']."', '".$_POST['edadminima']*$_POST['edadminmed']."',  '".$_POST['edadmaxima']*$_POST['edadmaxmed']."', '".$_POST['masculino']."', '".$_POST['femenino']."', '".$_POST['complejidad']."', '".$_POST['estado']."')";
	EjecutarSQL($SQL, $conexion);
	if ($_POST['tiposervicio']=="2") {
		$SQL="Replace into gxmedicamentos(Codigo_SER, Nombre_MED, Codigo_MED, CUPS_MED, CUM_MED, Dispositivo_MED, Concentracion_MED, Codigo_UNM, Codigo_VIA, Inventario_MED, PpioActivo_MED) Values ('".$Consec."', '".$_POST['nombre']."', '".$_POST['codigoprod']."', '".$_POST['cups']."', '".$_POST['cum']."', '".$_POST['disp']."', '".$_POST['concentracion']."', '".$_POST['medida']."', '".$_POST['via']."', '".$_POST['invent']."', '".$_POST['ppioactivo']."')";
		EjecutarSQL($SQL, $conexion);
	}
	if ($_POST['tiposervicio']=="1") {
		$serviciosqx='';
		$serviciosqz='';
		if ($_POST['tipoqx']!='CERO') {
			if ($_POST['tipoqx']!='0') {
				$serviciosqx=', '.$_POST['tipoqx'];
				$serviciosqz=', 1';
			}
		}
		$SQL="Replace into gxprocedimientos(Codigo_SER, Nombre_PRC, CUPS_PRC, ISS2001_PRC, ISS2000_PRC, SOAT_PRC, MAPIPOS_PRC, Procedimiento_PRC, UVR_PRC, GRUPOSOAT_PRC, PuntosSOAT_PRC, Tercerizar_PRC, UVRMin_PRC, UVRMax_PRC".$serviciosqx.") VALUES ('".$Consec."', '".$_POST['nombre']."', '".$_POST['cups2']."', '".$_POST['iss2001']."', '".$_POST['iss2000']."', '".$_POST['soat']."', '".$_POST['mapipos']."',".$_POST['quirurgico'].", ".$_POST['uvr'].", ".$_POST['gruposoat'].", ".$_POST['puntossoat'].", ".$_POST['tercerizar'].", ".$_POST['uvrmin'].", ".$_POST['uvrmax'].$serviciosqz.")";
		EjecutarSQL($SQL, $conexion);
	}
	if ($_POST['tiposervicio']=="3") {
		$SQL="Delete From gxpaquetes Where Codigo_SER='".$Consec."'";
		EjecutarSQL($SQL, $conexion);
		$totalpq=$_POST['controwPq'];
		if ($totalpq>0) {
			for ($i = 1; $i <= $totalpq; $i++) {
				if (isset($_POST['codigopqt'.$i])) {
					$SQL="Insert Into gxpaquetes( Codigo_SER, Codigo_PQT, Cantidad_PQT) values('".$Consec."', '".$_POST['codigopqt'.$i]."', '".$_POST['cantpqt'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	
	}
	
	it_aud('1', 'Servicios', 'Código No.'.$Consec);

include '99trnsctns.php';

?>