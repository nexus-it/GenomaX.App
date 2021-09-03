<?php

header('Content-type:application/xls');
header('Content-Disposition: attachment; filename='.$_GET["reporte"].'.xls');
session_start();

include '../../functions/php/nexus/database.php';	

$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);

	mysqli_query ($conexion, "SET NAMES 'utf8'");

require_once("phpspreadsheet/vendor/autoload.php"); 

$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, Descripcion_RPT, IfNULL(Subtitle_RPT,' ') from nxs_gnx.itreports where codigo_rpt='".$_GET["reporte"]."'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreReporte=$row[3];
	$Subtitulo=$row[4];
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
						$Subtitulo=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$Subtitulo);
					} else {
						$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
						$Subtitulo=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$Subtitulo);
					}
				} else {
					$SQL=str_replace("@".$tags[$i],$_GET[$tags[$i]],$SQL);
					$Subtitulo=str_replace("@".$tags[$i],$_GET[$tags[$i]],$Subtitulo);
				}
			}
		}
	}
}
mysqli_free_result($result);

// include "phpspreadsheet/index.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Nexus Information Technologies S.A.S.")
    ->setLastModifiedBy('GenomaX') 
    ->setTitle($NombreReporte)
    ->setSubject($Subtitulo)
    ->setDescription('Documento creado por genomax.co')
    ->setKeywords('GenomaX Nexus '.$NombreReporte)
    ->setCategory('GNX NXS');
 
/**
 * Los siguientes encabezados son necesarios para que
 * el navegador entienda que no le estamos mandando
 * simple HTML
 * Por cierto: no hagas ningún echo ni cosas de esas; es decir, no imprimas nada
 */
 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $_GET["reporte"] . '.xlsx"');
header('Cache-Control: max-age=0');
 
$hoja = $documento->getActiveSheet();
$hoja->setTitle($NombreReporte);
$hoja->setCellValueByColumnAndRow(1, 1, $NombreReporte);
$hoja->setCellValueByColumnAndRow(1, 2, $Subtitulo);

$conta=0;

$result = mysqli_query($conexion, $SQL);
$totalcols = mysqli_num_fields($result);
while($totalcols>$conta){
	$Objectx=mysqli_fetch_field($result, $conta);
	$hoja->setCellValueByColumnAndRow($conta+1, 3,  $Objectx->name);
	$conta++;
} 

$xlsRow = 4;
while($row = mysqli_fetch_row($result)) {
	for($i=0;$i<$conta;$i++){
		$hoja->setCellValueByColumnAndRow($i, $xlsRow, utf8_decode($row[$i]));
	}
	$xlsRow++;
}

mysqli_free_result($result);
// $hoja->setCellValue("B2", "Este va en B2");
// $hoja->setCellValue("A3", "Parzibyte");
 
$writer = IOFactory::createWriter($documento, 'Xlsx');
$writer->save('php://output');
exit;


?>