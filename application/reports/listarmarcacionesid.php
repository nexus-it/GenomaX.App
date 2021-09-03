<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';
if (isset($_GET["DB_HOST"])) {
	
	include '../../config.php';
	$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	mysqli_query ($conexion, "SET NAMES 'utf8'");
} else {
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
}
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
if (isset($_GET["DB_HOST"])) {
	$conexion = mysqli_connect($_GET["DB_HOST"], $_GET["DB_USER"], $_GET["DB_PASSWORD"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
} else {
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
}
$SQLH="SELECT RazonSocial_DCD, NIT_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
}
mysqli_free_result($resultH);
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',7,3,75);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->MultiCell(0,7,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(22);
$this->SetFont('Arial','B',11);
$this->Cell(0,10,'LISTADO DE MARCACIONES ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '/*.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"]*/,'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',10);
$this->Cell(25,6,'FECHA','BR',0,'C',0);
$this->Cell(25,6,'HORA','BR',0,'C',0);
$this->Cell(28,6,'DOCUMENTO','BR',0,'C',0);
$this->Cell(60,6,'EMPLEADO','BR',0,'C',0);
$this->Cell(56,6,'CARGO','BR',0,'C',0);
$this->Cell(28,6,'EMPRESA','BR',0,'C',0);
$this->Cell(38,6,'MARCACION','B',0,'C',0);
$this->SetY(40);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
	$this->Cell(100,7,'(*) Registros marcados con asterisco fueron ingresados de manera manual.','T',0,'L');
    //Número de página
    $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from nxs_gnx.itreports, itconfig where codigo_rpt='listarmarcacionesid'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
	$SQL=str_replace("@EMPRESA",$_GET["EMPRESA"],$SQL);
	$SQL=str_replace("@EMPLEADO",$_GET["EMPLEADO"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('LISTADO MARCACIONES ID NEXUS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(39);
$pdf->SetFillColor(255);
while($row = mysqli_fetch_row($result)) {
$pdf->SetFont('Arial','',9);
$pdf->Cell(25,5,FormatoFecha($row[1]),'',0,'C',0); //INGRESO
$pdf->Cell(25,5,$row[2],'',0,'C',0); //FECHA
$pdf->Cell(28,5,$row[3],'',0,'L',0); //DOCUMENTO
$pdf->Cell(60,5,ucwords(strtolower(utf8_decode($row[4]))),'',0,'L',0); //PACIENTE
$pdf->Cell(56,5,utf8_decode($row[5]),'',0,'L',1); //TIPO
$pdf->SetFont('Arial','',8);
$pdf->Cell(28,5,$row[6],'',0,'L',1); //ENTIDAD
$pdf->Cell(37,5,$row[7],'',0,'L',1); //ENTIDAD
if (trim($row[8])!='-') {
	$pdf->Cell(1,5,'*','',0,'C',1); //ENTIDAD
}
$pdf->Ln();
}
mysqli_free_result($result);
//Mostramos el informe
$pdf->Output();
?>