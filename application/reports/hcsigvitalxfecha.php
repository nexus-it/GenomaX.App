<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';	
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");


class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;
function PDF($orientation='P',$unit='mm',$format='Letter')
{
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}
function Header()
{
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQLH="SELECT RazonSocial_DCD, NIT_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
}
mysqli_free_result($resultH);
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',1,1,0);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->MultiCell(0,7,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(22);
$this->SetFont('Arial','B',11);
$this->Cell(0,10,'CUADRO DE SIGNOS VITALES EN EL PERIODO DEL '.$_GET["FECHA_INICIAL"].' AL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',10);
$this->Cell(23,6,'HISTORIA','BR',0,'C',0);
$this->Cell(70,6,'PACIENTE','BR',0,'C',0);
$this->Cell(10,6,'SEXO','BR',0,'C',0);
$this->Cell(25,6,'FEC. NAC.','BR',0,'C',0);
$this->Cell(25,6,'ATENCION','BR',0,'C',0);
$this->Cell(15,6,'T/A','BR',0,'C',0);
$this->Cell(15,6,'FC','BR',0,'C',0);
$this->Cell(15,6,'FR','BR',0,'C',0);
$this->Cell(15,6,'PESO','BR',0,'C',0);
$this->Cell(15,6,'TALLA','RB',0,'C',0);
$this->Cell(15,6,'TEMP','RB',0,'C',0);
$this->Cell(0,6,'IMC','B',0,'C',0);
$this->SetY(39);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
    $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='hcsigvitalxfecha'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
    $SQL=str_replace("@PACIENTE",$_GET["PACIENTE"],$SQL);
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('CUADRO DE SIGNOS VITALES');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(41);
$pdf->SetFillColor(255);
while($row = mysqli_fetch_row($result)) {
$pdf->SetFont('Arial','',8);
$pdf->Cell(23,5,$row[0].' '.$row[1],'',0,'L',0); //INGRESO
$pdf->Cell(70,5,utf8_decode($row[2]),'',0,'L',1); //DOCUMENTO
$pdf->Cell(10,5,$row[3],'',0,'C',1); //ESTADO
$pdf->Cell(25,5,$row[4],'',0,'C',1); //ESTADO
$pdf->Cell(25,5,$row[5],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[6],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[7],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[8],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[9],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[10],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[11],'',0,'L',1); //ESTADO
$pdf->Cell(15,5,$row[12],'',0,'L',1); //ESTADO
$pdf->Ln();
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>