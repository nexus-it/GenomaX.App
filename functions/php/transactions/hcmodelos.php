<?php

include '00trnsctns.php';
	

	// Primero buscamos los registros existentes en tipos y campos para eliminarlos, ademas de la tabla del modelo hc
	$SQL="Delete from hctipos Where trim(Codigo_HCT)='".trim($_POST['Codigo_HCT'])."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from hccampos Where trim(Codigo_HCT)='".trim($_POST['Codigo_HCT'])."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="Delete from hccamposlistas Where trim(Codigo_HCT)='".trim($_POST['Codigo_HCT'])."'";
	EjecutarSQL($SQL, $conexion);
	$SQL="DROP TABLE hc_".trim($_POST['Codigo_HCT']).";";
	EjecutarSQL($SQL, $conexion);
	
	//Creamos los registros y la tabla
	$SQLx="Insert Into hctipos(Codigo_HCT";
	$SQL0="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hctipos' AND COLUMN_NAME not in ('Codigo_HCT')";
	$SQLy=") Values('".trim($_POST['Codigo_HCT'])."'";
	$resultHCA = mysqli_query($conexion, $SQL0);
	while ($rowHCA = mysqli_fetch_row($resultHCA)) {
		$SQLx=$SQLx.", ".$rowHCA[0];
		$SQLy=$SQLy.", '".trim($_POST[$rowHCA[0]])."'";
	}
	mysqli_free_result($resultHCA);
	$SQLx=$SQLx.$SQLy.");";
	error_log($SQLx);
	EjecutarSQL($SQLx, $conexion);


	$SQL="Create Table hc_".trim($_POST['Codigo_HCT'])." (Codigo_TER CHAR(10) NOT NULL COLLATE 'latin1_swedish_ci', Codigo_HCF INT(11) NOT NULL,";
	$Item=0; 
	while($Item <= $_POST['TotRows']) {
		$Item++;
		$Kamp="0";
		if (trim($_POST['Codigo_HCC'.$Item])!="") {
			// hccampos
			$SQLx="Insert Into hccampos(Codigo_HCT";
			$SQL0="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccampos' AND COLUMN_NAME not in ('Codigo_HCT')";
			$SQLy=") Values('".trim($_POST['Codigo_HCT'])."'";
			$resultHCA = mysqli_query($conexion, $SQL0);
			while ($rowHCA = mysqli_fetch_row($resultHCA)) {
				$SQLx=$SQLx.", ".$rowHCA[0];
				$SQLy=$SQLy.", '".trim($_POST[$rowHCA[0].$Item])."'";
			}
			mysqli_free_result($resultHCA);
			$SQLx=$SQLx.$SQLy.");";
			error_log($SQLx);
			EjecutarSQL($SQLx, $conexion);
			// Fin hccampos
		
			if (trim($_POST['Tipo_HCC'.$Item])=="textarea") { $Type="TEXT"; $Long="(65535)"; $Kamp="1"; }
			if (trim($_POST['Tipo_HCC'.$Item])=="check") { $Type="CHAR"; $Long="(1)"; $Kamp="1"; }
			if (trim($_POST['Tipo_HCC'.$Item])=="select") { $Type="VARCHAR"; $Long="(255)"; $Kamp="1"; }
			if (trim($_POST['Tipo_HCC'.$Item])=="text") { $Type="VARCHAR"; $Long="(255)"; $Kamp="1"; }
			if (trim($_POST['Tipo_HCC'.$Item])=="date") { $Type="DATE"; $Long=""; $Kamp="1"; }
			if (trim($_POST['Tipo_HCC'.$Item])=="time") { $Type="TIME"; $Long=""; $Kamp="1"; }
			error_log(trim($_POST['Tipo_HCC'.$Item]));
			if ($Kamp=="1") {
				$SQL=$SQL." `".trim($_POST['Codigo_HCC'.$Item])."_HC` ".$Type.$Long."  NULL COMMENT '".trim($_POST['Nombre_HCC'.$Item])." ', ";
			}
		}
	}
	$SQL=$SQL." PRIMARY KEY (`Codigo_TER`, `Codigo_HCF`), 	INDEX `Codigo_TER` (`Codigo_TER`), INDEX `Codigo_HCF` (`Codigo_HCF`) ) 	COMMENT='".$_POST['Nombre_HCT']."' 	COLLATE='utf8_general_ci' 	ENGINE=InnoDB;";
	error_log($SQL);
	EjecutarSQL($SQL, $conexion);

	$Itemx=0; 
	while($Itemx <= $_POST['TotRows2']) {
		$Itemx++;
		$Kamp="0";
		if (trim($_POST['lCodigo_HCC'.$Itemx])!="") {
			// hccampos
			$SQLx="Insert Into hccamposlistas(Codigo_HCT";
			$SQL0="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccamposlistas' AND COLUMN_NAME not in ('Codigo_HCT')";
			$SQLy=") Values('".trim($_POST['Codigo_HCT'])."'";
			$resultHCA = mysqli_query($conexion, $SQL0);
			while ($rowHCA = mysqli_fetch_row($resultHCA)) {
				$SQLx=$SQLx.", ".$rowHCA[0];
				$SQLy=$SQLy.", '".trim($_POST['l'.$rowHCA[0].$Itemx])."'";
			}
			mysqli_free_result($resultHCA);
			$SQLx=$SQLx.$SQLy.");";
			error_log($SQLx);
			EjecutarSQL($SQLx, $conexion);
			// Fin hccampos			
		}
	}
	



	it_aud('1', 'Modelos HC', 'Código: '.trim($_POST['Codigo_HCT']));

include '99trnsctns.php';

?>