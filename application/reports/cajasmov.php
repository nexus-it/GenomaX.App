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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='cajasmov'";
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
$pdf->Settitle('COMPROBANTE DE MOVIMIENTO DE CAJA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
if (trim($row[15])=="0") {
    $pdf->Image('../../anulado.jpg',25,1,0);
}
$pdf->SetY(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,6,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,6,'NIT '.$row[2],'',0,'C',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,utf8_decode('COMPROBANTE MOVIMIENTO DE CAJA '),'B',0,'C',0);
$pdf->SetY(9);
$pdf->Ln();
$pdf->SetFont('Courier','B',13);
$pdf->Cell(0,6,'No. '.$row[0],'',0,'R',0); //Numero NC 

$pdf->SetY(25);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,utf8_decode('Código Caja: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(75,5,utf8_decode('['.$row[3].'] - '.$row[4].' ('.$row[6].')'),'',0,'L',0); //CodigoCaja
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Fecha : ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,$row[5],'',0,'L',0); //No Factura
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Tercero:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(75,5,$row[7],'',0,'L',0); //Identificacion eps
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Nombre: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,utf8_decode($row[8]),'',0,'L',0); //Nombre Tercero
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Movimiento: ','',0,'L',0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(75,5,$row[10],'',0,'L',0); //Concepto Nota
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Tipo Ingreso: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$tIPiNGR="- - - - -";
if ($row[11]=="I" ) {
    $SQL="Select Nombre_TIC from cztipoingresocaja Where Codigo_TIC='".$row[12] ."'";
    $resultx = mysqli_query($conexion, $SQL);
    if ($rowx = mysqli_fetch_array($resultx)) {
        $tIPiNGR=$rowx[0];
    } 
    mysqli_free_result($resultx);
}
$pdf->Cell(0,5,$tIPiNGR,'',0,'L',0); //valor NC
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'CONCEPTO:','',0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,5,utf8_decode($row[13]),0); //Descripcion
$tOTmOV=0;
$ConsecCaja=$row[0];
$SQL="Select Consec_MCJ, concat(TipoPago_MCJ,' ',Nombre_FPG), Codigo_BCO, Documento_MCJ, CuentaBco_MCJ, Valor_MCJ 
From czmovcajadet a, czformasdepago b Where a.TipoPago_MCJ=b.Codigo_FPG and LPAD(a.Codigo_MCJ,10,'0')='".$row[0]."' Order By 1,2";
//echo $SQL;
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(135);
$pdf->Cell(0,4,'Detalle De Movimiento de Caja','',0,'R',0); //Concepto Nota
$pdf->SetFillColor(170);
$pdf->SetTextColor(255);
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,'FORMA DE PAGO','',0,'C',1); //Concepto Nota
$pdf->Cell(25,4,'COD. BANCO','',0,'C',1); //Concepto Nota
$pdf->Cell(42,4,'DOCUMENTO','',0,'C',1); //Concepto Nota
$pdf->Cell(42,4,'CUENTA','',0,'C',1); //Concepto Nota
$pdf->Cell(0,4,'VALOR','',0,'C',1); //Concepto Nota
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetFont('Courier','',10);
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_row($resultz)) {
    $pdf->Ln();
    $pdf->Cell(50,4,$rowz[1],'',0,'L',1); //Concepto Nota
    $pdf->Cell(25,4,$rowz[2],'',0,'L',1); //Concepto Nota
    $pdf->Cell(42,4,$rowz[3],'',0,'L',1); //Concepto Nota
    $pdf->Cell(42,4,$rowz[4],'',0,'L',1); //Concepto Nota
    $pdf->Cell(0,4,number_format($rowz[5],2,'.',','),'',0,'R',1); //Concepto Nota
    $tOTmOV=$tOTmOV+$rowz[5];
}
mysqli_free_result($resultz);
$pdf->Ln();
$pdf->Cell(0,1,'','T',0,'L',0); //Concepto Nota
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Observaciones:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode(strtoupper($row[14])),0); //Descripcion
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,5,'VALOR TOTAL: ','T',0,'L',0);
$pdf->Cell(0,4,number_format($tOTmOV,2,'.',','),'T',0,'R',1); //Concepto Nota
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,'Valor en Letras: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode(strtoupper(ValorLetras($tOTmOV))),0); //Descripcion
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