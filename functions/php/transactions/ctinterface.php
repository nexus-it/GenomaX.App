<?php

include '00trnsctns.php';

$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='itconfig_ct' ORDER BY ORDINAL_POSITION;";
$rstColumns = mysqli_query($conexion, $SQL);
while($rowColumns = mysqli_fetch_array($rstColumns)) {
    $SQL="Update itconfig_ct Set ".$rowColumns[0]."='".$_POST[$rowColumns[0]]."';";
    EjecutarSQL($SQL, $conexion);
}
mysqli_free_result($rstColumns); 

	it_aud('1', 'Configuracion Contabilidad', 'Parametros Contables');

include '99trnsctns.php';

?>