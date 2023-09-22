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
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Courier','',8);
    //Número de página
	$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'B',0,'L',0);	
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','B',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='ct_balancesheet'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@DETALLE",$_GET["DETALLE"],$SQL);
    $SQL=str_replace("@FECHA_FINAL",$_GET["FECHA_FINAL"],$SQL);
}
mysqli_free_result($result);


$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('BALANCE GENERAL');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFillColor(215);
$Empresa="";
$Clase="";
$Nivel="";
$UtiBruta=0;
$UtiOper=0;
$UtiAntes=0;
$UtiNeta=0;
$Line=4;
$result = mysqli_query($conexion, $SQL);
// echo $SQL;
while($row = mysqli_fetch_row($result)) {
    // Encabezado de la tabla
    if ($row[0]!=$Empresa) {
        $Empresa=$row[0];
        $pdf->SetY(5);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,6,$row[0],'',0,'C',0); //Razon Social
        $pdf->Ln();
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(0,6,'NIT '.$row[1],'',0,'C',0);
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,6,utf8_decode('Balance General Hasta '.$_GET["FECHA_FINAL"]),'B',0,'C',0);
        $pdf->SetY(9);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
    }
    // Titulo de Clase
    if ($row[4]!=$Clase) {
        $taB=0;
        if($Clase!="") {
            // Totalizamos
            $pdf->SetFont('Arial','B',10);
            switch ($Clase) {
                case 'Costo de Ventas':
                    $pdf->Cell(150-$taB,$Line,utf8_decode('Utilidad Bruta'),'',0,'L',1); 
                    $pdf->Cell(0,$Line,number_format($UtiBruta,2,'.',','),'T',0,'R',1); 
                    $pdf->Ln();
                    $pdf->Ln();
                break;
                case 'Gastos de Operación':
                    $UtiOper=$UtiBruta+$UtiOper;
                    $pdf->Cell(150-$taB,$Line,utf8_decode('Utilidad Operacional'),'',0,'L',1); 
                    $pdf->Cell(0,$Line,number_format($UtiOper,2,'.',','),'T',0,'R',1); 
                    $pdf->Ln();
                    $pdf->Ln();
                break;
                case 'Costos Financieros':
                    $UtiAntes=$UtiOper+$UtiAntes;
                    $pdf->Cell(150-$taB,$Line,utf8_decode('Utilidad Antes de Impuestos'),'',0,'L',1); 
                    $pdf->Cell(0,$Line,number_format($UtiAntes,2,'.',','),'T',0,'R',1); 
                    $pdf->Ln();
                    $pdf->Ln();
                break;
                case 'Gastos por Impuestos':
                    $pdf->Cell(150-$taB,$Line,utf8_decode('Resultado del Periodo'),'',0,'L',1); 
                    $pdf->Cell(0,$Line,number_format($UtiNeta,2,'.',','),'T',0,'R',1); 
                    $pdf->Ln();
                    $pdf->Ln();
                break;
            }            
        }
        $Clase=$row[4];
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(150-$taB,$Line,utf8_decode($Clase),'',0,'L',0); 
        $pdf->Ln();
    } 
    // Controlar Cambio de Nivel
    $Nivel=$row[2];
    switch ($Nivel) {
        case "2":
            $pdf->SetFont('Courier','B',10);
            $taB=5;
            
        break;
        case "3":
            $pdf->SetFont('Courier','',9);
            $taB=10;
            switch ($Clase) {
                case 'Ingresos':
                    if($row[8]=="+") {
                        $UtiBruta=$UtiBruta+$row[9];
                    } else {
                        $UtiBruta=$UtiBruta-$row[9];
                    }
                break;
                case 'Costo de Ventas':
                    if($row[8]=="+") {
                        $UtiBruta=$UtiBruta+$row[9];
                    } else {
                        $UtiBruta=$UtiBruta-$row[9];
                    }
                break;
                case 'Ingresos No Operacionales':
                    if($row[8]=="+") {
                        $UtiOper=$UtiOper+$row[9];
                    } else {
                        $UtiOper=$UtiOper-$row[9];
                    }
                break;
                case 'Gastos de Operación':
                    if($row[8]=="+") {
                        $UtiOper=$UtiOper+$row[9];
                    } else {
                        $UtiOper=$UtiOper-$row[9];
                    }
                break;
                case 'Ingresos Financieros':
                    if($row[8]=="+") {
                        $UtiAntes=$UtiAntes+$row[9];
                    } else {
                        $UtiAntes=$UtiAntes-$row[9];
                    }
                break;
                case 'Costos Financieros':
                    if($row[8]=="+") {
                        $UtiAntes=$UtiAntes+$row[9];
                    } else {
                        $UtiAntes=$UtiAntes-$row[9];
                    }
                break;
                case 'Gastos por Impuestos':
                    if($row[8]=="+") {
                        $UtiNeta=$UtiNeta+$row[9];
                    } else {
                        $UtiNeta=$UtiNeta-$row[9];
                    }
                break;
            }
            
        break;
                
    }

    $pdf->Cell($taB,$Line,'','',0,'L',0);
    
    $pdf->Cell(150-$taB,$Line,utf8_decode($row[6]),'',0,'L',0);
    $pdf->Cell(0,$Line,number_format($row[9],2,'.',','),'',0,'R',0); 
    $pdf->Ln();
}
mysqli_free_result($result);
$UtiNeta=$UtiAntes+$UtiNeta;
$pdf->SetFont('Arial','B',11);
$pdf->Cell(150,$Line,utf8_decode('Resultado del Periodo'),'',0,'L',1); 
$pdf->Cell(0,$Line,number_format($UtiNeta,2,'.',','),'T',0,'R',1); 
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