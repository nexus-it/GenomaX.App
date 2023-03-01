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
	
	
	$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',3,1,0);
	$SQL="Select Upper(z.Razonsocial_DCD), LPAD(a.Codigo_RAD,10,'0'), DATE_FORMAT(a.Fecha_RAD, '%d/%m/%Y'), Case a.Estado_RAD When '1' Then 'Sin Confirmar' When '2' Then 'Confirmado' End, DATE_FORMAT(a.FechaConf_RAD, '%d/%m/%Y'), d.Nombre_TER, a.Codigo_PLA, Concat(d.ID_TER,'-',d.DigitoVerif_TER), c.Codigo_EPS, Radicado_RAD From itconfig as z, czradicacionescab as a, gxeps as c, czterceros as d 
Where d.Codigo_TER=c.Codigo_TER and a.Codigo_EPS=c.Codigo_EPS
and LPAD(a.Codigo_RAD,10,'0')=LPAD('".$_GET["CODIGO_INICIAL"]."',10,'0')";
	$resultRAD = mysqli_query($conexion, $SQL);
	if ($rowRAD = mysqli_fetch_row($resultRAD)) {
		$this->SetY(3);
		$this->SetFont('Arial','B',13);
		$this->Cell(0,8,$rowRAD[0],'',0,'C',0); //Razon Social
		$this->SetY(30);
		$this->SetFont('Arial','B',10);
		$this->Cell(62,7,'Numero de Radicacion: '.$rowRAD[1],'',0,'L',0);
		$this->SetY(10);
		$this->Cell(0,6,'RADICACION DE CUENTAS','',0,'C',0);
		$this->SetY(30);
		$this->Cell(0,6,'Fecha de Radicacion '.$rowRAD[2],'',0,'R',0);		
		$this->SetY(35);
		$this->Cell(62,6,'Estado: '.$rowRAD[3].'  '.$rowRAD[9],'',0,'L',0);	
		if ($rowRAD[3]=="Confirmado") {
			$this->SetY(35);
			$this->Cell(0,6,'Fecha de Confirmacion: '.$rowRAD[4],'',0,'R',0);	
		}
		$this->SetY(42);
		$this->Cell(0,6,'ENTIDAD: '.$rowRAD[8].' - '.$rowRAD[5],'T',0,'L',0);	
		$this->SetY(47);
		$this->Cell(62,6,'NIT '.$rowRAD[7],'',0,'L',0);	
		$this->SetY(47);
		$SQL="Select Upper(Nombre_PLA) From gxplanes Where Codigo_PLA='".$rowRAD[6]."'";
		$resultRADp = mysqli_query($conexion, $SQL);
		if ($rowRADp = mysqli_fetch_row($resultRADp)) {
			$this->Cell(0,6,'PLAN: '.$rowRADp[0],'',0,'R',0);
		} else {
			$this->Cell(0,6,'PLAN: TODOS','',0,'R',0);
		}
	}
	mysqli_free_result($resultRAD);
	$this->SetFillColor(235);
	$this->SetY(55);
	$this->Cell(7,5,'#','TBL',0,'C',1);	
	$this->Cell(30,5,'FACTURA','TBL',0,'C',1);	
	$this->Cell(32,5,'DOCUMENTO','TBL',0,'C',1);	
	$this->Cell(78,5,'PACIENTE','TBL',0,'C',1);	
	$this->Cell(23,5,'FECHA FAC','TBL',0,'C',1);	
	$this->Cell(0,5,'VALOR','TBLR',0,'C',1);	
	$this->SetY(62);

	
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(19,5,utf8_decode('Powered By:'),'T',0,'L');
    $this->SetFont('Arial','B',7);
    $this->Cell(10,5,utf8_decode('GenomaX'),'T',0,'R');
    $this->SetFont('Arial','',6);
    $this->Cell(3,5,utf8_decode('.co'),'T',0,'R');
	$this->SetFont('Arial','',7);
	$this->Cell(145,5,'','T',0,'C');
    //$this->Cell(145,5,'Impreso por: {'.$_SESSION["it_CodigoUSR"].'} - '.$_SESSION["it_user"].'    Fecha: '.$PrintFecha,'T',0,'C');
	$this->SetFont('Courier','B',7);
	$this->SetTextColor(100,100,100);
	$this->SetFillColor(220);
    $this->Cell(0,5,utf8_decode('Pág').$this->PageNo().'/{nb}','T',0,'R',1);
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt, sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='radicaciones'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$FormatoPagina=$row[0];
	$Orientation=$row[1];
	$SQL=$row[2];
	$SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('RADICACION DE CUENTAS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 20,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
//Encabezado de la tabla
$pdf->SetFillColor(255);
//while($row = mysqli_fetch_row($result)) {

	$pdf->AddPage();

$resultH = mysqli_query($conexion, $SQL);
$total=0;
$cantfac=0;

while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->SetFont('Arial','',9);
	$NoFact=trim($rowH[0]);
	if (substr($NoFact,0,1 )=="-") {
		$NoFact=substr($NoFact,1,strlen($NoFact)-1);
	}
	$total=$total+$rowH[4];
	$cantfac++;
	$pdf->Cell(7,5,$cantfac,'',0,'R',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,5,$NoFact,'',0,'C',1);	
	$pdf->Cell(32,5,$rowH[1],'',0,'L',1);	
	$pdf->Cell(78,5,utf8_decode($rowH[2]),'',0,'L',1);	
	$pdf->Cell(23,5,$rowH[3],'',0,'C',1);	
	$pdf->Cell(0,5,number_format($rowH[4], 2, ",", "."),'',0,'R',1);	
	$pdf->Ln();
	}
	mysqli_free_result($resultH);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(70,6,'CANTIDAD : '.$cantfac.' FACTURAS','T',0,'L',1);		
	$pdf->Cell(0,6,'TOTAL RADICACION:  $ '.number_format($total, 2, ",", "."),'T',0,'R',1);		
//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>