<?php

include '00trnsctns.php';
  $nxsTabla=$_POST["nxsTabla"];
  error_log('MasterDB table: '.$nxsTabla);
  $SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='".$nxsTabla."' ORDER BY ORDINAL_POSITION;";
  error_log('MasterDB Describe: '.$SQL);
  $rstColumns = mysqli_query($conexion, $SQL);
  $jk=0;
  $Kampox="";
  $Valorez="";
  $Dexcribe = array();
  while ($rowCols = mysqli_fetch_row($rstColumns)) {
  	$Kampox=$Kampox.$rowCols[0].", ";
  	$Valorez=$Valorez."'".$_POST[str_replace('_', '', $rowCols[0])]."', ";
	$jk++;
	$Dexcribe['COLUMN_NAME'.$jk] = $rowCols[0];
	$Dexcribe['COLUMN_DEFAULT'.$jk] = $rowCols[1];
	$Dexcribe['DATA_TYPE'.$jk] = $rowCols[2];
	$Dexcribe['CHARACTER_MAXIMUM_LENGTH'.$jk] = $rowCols[3];
	$Dexcribe['COLUMN_TYPE'.$jk] = $rowCols[4];
	$Dexcribe['COLUMN_KEY'.$jk] = $rowCols[5];
	$Dexcribe['COLUMN_COMMENT'.$jk] = $rowCols[6];
	}
  mysqli_free_result($rstColumns);
  $Kampox=substr($Kampox, 0,strlen($Kampox)-2);
  $Valorez=substr($Valorez, 0,strlen($Valorez)-2);

  $SQL="Replace Into ".$nxsTabla."(".$Kampox.") Values (".$Valorez.");";
  error_log('MasterDB: '.$SQL);
  EjecutarSQL($SQL, $conexion);
  $MSG='Datos registrados correctamente. '.$nxsTabla;
	
  it_aud('1', '[nxs]Master DB', $nxsTabla.': '.$Kampox.' => '.$Valorez);

include '99trnsctns.php';

?>