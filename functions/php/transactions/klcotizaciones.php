<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['pasaporte'], $conexion, "ID_TER");
	$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('".$Consec."', '".$_POST['pasaporte']."', '".trim($_POST['nombres'])." ".trim($_POST['apellidos'])."', 3, '".$_POST['direccion']."', '".$_POST['telefono']."','".strtolower($_POST['correo'])."', '".$_POST['nacionalidad']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from klclientes Where Codigo_TER='".$Consec."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into klclientes(Codigo_TER, Nombres_KLI, Apellidos_KLI, Contacto_KLI, FechaNac_KLI, Nacionalidad_KLI) Values ('".$Consec."', '".trim($_POST['nombres'])."', '".trim($_POST['apellidos'])."', '".$_POST['contacto']."', '".($_POST['fnac'])."', '".$_POST['nacionalidad']."')";
	EjecutarSQL($SQL, $conexion);
	$ConsecTer=$Consec;
	$Consec=LoadConsec("klcotizaciones", "Codigo_CTZ", '0', $conexion, "Codigo_CTZ");
	$SQL="Insert into klcotizaciones(Codigo_CTZ, Codigo_TER, Codigo_AGE, Codigo_PLA, Edad_CTZ, Modalidad_CTZ, Codigo_DST, FechaIni_CTZ, FechaFin_CTZ, Dias_CTZ, TRM_CTZ, Dolares_CTZ, Pesos_CTZ, Voucher_CTZ, Codigo_USR, Estado_CTZ, Fecha_CTZ, Procedencia_CTZ, Descuento_CTZ, Total_CTZ) Values('".$Consec."', '".$ConsecTer."', '".trim($_POST['agencia'])."', '".trim($_POST['plan'])."', '".trim($_POST['edad'])."', '".substr($_POST['modalidad'],0, -4)."', '".$_POST['destino']."', '".($_POST['fini'])."', '".($_POST['ffin'])."', '".$_POST['dias']."', '".trim($_POST['trm'])."', '".$_POST['dolares0']."', '".$_POST['pesos0']."', '".str_pad($Consec, 5, "0", STR_PAD_LEFT)."', '".$_SESSION["it_CodigoUSR"]."', '1', now(), '".trim($_POST['procedencia'])."', '".$_POST['descuento']."', '".$_POST['total0']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from cztrm Where Moneda_TRM='US' and Fecha_TRM=date(now());";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into cztrm(Fecha_TRM, Moneda_TRM, Valor_TRM) Values(date(now()), 'US',".$_POST['trm'].");";
	EjecutarSQL($SQL, $conexion);
	$ConsecPoliza=$Consec;
	if ($_POST['controwx']!='0') {
		$totalpersonas=$_POST['controwx'];
		for ($i = 1; $i <= $totalpersonas; $i++) {
			if (isset($_POST['parentesco'.$i])) {
				$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['pasaporte'.$i], $conexion, "ID_TER");
				$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
				EjecutarSQL($SQL, $conexion);
				$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('".$Consec."', '".$_POST['pasaporte'.$i]."', '".trim($_POST['nombre'.$i])."', 3, '".$_POST['direccion']."', '".$_POST['telefono']."','".strtolower($_POST['correo'])."', '".$_POST['nacionalidad']."')";
				EjecutarSQL($SQL, $conexion);
				$SQL="Insert into klpersonas(Codigo_EMI, Codigo_TER, Parentesco_PER, FechaNac_PER) Values ('".$ConsecPoliza."', '".$Consec."', '".trim($_POST['parentesco'.$i])."', '".($_POST['fecnac'.$i])."')";
				EjecutarSQL($SQL, $conexion);
			}
		}
	}
	if (substr($_POST['modalidad'],0, -4)=='PAREJA') {
		$totalpersonas="1";
		$i = 1;
		if (isset($_POST['parentesco'.$i])) {
			if ($_POST['parentesco'.$i]!="") {
				$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['pasaporte'.$i], $conexion, "ID_TER");
				$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
				EjecutarSQL($SQL, $conexion);
				$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('".$Consec."', '".$_POST['pasaporte'.$i]."', '".trim($_POST['nombre'.$i])."', 3, '".$_POST['direccion']."', '".$_POST['telefono']."','".strtolower($_POST['correo'])."', '".$_POST['nacionalidad']."')";
				EjecutarSQL($SQL, $conexion);
				$SQL="Insert into klpersonas(Codigo_EMI, Codigo_TER, Parentesco_PER, FechaNac_PER) Values ('".$ConsecPoliza."', '".$Consec."', '".trim($_POST['parentesco'.$i])."', '".($_POST['fecnac'.$i])."')";
				EjecutarSQL($SQL, $conexion);
			}
		}
	}
	$MSG=$ConsecPoliza;

	it_aud('1', 'Cotizacion Poliza', 'Consecutivo No. '.$ConsecPoliza);

include '99trnsctns.php';

?>