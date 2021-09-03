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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='cajascierre'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@IDCAJA",$_GET["IDCAJA"],$SQL);
    $SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
    $SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('COMPROBANTE DE CIERRE DE CAJA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,6,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,6,'NIT '.$row[2],'',0,'C',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,utf8_decode('COMPROBANTE CIERRE DE CAJA '),'B',0,'C',0);
$pdf->SetY(9);
$pdf->Ln();
$pdf->SetFont('Courier','B',13);
$pdf->Cell(0,6,'No. '.$row[0],'',0,'R',0); //Numero NC 

$pdf->SetY(25);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,utf8_decode('Código Caja: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,utf8_decode('['.$row[3].'] - '.$row[4]),'',0,'L',0); //CodigoCaja
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Fecha Apertura: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,5,$row[5],'',0,'L',0); //No Factura
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Saldo Inicial:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,$row[9],'',0,'L',0); //Identificacion eps
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Fecha Cierre: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,5,$row[10],'',0,'L',0); //Nombre Tercero
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Usuario Apertura: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,utf8_decode($row[12].' - '.$row[13]),'',0,'L',0); //Concepto Nota
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Saldo Final: ','',0,'L',0);
$pdf->SetFont('Courier','B',11);
$pdf->Cell(41,5,'$ '.number_format($row[11],2,'.',','),'',0,'L',0); //valor NC
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Usuario Cierre:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,utf8_decode($row[14].' - '.$row[15]),'',0,'L',0); //Concepto Nota
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,utf8_decode('Arrastra Saldo:'),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,5,utf8_decode($row[16]),'',0,'L',0); //Concepto Nota
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Saldo en Letras:','',0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,5,utf8_decode(strtoupper(ValorLetras($row[11]))),0); //Descripcion
$SQL="Select sum(b.Valor_MCJ) From czmovcajaenc a, czmovcajadet b, cztipomovcaja c Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and Estado_MCJ='1' and a.Codigo_CJA='".$row[3]."' and c.Naturaleza_TMC='I' and Consec_CJA='".$row[0]."' ";
$resultx = mysqli_query($conexion, $SQL);
if ($rowx = mysqli_fetch_array($resultx)) {
    $TotIngreso=$rowx[0];
} 
mysqli_free_result($resultx);
$SQL="Select sum(b.Valor_MCJ) From czmovcajaenc a, czmovcajadet b, cztipomovcaja c Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and Estado_MCJ='1' and a.Codigo_CJA='".$row[3]."' and c.Naturaleza_TMC='E' and Consec_CJA='".$row[0]."' ";
$resultx = mysqli_query($conexion, $SQL);
if ($rowx = mysqli_fetch_array($resultx)) {
    $TotEgreso=$rowx[0];
} 
mysqli_free_result($resultx);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(27,5,'Total Ingresos:','BT',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,number_format($TotIngreso,2,'.',','),'TB',0,'L',0); //Concepto Nota
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,utf8_decode('Total Egresos:'),'BT',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,number_format($TotEgreso,2,'.',','),'TB',0,'L',0); //Concepto Nota
$pdf->Ln();
$ConsecCaja=$row[0];
$SQL="Select date(a.Fecha_MCJ), time(a.Fecha_MCJ), c.Nombre_TMC, d.Nombre_TIC, b.Valor_MCJ, '0', id_ter, nombre_ter From czmovcajaenc a, czmovcajadet b, cztipomovcaja c, cztipoingresocaja d, czterceros e Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and d.Codigo_TIC=a.Codigo_TIC and e.codigo_ter=a.codigo_ter and a.Estado_MCJ='1' and c.Naturaleza_TMC='I' and a.Consec_CJA=".$ConsecCaja." Union Select date(a.Fecha_MCJ), time(a.Fecha_MCJ), c.Nombre_TMC, '', '0',b.Valor_MCJ, id_ter, nombre_ter From czmovcajaenc a, czmovcajadet b, cztipomovcaja c, czterceros e Where a.Codigo_MCJ=b.Codigo_MCJ and c.Codigo_TMC=a.Codigo_TMC and e.codigo_ter=a.codigo_ter and a.Estado_MCJ='1' and c.Naturaleza_TMC='E' and a.Consec_CJA=".$ConsecCaja." Order By 1,2";
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(135);
$pdf->Cell(50,4,'Detalle De Movimientos de Caja','',0,'L',0); //Concepto Nota
$pdf->SetFillColor(170);
$pdf->SetTextColor(255);
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,4,'FECHA','',0,'C',1); //Concepto Nota
$pdf->Cell(15,4,'HORA','',0,'C',1); //Concepto Nota
$pdf->Cell(53,4,'TIPO MOVIMIENTO','',0,'C',1); //Concepto Nota
$pdf->Cell(64,4,'TERCERO','',0,'C',1); //Concepto Nota
$pdf->Cell(26,4,'INGRESO','',0,'C',1); //Concepto Nota
$pdf->Cell(0,4,'EGRESO','',0,'C',1); //Concepto Nota
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_row($resultz)) {
    $pdf->Ln();
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(15,4,$rowz[0],'',0,'C',1); //Concepto Nota
    $pdf->Cell(15,4,$rowz[1],'',0,'C',1); //Concepto Nota
    $pdf->Cell(53,4,utf8_decode($rowz[2].' '.$rowz[3]),'',0,'L',1); //Concepto Nota
    $pdf->Cell(64,4,utf8_decode($rowz[6].' '.$rowz[7]),'',0,'L',1); //Concepto Nota
    $pdf->SetFont('Courier','',9);
    $pdf->Cell(26,4,number_format($rowz[4],0,'.',','),'',0,'R',1); //Concepto Nota
    $pdf->Cell(0,4,number_format($rowz[5],0,'.',','),'',0,'R',1); //Concepto Nota
}
$pdf->Ln();
$pdf->Cell(0,1,'','T',0,'L',0); //Concepto Nota
mysqli_free_result($resultz);
}
mysqli_free_result($result);


//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>