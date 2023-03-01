<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';
if (isset($_GET["DB_HOST"])) {
	
	include '../../config.php';
	$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	mysqli_query ($conexion, "SET NAMES 'utf8'");
} else {
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQLH="SELECT RazonSocial_DCD, NIT_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
}
mysqli_free_result($resultH);
$this->Image('../../logo.jpg',7,3,50);
$this->SetY(16);
$this->SetFont('Courier','',8);
$this->MultiCell(0,7,"          NIT: ".$NIT,'','L',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',8);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(12);
$this->SetFont('Arial','B',13);
$this->Cell(0,10,'HOJA DE VIDA EQUIPO DE COMPUTO','B',0,'C',0);
$this->SetY(40);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Número de página
    $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
//Conectamos con Fomplus...
$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala;";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	//echo $row[1].'-'.$row[2].'-'.$row[3].'-'.$row[0];
	$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
	mssql_select_db('Intranet', $conexionFPx);
}
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='hvpc'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@TIPOEQ",$_GET["TIPOEQ"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('HOJAS DE VIDA EQUIPOS COMPUTO');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$resultFPx = mssql_query($SQL, $conexionFPx);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(39);
$pdf->SetFillColor(255);
while($rowFPx = mssql_fetch_row($resultFPx)) {
$pdf->SetFont('Arial','',9);
$pdf->Cell(25,5,FormatoFecha($rowFPx[1]),'',0,'C',0); //INGRESO
$pdf->Cell(25,5,$rowFPx[2],'',0,'C',0); //FECHA
$pdf->Cell(28,5,$rowFPx[3],'',0,'L',0); //DOCUMENTO
$pdf->Cell(60,5,ucwords(strtolower(utf8_decode($rowFPx[4]))),'',0,'L',0); //PACIENTE
$pdf->Cell(56,5,utf8_decode($rowFPx[5]),'',0,'L',1); //TIPO
$pdf->SetFont('Arial','',8);
$pdf->Cell(28,5,$rowFPx[6],'',0,'L',1); //ENTIDAD
$pdf->Cell(37,5,$rowFPx[7],'',0,'L',1); //ENTIDAD
if (trim($rowFPx[8])!='-') {
	$pdf->Cell(1,5,'*','',0,'C',1); //ENTIDAD
}
$pdf->Ln();
}
mssql_free_result($result);
//Mostramos el informe
$pdf->Output();
?>