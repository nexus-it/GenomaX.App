<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';
if (isset($_GET["DB_HOST"])) {
	$conexion = mysqli_connect($_GET["DB_HOST"], $_GET["DB_USER"], $_GET["DB_PASSWORD"]);
	
} else {
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
}
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
if (isset($_GET["DB_HOST"])) {
	$conexion = mysqli_connect($_GET["DB_HOST"], $_GET["DB_USER"], $_GET["DB_PASSWORD"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
} else {
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
}
$SQLH="SELECT RazonSocial_DCD, NIT_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
}
mysqli_free_result($resultH);
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',7,3,50);
$this->SetY(5);
$this->SetFont('Arial','B',11);
$this->MultiCell(0,5,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',8);
$this->Cell(0,5,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(22);
$this->SetFont('Arial','B',10);
$this->Cell(0,5,'RENDIMIENTO DIARIO EN REVISION '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',8);
$this->Cell(0,5,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(30);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
    $this->Cell(0,6,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
//Conectamos con Fomplus...
$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala;";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	//echo $row[1].'-'.$row[2].'-'.$row[3].'-'.$row[0];
	$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
	mssql_select_db($row[0], $conexionFPx);
}

$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='rendrevision'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
	$SQL=str_replace("@EMPLEADO",$_GET["EMPLEADO"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('RENDIMIENTO REVISION');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
$Empleado="";
$Fecha="";
$SumaD=0;
$ContaD=0;
$SumaT=0;
$ContaT=0;
$SumArea=0;
//	echo $SQL;
$result = mssql_query($SQL, $conexionFPx);
$pdf->AddPage();
$pdf->SetY(30);
while($row = mssql_fetch_row($result)) {
//Encabezado de la tabla
if ($Empleado!=$row[0]) {
	if ($Empleado!="") {
		if ($Fecha!="") {
			$pdf->Cell(180,5,"Total Trabajos Realizados el ".FormatoFecha($Fecha).": ",'TBL',0,'R',1); //
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,5,$SumaD,'TBLR',0,'R',1); 
			$SumaT=$SumaT+$SumaD;
			$SumArea=$SumArea+$SumaT;
			$ContaD++;
			$SumaD=0;
			$pdf->Ln();
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(160,5,"PROMEDIO DIARIO REVISION ".$Empleado.": ",'TBL',0,'R',1); //
		$pdf->Cell(0,5,number_format($SumaT/$ContaD, 2, ",", "."),'TBLR',0,'R',1); 
		$pdf->Ln();
	}
	$ContaD=0;
	$SumaT=0;
	$SumaD=0;
	$Fecha="";
	$Empleado=$row[0];
	$pdf->Ln();
	$pdf->SetFillColor(255);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,$row[0],'',0,'L',0); //NOMBRE
	$pdf->Ln();
}
if ($Fecha!=$row[1]) {
	if (($Fecha!="")&&($SumaD!=0)) {
		$pdf->Cell(180,5,"Total Trabajos Realizados el ".FormatoFecha($Fecha).": ",'TBL',0,'R',1); //
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(0,5,$SumaD,'TBLR',0,'R',1); 
		$SumaT=$SumaT+$SumaD;
		$SumArea=$SumArea+$SumaT;
		$ContaD++;
		$SumaD=0;
		$pdf->Ln();
	}
	$Fecha=$row[1];
	$pdf->SetFillColor(255);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'Fecha: '.FormatoFecha($row[1]),'TRL',0,'L',1); 
	$pdf->Ln();
	$pdf->SetFillColor(150);
	$pdf->SetTextColor(255);
	$pdf->Cell(20,5,"No. OP",'TBRL',0,'C',1); //
	$pdf->Cell(100,5,"Producto",'TBL',0,'C',1); //
	$pdf->Cell(20,5,"Hora Inicial",'TBL',0,'C',1); //
	$pdf->Cell(20,5,"Hora Final",'TBL',0,'C',1); //
	$pdf->Cell(20,5,"Total Horas",'TBL',0,'C',1); //
	$pdf->Cell(0,5,"Cantidad",'TBLR',0,'C',1); //
	$pdf->Ln();
	$ContaT++;
}

$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);
$pdf->SetFillColor(250);
$pdf->Cell(20,5,$row[2],'TBRL',0,'C',1); //
$pdf->Cell(100,5,$row[3],'TBRL',0,'L',1); //
$pdf->Cell(20,5,$row[4],'TBL',0,'C',1); //
$pdf->Cell(20,5,$row[5],'TBL',0,'C',1); //
$pdf->Cell(20,5,$row[6],'TBL',0,'R',1); //
$pdf->Cell(0,5,$row[7],'TBLR',0,'R',1); //
$pdf->Ln();
$SumaD=$SumaD+$row[7];
}
$pdf->Cell(180,5,"Total Trabajos Realizados el ".FormatoFecha($Fecha).": ",'TBL',0,'R',1); //
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,$SumaD,'TBLR',0,'R',1); 
$SumaT=$SumaT+$SumaD;
$SumArea=$SumArea+$SumaT;
$ContaD++;
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(160,5,"PROMEDIO DIARIO REVISION ".$Empleado.": ",'TBL',0,'R',1); //
$pdf->Cell(0,5,number_format($SumaT/$ContaD, 2, ",", "."),'TBLR',0,'R',1); 
$pdf->Ln();
$pdf->Ln();

$pdf->SetFillColor(150);
$pdf->SetTextColor(255);
$SQL="";
$pdf->SetFont('Arial','B',10);
$pdf->Cell(160,5,"PROMEDIO DIARIO GENERAL AREA REVISION: ",'TBL',0,'R',1); //
$pdf->Cell(0,5,number_format($SumArea/$ContaT, 2, ",", "."),'TBLR',0,'R',1); 

mssql_free_result($result);
//Mostramos el informe
$pdf->Output();
?>