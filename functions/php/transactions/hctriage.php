<?php

include '00trnsctns.php'; 

$SQL="Select max(Cast(Codigo_HCF as decimal(2)))  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
$SQL="Select max(Folio_HCF)  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_row($result)) {
	if($row[0]==null) {
		$XFolio="1";
	} else {
		$XFolio=$row[0];
	}
} else {
	$XFolio="1";
}
mysqli_free_result($result);
$SQL="Select max(Codigo_HCF)  + 1 from hcfolios Where Codigo_TER='".$_POST['codigoter']."'";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_row($result)) {
	if($row[0]==null) {
		$ElFolio="1";
	} else {
		$ElFolio=$row[0];
	}
} else {
	$ElFolio="1";
}
mysqli_free_result($result);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha clasificado Triage del paciente en el folio '.add_ceros($ElFolio,5);
	}
	//Generamos registro del nuevo folio
	$SQL="Insert Into hcfolios(Codigo_TER, Codigo_HCT, Codigo_HCF, Folio_HCF, Fecha_HCF, Hora_HCF, Codigo_ADM, Codigo_ARE, Codigo_USR, FechaReg_HCF) Select '".$_POST['codigoter']."', '".$_POST['formatohc']."', '".$ElFolio."', '".$ElFolio."', date(now()), '".substr($_POST['hora'],0,5)."', '".$_POST['ingreso']."', Codigo_ARE, '".$_SESSION["it_CodigoUSR"]."', now() From gxconsultorios Where Codigo_CNS='".$_POST['modulo']."';";
	EjecutarSQL($SQL, $conexion);
	$SQL="Update hctriage Set Edad_TRG='".$_POST['edad']." ".$_POST['tipoe']."', Codigo_HCF='".$ElFolio."', Codigo_HTR='".$_POST['triage']."', Estado_TRG='3' Where Codigo_TER='".$_POST['codigoter']."' and Codigo_TRG='".$_POST['pretriage']."';";
	EjecutarSQL($SQL, $conexion);
	$SV_HCT="0";
	$Antecedentes_HCT="0";
	$Dx_HCT="0";
	//Buscamos los parametros del formato para guardar la hc
	$SQL="Select * from hctipos Where Codigo_HCT='".$_POST['formatohc']."'";
	$resultHCT = mysqli_query($conexion, $SQL);
	if($rowHCT = mysqli_fetch_row($resultHCT)) {
		$SV_HCT=$rowHCT["SV_HCT"];
		$Antecedentes_HCT=$rowHCT["Antecedentes_HCT"];
		$Dx_HCT=$rowHCT["Dx_HCT"];
	}
	mysqli_free_result($resultHCT);
	// SIGNOS VITALES
	if ($SV_HCT!="0") {
		$totalsv=12;
		for ($i = 1; $i <= $totalsv; $i++) {
			if (isset($_POST['codsv'.$i])) {
				$SQL="Insert Into hcsignosvitales(Codigo_TER, Codigo_HCF, Codigo_HSV, Valor_HSV, Fecha_HSV, Hora_HSV) values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['codsv'.$i]."', '".$_POST['valorsv'.$i]."', date(now()), '".substr($_POST['hora'],0,5)."')";
				EjecutarSQL($SQL, $conexion);
			}
		}
	} 
	// ANTECEDENTES
	if ($Antecedentes_HCT!="0") {
		$totalant=$_POST['hdn_controwantX'];
		if ($totalant>0) {
			for ($i = 1; $i <= $totalant; $i++) {
				if (isset($_POST['tantecedente'.$i])) {
					$SQL="Insert Into hcantecedentes(Codigo_TER, Codigo_HCF, Consec_HCA, Codigo_HCA, Descripcion_HCA) values('".$_POST['codigoter']."', '".$ElFolio."', '".$i."', '".$_POST['tantecedente'.$i]."', '".$_POST['dantecedente'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	} 
	// DIAGNOSTICOS
	if ($Dx_HCT!="0") {
		$DGNR="";
		$DGNR2="";
		$DGNR3="";
		$DGNM="";
		if (isset($_POST["dxrel1"])) {
			$DGNR=$_POST["dxrel1"];
		}
		if (isset($_POST["dxrel2"])) {
			$DGNR2=$_POST["dxrel2"];
		}
		if (isset($_POST["dxrel3"])) {
			$DGNR3=$_POST["dxrel3"];
		}
		if (isset($_POST["dxmanejo"])) {
			$DGNM=$_POST["dxmanejo"];
		}
		$SQL="Insert Into hcdiagnosticos(Codigo_TER, Codigo_HCF, Codigo_DGN, CodigoR_DGN, CodigoR2_DGN, CodigoR3_DGN, Tipo_DGN, Manejo_DGN) Values('".$_POST["codigoter"]."', '".$ElFolio."', '".$_POST["dxppal"]."', '".$DGNR."', '".$DGNR2."', '".$DGNR3."', '".$_POST["tipodx"]."', '".$DGNM."')";
		EjecutarSQL($SQL, $conexion);
	} 
	// GUARDAR CAMPOS DE LA HC
	$SQL1="Insert Into hc_".$_POST['formatohc']."(Codigo_TER, Codigo_HCF, ";
	$SQL2=") Values('".$_POST['codigoter']."', '".$ElFolio."', ";
	$SQL="Select Codigo_HCC, Orden_HCC, Tipo_HCC from hccampos where Codigo_HCT='".$_POST['formatohc']."' and Tipo_HCC<>'well' order by Orden_HCC";
	$resulty = mysqli_query($conexion, $SQL);
	while($rowy = mysqli_fetch_row($resulty)) {
		$campo=$rowy[0];
		if (isset($_POST[$campo])) {
			$SQL1=$SQL1.$rowy[0]."_HC, ";
			if ($rowy[2]=="select") {
				$SQL3="Select Texto_HCC from hccamposlistas Where Codigo_HCT='".$_POST['formatohc']."' and Codigo_HCC='".$rowy[0]."' and Valor_HCC='".$_POST[$campo]."'";
				$resultlist = mysqli_query($conexion, $SQL3);
				while($rowlist = mysqli_fetch_row($resultlist)) {
					$SQL2=$SQL2."'".$rowlist[0]."', ";	
				}
				mysqli_free_result($resultlist);
			} else {
				$SQL2=$SQL2."'".$_POST[$campo]."', ";
			}
		}
	}
	mysqli_free_result($resulty);
	$SQL=substr($SQL1,0,-2).substr($SQL2,0,-2).");";
	EjecutarSQL($SQL, $conexion);
	

	it_aud('1', 'Clasificación Triage', 'Tercero '.$_POST['codigoter'].' - Folio '.$ElFolio);

include '99trnsctns.php';

?>