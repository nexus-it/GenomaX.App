<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czterceros", "Codigo_TER", $_POST['idagencia'], $conexion, "ID_TER");
	$SQL="Delete From klagencias Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete From czterceros Where Codigo_TER='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER, RazonSocial_TER, DigitoVerif_TER, Web_TER) Values ('".$Consec."', '".$_POST['idagencia']."', '".trim($_POST['ncomercial'])."', ".$_POST['tipoid'].", '".$_POST['Direccion']."', '".$_POST['Telefonos']."','".$_POST['email']."', '".$_POST['expedicion']."', '".$_POST['rsocial']."', '".$_POST['id']."', '".strtolower($_POST['webpage'])."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into klagencias(Codigo_TER, Codigo_AGE, Nombre_AGE, Descripcion_AGE, Codigo_PAI, Codigo_DEP, Codigo_MUN, Representante_AGE, Contacto_AGE, Cargo_AGE, Estado_AGE, RazonPrint_AGE, NITPrint_AGE, ValVentaPrint_AGE) Values('".$Consec."', '".$Consec."', '".trim($_POST['ncomercial'])."', '".trim($_POST['descripcion'])."', '".$_POST['pais']."', '".$_POST['Departamento']."', '".$_POST['Municipio']."', '".$_POST['replegal']."', '".$_POST['contacto']."', '".trim($_POST['cargo'])."', '".$_POST['estado']."', '".$_POST['rsocialprint']."', '".$_POST['nitprint']."', '".$_POST['valorprint']."')";
	EjecutarSQL($SQL, $conexion);
	$SQL="UPDATE klagencias a, klagencias b SET a.LogoPrint_AGE=b.LogoPrint_AGE, a.WaterMarkPrint_AGE=b.WaterMarkPrint_AGE WHERE a.Codigo_AGE='".$Consec."' AND b.Codigo_AGE='1'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from klagenciasusuarios Where Codigo_AGE='".$Consec."'";
	EjecutarSQL($SQL, $conexion);
	$contador=1;
	while($contador <= $_POST['controw']) { 
		if (isset($_POST['idusr'.$contador])) {
			if ($_POST['idusr'.$contador]!="-") {
				$SQL="Insert into klagenciasusuarios(Codigo_AGE, Codigo_USR) Select '".$Consec."', Codigo_USR From itusuarios Where ID_USR='".$_POST['idusr'.$contador]."'";
				EjecutarSQL($SQL, $conexion);
			}
		}
		$contador++;
	}

	it_aud('1', 'Agencias Klud', 'Agencia No. '.$Consec);

include '99trnsctns.php';

?>