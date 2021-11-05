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
function _construct($orientation='P',$unit='mm',$format='Letter')
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
	//$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',3,1,0);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,'FACTURA IMPRESA POR COMPUTADOR [GenomaX]','T',0,'L');
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='facturasalud'";
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
$pdf->Settitle('FACTURA EN SALUD');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
//Encabezado de la tabla
$pdf->SetFillColor(255);
//while($row = mysqli_fetch_row($result)) {

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='facturasalud'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",trim($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
	$SQL=str_replace("@CODIGO_FINAL",($_GET["CODIGO_FINAL"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->AddPage();
	$pdf->SetY(3);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(0,8,strtoupper($rowH[0]),'',0,'C',0); //Razon Social
	$pdf->SetY(28);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(60,7,'NIT: '.$rowH[1],'',0,'C',0);
	$pdf->SetY(10);
	$pdf->Cell(0,6,$rowH[2],'',0,'C',0);
	$pdf->SetY(15);
	$pdf->Cell(0,6,'Tel. '.$rowH[3],'',0,'C',0);
	$pdf->SetY(20);
	$pdf->Cell(0,6,$rowH[29],'',0,'C',0);
	if ($rowH[16]=="0") {
		$pdf->Image('../../anulado.jpg',35,45,0);
	}
	$pdf->SetY(35);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(125,5,'Cliente:','LTR',0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(125,5,$rowH[17],'LR',0,'L',0);
	$pdf->Ln();
	$pdf->Cell(125,5,$rowH[18],'LR',0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(125,5,$rowH[19].' Tel. '.$rowH[20],'LBR',0,'L',0);
		
	$pdf->SetY(5);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'FACTURA DE VENTA','LBTR',0,'C',0);
	$pdf->Ln();
	$pdf->SetX(165);
	$pdf->SetTextColor(255,20,10);
	$pdf->SetFont('Courier','B',12);
	$NoFact=trim($rowH[10]);
	if (substr($NoFact,0,1 )=="-") {
		$NoFact=substr($NoFact,1,strlen($NoFact)-1);
	}
	$pdf->Cell(0,6,$NoFact,'LBR',0,'C',0);
	$pdf->SetTextColor(0);
	
	$pdf->SetY(55);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'RESOLUCION DE LA DIAN No. '.$rowH[8].' DE '.FormatoFecha($rowH[9]).' DESDE EL No. '.$rowH['Prefijo_AFC'].$rowH[6].' HASTA EL No. '.$rowH['Prefijo_AFC'].$rowH[7],'',0,'C',0);
	$pdf->Ln();
	$pdf->Cell(95,5,'Paciente:','LBTR',0,'L',0);
	$pdf->Cell(42,5,'Identificacion:','BTR',0,'L',0);
	$pdf->Cell(31,5,'Plan:','BTR',0,'L',0);
	$pdf->Cell(0,5,'Ingreso:','BTR',0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(95,5,$rowH[23],'LBR',0,'L',0);
	$pdf->Cell(42,5,$rowH[22],'BR',0,'C',0);
	$pdf->Cell(31,5,$rowH[24],'BR',0,'C',0);
	$pdf->Cell(0,5,$rowH[21],'BR',0,'C',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(37,5,'AUTORIZACION No.:','LB',0,'L',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,$rowH[28],'BR',0,'L',0);	
	$pdf->Ln();

	$pdf->SetY(35);
	$pdf->SetX(153);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(32,5,'Fecha Factura:','',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,FormatoFecha($rowH[12]),'',0,'L',0);
	$pdf->SetY(40);
	$pdf->SetX(153);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(32,5,'Fecha Vence:','',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,FormatoFecha($rowH[27]),'',0,'L',0);

	$pdf->SetY(76);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(180);
	$pdf->SetTextColor(255);
	$pdf->Cell(23,5,'CONCEPTO','',0,'C',1);
	$pdf->Cell(140,5,'DESCRIPCION DEL SERVICIO','',0,'C',1);
	$pdf->Cell(0,5,'TOTAL','',0,'C',1);
	$pdf->SetTextColor(0);
	
	$SQL="SELECT c.Codigo_CFC, c.Nombre_CFC, SUM(b.Cantidad_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD)) FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH[25]."' AND b.Codigo_PLA='".$rowH[26]."' AND LPAD(a.Codigo_ADM,10,'0')='".$rowH[21]."' GROUP BY c.Codigo_CFC, c.Nombre_CFC";
	$result = mysqli_query($conexion, $SQL);
//	echo $SQL;
	while ($row = mysqli_fetch_row($result)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(23,7,$row[0],'',0,'C',0);
		$pdf->Cell(140,7,strtoupper($row[1]),'',0,'L',0);
		$pdf->Cell(0,7,number_format($row[2],2,'.',','),'',0,'R',0);
	}
	mysqli_free_result($result);
    $pdf->SetY(-100);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'SUBTOTAL','TLBR',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','TB',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[14],2,'.',','),'TBR',0,'R',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'VALOR PACIENTE','LBR',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','TB',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[13],2,'.',','),'BR',0,'R',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(163,5,'VALOR NOTAS CREDITO','LBR',0,'R',0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(5,5,'$','TB',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[15],2,'.',','),'BR',0,'R',0);
	$Cadena=explode('\n',$rowH[4]);
	$pdf->SetFont('Arial','',8);
	$conteo = count($Cadena);
	for ($i = 0; $i < $conteo; $i++) {
		$pdf->Ln();
		$pdf->Cell(163,3,$Cadena[$i],'LR',0,'C',0);
		if ($conteo!=($i+1)) {
			$pdf->Cell(0,3,'','R',0,'C',0);
		} else {
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(0,3,'TOTAL','R',0,'C',0);
		}
	}	
//	$pdf->MultiCell(163,5,$rowH[15],'BR',0,'R',0);
	$pdf->Ln();
	$pdf->Cell(163,5,'','TLBR',0,'R',0);
	$pdf->Cell(5,5,'$','TB',0,'C',0);
	$pdf->Cell(0,5,number_format($rowH[14]-$rowH[15],2,'.',','),'TBR',0,'R',0);
	$pdf->Ln();
	$pdf->Cell(0,4,numerotexto($rowH[14]-$rowH[15]),'LBR',0,'L',0);
	$Cadena2=explode('\n',$rowH[5]);
	$pdf->SetFont('Times','',7);
	$conteo = count($Cadena2);
	for ($i = 0; $i < $conteo; $i++) {
		$pdf->Ln();
		$pdf->Cell(0,3,(($Cadena2[$i])),'LR',0,'L',0);
	}	
	$pdf->Ln();
	$pdf->Cell(0,15,'','T',0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$SQL="Select a.Codigo_USR, a.Nombre_USR From gxfacturas c, itusuarios a Where a.Codigo_USR=c.Codigo_USR and c.Codigo_FAC='".$rowH[10]."' ";
	$result = mysqli_query($conexion, $SQL);
//	echo $SQL;
	while ($row = mysqli_fetch_row($result)) {	
		$pdf->Cell(60,3,'Responsable: {'.$row[0].'} '.$row[1],'T',0,'L',0);
	}
	mysqli_free_result($result);
	$pdf->Ln();
	$pdf->Cell(50,3,'CC No.','',0,'L',0);

	}
	mysqli_free_result($resultH);
	$pdf->Ln();
//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>