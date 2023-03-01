<?php





session_start();

require_once("../../functions/php/nexus/export-excel.php");

include 'rutafpdf.php';

include '../../functions/php/nexus/database.php';	

$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);

	mysqli_query ($conexion, "SET NAMES 'utf8'");







$NombreEmpresa="";

$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, Descripcion_RPT from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='".$_GET["reporte"]."'";

$result = mysqli_query($conexion, $SQL);

if ($row = mysqli_fetch_row($result)) {

	$SQL=$row[0];

	$FormatoPagina=$row[1];

	$Orientation=$row[2];

	$NombreReporte=$row[3];

	$numero = count($_GET);

	$tags = array_keys($_GET);

	$valores = array_values($_GET);

	for($i=0;$i<$numero;$i++){

		if ($tags[$i]!="reporte") {

			if (substr($tags[$i],0,7)=="USUARIO") {

				$SQL=str_replace("@USUARIO",$_SESSION["it_CodigoUSR"],$SQL);

			} else {

				if (substr($tags[$i],0,5)=="FECHA") {

					if ($tags[$i]=="FECHA_INICIAL") {

						$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);

					} else {

						$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);

					}

					/* $SQL=str_replace("@".$tags[$i],($_GET[$tags[$i]]),$SQL); */

				} else {

					$SQL=str_replace("@".$tags[$i],$_GET[$tags[$i]],$SQL);

				}

			}

			//$SQL=$SQL.' tag:'.substr($tags[$i],1,5);

		}

	}

}

mysqli_free_result($result);

createExcel($NombreReporte.'.xls');

xlsBOF();

$conta=0;

$result = mysqli_query($conexion, $SQL);

$totalcols = mysqli_num_fields($result);

while($totalcols>$conta){

	$Objectx=mysqli_fetch_field($result, $conta);

	xlsWriteLabel(0,$conta,$Objectx->name);

	$conta++;

} 

$xlsRow = 1;



//echo $SQL;

while($row = mysqli_fetch_row($result)) {

	for($i=0;$i<$conta;$i++){

		xlsWriteLabel($xlsRow,$i,utf8_decode($row[$i]));

	}

	$xlsRow++;

}

mysqli_free_result($result);

//mysqli_close();

xlsEOF();

exit();
?>