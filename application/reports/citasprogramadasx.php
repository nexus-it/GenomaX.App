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

$SQLH="Select RazonSocial_DCD, NIT_DCD from itconfig";
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
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetTextColor(255);
$this->SetFillColor(190);
$this->SetFont('Arial','B',8);
$this->Cell(10,6,'No.','R',0,'C',1);
$this->Cell(14,6,'HORA','R',0,'C',1);
$this->Cell(23,6,'DOCUMENTO','R',0,'C',1);
$this->Cell(62,6,'PACIENTE','R',0,'C',1);
$this->Cell(10,6,'EDAD','R',0,'C',1);
$this->Cell(8,6,'SEXO','R',0,'C',1);
$this->Cell(30,6,'TELEFONO','R',0,'C',1);
$this->Cell(35,6,'DIRECCION','R',0,'C',1);
$this->Cell(0,6,'ENTIDAD','',0,'C',1);
$this->SetY(40);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,html_entity_decode('Powered By: GenomaX '),'T',0,'L');
	$this->SetFont('Arial','',8);
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$OtraPage="";
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='citasprogramadasx'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
    $SQL=str_replace("@MEDICO",$_GET["MEDICO"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('LISTADO CITAS PROGRAMADAS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 18);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
//Encabezado de la tabla
$pdf->SetY(42);
$pdf->SetFillColor(255);
$totalpte=0;

 while($row = mysqli_fetch_row($result)) {
    $Concat=$row[0].$row[1].$row[2].$row[3].$row[4].$row[5];
    if ($Concat!=$OtraPage) {
        $pdf->AddPage();
        $OtraPage=$Concat;
        $pdf->SetY(20);
        $totalpte=0;
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(100,5,'Area: '.utf8_decode($row[1]),'',0,'L',0);      
        $pdf->Cell(0,5,''.utf8_decode($row[3].'-'.$row[4]),'',0,'R',0);  
        $pdf->Ln();    
        $pdf->Cell(100,5,'Lugar: '.utf8_decode($row[2]),'',0,'L',0);      
        $pdf->Cell(0,5,''.utf8_decode($row[5]),'',0,'R',0);  
        $pdf->SetY(24);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,5,'PLANILLA PACIENTES PROGRAMADOS '.$row[0],'',0,'C',0);      
        $pdf->SetFont('Arial','',8);
        $pdf->SetY(40);
    }
$totalpte++;
$pdf->SetFont('Arial','',8);
$NoFact=trim($row[0]);

$pdf->Cell(10,6,$totalpte,'',0,'C',0); //INGRESO
$pdf->Cell(14,6,utf8_decode($row[6]),'',0,'C',0); //FECHA
$pdf->Cell(23,6,utf8_decode($row[7].' '.$row[8]),'',0,'L',0); //DOCUMENTO
$pdf->Cell(62,6,utf8_decode($row[9]),'',0,'L',0); //PACIENTE
$pdf->Cell(10,6,utf8_decode($row[10]),'',0,'C',1); //TIPO
$pdf->Cell(8,6,utf8_decode($row[11]),'',0,'C',1); //TIPO
$pdf->Cell(30,6,utf8_decode($row[12]),'',0,'L',1); //ENTIDAD
$pdf->Cell(35,6,utf8_decode($row[13]),'',0,'L',1); //ESTADO
$pdf->Cell(0,6,utf8_decode($row[14]),'',0,'L',1); //ESTADO
$pdf->Ln();
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>