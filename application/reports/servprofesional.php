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
$this->Cell(0,10,'SERVICIOS CARGADOS POR PROFESIONAL ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',10);
$this->Cell(140,7,'SERVICIO','LBR',0,'C',0);
$this->Cell(0,7,'CANTIDAD','BR',0,'C',0);
$this->SetY(40);
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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='servprofesional'";
//echo $SQL;
$resultS = mysqli_query($conexion, $SQL);
if ($rowS = mysqli_fetch_row($resultS)) {
    $SQL=$rowS[0];
    $FormatoPagina=$rowS[1];
    $Orientation=$rowS[2];
    $NombreEmpresa=$rowS[3];
    $SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
    $SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
    $SQL=str_replace("@PROFESIONAL1",$_GET["PROFESIONAL1"],$SQL);
    $SQL=str_replace("@PROFESIONAL2",$_GET["PROFESIONAL2"],$SQL);
}
mysqli_free_result($resultS);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('SERVICIOS POR PROFESIONAL');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(42);
$pdf->SetFillColor(255);
$SEDE="";
$PROFESIONAL="";
$PACIENTE="";
while($row = mysqli_fetch_row($result)) {
    if ($SEDE!=$row[4]){
        $pdf->SetFillColor(100);
        $pdf->Cell(0,2,'    ','',0,'L',0); 
        $pdf->Ln();
        $SEDE=$row[4];
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,6,'Sede:  '.strtoupper($SEDE),'',0,'R',1); 
        $pdf->Ln();
    }
    if ($PROFESIONAL!=$row[3]){
        $pdf->SetFillColor(155);
        $pdf->Cell(0,2,'    ','',0,'L',0); 
        $pdf->Ln();
        $PROFESIONAL=$row[3];
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,6,'::  '.$PROFESIONAL,'',0,'L',1); 
        $pdf->Ln();
    }
    if ($PACIENTE!='Ingreso: '.$row[5].' - Paciente:'.$row[6]){
        $pdf->SetFillColor(253);
        $pdf->Cell(0,2,'    ','',0,'L',0); 
        $pdf->Ln();
        $PACIENTE='Ingreso: '.$row[5].' - Paciente: '.$row[6];
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,5,$PACIENTE,'TBLR',0,'L',1); 
        $pdf->Ln();
    }
$pdf->SetFillColor(255);
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,5,$row[1],'BLR',0,'L',1); //INGRESO
$pdf->Cell(25,5,$row[2],'BLR',0,'C',1); //FECHA
$pdf->Cell(0,5,'','BLR',0,'C',1); //FECHA
$pdf->Ln();
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>