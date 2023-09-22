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
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',7,5,25);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->MultiCell(0,7,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(22);
$this->SetFont('Arial','B',11);
$this->Cell(0,10,'LISTADO DE POLIZAS EMITIDAS ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',7);
$this->Cell(21,5,'Poliza','BR',0,'C',0);
$this->Cell(15,5,'Fecha','BR',0,'C',0);
$this->Cell(24,5,'Cliente','BR',0,'C',0);
$this->Cell(18,5,'Plan','BR',0,'C',0);
$this->Cell(13,5,'Voucher','BR',0,'C',0);
$this->Cell(7,5,'Edad','BR',0,'C',0);
$this->Cell(13,5,'Modalidad','BR',0,'C',0);
$this->Cell(14,5,'F. Inicial','BR',0,'C',0);
$this->Cell(14,5,'F. Final','BR',0,'C',0);
$this->Cell(6,5,'Dias','BR',0,'C',0);
$this->Cell(16,5,'Origen','BR',0,'C',0);
$this->Cell(18,5,'Destino','BR',0,'C',0);
$this->Cell(10,5,'U$','BR',0,'C',0);
$this->Cell(14,5,'Pesos','BR',0,'C',0);
$this->Cell(10,5,'Dscto','BR',0,'C',0);
$this->Cell(14,5,'Total','BR',0,'C',0);
$this->Cell(0,5,'Asesor','B',0,'C',0);
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
    $this->Cell(100,5,html_entity_decode('Powered By: KL\'UD '),'T',0,'L');
	$this->SetFont('Arial','',8);
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='kventaslocal'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
    $SQL=str_replace("@USUARIO",$_SESSION["it_CodigoUSR"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('REPORTE LOCAL DE VENTAS POR PERIODO');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(9, 9, 7);
$pdf->SetAutoPageBreak(true, 18);
//echo $SQL;
$agencia="";
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
//$pdf->SetY(39);
$pdf->SetFillColor(255);
$totalent=0;
$totalfacts=0;
while($row = mysqli_fetch_row($result)) {
    if ($agencia!=$row[5]) {
        $positiony=$pdf->GetY();
        $pdf->SetY(18);
        if ($agencia!="") {
            $pdf->AddPage();
        }
        $agencia=$row[5];
        $pdf->Cell(0,6,'AGENCIA: '.$agencia,'',0,'C',0); 
        $pdf->SetY($positiony);
        $pdf->SetY(39);
    }
$pdf->SetFont('Arial','',7);

$pdf->Cell(21,4,$row[0].'-'.$row[1],'',0,'L',0); //INGRESO
$pdf->Cell(15,4,FormatoFecha(substr($row[2],0,10)),'',0,'C',0); //DOCUMENTO
$pdf->SetFont('Arial','',6);
$pdf->Cell(24,4,ucwords(strtolower(utf8_decode($row[4]))),'',0,'L',1); //TIPO
$pdf->Cell(18,4,ucwords(strtolower(utf8_decode($row[6]))),'',0,'L',1); //ESTADO
$pdf->Cell(13,4,$row[7],'',0,'L',1); //ESTADO
$pdf->SetFont('Arial','',7);
$pdf->Cell(7,4,$row[8],'',0,'R',1); //ESTADO
$pdf->Cell(13,4,ucwords(strtolower(utf8_decode($row[9]))),'',0,'R',1); //ESTADO
$pdf->Cell(14,4,FormatoFecha($row[10]),'',0,'R',1); //ENTIDAD
$pdf->Cell(14,4,FormatoFecha($row[11]),'',0,'L',1); //ENTIDAD
$pdf->Cell(6,4,$row[12],'',0,'L',1); //ENTIDAD
$pdf->Cell(16,4,utf8_decode($row[13]),'',0,'L',1); //ENTIDAD
$pdf->Cell(18,4,utf8_decode($row[14]),'',0,'L',1); //ENTIDAD
$pdf->Cell(10,4,$row[15],'',0,'R',1); //ENTIDAD
$pdf->Cell(14,4,number_format($row[16],0,'.',','),'',0,'R',1); //ENTIDAD
$pdf->Cell(10,4,number_format($row[17],0,'.',','),'',0,'R',1); //ENTIDAD
$pdf->Cell(14,4,number_format($row[18],0,'.',','),'',0,'R',1); //ENTIDAD
$pdf->Cell(0,4,utf8_decode($row[19]),'',0,'L',1); //ENTIDAD
$pdf->Ln();
$totalent=$totalent+$row[18];
$totalfacts++;
}
mysqli_free_result($result);
//mysqli_close();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(180,6,"Polizas emitidas en el periodo: ".$totalfacts,'T',0,'L',1); //ESTADO
$pdf->Cell(0,6,number_format($totalent,2,'.',','),'T',0,'R',1); //ESTADO
//Mostramos el informe
$pdf->Output();
?>