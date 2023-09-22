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
	
	
	$SQL="Select Nombre_TUR from czmyturnosenc Where Codigo_TUR='".$_GET["CODIGO"]."'";
	$resultRAD = mysqli_query($conexion, $SQL);
	if ($rowRAD = mysqli_fetch_row($resultRAD)) {
		$this->SetY(3);
		$this->SetFont('Arial','B',14);
		$this->Cell(0,7,'PROGRAMACION DE TURNOS','',0,'C',0); //Razon Social
		$this->Ln();
		$this->SetFont('Arial','B',11);
		$this->Cell(0,6,utf8_decode($rowRAD[0]),'',0,'L',0); //Razon Social
		
	}
	mysqli_free_result($resultRAD);
	$this->SetFont('Arial','',10);
	$this->SetFillColor(252);
	$this->Ln();
	$this->Cell(44,4,'AREA','TBL',0,'C',1);	
	$this->Cell(24,4,'TURNO 1','TBL',0,'C',1);	
	$this->Cell(52,4,'NOMBRES','TBL',0,'C',1);	
	$this->Cell(24,4,'TURNO 2','TBL',0,'C',1);	
	$this->Cell(0,4,'NOMBRES','TBLR',0,'C',1);	
	$this->SetY(20);

	
}
function Footer()
{
    $this->SetY(-12);
    $this->SetFont('Arial','',8);
    $this->SetTextColor(200,200,200);
	$this->Cell(30,4,'Prog. No. '.$_GET["CODIGO"],'T',0,'L',0); //Razon Social
	$this->Cell(0,4,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT page_rpt, orientacion_rpt, sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='myturnos'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$FormatoPagina=$row[0];
	$Orientation=$row[1];
	$SQL="Select distinct C.Codigo_ARE, C.Nombre_ARE From czmyturnosdet A, czareas C Where C.Codigo_ARE=A.Codigo_ARE and A.Codigo_TER<>'' and A.Codigo_TUR='".$_GET["CODIGO"]."' Order By 1 asc;";
//	$SQL=str_replace("@CODIGO",($_GET["CODIGO"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('PROGRAMACION DE TURNOS');
$pdf->SetCreator('@Skanner79');
$pdf->SetMargins(10, 14,10);
$pdf->SetAutoPageBreak(true, 15);
//echo $SQL;
$pdf->AddPage();
$pdf->SetY(20);
$resultH = mysqli_query($conexion, $SQL);
$xTurno1="";
$xTurno2="";
$xMaxFilaT1=0;
$xfilasAreas=20;
$xColorBack=255;
while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->SetFillColor($xColorBack);
	//Area
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(44,4,$rowH[1],'TLR',0,'L',1);
	$xContaFila=0;
	//Turno1
	$SQL="Select A.Codigo_TRN, E.Nombre_TRN, A.Codigo_TER, Concat_WS(' ',D.Nombre1_EMP, left(D.Nombre2_EMP, 1), D.Apellido1_EMP, D.Apellido2_EMP) From czmyturnosdet A Left Join czempleados D On D.Codigo_TER=A.Codigo_TER Left Join cztipoturnos E On E.Codigo_TRN=A.Codigo_TRN Where A.Tipo_TUR='1' and A.Codigo_TER<>'' and A.Codigo_ARE='".$rowH[0]."' and A.Codigo_TUR='".$_GET["CODIGO"]."' Order By 2, 4;";
	$resultT1 = mysqli_query($conexion, $SQL);
	$xMaxFilaT1=0;
	while ($rowT1 = mysqli_fetch_row($resultT1)) {
		$xContaFila++;
		$xMaxFilaT1=$xContaFila;
		$pdf->SetFont('Arial','',7);
		$Tit="";
		if (($xTurno1!=$rowT1[0])||($xContaFila==1)) {
			if ($xContaFila!=1) {
				$pdf->Cell(44,4,'','LR',0,'L',1);
			} else {
				$Tit="T";
			}
			$pdf->Cell(24,4,$rowT1[1],$Tit.'R',0,'L',1);
			$xTurno1=$rowT1[0];
		} else {
			$pdf->Cell(44,4,'','LR',0,'L',1);
			$pdf->Cell(24,4,'','R',0,'L',1);
		}
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(52,4,utf8_decode($rowT1[3]),$Tit.'R',0,'L',1);
		$pdf->Cell(24,4,'',$Tit.'R',0,'L',1);
		$pdf->Cell(0,4,'',$Tit.'R',0,'L',1);
		$pdf->Ln();
	}
	mysqli_free_result($resultT1);

	$xContaFila=0;
	//Turno2
	$SQL="Select A.Codigo_TRN, E.Nombre_TRN, A.Codigo_TER, Concat_WS(' ',D.Nombre1_EMP, left(D.Nombre2_EMP, 1), D.Apellido1_EMP, D.Apellido2_EMP) From czmyturnosdet A Left Join czempleados D On D.Codigo_TER=A.Codigo_TER Left Join cztipoturnos E On E.Codigo_TRN=A.Codigo_TRN Where A.Tipo_TUR='2' and A.Codigo_TER<>'' and A.Codigo_ARE='".$rowH[0]."' and A.Codigo_TUR='".$_GET["CODIGO"]."' Order By 2, 4;";
	$resultT2 = mysqli_query($conexion, $SQL);
	while ($rowT2 = mysqli_fetch_row($resultT2)) {
		$xContaFila++;
		if ($xMaxFilaT1<$xContaFila) {
			if (($xMaxFilaT1==0)&&($xContaFila==1)) {
				$pdf->SetX(54);
				$pdf->Cell(24,4,'','TR',0,'L',1);
				$pdf->Cell(52,4,'','TR',0,'L',1);
			} else {
				$pdf->Cell(44,4,'','LR',0,'L',1);
				$pdf->Cell(24,4,'','R',0,'L',1);
				$pdf->Cell(52,4,'','R',0,'L',1);
			}
		}
		$pdf->SetFont('Arial','',7);
		if (($xTurno2!=$rowT2[0])||($xContaFila==1)) {
			$pdf->SetY($xfilasAreas+(($xContaFila-1)*4));
			$pdf->SetX(130);
			$pdf->Cell(24,4,$rowT2[1],'TR',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowT2[3]),'TR',0,'L',1);
			$xTurno2=$rowT2[0];
		} else {
			$pdf->SetX(130);
			$pdf->Cell(24,4,'','R',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowT2[3]),'R',0,'L',1);
		}
		$pdf->Ln();
	}
	mysqli_free_result($resultT2);

	if ($xMaxFilaT1<$xContaFila) {
		$xMaxFilaT1=$xContaFila;
	} /*
		else {
		$xfilasAreas=$xfilasAreas+(($xMaxFilaT1)*4);
		while ($xMaxFilaT1!=$xContaFila) {
			$t="";
			if ($xContaFila==0){
				$pdf->SetY($xfilasAreas+(($xContaFila-1)*4));
				$t="T";
			}
			$xContaFila++;
			$pdf->SetX(130);
			$pdf->Cell(24,4,$xfilasAreas,$t.'R',0,'L',1);
			$pdf->Cell(0,4,'',$t.'R',0,'L',1);
			$pdf->Ln();
		}
		
	}
	*/

	$xfilasAreas=$xfilasAreas+(($xMaxFilaT1)*4);	
	$pdf->SetY($xfilasAreas);
	if ($xColorBack==255) {
		$xColorBack=252;
	} else {
		$xColorBack=255;
	}
}
mysqli_free_result($resultH);
$pdf->Cell(44,0,'','BL',0,'C',1);	
$pdf->Cell(24,0,'','BL',0,'C',1);	
$pdf->Cell(52,0,'','BL',0,'C',1);	
$pdf->Cell(24,0,'','BL',0,'C',1);	
$pdf->Cell(0,0,'','BLR',0,'C',1);	
$pdf->Ln();

$SQL="Select Observaciones_TUR from czmyturnosenc Where Codigo_TUR='".$_GET["CODIGO"]."'";
$resultO = mysqli_query($conexion, $SQL);
if ($rowO = mysqli_fetch_row($resultO)) {
	if (trim($rowO[0])!='') {
		$pdf->MultiCell(0, 4, $rowO[0], 1);
	}
}
mysqli_free_result($resultO);

$pdf->Output();
?>