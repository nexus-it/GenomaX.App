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
$this->MultiCell(0,6,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(16);
$this->SetFont('Arial','B',11);
$this->Cell(0,10,'PAGOS RECIBIDOS','',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='pagoscartera'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
    $SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
	$SQL=str_replace("@CODIGO_FINAL",($_GET["CODIGO_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('PAGOS RECIBIDOS EN CARTERA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$Uno=1;
while($row = mysqli_fetch_row($result)) {
    if($Uno==1) {
        $pdf->SetY(18);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(0,7,'No. '.$row[0],'',0,'R',0);
        $pdf->Ln();
        $pdf->Cell(100,7,'Fecha: '.$row[1],'',0,'L',0);
        $pdf->Cell(0,7,'Tercero: '.$row[2],'',0,'R',0);
        $pdf->Ln();
        $pdf->Cell(100,7,'Forma de Pago: '.$row[3],'',0,'L',0);
        $pdf->Cell(0,7,'Cuenta Banco: '.$row[4],'',0,'R',0);
        $pdf->Ln();
        $pdf->Cell(100,7,'Valor: $'.$row[5],'',0,'L',0);
        $pdf->Cell(0,7,'Estado Pago: '.$row[8],'',0,'R',0);

        $pdf->Ln();
        $Uno=0;
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(27,6,'FACTURA','BRT',0,'C',0);
        $pdf->Cell(20,6,'F. FACT.','BTR',0,'C',0);
        $pdf->Cell(14,6,'# RAD.','BTR',0,'C',0);
        $pdf->Cell(20,6,'F. CARTERA.','TBR',0,'C',0);
        $pdf->Cell(25,6,'VAL. FACT.','BTR',0,'C',0);
        $pdf->Cell(25,6,'N. DEB.','BTR',0,'C',0);
        $pdf->Cell(25,6,'N.CRED.','BTR',0,'C',0);
        $pdf->Cell(25,6,'PAGADO','RTB',0,'C',0);
        $pdf->Cell(25,6,'SALDO ANTES','RTB',0,'C',0);
        $pdf->Cell(25,6,'ABONO','BTR',0,'C',0);
        $pdf->Cell(25,6,'SALDO','BT',0,'C',0);
        $pdf->Ln();
    }
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(27,5,$row[9],'',0,'L',0); //INGRESO
    $pdf->Cell(20,5,$row[10],'',0,'L',0); //DOCUMENTO
    $pdf->Cell(14,5,$row[11],'',0,'C',0); //ESTADO
    $pdf->Cell(20,5,$row[12],'',0,'C',0); //ESTADO
    $pdf->Cell(25,5,$row[13],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[14],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[15],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[16],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[17],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[18],'',0,'R',0); //ESTADO
    $pdf->Cell(25,5,$row[19],'',0,'R',0); //ESTADO
    $pdf->Ln();
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>