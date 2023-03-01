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
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Courier','',8);
    //Número de página
	$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'T',0,'L',0);	
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='ct_accounting_x_t'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@DETALLE",$_GET["DETALLE"],$SQL);
    $SQL=str_replace("@FECHA_INICIAL",$_GET["FECHA_INICIAL"],$SQL);
    $SQL=str_replace("@FECHA_FINAL",$_GET["FECHA_FINAL"],$SQL);
    $SQL=str_replace("@TERCERO",$_GET["TERCERO"],$SQL);
    $SQL=str_replace("@CUENTA",$_GET["CUENTA"],$SQL);
}
mysqli_free_result($result);


$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('AUXILIAR POR TERCEROS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 11);
$pdf->AddPage();
$pdf->SetFillColor(225);
$Empresa="";
$Clase="";
$Nivel="";
$ACTIVOS=0;
$PASIVOS=0;
$PATRIMONIO=0;
$Line=4;
$result = mysqli_query($conexion, $SQL);
// echo $SQL;


        $pdf->SetY(5);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,6,'AUXILIAR POR TERCERO','',0,'C',0); //Razon Social
        $pdf->Ln();
        $pdf->SetFont('Arial','B',9);
        //$pdf->Cell(0,6,'NIT '.$row[1],'',0,'C',0);
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        //$pdf->Cell(0,6,utf8_decode('Auxiliar por Terceros '),'B',0,'C',0);
        $pdf->Cell(0,6,'LISTADO DE AUXILIARES ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
        $pdf->SetY(9);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();

        $pdf->Cell(32,7,'CODIGO CUENTA','BR',0,'C',0);
        $pdf->Cell(55,7,'DESCRIPCION DE CUENTA','BR',0,'C',0);
        $pdf->Cell(25,7,'ID TERCERO','BR',0,'C',0);
        $pdf->Cell(44,7,'NOMBRE TERCERO','BR',0,'C',0);
        $pdf->Cell(20,7,'DEBITOS','BR',0,'C',0);
        $pdf->Cell(20,7,'CREDITOS','BR',0,'C',0);
        $pdf->SetY(40);
    

while($row = mysqli_fetch_row($result)) {
    // Encabezado de la tabla

  

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(32,7,$row[0],'',0,'C',0); 
        $pdf->Cell(55,7,$row[1],'',0,'C',0); 
        $pdf->Cell(25,7,$row[2],'',0,'C',0); 
        $pdf->Cell(44,7,$row[3],'',0,'C',0); 
        $pdf->Cell(20,7,$row[4],'',0,'C',0); 
        $pdf->Cell(20,7,$row[5],'',0,'C',0); 
        $pdf->Ln();

    
   
}
mysqli_free_result($result);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,$Line,utf8_decode(''.$Clase),'T',0,'L',1); 
$pdf->Cell(0,$Line,number_format('',2,'.',','),'T',0,'R',1); 
$pdf->Ln();
$pdf->Ln();

$pdf->SetY(-30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,$Line,' ','',0,'L',0); 
$pdf->Cell(50,$Line,'REPRESENTANTE LEGAL','T',0,'C',0); 
$pdf->Cell(10,$Line,' ','',0,'L',0); 
$pdf->Cell(50,$Line,'CONTADOR','T',0,'C',0); 
$pdf->Cell(10,$Line,' ','',0,'L',0); 
$pdf->Cell(50,$Line,'REVISOR FISCAL','T',0,'C',0); 
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>