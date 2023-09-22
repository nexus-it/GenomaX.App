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
$this->Cell(0,5,'MARCACIONES POR EMPLEADO ENTRE EL '.$_GET["FECHA_INICIAL"].' Y EL '.$_GET["FECHA_FINAL"],'B',0,'C',0);
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
	$this->Cell(100,6,'(*) Registros marcados con asterisco fueron ingresados de manera manual.','T',0,'L');
    //Número de página
    $this->Cell(0,6,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from ".$_SESSION['DB_NXS'].".itreports, itconfig where codigo_rpt='marcacionesempid'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL="Select distinct A.ID_TER, A.Nombre_TER, C.Nombre_CRG, E.Nombre_TCL  
From czterceros A, idmarcaciones B, czcargos C, czcargoemp D, cztipocontratos E, czempleados F, idtipomarcacion G 
Where G.Codigo_MRC=B.Codigo_MRC AND A.Codigo_TER=B.Codigo_TER AND C.Codigo_CRG=D.Codigo_CRG AND D.Codigo_TER=A.Codigo_TER AND F.Codigo_TER=A.Codigo_TER AND F.Codigo_TCL=E.Codigo_TCL 
 AND B.Fecha_IDM>='@FECHA_INICIAL 00:00:00' AND B.Fecha_IDM<='@FECHA_FINAL 23:59:59'
 AND A.Nombre_TER like '%@EMPLEADO%'
 AND D.FechaFin_CRG ='0000-00-00' 
Order By A.Nombre_TER, B.Fecha_IDM asc";
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
$pdf->Settitle('LISTADO MARCACIONES ID NEXUS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(30);
$pdf->SetFillColor(255);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,"Nombre:",'',0,'R',0); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,utf8_decode($row[1]),'',0,'L',0); //NOMBRE
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,"ID:",'',0,'R',0); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,$row[0],'',0,'L',0); //DOCUMENTO
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,"Cargo:",'',0,'R',0); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,utf8_decode($row[2]),'',0,'L',0); //CARGO
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,"Contrato:",'',0,'R',0); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,utf8_decode($row[3]),'',0,'L',0); //CONTRATO
$pdf->Ln();
$pdf->Cell(0,3,'','',0,'L',0); 
$pdf->Ln();
$pdf->SetFillColor(150);
$pdf->SetTextColor(255);
$pdf->Cell(40,5,"FECHA",'TBR',0,'C',1); //ENC FECHA
$pdf->Cell(40,5,"HORA",'TBRL',0,'C',1); //ENC HORA
$pdf->Cell(0,5,"TIPO DE MARCACION",'TBL',0,'C',1); //ENC TIPO MARCACION
$pdf->Ln();

//SE CONSULTAN LAS FECHAS DE MARCACION DEL USUARIO
$SQL="Select distinct date(B.Fecha_IDM), date_format(B.Fecha_IDM, '%h:%i:%s %p'), G.Nombre_MRC, Case Codigo_USR When '-' Then ' ' Else '*' End
From czterceros A, idmarcaciones B, czcargos C, czcargoemp D, cztipocontratos E, czempleados F, idtipomarcacion G 
Where G.Codigo_MRC=B.Codigo_MRC AND A.Codigo_TER=B.Codigo_TER AND C.Codigo_CRG=D.Codigo_CRG AND D.Codigo_TER=A.Codigo_TER AND F.Codigo_TER=A.Codigo_TER AND F.Codigo_TCL=E.Codigo_TCL 
 AND B.Fecha_IDM>='@FECHA_INICIAL 00:00:00' AND B.Fecha_IDM<='@FECHA_FINAL 23:59:59'
 AND A.Nombre_TER like '%@EMPLEADO%'
 AND D.FechaFin_CRG ='0000-00-00' 
 AND A.ID_TER='".$row[0]."'
Order By B.Fecha_IDM asc";
$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
$SQL=str_replace("@EMPLEADO",$_GET["EMPLEADO"],$SQL);
$resfecha = mysqli_query($conexion, $SQL);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);
$pdf->SetFillColor(250);
$fondito=1;
$fechita="";
$top="";
while ($rowfecha = mysqli_fetch_row($resfecha)) {
	if ($fechita!=$rowfecha[0]) {
		if ($fondito==0) {
			$fondito=1;
		}else {
			$fondito=0;
		}
		$fechita=$rowfecha[0];
		$top="T";
		$pdf->Cell(40,5,FormatoFecha($fechita),'RT',0,'C',$fondito); //FECHA
	} else {
		$pdf->Cell(40,5,'','R',0,'C',$fondito); //FECHA
		$top="";
	}
	$pdf->Cell(5,5,$rowfecha[3],'L'.$top,0,'C',$fondito);
	$pdf->Cell(35,5,$rowfecha[1],'R'.$top,0,'C',$fondito);
	$pdf->Cell(0,5,$rowfecha[2],'L'.$top,0,'C',$fondito);

	$pdf->Ln();
	
}
$pdf->Cell(0,1,'','T',0,'C',$fondito);

mysqli_free_result($resfecha);
$pdf->Ln();

}
mysqli_free_result($result);
//Mostramos el informe
$pdf->Output();
?>