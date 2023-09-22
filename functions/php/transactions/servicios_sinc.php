<?php

include '00trnsctns.php';


foreach($_POST['obj'] as $row){
			//echo $row['TipoArticulo']."<br>";

	$Consec = $row['cod_servicio'];
	if ($tiposervicio=="2") { 
		$Consec = 'MD'.$row['cod_servicio'];
	}
	$nombre = $row['des_servicio'];
	if ($row['TipoArticulo'] == 'Articulo'){ $tiposervicio = 2; $conceptofact = '12'; }else{ $tiposervicio = 1; $conceptofact = '04'; }
	$edadminima=0;
	$edadminmed=0;
	$edadmaxima=0;
	$edadmaxmed=0;
	$masculino=1;
	$femenino=1;
	$complejidad=2;
	$estado=1;

	$codigoprod = $row['cod_servicio'];
	$cups = $row['cups']; 
	$cum = $row['CUM']; 
	$disp = 0;
	$concentracion = 0;
	$medida = 0;
	$via = 0;
	$invent =1;

	$cups2 = $row['cups'];
	$iss2001 = 0;
	$soat = 0;
	$mapipos = 0;
	$quirurgico = 0;
	$uvr = 0;
	$gruposoat = 0;
	$puntossoat = 0;
	$tercerizar = 0;
	$uvrmin = 0;
	$uvrmax=0;
	$serviciosqz=0;
	$serviciosqx='';
  
	
	//$Consec=LoadConsec("gxservicios", "Codigo_SER", $_POST['codigo'], $conexion, "LPAD(Codigo_SER,6,'0')");
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha registrado correctamente el servicio!';
	}
	$SQL="Replace into gxservicios(Codigo_SER, Nombre_SER, Tipo_SER, Codigo_CFC, Estado_SER) Values ('".$Consec."', '".$nombre."', '".$tiposervicio."', '".$conceptofact."', '".$estado."')";
	//echo $SQL."<br><br>";
	EjecutarSQL($SQL, $conexion);
	if ($tiposervicio=="2") {
		$SQL="Replace into gxmedicamentos(Codigo_SER, Nombre_MED, Codigo_MED, CUPS_MED, CUM_MED, Dispositivo_MED, Concentracion_MED, Codigo_UNM, Codigo_VIA, Inventario_MED) Values ('".$Consec."', '".$nombre."', '".$codigoprod."', '".$cups."', '".$cum."', '".$disp."', '".$concentracion."', '".$medida."', '".$via."', '".$invent."')";
		//echo $SQL."<br><br>";
		EjecutarSQL($SQL, $conexion);
	}
	if ($tiposervicio=="1") {
		$serviciosqx='';
		$serviciosqz='';
		/*
		if ($_POST['tipoqx']!='CERO') {
			if ($_POST['tipoqx']!='0') {
				$serviciosqx=', '.$_POST['tipoqx'];
				$serviciosqz=', 1';
			}
		}*/
		$SQL="Replace into gxprocedimientos(Codigo_SER, Nombre_PRC, CUPS_PRC, ISS2001_PRC, ISS2000_PRC, SOAT_PRC, MAPIPOS_PRC, Procedimiento_PRC, UVR_PRC, GRUPOSOAT_PRC, PuntosSOAT_PRC, Tercerizar_PRC, UVRMin_PRC, UVRMax_PRC".$serviciosqx.") VALUES ('".$Consec."', '".$nombre."', '".$cups2."', '".$iss2001."', '".$iss2000."', '".$soat."', '".$mapipos."',".$quirurgico.", ".$uvr.", ".$gruposoat.", ".$puntossoat.", ".$tercerizar.", ".$uvrmin.", ".$uvrmax.$serviciosqz.")";
		//echo $SQL."<br><br>";
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

}

include '99trnsctns.php';

?>