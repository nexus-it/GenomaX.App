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
$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='anexofacturasalud'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@CODIGO_FACTURA",($_GET["CODIGO_FACTURA"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$this->SetFillColor(255);
	$this->SetY(3);
	$this->SetFont('Arial','B',13);
	$this->Cell(0,8,strtoupper($rowH[0]),'',0,'C',0); //Razon Social
	$this->SetY(14);
	$this->SetFont('Arial','B',11);
	$this->Cell(0,6,'NIT: '.$rowH[1],'',0,'C',0);
	$this->SetY(9);
	$this->Cell(0,6,$rowH[2],'',0,'C',0);
	$this->SetY(18);
	$this->Cell(0,6,'ANEXO DE FACTURACION','',0,'C',0);
	if ($rowH[16]=="0") {
		$this->Image('../../anulado.jpg',35,45,0);
	}
	$this->Ln();
	$this->SetFont('Arial','',10);
	$this->Cell(15,5,'Factura:','LT',0,'L',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(50,5,$rowH[10],'TR',0,'L',0);
	$this->SetFont('Arial','',10);
	$this->Cell(25,5,'Fecha Factura:','T',0,'L',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(50,5,FormatoFecha($rowH[12]),'TR',0,'L',0);

	$this->SetFont('Arial','',10);
	$this->Cell(15,5,'Usuario:','T',0,'R',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,5,$rowH[4],'TR',0,'L',0);
	$this->SetFont('Arial','',10);
	$this->Ln();
	$this->Cell(15,5,'Entidad:','LT',0,'L',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,5,html_entity_decode($rowH[17].' &middot; '.$rowH[18]),'RT',0,'L',0);
	$this->Ln();
	$this->SetFont('Arial','',10);
	$this->Cell(0,5,html_entity_decode('Direcci&oacute;n: '.$rowH[19].' Tel&eacute;fono: '.$rowH[20]),'LBR',0,'L',0);
	$this->Ln();
	$this->Cell(95,5,'Paciente:','LBR',0,'L',0);
	$this->Cell(42,5,'Identificacion:','BR',0,'L',0);
	$this->Cell(31,5,'Plan:','BR',0,'L',0);
	$this->Cell(0,5,'Ingreso:','BR',0,'L',0);
	$this->Ln();
	$this->SetFont('Arial','B',10);
	$this->Cell(95,5,$rowH[23],'LBR',0,'L',0);
	$this->Cell(42,5,$rowH[22],'BR',0,'C',0);
	$this->Cell(31,5,$rowH[24],'BR',0,'C',0);
	$this->Cell(0,5,$rowH[21],'BR',0,'C',0);
	$this->SetY(51);
	$this->SetFont('Arial','B',9);
	$this->Cell(130,5,'NOMBRE SERVICIO','LTBR',0,'C',0);
	$this->Cell(13,5,'CANT.','TBR',0,'C',0);
	$this->Cell(25,5,'VAL. UNIT.','TBR',0,'C',0);
	$this->Cell(0,5,'TOTAL','TBR',0,'C',0);	
	$this->Ln();
	}
	mysqli_free_result($resultH);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,html_entity_decode('Powered By: GenomaX &reg;'),'T',0,'L');
	$this->SetFont('Arial','',8);
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='anexofacturasalud'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$FormatoPagina=$row[0];
	$Orientation=$row[1];
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('ANEXO FACTURACION EN SALUD');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
	$pdf->AddPage();
//Encabezado de la tabla
//while($row = mysqli_fetch_row($result)) {
	$pdf->SetFillColor(255);
	$SQL="SELECT c.Codigo_CFC, c.Nombre_CFC, SUM(b.Cantidad_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD)) FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d, gxfacturas e WHERE e.Codigo_FAC=Concat('".$_GET["PREFIJO"]."','-',LPAD('".$_GET["CODIGO_FACTURA"]."',10,'0')) AND a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS=e.Codigo_EPS AND b.Codigo_PLA=e.Codigo_PLA AND a.Codigo_ADM=e.Codigo_ADM GROUP BY c.Codigo_CFC, c.Nombre_CFC";
	$result = mysqli_query($conexion, $SQL);
//	echo $SQL;
	while ($row = mysqli_fetch_row($result)) {
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10,5,$row[0].' - ','',0,'C',0);
		$pdf->Cell(0,5,strtoupper($row[1]),'',0,'L',0);
		$pdf->Ln();
		$SQL="SELECT left(Nombre_SER,65), (b.Cantidad_ORD), (b.ValorPaciente_ORD+b.ValorEntidad_ORD), (b.ValorPaciente_ORD+b.ValorEntidad_ORD)*(b.Cantidad_ORD) FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d, gxfacturas e WHERE e.Codigo_FAC=Concat('".$_GET["PREFIJO"]."','-',LPAD('".$_GET["CODIGO_FACTURA"]."',10,'0')) AND a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS=e.Codigo_EPS AND b.Codigo_PLA=e.Codigo_PLA AND a.Codigo_ADM=e.Codigo_ADM AND d.Codigo_CFC='".$row[0]."' ";
		$resultX = mysqli_query($conexion, $SQL);
		while ($rowX = mysqli_fetch_row($resultX)) {
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(130,5,$rowX[0],'',0,'L',0);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(13,5,$rowX[1],'',0,'C',0);
			$pdf->Cell(25,5,$rowX[2],'',0,'R',0);
			$pdf->Cell(0,5,$rowX[3],'',0,'R',0);
			$pdf->Ln();
		}
		mysqli_free_result($resultX);
		$pdf->Cell(163,5,'','',0,'C',0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,5,number_format($row[2],2,'.',','),'T',0,'R',0);
		$pdf->Ln();
	}
	mysqli_free_result($result);
	$pdf->Ln();
//}
$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='anexofacturasalud'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@CODIGO_FACTURA",($_GET["CODIGO_FACTURA"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'SUBTOTAL','T',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','T',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[14]+$rowH[15]+$rowH[13],2,'.',','),'T',0,'R',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'VALOR PACIENTE','',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[13],2,'.',','),'',0,'R',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'VALOR DESCUENTO','',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[15],2,'.',','),'',0,'R',0);
//	$pdf->MultiCell(163,5,$rowH[15],'BR',0,'R',0);
	$pdf->Ln();
	$pdf->Cell(163,5,'TOTAL','TLBR',0,'R',0);
	$pdf->Cell(5,5,'$','TB',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[14],2,'.',','),'TBR',0,'R',0);

}
mysqli_free_result($resultH);
//Mostramos el informe
$pdf->Output();
?>