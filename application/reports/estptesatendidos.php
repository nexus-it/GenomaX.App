<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';	
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
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
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
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
$this->Cell(0,10,'LISTADO DE PACIENTES ATENDIDOS ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',9);
$this->Cell(18,6,'FECHA','BLR',0,'C',0);
$this->Cell(18,6,'HORA','BR',0,'C',0);
$this->Cell(28,6,'HISTORIA','BR',0,'C',0);
$this->Cell(65,6,'PACIENTE','BR',0,'C',0);
$this->Cell(50,6,'TIPO HISTORIA','BR',0,'C',0);
$this->Cell(0,6,'FOLIO','BR',0,'C',0);
$this->SetY(40);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'B',0,'L',0);	
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','B',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='estptesatendidos'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$Orientation=$row[2];
	$FormatoPagina=$row[1];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('PACIENTES ATENDIDOS ');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(42);
$pdf->SetFillColor(255);
while($row = mysqli_fetch_row($result)) {
$pdf->SetFont('Arial','',9);
$pdf->Cell(25,6,$row[0],'',0,'C',0); //INGRESO
$pdf->Cell(32,7,$row[1],'',0,'C',0); //FECHA
$pdf->Cell(32,7,$row[2].' '.$row[3],'',0,'L',0); //DOCUMENTO
$pdf->Cell(55,6,utf8_decode(ucwords(strtolower($row[4]))),'',0,'L',0); //PACIENTE
$pdf->Cell(25,6,$row[8],'',0,'L',1); //TIPO
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,utf8_decode($row[10]),'',0,'L',1); //ENTIDAD
$pdf->SetFont('Arial','',9);
$pdf->Cell(21,6,$row[6],'',0,'L',1); //ESTADO
$pdf->Cell(20,6,'{'.$row[11].'}'.$row[12],'',0,'L',1); //ESTADO
$pdf->Ln();
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
}
$pdf->Output();
?>