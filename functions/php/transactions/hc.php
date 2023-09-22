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
		$MSG='Se generado el folio '.add_ceros($XFolio,5);
	}
	//Verificamos si el contrato permite el cargue automatico de ordenes en facturacion
	$OrdXHCEPS='1';
	$SQL="Select OrdXHC_EPS from gxeps where Codigo_EPS='".TRIM($_POST['contrato'])."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$OrdXHCEPS=$row[0];
	}
	mysqli_free_result($result);
	//Generamos registro del nuevo folio
	$SQL="Insert Into hcfolios(Codigo_TER, Codigo_HCT, Codigo_HCF, Fecha_HCF, Hora_HCF, Codigo_ADM, Codigo_ARE, Codigo_USR, FechaReg_HCF, Folio_HCF) Values ('".$_POST['codigoter']."', '".$_POST['formatohc']."', '".$ElFolio."', date(now()), '".substr($_POST['hora'],0,5)."', '".$_POST['ingreso']."', '".$_POST['area']."', '".$_SESSION["it_CodigoUSR"]."', now(), '".$XFolio."')";
	
	EjecutarSQL($SQL, $conexion);
	$SV_HCT="0";
	$Antecedentes_HCT="0";
	$Dx_HCT="0";
	$AyudasDiag_HCT="0";
	$QX_HCT="0";
	$Cons_HCT="0";
	$Med_HCT="0";
	$Ordenes_HCT="0";
	$Indicaciones_HCT="0";
	$Medico2_HCT="0";
	$Incapacidad_HCT="0";
	$Insumos_HCT="0";
	$RiesgoEspecifHCT="0";
	$AntGineObsHCT="0";
	$EmbarazoActHCT="0";
	$RiesgoObstHCT="0";
	$CtrlParacObsHCT="0";
	$CtrlPreNatHCT="0";
	$RiesgoCardVHCT="0";
	$FraminghamHCT="0";
	$ValHeridasHCT="0";
	$DescQxHCT="0";  
	//Buscamos los parametros del formato para guardar la hc
	$SQL="Select SV_HCT, Antecedentes_HCT, Dx_HCT, AyudasDiag_HCT, Qx_HCT, Med_HCT, Ordenes_HCT, Indicaciones_HCT, Medico2_HCT, Incapacidad_HCT, RiesgoEspecif_HCT, AntGineObs_HCT, EmbarazoAct_HCT, RiesgoObst_HCT, CtrlParacObs_HCT, CtrlPreNat_HCT, RiesgoCardV_HCT, Framingham_HCT, Insumos_HCT, ValHeridas_HCT, Cons_HCT, DescQx_HCT from hctipos Where Codigo_HCT='".$_POST['formatohc']."'";
	// error_log($SQL);
	$resultHCT = mysqli_query($conexion, $SQL);
	if($rowHCT = mysqli_fetch_row($resultHCT)) {
		$SV_HCT=$rowHCT[0];
		$Antecedentes_HCT=$rowHCT[1];
		$Dx_HCT=$rowHCT[2];
		$AyudasDiag_HCT=$rowHCT[3];
		$QX_HCT=$rowHCT[4];
		$Cons_HCT=$rowHCT[20];
		$Med_HCT=$rowHCT[5];
		$Ordenes_HCT=$rowHCT[6];
		$Indicaciones_HCT=$rowHCT[7];
		$Medico2_HCT=$rowHCT[8];
		$Incapacidad_HCT=$rowHCT[9];
		$RiesgoEspecifHCT=$rowHCT["RiesgoEspecif_HCT"];
		$AntGineObsHCT=$rowHCT["AntGineObs_HCT"];
		$EmbarazoActHCT=$rowHCT["EmbarazoAct_HCT"];
		$RiesgoObstHCT=$rowHCT["RiesgoObst_HCT"];
		$CtrlParacObsHCT=$rowHCT["CtrlParacObs_HCT"];
		$CtrlPreNatHCT=$rowHCT["CtrlPreNat_HCT"];
		$RiesgoCardVHCT=$rowHCT["RiesgoCardV_HCT"];
		$FraminghamHCT=$rowHCT["Framingham_HCT"];
		$Insumos_HCT=$rowHCT["Insumos_HCT"];
		$ValHeridasHCT=$rowHCT["ValHeridas_HCT"];
		$DescQxHCT=$row["DescQx_HCT"];  
		// error_log('Cons_HCT: '.$rowHCT[20]);
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
	// Riesgo Especifico
	if ($RiesgoEspecifHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  = '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcidriesgoesp' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['ire'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcidriesgoesp(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
	}
	// Embarazo Actual 
	if ($EmbarazoActHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcembactual' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['emb'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcembactual(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
	}
	// Riesgo Obstetrico
	if ($RiesgoObstHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcriegoobs' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['obt'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcriegoobs(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
	}
	// Control Paraclinico
	if ($CtrlParacObsHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  = '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcctrlparaobs' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['cpo'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcctrlparaobs(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
	}
	// Test de Framingham
	if ($FraminghamHCT=="1") {
		$SQL="Insert Into hcframingham(Codigo_TER, Codigo_HCF, Sexofr_HCA, Edadfr_HCA, TAsistfr_HCA, ColTfr_HCA, ColHDLfr_HCA, Medicadofr_HCA, Fumafr_HCA, Puntosfr_HCA, Riesgofr_HCA) Values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['sexofr']."', '".$_POST['edadfr']."', '".$_POST['tsafr']."', '".$_POST['totcfr']."', '".$_POST['hdlfr']."', '".$_POST['medicfr']."', '".$_POST['fumafr']."', '".$_POST['puntosfr']."', '".$_POST['porcfr']."');";
		EjecutarSQL($SQL, $conexion);
	}
	// Factores de Riesgo Cardiovascular
	if ($RiesgoCardVHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  = '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcriegocv' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['rcv'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcriegocv(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  = '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hctfg' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST[$rowHCA[0]]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hctfg(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
		// Laboratorios RCV
		$SQL="Select Codigo_SER from hcpqservicios where Codigo_PQT in ('Laboratorios RCV 1', 'Laboratorios RCV 2')";
		$resultLBRCV = mysqli_query($conexion, $SQL);
		while ($rowLBRCV = mysqli_fetch_row($resultLBRCV)) {
			$Vallb=$_POST["lbrcv".$rowLBRCV[0]];
			$Fechalb=$_POST["lbdrcv".$rowLBRCV[0]];
			// error_log($_POST["lbrcv".$rowLBRCV[0]]);
			// error_log($_POST["lbdrcv".$rowLBRCV[0]]);
			if($Vallb!="") {
				$SQL="Insert Into hclabsrcv(Codigo_TER, Codigo_HCF, Codigo_SER, Valor_LAB, Fecha_LAB) Values('".$_POST['codigoter']."', '".$ElFolio."', '".$rowLBRCV[0]."', '".$Vallb."', '".$Fechalb."');";
				// error_log($SQL);
				EjecutarSQL($SQL, $conexion);	
			}
		}
		mysqli_free_result($resultLBRCV);
		
	}
	// Control Prenatal
	if ($CtrlPreNatHCT=="1") {
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  = '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcctrlprentl' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST[$rowHCA[0]]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcctrlprentl(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);
	}
	// error_log('Val Heridas: '.$ValHeridasHCT);
	if ($ValHeridasHCT=="1") {
		for ($i = 1; $i <= 47; $i++) {
			for ($j = 1; $j <= 66; $j++) {
				if (isset($_POST['VH'.$j.'-'.$i])) {
					$SQL="Insert Into hcubicanatom(Codigo_TER, Codigo_HCF, PosX_HUA, PosY_HUA) Values('".$_POST['codigoter']."', '".$ElFolio."', '".$j."', '".$i."');";
					// error_log($SQL);
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	}
	// ANTECEDENTES
	if ($Antecedentes_HCT!="0") {
		// Personales
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcant_personales' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['ant'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcant_personales(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);

		// Toxicologicos
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcant_toxicologico' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['ant'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcant_toxicologico(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);

		// Alergicos
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcant_alergico' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['ant'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcant_alergico(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);

		// Familiares
		$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcant_familiar' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
		$resultHCA = mysqli_query($conexion, $SQL);
		$antRes=0;
		$campox="Codigo_TER, Codigo_HCF, ";
		$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			if($antRes!=0) { 
				$campox=$campox.", "; 
				$valorex=$valorex.", ";
			}
			$antRes++;
			$campox=$campox.$rowHCA[0];
			$valorex=$valorex."'".$_POST['ant'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
		}
		mysqli_free_result($resultHCA);
		$SQL="Insert Into hcant_familiar(".$campox.") Values(".$valorex.");";
		
		EjecutarSQL($SQL, $conexion);

		// Gineco Obstetricos
		if (isset($_POST["antgGravindez"])) {
			$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcant_ginecobst' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER')";
			$resultHCA = mysqli_query($conexion, $SQL);
			$antRes=0;
			$campox="Codigo_TER, Codigo_HCF, ";
			$valorex="'".$_POST['codigoter']."', '".$ElFolio."', ";
			while ($rowHCA = mysqli_fetch_row($resultHCA)) {
				if($antRes!=0) { 
					$campox=$campox.", "; 
					$valorex=$valorex.", ";
				}
				$antRes++;
				$campox=$campox.$rowHCA[0];
				$valorex=$valorex."'".$_POST['ant'.substr($rowHCA[0],0,strlen($rowHCA[0])-4)]."'";
			}
			mysqli_free_result($resultHCA);
			$SQL="Insert Into hcant_ginecobst(".$campox.") Values(".$valorex.");";
			
			EjecutarSQL($SQL, $conexion);
		}
		// ODONTOGRAMMA
		if (isset($_POST["TotRowsOdont"])) {
			// error_log($_POST["TotRowsOdont"]);
			$TotTtoOdont=$_POST["TotRowsOdont"];
			$TtosOdont="";
			for ($i = 1; $i <= $TotTtoOdont; $i++) {
				$TtosOdont=$TtosOdont.$_POST['Diente'.$i].'_'.$_POST['Cara'.$i].'_'.$_POST['EstadoD'.$i].'__';
			}
			$TtosOdont=substr($TtosOdont,0,-2);
			$SQL="Insert Into hcodontograma(Codigo_TER, Codigo_HCF, Estados_ODG, Nota_ODG) Values('".$_POST["codigoter"]."', '".$ElFolio."', '".$TtosOdont."', '".$_POST["odontodesc"]."')";
			EjecutarSQL($SQL, $conexion);
		}
		/*$totalant=$_POST['controwantX'];
		if ($totalant>0) {
			for ($i = 1; $i <= $totalant; $i++) {
				if (isset($_POST['tantecedente'.$i])) {
					$SQL="Insert Into hcantecedentes(Codigo_TER, Codigo_HCF, Consec_HCA, Codigo_HCA, Descripcion_HCA) values('".$_POST['codigoter']."', '".$ElFolio."', '".$i."', '".$_POST['tantecedente'.$i]."', '".$_POST['dantecedente'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}*/
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
	// CONSULTAS
	// error_log('Cons HC:'.$Cons_HCT);
	if ($Cons_HCT!="0") {
		$totalOrdCons=$_POST['controwordcons'];
		if ($totalOrdCons>0) {
			$ConsecOrdCons=LoadConsec("hcordenescons", "Codigo_HCS", '0', $conexion, "Codigo_HCS");
			for ($i = 1; $i <= $totalOrdCons; $i++) {
				if (isset($_POST['codordcons'.$i])) {
					$SQL="Insert Into hcordenescons(Codigo_TER, Codigo_HCF, Codigo_HCS, Codigo_SER, Cantidad_HCS, Observaciones_HCS) values('".$_POST['codigoter']."', '".$ElFolio."', '".$ConsecOrdQx."', '".$_POST['codordcons'.$i]."', '".$_POST['cantordcons'.$i]."', '".$_POST['obsordcons'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	}
	// PROCEDIMIENTOS
	if ($QX_HCT!="0") {
		$totalOrdQx=$_POST['controwordqx'];
		if ($totalOrdQx>0) {
			$ConsecOrdQx=LoadConsec("hcordenesqx", "Codigo_HCS", '0', $conexion, "Codigo_HCS");
			for ($i = 1; $i <= $totalOrdQx; $i++) {
				if (isset($_POST['codordqx'.$i])) {
					$SQL="Insert Into hcordenesqx(Codigo_TER, Codigo_HCF, Codigo_HCS, Codigo_SER, Cantidad_HCS, Observaciones_HCS) values('".$_POST['codigoter']."', '".$ElFolio."', '".$ConsecOrdQx."', '".$_POST['codordqx'.$i]."', '".$_POST['cantordqx'.$i]."', '".$_POST['obsordqx'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	}
	// PARACLINICOS
	if ($AyudasDiag_HCT!="0") {
		$totalHlpDx=$_POST['controwhlpdx'];
		if ($totalHlpDx>0) {
			$ConsecHlpDx=LoadConsec("hcordenesdx", "Codigo_HCS", '0', $conexion, "Codigo_HCS");

			$SQL="Select OrdHDxFac_XHC From itconfig_hc";
			$resultmx = mysqli_query($conexion, $SQL);
			while($rowmx = mysqli_fetch_row($resultmx)) {
				$ConsecDxFac=$rowmx[0];
			}
			mysqli_free_result($resultmx);
			if ($ConsecDxFac!='0') {
				$ConsecDxFac=LoadConsec("gxordenescab","Codigo_ORD", '0', $conexion, "Codigo_ORD");
				$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$ConsecDxFac."', '".(int)$_POST['ingreso']."', now(), '".$_POST['area']."', 'ORDEN GENERADA POR HC-AYUDASDX',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizacion']."')";
				EjecutarSQL($SQL, $conexion);
			}
			
			// Se genera solicitud de examen
			$SQL="Insert Into lbsolicitudes(Codigo_SLB, Tipo_SLB, Origen_CNX, Codigo_ORD, Codigo_TER, Estado_SLB, Codigo_USR, Institucion_TER, Fecha_SLB, Codigo_ARE)
			Values ('".$ConsecHlpDx."', 'O', '0', '', '".$_POST['codigoter']."','0', '".$_SESSION["it_CodigoUSR"]."', 'X', now(), '".$_POST['area']."');";
			EjecutarSQL($SQL, $conexion);
			for ($i = 1; $i <= $totalHlpDx; $i++) {
				if (isset($_POST['codhlpdx'.$i])) {
					$SQL="Insert Into hcordenesdx(Codigo_TER, Codigo_HCF, Codigo_HCS, Codigo_SER, Cantidad_HCS, Observaciones_HCS) values('".$_POST['codigoter']."', '".$ElFolio."', '".$ConsecHlpDx."', '".$_POST['codhlpdx'.$i]."', '".$_POST['canthlpdx'.$i]."', '".$_POST['obshlpdx'.$i]."')";
					EjecutarSQL($SQL, $conexion);
					$ConsecExam=LoadConsec("lbexamenes", "Codigo_EXA", '0', $conexion, "Codigo_EXA");
					$SQL="Insert Into lbexamenes(Codigo_EXA, Codigo_SLB, Codigo_SER, Cantidad_EXA, Observaciones_EXA, Estado_EXA) Values ('".$ConsecExam."', '".$ConsecHlpDx."', '".$_POST['codhlpdx'.$i]."', '".$_POST['canthlpdx'.$i]."', '".$_POST['obshlpdx'.$i]."', '0');";
					EjecutarSQL($SQL, $conexion);
					if ($ConsecDxFac!='0') {
						$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER) Values ('".$ConsecDxFac."', '".$_POST['codhlpdx'.$i]."', ".$_POST['canthlpdx'.$i].", '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$CodMED."')";
						EjecutarSQL($SQL, $conexion);
					}
				}
			}
		}
	}
	// INSUMOS
	if ($Insumos_HCT!="0") {
		$totalIns=$_POST['controwins'];
		if ($totalIns>0) {
			for ($i = 1; $i <= $totalIns; $i++) {
				if (isset($_POST['codinsumo'.$i])) {
					$SQL="Insert Into hcordenesins(Codigo_TER, Codigo_HCF, Codigo_SER, Cantidad_SER, Observaciones_SER) values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['codinsumo'.$i]."', '".$_POST['cantinsumo'.$i]."', '".$_POST['observins'.$i]."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
		}
	}
	if ($Med_HCT!="0") {
	// ORDENES DE MEDICAMENTOS
		$totalmed=$_POST['controwMed'];
		if ($totalmed>0) {
			$ConsecMed=LoadConsec("hcordenesmedica", "Codigo_HCM", '0', $conexion, "Codigo_HCM");
			$ConsecMInv='0';
			$ConsecMFact='0';
			$SQL="Select OrdMedInv_XHC, OrdMedFac_XHC From itconfig_hc";
			$resultmx = mysqli_query($conexion, $SQL);
			while($rowmx = mysqli_fetch_row($resultmx)) {
				$ConsecMInv=$rowmx[0];
				$ConsecMFact=$rowmx[1];
			}
			mysqli_free_result($resultmx);
			if ($ConsecMInv!='0') {
				$ConsecMInv=LoadConsec("czinvsolfarmacia", "Codigo_ISF", '0', $conexion, "Codigo_ISF");
			}
			if ($ConsecMFact!='0') {
				$ConsecMFact=LoadConsec("gxordenescab","Codigo_ORD", '0', $conexion, "Codigo_ORD");
				if ($totalmed>0) {
					$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$ConsecMFact."', '".(int)$_POST['ingreso']."', now(), '".$_POST['area']."', 'ORDEN GENERADA POR HC-MEDICAMENTOS',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizacion']."')";
					EjecutarSQL($SQL, $conexion);
				}
			}
							
			for ($i = 1; $i <= $totalmed; $i++) {
				if (isset($_POST['codmed'.$i])) {
					$SQL="Insert Into hcordenesmedica(Codigo_TER, Codigo_HCF, Codigo_HCM, Codigo_SER, Dosis_HCM, Via_HCM, Frecuencia_HCM, Duracion_HCM, Cantidad_HCM, Pendiente_HCM, Estado_HCM, Observaciones_HCM) values('".$_POST['codigoter']."', '".$ElFolio."', '".$ConsecMed."', '".$_POST['codmed'.$i]."', '".$_POST['dosis'.$i]."', '".$_POST['via'.$i]."', '".$_POST['frecuencia'.$i]."', '".$_POST['duracion'.$i]."', '".$_POST['cantmed'.$i]."','".$_POST['cantmed'.$i]."','".$_POST['estadomed'.$i]."', '".$_POST['obsmed'.$i]."')";
					EjecutarSQL($SQL, $conexion);
					// SOLICITUD A INVENTARIO
					if ($ConsecMInv!='0') {
						if ($_POST['estadomed'.$i]=="O") {
							$SQL="Insert into czinvsolfarmacia(Codigo_TER, Codigo_HCF, Codigo_ISF, Codigo_SER, Formula_ISF, Cantidad_ISF, Pendiente_ISF, Estado_ISF, Fecha_ISF, Hora_ISF, Codigo_ADM, Codigo_ARE, Ordena_ISF) Values('".$_POST['codigoter']."', '".$ElFolio."', '".$ConsecMInv."', '".$_POST['codmed'.$i]."', 'DOSIS: ".$_POST['dosis'.$i]." | VÍA: ".$_POST['via'.$i]." | FRECUENCIA: ".$_POST['frecuencia'.$i]." | DURACION: ".$_POST['duracion'.$i]."', '".$_POST['cantmed'.$i]."','".$_POST['cantmed'.$i]."','P', date(NOW()), TIME(NOW()), '".$_POST['ingreso']."', '".$_POST['area']."', '".$_SESSION["it_CodigoUSR"]."')";
							EjecutarSQL($SQL, $conexion);
						}
					}
					// ORDEN DE SERVICIO A FACTURACION
					if ($ConsecMFact!='0') {
						$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER) Values ('".$ConsecMFact."', '".$_POST['codmed'.$i]."', ".$_POST['cantmed'.$i].", '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$CodMED."')";
						EjecutarSQL($SQL, $conexion);
					}
				}
			}
		}
	}
	// error_log('Ordenes:'.$Ordenes_HCT);
	if ($Ordenes_HCT!="0") {
	// ORDENES DE SERVICIOS
		$totalmed=$_POST['controwTer'];
		// error_log('TotOrd:'.$totalmed);
		for ($i = 1; $i <= $totalmed; $i++) {
			if (isset($_POST['tipot'.$i])) {
				$SQL="Insert Into hcordenesservicios(Codigo_TER, Codigo_HCF, Codigo_SER, TipoSer_HCS, Frecuencia_HCS, Duracion_HCS, Cantidad_HCS, Observaciones_HCS) values('".$_POST['codigoter']."', '".$ElFolio."', '------', '".$_POST['tipot'.$i]."', '".$_POST['frecuenciat'.$i]."', '".$_POST['duraciont'.$i]."', '".$_POST['cantt'.$i]."', '".$_POST['obster'.$i]."')";
				// error_log('SQL:'.$SQL);
				EjecutarSQL($SQL, $conexion);
			}
		}
	}
	// INDICACIONES Y TRATAMIENTO
	if ($Indicaciones_HCT!="0") {
		$TotTto=$_POST["controwTto"];
		for ($i = 1; $i <= $TotTto; $i++) {
			if (isset($_POST['indicacion'.$i])) {
				$SQL="Insert Into hctratamiento(Codigo_TER, Codigo_HCF, Codigo_HTT, Indicacion_HTT) Values ('".$_POST['codigoter']."', '".$ElFolio."', '".$i."', '".$_POST['indicacion'.$i]."')";
				EjecutarSQL($SQL, $conexion);
			}
		}
		if ($_POST['anlytrat']!="") {
			$SQL="Insert Into hcanalisis(Codigo_TER, Codigo_HCF, Analisis_HCA) Values('".$_POST['codigoter']."', '".$ElFolio."', '".$_POST['anlytrat']."')";
			EjecutarSQL($SQL, $conexion);
		}
	} 
	// INCAPACIDAD
	if ($Incapacidad_HCT!="0") { 
		if ($_POST["diasincap"]>0) {
			$SQL="Insert Into hcincapacidades(Codigo_TER, Codigo_HCF, Fecha_INC, Codigo_HCI, FechaIni_HCI, Dias_HCI, FechaFin_HCI, Codigo_HMI, Codigo_HTI, Observaciones_INC) Values('".$_POST['codigoter']."', '".$ElFolio."', date(now()), '".$_POST["claseincap"]."', '".$_POST["fecincapini"]."', '".$_POST["diasincap"]."', '".$_POST["fecincapfin"]."', '".$_POST["motivoincap"]."','".$_POST["tipoincap"]."','".$_POST["observincap"]."')";
			EjecutarSQL($SQL, $conexion);
		}
	}
	// FIRMA DE MEDICO 2
	if ($Medico2_HCT!="0") {
		$SQL="Update hcfolios set Medico2_HCF='".$_POST['medico2']."' Where Codigo_HCF='".$ElFolio."' and Codigo_TER='".$_POST['codigoter']."' and Codigo_HCT='".$_POST['formatohc']."'";
		EjecutarSQL($SQL, $conexion);
	}
	
	// GUARDAR CAMPOS DE LA HC
	$SQL1="Insert Into hc_".strtolower($_POST['formatohc'])."(Codigo_TER, Codigo_HCF, ";
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
	// GENERAR ORDEN DE SERVICIO EN CUENTA DEL PACIENTE
	if ($OrdXHCEPS=="1") {
		if ($_POST["codigoser"]!="0") {
			$Consec=LoadConsec("gxordenescab", "Codigo_ORD", "0000000000", $conexion, "LPAD(Codigo_ORD,10,'0')");
			$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$Consec."', '".(int)$_POST['ingreso']."', now(), '".$_POST['area']."', 'ORDEN GENERADA POR HC',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizacion']."')";
			EjecutarSQL($SQL, $conexion);
			// buscamos el codigo del profesional
			$CodMED="0";
			$SQL="Select Codigo_TER from gxmedicos Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
			$resultMEd = mysqli_query($conexion, $SQL);
			if($rowMed = mysqli_fetch_row($resultMEd)) {
				$CodMED=$rowMed[0];
			}
			mysqli_free_result($resultMEd);
			$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER) Values ('".$Consec."', '".$_POST["codigoser"]."', 1, '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$CodMED."')";
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxordenesdet b, gxmanualestarifarios c, gxcontratos d Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where b.Codigo_ORD='".$Consec."' and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER and date(now()) between c.FechaIni_TAR and c.FechaFin_TAR";
			EjecutarSQL($SQL, $conexion);
		}
		// Cargar proc quirúrgico
		if ($DescQxHCT=="1") {
			$Consec=LoadConsec("gxordenescab", "Codigo_ORD", "0000000000", $conexion, "LPAD(Codigo_ORD,10,'0')");
			$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Values ('".$Consec."', '".(int)$_POST['ingreso']."', now(), '".$_POST['area']."', 'ORDEN GENERADA POR HC - Qx',  '".$_SESSION["it_CodigoUSR"]."', '1', '".$_POST['autorizacion']."')";
			EjecutarSQL($SQL, $conexion);
			// buscamos el codigo del profesional
			$CodMED="0";
			$SQL="Select Codigo_TER from gxmedicos Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
			$resultMEd = mysqli_query($conexion, $SQL);
			if($rowMed = mysqli_fetch_row($resultMEd)) {
				$CodMED=$rowMed[0];
			}
			mysqli_free_result($resultMEd);
			$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER) Values ('".$Consec."', '".$_POST["qxproc"]."', 1, '".TRIM($_POST['contrato'])."', '".$_POST['plan']."', '".$CodMED."')";
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxordenesdet b, gxmanualestarifarios c, gxcontratos d Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where b.Codigo_ORD='".$Consec."' and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER and date(now()) between c.FechaIni_TAR and c.FechaFin_TAR";
			EjecutarSQL($SQL, $conexion);
		}
	}
	it_aud('1', 'Historia Clínica', 'Tercero '.$_POST['codigoter'].' - Folio Int. '.$ElFolio);

include '99trnsctns.php';

?>