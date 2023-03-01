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
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->Cell(40,7,'Impreso por: {'.$_SESSION["it_CodigoUSR"].'} - '.$_SESSION["it_user"],'T',0,'L',0);	
    $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='ordenesdeservicio'";
//echo $SQL;
$resultS = mysqli_query($conexion, $SQL);
if ($rowS = mysqli_fetch_row($resultS)) {
	$SQL=$rowS[0];
	$FormatoPagina=$rowS[1];
	$Orientation=$rowS[2];
	$SQL=str_replace("@CODIGO_INICIAL",$_GET["CODIGO_INICIAL"],$SQL);
	$SQL=str_replace("@CODIGO_FINAL",$_GET["CODIGO_FINAL"],$SQL);
}
mysqli_free_result($resultS);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('ORDEN DE SERVICIO');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {

$pdf->AddPage();
if (trim($row[5])=="0") {
	$pdf->Image('../../anulado.jpg',25,1,0);
}
//Encabezado de la tabla
$pdf->SetY(3);
$pdf->SetFillColor(255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,5,'Fecha: ','',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,5,date('d/m/Y'),'',0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(0,5,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,5,'Hora: ','',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,5,date('H:i:s'),'',0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(0,5,'NIT: '.$row[2],'',0,'C',0); //NIT
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(150,5,'ORDEN DE SERVICIO No. '.$row[3],'BT',0,'L',0);
$pdf->Cell(0,5,'FECHA ORDEN: '.strtoupper($row[4]),'BT',0,'R',0); //Area Solicitante
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,4,strtoupper($row[19]),'',0,'C',0); //Titulo
$pdf->Ln();
//=============================
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Paciente: ','',0,'R',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,$row[9].' '.$row[10].' - '.$row[11],'',0,'L',1); //Nombre paciente
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Edad: ','',0,'R',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,4,utf8_decode(edad($row[6])),'',0,'L',1); //Edad
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Entidad: ','',0,'R',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,$row[13].' - '.$row[14],'',0,'L',1); //Nombre entidad
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Sexo: ','',0,'R',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,4,$row[7],'',0,'L',1); //Sexo
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Plan: ','',0,'R',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,$row[15].' - '.$row[16],'',0,'L',1); //Nombre Plan
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Cama: ','',0,'R',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,4,$row[24],'',0,'L',1); //Cama
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Area: ','',0,'R',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,$row[20],'',0,'L',1); //Nombre Area
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'Ingreso: ','',0,'R',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,4,$row[0],'',0,'L',1); //Ingreso
$pdf->SetY(39);
//=========================
$pdf->SetFillColor(245);
//$pdf->SetTextColor(245);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,4,'CODIGO','TLBR',0,'C',1);
$pdf->Cell(115,4,'SERVICIO','LTBR',0,'C',1);
$pdf->Cell(11,4,'CANT','TRBL',0,'C',1);
/*
$pdf->Cell(25,4,'VAL. UNIT.','TRLB',0,'C',1);
$pdf->Cell(0,4,'VAL. TOTAL','TRLB',0,'C',1);
*/
$pdf->Cell(0,4,'PROFESIONAL','TRLB',0,'C',1);
$pdf->SetY(40);
//$SQL= "SELECT c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD, sum(b.Valor_SER), (a.Cantidad_ORD* sum(b.Valor_SER)), '1' FROM gxordenesdet a, gxprocedimientosdet b, gxprocedimientos c WHERE  a.Codigo_SER= b.Codigo_SER AND a.Codigo_SER= c.Codigo_SER  and c.Codigo_SER=b.Codigo_SER AND c.Procedimiento_PRC='1' AND b.Codigo_ORD=a.Codigo_ORD  AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0') GROUP BY c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD union SELECT c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD, b.Valor_TAR, (a.Cantidad_ORD* b.Valor_TAR),'0' FROM gxordenesdet a, gxmanualestarifarios b, gxprocedimientos c, gxcontratos d, gxordenescab e WHERE  a.Codigo_SER= b.Codigo_SER AND a.Codigo_SER= c.Codigo_SER AND a.Codigo_EPS=d.Codigo_EPS AND a.Codigo_PLA=d.Codigo_PLA AND b.Codigo_TAR=d.Codigo_TAR AND e.Codigo_ORD=a.Codigo_ORD AND e.Fecha_ORD >= b.FechaIni_TAR AND e.Fecha_ORD <= b.FechaFin_TAR AND c.Procedimiento_PRC='0' AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0') UNION SELECT c.Codigo_MED, c.Nombre_MED, a.Cantidad_ORD, b.Valor_TAR, (a.Cantidad_ORD* b.Valor_TAR),'0' FROM gxordenesdet a, gxmanualestarifarios b, gxmedicamentos c, gxcontratos d, gxordenescab e WHERE  a.Codigo_SER= b.Codigo_SER AND a.Codigo_SER= c.Codigo_SER AND a.Codigo_EPS=d.Codigo_EPS AND a.Codigo_PLA=d.Codigo_PLA AND b.Codigo_TAR=d.Codigo_TAR AND e.Codigo_ORD=a.Codigo_ORD AND e.Fecha_ORD >= b.FechaIni_TAR AND e.Fecha_ORD <= b.FechaFin_TAR AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0');";
$SQL= "SELECT c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD, b.Nombre_TER, '1' FROM gxordenesdet a, czterceros b, gxprocedimientos c WHERE  a.Codigo_TER= b.Codigo_TER AND a.Codigo_SER= c.Codigo_SER AND c.Procedimiento_PRC='1' AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0') GROUP BY c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD union SELECT c.CUPS_PRC, c.Nombre_PRC , a.Cantidad_ORD, b.Nombre_TER,'0' FROM gxordenesdet a, czterceros b, gxprocedimientos c WHERE  a.Codigo_TER= b.Codigo_TER AND a.Codigo_SER= c.Codigo_SER AND c.Procedimiento_PRC='0' AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0') UNION SELECT c.Codigo_MED, c.Nombre_MED, a.Cantidad_ORD, b.Nombre_TER,'0' FROM gxordenesdet a, czterceros b, gxmedicamentos c WHERE  a.Codigo_TER= b.Codigo_TER AND a.Codigo_SER= c.Codigo_SER AND LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0');";
//echo $SQL;

$resultX = mysqli_query($conexion, $SQL);
$sW=245;
$ToTal=0;
while ($rowX = mysqli_fetch_row($resultX)) {
	if ($sW==255) {
		$sW=245;
	} else {
		$sW=255;
	}
	$pdf->SetFillColor($sW);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Cell(20,4,$rowX[0],'',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(115,4,$rowX[1],'',0,'L',1);
	$pdf->Cell(11,4,$rowX[2],'',0,'C',1);
	/*
	$pdf->Cell(25,4,number_format($rowX[3],2,'.',','),'',0,'R',1);
	$pdf->Cell(0,4,number_format($rowX[4],2,'.',','),'',0,'R',1);
	*/
	$pdf->Cell(0,4,$rowX[3],'',0,'L',1);
	$ToTal=$ToTal+$rowX[4];
	if ($rowX[5]=="1") {
		$SQL="Select c.Nombre_PRC, Cantidad_PRD, Valor_SER, Cantidad_PRD* Valor_SER*".$rowX[2]." From gxprocedimientosdet as a, gxprocedimientos as b, gxprocedimientos as c Where LPAD(a.Codigo_ORD,10,'0')=LPAD('".$row[3]."',10,'0') and a.Codigo_SER=b.Codigo_SER and a.Codigo2_SER=c.Codigo_SER AND b.CUPS_PRC='".$rowX[0]."'";
		$resultXY = mysqli_query($conexion, $SQL);
		while ($rowXY = mysqli_fetch_row($resultXY)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(23,4,'','',0,'L',0);
		$pdf->Cell(112,4,$rowXY[0],'',0,'L',0);
		$pdf->Cell(11,4,$rowXY[1],'',0,'C',0);
		$pdf->Cell(25,4,number_format($rowXY[2],2,'.',','),'',0,'R',0);
		$pdf->Cell(0,4,number_format($rowXY[3],2,'.',','),'',0,'R',0);
		}
		mysqli_free_result($resultXY);
	}
}
$pdf->Ln();
$pdf->SetFillColor(255);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,4,utf8_decode('Manifiesto bajo la gravedad de juramento que he recibido a satisfacción los servicios relacionados'),'',0,'L',0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','I',8);
$pdf->Cell(115,4,'','',0,'L',0);
$pdf->Cell(0,4,utf8_decode('Firma de recibido a satisfacción'),'T',0,'C',0);
mysqli_free_result($resultX);
/*
$pdf->SetFont('Arial','B',9);
$pdf->Cell(170,4,'TOTAL ORDEN DE SERVICIO','',0,'L',1);
$pdf->Cell(0,4,'$'.number_format($ToTal,2,'.',','),'T',0,'R',1);
*/
$pdf->SetFont('Arial','',9);
$pdf->SetY(6);
$pdf->Cell(0,4,'Usuario: '.$row[12],'',0,'R',0); //USUARIO

}

mysqli_free_result($result);

//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>