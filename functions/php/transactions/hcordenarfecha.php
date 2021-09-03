<?php

include '00trnsctns.php';

	$totalnc=$_POST['controwhcf'];
	$xyz=1;
	$kfolios=0;
	//FECHA Y HRA DEL FOLIO
	while($xyz <= $totalnc) {
		//FOLIOS A ELIMINAR
		if(isset($_POST['chknohc'.$xyz])) {
			if($_POST['chknohc'.$xyz]=="1") {
				$SQL="update hcfolios Set Codigo_TER='X".$_POST['codigoter']."', Codigo_ADM=concat('X',Codigo_ADM) Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCT='".$_POST['tipohc'.$xyz]."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				// BORRAMOS DEMAS TABLAS...
				$SQL="Delete From hcantecedentes Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcconsentinformados Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcdiagnosticos Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcglasgow Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcincapacidades Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcnotas Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcodontograma Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcordenesdx Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcordenesmedica Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcordenesqx Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcordenesservicios Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcpypdata Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hcsignosvitales Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hctratamiento Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				$SQL="Delete From hc_".$_POST['tipohc'.$xyz]." Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
				
			} 

			if($_POST['chngdt'.$xyz]=="1") {
				$SQL="Update hcfolios Set Fecha_HCF='".$_POST['fechahc'.$xyz]."', Hora_HCF='".$_POST['timehc'.$xyz]."' Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCT='".$_POST['tipohc'.$xyz]."' and Codigo_HCF='".$_POST['folio'.$xyz]."';";
				EjecutarSQL($SQL, $conexion);
			}
			$kfolios=$kfolios+1;
		}
		$xyz++;
	}
	$MSG="SE ACTUALIZARON ".$kfolios." FOLIOS DE ".$totalnc;
	//ACTUALIZAR NUMERO DE FOLIO
	$contaFolios=0;
	$SQL="Select Codigo_HCF, Codigo_HCT From hcfolios Where Codigo_TER='".$_POST['codigoter']."' Order By Fecha_HCF asc, Hora_HCF asc;";
	$resulty = mysqli_query($conexion, $SQL);
	while($rowy = mysqli_fetch_row($resulty)) {
		$contaFolios++;
		$NumFolio=$rowy[0];
		$SQL="Update hcfolios set Folio_HCF=".$contaFolios."  Where Codigo_TER='".$_POST['codigoter']."' and Codigo_HCF=".$NumFolio.";";
		EjecutarSQL($SQL, $conexion);
	}
	mysqli_free_result($resulty);
	$SQL="INSERT INTO hcfolios_old(Codigo_TER,  Codigo_HCT, Codigo_HCF, Fecha_HCF, Hora_HCF, Codigo_ADM, Codigo_ARE, Nota_HCF, FecNota_HCF, FechaReg_HCF, Codigo_USR, Medico2_HCF) SELECT  Codigo_TER,  Codigo_HCT, Codigo_HCF, Fecha_HCF, Hora_HCF, Codigo_ADM, Codigo_ARE, Nota_HCF, FecNota_HCF, now(), Codigo_USR, Medico2_HCF FROM hcfolios WHERE codigo_ter like 'X%'";
	EjecutarSQL($SQL, $conexion);

	$SQL="DELETE FROM hcfolios WHERE codigo_ter like 'X%'";
	EjecutarSQL($SQL, $conexion);

	it_aud('2', 'HC Folios', 'Ordenacion Tercero: '.$_POST['codigoter']);

include '99trnsctns.php';

?>