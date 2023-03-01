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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='inventariosolfarm'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@CODIGO_INICIAL",$_GET["CODIGO_INICIAL"],$SQL);
    $SQL=str_replace("@CODIGO_FINAL",$_GET["CODIGO_FINAL"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('SOLICITUD A FARMACIA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
$pdf->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,2,50); 
$pdf->SetY(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,6,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,6,'NIT '.$row[2],'',0,'C',0);
$pdf->Ln();
$pdf->SetY(9);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(135);
$pdf->Cell(0,6,utf8_decode('Asiento Contable'),'',0,'R',0);
$pdf->Ln();
$pdf->SetFont('Courier','B',13);
$pdf->SetTextColor(4,8,0);
$pdf->Cell(0,6,'No. '.$row[0],'',0,'R',0); //Numero NC 
$pdf->SetTextColor(0);

$pdf->SetY(25);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Tipo Comprobante: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(75,5,utf8_decode($row[5]),'',0,'L',0); //CodigoCaja
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'No. Comprobante: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,$row[3].'-'.$row[4],'',0,'L',0); //No Factura
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Referencia:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(75,5,utf8_decode($row[7]),'',0,'L',0); //Identificacion eps
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Fecha: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,utf8_decode($row[6]),'',0,'L',0); //Nombre Tercero
$pdf->Ln();
$SQL="SELECT Sigla_TID, ID_TER, a.Codigo_CTA, a.Descripcion_CNT, Nombre_CCT, Debito_CNT, Credito_CNT From czmovcontdet a LEFT JOIN czterceros b ON a.Codigo_TER=b.Codigo_TER LEFT JOIN cztipoid e ON b.Codigo_TID=e.Codigo_TID LEFT JOIN czcentrocosto d ON a.Codigo_CCT=d.Codigo_CCT Where Codigo_CNT=".$row[0]." Order By 2";
//echo $SQL;
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(135);
$pdf->Cell(0,4,'Detalle De Movimiento Contable','',0,'R',0); //Concepto Nota
$pdf->SetFillColor(152,252,167);
$pdf->SetTextColor(25);
$pdf->Ln();
$pdf->SetDrawColor(152,252,167);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(22,4,'TERCERO','L',0,'C',1); //Concepto Nota
$pdf->Cell(80,4,'CUENTA CONTABLE','L',0,'C',1); //Concepto Nota
$pdf->Cell(40,4,'CENTRO DE COSTO','L',0,'C',1); //Concepto Nota
$pdf->Cell(26,4,'DEBITO','L',0,'C',1); //Concepto Nota
$pdf->Cell(0,4,'CREDITO','LR',0,'C',1); //Concepto Nota
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_row($resultz)) {
    $pdf->SetFont('Arial','',8);
    $pdf->Ln();
    $pdf->Cell(22,4,$rowz[0].' '.$rowz[1],'L',0,'L',1); //Concepto Nota
    $pdf->Cell(17,4,$rowz[2],'L',0,'L',1); //Concepto Nota
    $pdf->Cell(63,4,$rowz[3],'',0,'L',1); //Concepto Nota
    $pdf->Cell(40,4,$rowz[4],'L',0,'L',1); //Concepto Nota
    $pdf->Cell(26,4,'$ '.number_format($rowz[5],2,'.',','),'L',0,'R',1);
    $pdf->Cell(0,4,'$ '.number_format($rowz[6],2,'.',','),'LR',0,'R',1); //Concepto Nota
}
mysqli_free_result($resultz);
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(102,4,'','T',0,'L',1); //Concepto Nota
$pdf->SetFillColor(152,252,167);
$pdf->Cell(40,4,'Total','TBL',0,'C',1); //Concepto Nota
$pdf->Cell(26,4,'$ '.number_format($row[9],2,'.',','),'BTL',0,'R',1); //Concepto Nota
$pdf->Cell(0,4,'$ '.number_format($row[9],2,'.',','),'LBTR',0,'R',1); //Concepto Nota
$pdf->SetFillColor(255);
$pdf->SetDrawColor(0);
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Observaciones:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode(strtoupper($row[8])),0); //Descripcion
$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,'Valor en Letras: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode(strtoupper(ValorLetras($row[9]))),0); //Descripcion
$pdf->Cell(0,1,'','T',0,'L',0); //Concepto Nota
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',8);
$pdf->Cell(65,4,'Elaborado por:','TL',0,'L',1); 
$pdf->Cell(65,4,'','L',0,'L',1); 
if ($row[11]=="I" ) {
    $pdf->Cell(0,4,'Pagado por:','TLR',0,'L',1); 
} else {
    $pdf->Cell(0,4,'Recibido por:','TLR',0,'L',1); 
}
$pdf->Ln();
$pdf->Cell(65,16,'','L',0,'L',1); 
$pdf->Cell(65,16,'','L',0,'L',1); 
$pdf->Cell(0,16,'','LR',0,'L',1); 
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(65,4,$row[16],'LB',0,'C',1); 
$pdf->Cell(65,4,'','L',0,'LB',1); 
$pdf->Cell(0,4,'Firma Tercero','BLR',0,'C',1); 

}
mysqli_free_result($result);


//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>