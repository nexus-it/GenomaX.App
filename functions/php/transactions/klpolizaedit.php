<?php

include '00trnsctns.php';

	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha actualizado correctamente la póliza '.$_POST["prefijo"].'-'.$_POST["poliza"];
	}
	// Primero actualizamos contrato y plan...
	$SQL="Update czterceros set ID_TER='".$_POST["pasaporte"]."', Nombre_TER='".$_POST["nombres"]." ".$_POST["apellidos"]."', Direccion_TER='".$_POST["direccion"]."', Telefono_TER='".$_POST["telefono"]."', Correo_TER='".$_POST["correo"]."' Where Codigo_TER='".$_POST['tercero']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update klclientes set Nombres_KLI='".$_POST["nombres"]."', Apellidos_KLI='".$_POST["apellidos"]."', FechaNac_KLI='".($_POST["fnac"])."', Contacto_KLI='".$_POST["contacto"]."', Nacionalidad_KLI='".$_POST["nacionalidad"]."' Where Codigo_TER='".$_POST['tercero']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update klcotizaciones set Codigo_AGE='".$_POST["agencia"]."', Codigo_PLA='".$_POST["plan"]."', Edad_CTZ='".$_POST["edad"]."', Modalidad_CTZ='".substr($_POST["modalidad"],0, -4)."', Codigo_DST='".$_POST["destino"]."', FechaIni_CTZ='".($_POST["fini"])."', FechaFin_CTZ='".($_POST["ffin"])."', Dias_CTZ='".$_POST["dias"]."', Procedencia_CTZ='".$_POST["procedencia"]."' Where Codigo_CTZ='".$_POST['cotizacion']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update klemisiones set Estado_EMI='".$_POST["estado"]."', Fecha_EMI='".$_POST["femision"]."' Where Codigo_EMI='".$_POST['poliza']."';";
	EjecutarSQL($SQL, $conexion);
	$ConsecPoliza=$Consec;
	error_log('contastby: '.$_POST['controwsby']);
	if ($_POST['controwsby']!='0') {
		$totalstby=$_POST['controwsby'];
		for ($i = 1; $i <= $totalstby; $i++) {
			error_log('i: '.$i);
			$SQL="Insert into klstandby(Codigo_CTZ, Fecha_SBY, Vence_SBY, Observaciones_SBY, Cobro_SBY) Values ('".$_POST['cotizacion']."', '".$_POST['fechastby'.$i]."', '".$_POST['fechavencestby'.$i]."', '".$_POST['descripcionstby'.$i]."', '".$_POST['cobrostby'.$i]."')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	it_aud('1', 'Emision de Poliza', 'Póliza No. '.$Consec);

include '99trnsctns.php';

?>