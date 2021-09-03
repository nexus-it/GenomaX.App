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
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
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
$this->Cell(0,10,'LISTADO DE NOTAS CREDITO EMITIDAS ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(32);
$this->SetFont('Arial','B',8);
$this->Cell(18,6,'No NOTA','BR',0,'C',0);
$this->Cell(16,6,'FECHA','BR',0,'C',0);
$this->Cell(22,6,'DOCUMENTO','BR',0,'C',0);
$this->Cell(16,6,'FECHA DOC','BR',0,'C',0);
$this->Cell(24,6,'TERCERO','BR',0,'C',0);
$this->Cell(45,6,'NOMBRE','BR',0,'C',0);
$this->Cell(26,6,'ENTIDAD','BR',0,'C',0);
$this->Cell(17,6,'VALOR','BR',0,'C',0);
$this->Cell(17,6,'SALDO','BR',0,'C',0);
$this->Cell(0,6,'U','BR',0,'C',0);
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
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from nxs_gnx.itreports, itconfig where codigo_rpt='listarnotascreditofecha'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('LISTADO NOTAS CREDITO POR PERIODO');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(9, 9, 7);
$pdf->SetAutoPageBreak(true, 18);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(39);
$pdf->SetFillColor(255);
$totalnota=0;
$totalfacts=0;
while($row = mysqli_fetch_row($result)) {
$pdf->SetFont('Arial','',8);
$NoFact=trim($row[0]);

$pdf->Cell(18,5,$row[0],'',0,'C',0); //INGRESO
$pdf->Cell(16,5,$row[1],'',0,'C',0); //FECHA
$pdf->Cell(22,5,$row[2],'',0,'C',0); //DOCUMENTO
$pdf->Cell(16,5,$row[3],'',0,'L',0); //PACIENTE
$pdf->Cell(24,5,$row[4],'',0,'L',1); //TIPO
$pdf->Cell(45,5,ucwords(strtolower($row[5])),'',0,'L',1); //ENTIDAD
$pdf->Cell(26,5,$row[7],'',0,'L',1); //ESTADO
$pdf->Cell(17,5,number_format($row[8],0,'.',','),'',0,'R',1); //ESTADO
$pdf->Cell(17,5,number_format($row[9],0,'.',','),'',0,'R',1); //ESTADO
$pdf->Cell(0,5,$row[10],'',0,'L',1); //ESTADO
$pdf->Ln();
$totalnota=$totalnota+$row[8];
$totalfacts++;
}
mysqli_free_result($result);
//mysqli_close();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(170,6,"Notas credito elaboradas en el periodo: ".$totalfacts,'T',0,'L',1); //ESTADO
$pdf->Cell(0,6,number_format($totalnota,2,'.',','),'T',0,'R',1); //ESTADO
//Mostramos el informe
$pdf->Output();
?>