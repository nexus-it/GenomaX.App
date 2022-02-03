<?php


session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';	
include('phpqrcode/qrlib.php'); 
//include('config.php'); 

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
	//$this->Image('../../themes/'.$_SESSION["THEME_DEFAULT"].'/images/background2.jpg',30,60,0);
	//$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,5,0);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,' [Klud] Powered by Nexus-it.co','T',0,'L');
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='klemisiones'";
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
$pdf->Settitle('EMISIONES');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
//Encabezado de la tabla
$pdf->SetFillColor(255);
//while($row = mysqli_fetch_row($result)) {

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='klemisiones'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@EMISION_INICIAL",($_GET["EMISION_INICIAL"]),$SQL);
	$SQL=str_replace("@EMISION_FINAL",($_GET["EMISION_FINAL"]),$SQL);
	$SQL=str_replace("@IDIOMA",($_GET["IDIOMA"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->AddPage();
	if ($rowH[28]=='1') {
		$SQL="Select a.Nombre_AGE, concat('NIT ',b.ID_TER,'-',b.DigitoVerif_TER), b.Telefono_TER, concat( d.Nombre_MUN, ' - ', c.Nombre_DST), b.Web_TER From klagencias a, czterceros b, kldestinos c, czmunicipios d Where a.Codigo_TER=b.Codigo_TER and c.Codigo_DST=a.Codigo_PAI and d.Codigo_MUN= a.Codigo_MUN and a.Codigo_DEP=d.Codigo_DEP and a.Codigo_AGE='".$rowH[31]."'";
	} else  {
		$SQL="Select a.Razonsocial_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.Ciudad_DCD, a.Site_DCD From itconfig a";
	}
	$resultE = mysqli_query($conexion, $SQL);
	while ($rowE = mysqli_fetch_row($resultE)) {
		$rsocial=$rowE[0];
		$direccionnit=$rowE[1];
		$telefono=$rowE[2];
		$ubicacion=$rowE[3];
		$website=$rowE[4];
	}
	mysqli_free_result($resultE);
	$polixa='';
	//Marca de agua;
	$LeWater='../../files/klud/images/logo02'.str_replace(" ","_",$rowH[8]).'.jpg';
	file_put_contents($LeWater, $rowH[27]);
	$pdf->Image($LeWater,30,60,0);
	//Logo
	$LeLogo='../../files/klud/images/logo01'.str_replace(" ","_",$rowH[8]).'.jpg';
	file_put_contents($LeLogo, $rowH[26]);
	$pdf->Image($LeLogo,4,5,0);
	
	$pdf->SetY(8);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,8,utf8_decode(strtoupper($rsocial)),'',0,'C',0); //Razon Social
	$pdf->SetFont('Arial','B',11);
	$pdf->SetY(15);
	if ($rowH[28]=='1') {
		$pdf->Cell(0,6,$direccionnit,'',0,'C',0);
	} else {
		$pdf->Cell(0,6,'NIT: '.$rowH[1],'',0,'C',0);
	}
	$pdf->SetFont('Arial','',10);
	$pdf->SetY(26);
	if ($_GET["IDIOMA"]=="ENG") {
		$pdf->Cell(0,6,'Agency','',0,'C',0);
	} else {
		$pdf->Cell(0,6,'Agencia','',0,'C',0);
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(30);
	$pdf->Cell(0,6,utf8_decode($rowH[8]),'',0,'C',0);
	$pdf->SetFont('Arial','',10);
	$pdf->SetY(37);
	if ($_GET["IDIOMA"]=="ENG") {
		$pdf->Cell(0,6,'Promoter','',0,'C',0);
	} else {
		$pdf->Cell(0,6,'Promotor','',0,'C',0);
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetY(41);
	$pdf->Cell(0,6,utf8_decode($rowH[9]),'',0,'C',0);
	if ($rowH[23]=="Anulado") {
		$pdf->Image('../../anulado.jpg',35,45,0);
	}
	if ($rowH[23]=="StandBy") {
		$pdf->Image('../../standby.jpg',35,45,0);
	}
	
	$pdf->SetY(10);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'COD/VOUCHER','LBTR',0,'C',0);
	$pdf->Ln();
	$pdf->SetX(165);
	$pdf->SetTextColor(255,20,10);
	$pdf->SetFont('Courier','B',13);
	$pdf->Cell(0,6,utf8_decode($rowH[20]),'LBR',0,'C',0);
	$pdf->SetTextColor(0);
	
	$pdf->SetY(30);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',10);
	if ($_GET["IDIOMA"]=="ENG") {
		$pdf->Cell(0,5,'Policy Number','LBTR',0,'C',0);
	} else {
		$pdf->Cell(0,5,'Numero de Poliza','LBTR',0,'C',0);
	}
	$pdf->Ln();
	$pdf->SetX(165);
	$pdf->SetFont('Courier','B',12);
	$pdf->SetTextColor(255);
	$pdf->SetFillColor(150);
	$pdf->Cell(0,6,$_GET["PREFIJO"]."-".str_pad($rowH[2], 10, "0", STR_PAD_LEFT),'LBR',0,'C',1);
	$polixa=$rowH[2];
	$pdf->SetTextColor(0);
	$pdf->Ln();
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',8);
	if ($_GET["IDIOMA"]=="ENG") {
		$pdf->Cell(0,6,'Broadcast date: '.FormatoFecha($rowH[3]),'LBR',0,'C',0);
	} else {
		$pdf->Cell(0,6,'Fecha Emision: '.FormatoFecha($rowH[3]),'LBR',0,'C',0);
	}

	$pdf->SetY(55);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(48,4,'Plan','TRL',0,'L',0);
	$pdf->Cell(90,4,'Nombre / Name','TR',0,'L',0);
	$pdf->Cell(30,4,'F. Nac / Birth Date','TR',0,'L',0);
	$pdf->Cell(0,4,'Passport','TR',0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(48,5,utf8_decode($rowH[10]),'LBR',0,'L',0);
	$pdf->Cell(90,5,utf8_decode($rowH[6]),'BR',0,'L',0);
	$pdf->Cell(30,5,FormatoFecha($rowH[7]),'BR',0,'C',0);
	$pdf->Cell(0,5,utf8_decode($rowH[5]),'BR',0,'C',0);
	$pdf->Ln();

	$contapersonas=0;
	$SQL="SELECT Parentesco_per, nombre_ter, FechaNac_PER, id_ter from klpersonas a, czterceros c where a.codigo_ter=c.codigo_ter and codigo_emi='".$rowH[25]."' order by c.codigo_ter";
//	echo $SQL;
	$resultP = mysqli_query($conexion, $SQL);
	while ($rowP = mysqli_fetch_row($resultP)) {
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(48,4,'Parentesco / Relationship','TRL',0,'L',0);
		$pdf->Cell(90,4,'Nombre / Name','TR',0,'L',0);
		$pdf->Cell(30,4,'F. Nac / Birth Date','TR',0,'L',0);
		$pdf->Cell(0,4,'Passport','TR',0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		/*$pdf->Cell(0,5,utf8_decode($rowH[5]),'BR',0,'C',0);*/
		$pdf->Cell(48,5,utf8_decode($rowP[0]),'LBR',0,'L',0);
		$pdf->Cell(90,5,utf8_decode($rowP[1]),'BR',0,'L',0);
		$pdf->Cell(30,5,FormatoFecha($rowP[2]),'BR',0,'C',0);
		$pdf->Cell(0,5,utf8_decode($rowP[3]),'BR',0,'C',0);
		$pdf->Ln();
		$contapersonas++;
	}
	mysqli_free_result($resultP);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,4,'Modalidad','LR',0,'L',0);
	$pdf->Cell(55,4,'Destino de Viaje / Trip Destination','R',0,'L',0);
	$pdf->Cell(25,4,'Desde / From','R',0,'L',0);
	$pdf->Cell(25,4,'Hasta / To','R',0,'L',0);
	if ($rowH[30]!='1') {
		$pdf->Cell(0,4,'# Dias / # Days','R',0,'L',0);
	} else {
		$pdf->Cell(21,4,'# Dias / # Days','R',0,'L',0);
		$pdf->Cell(0,4,'P. Venta / Price','R',0,'L',0);
	}
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	if ($rowH[11]=="HIJOS") {
		if ($_GET["IDIOMA"]=="ENG") {
			$pdf->Cell(40,5,"FAMILY",'LBR',0,'L',0);
		} else {
			$pdf->Cell(40,5,"FAMILIA",'LBR',0,'L',0);
		}
	} else {
		$pdf->Cell(40,5,utf8_decode($rowH[11]),'LBR',0,'L',0);
	}
	$pdf->Cell(55,5,utf8_decode($rowH[13]),'BR',0,'L',0);
	$pdf->Cell(25,5,FormatoFecha($rowH[14]),'BR',0,'L',0);
	$pdf->Cell(25,5,FormatoFecha($rowH[15]),'BR',0,'C',0);
	if ($rowH[30]!='1') {
		$pdf->Cell(0,5,utf8_decode($rowH[16]),'BR',0,'L',0);
	} else {
		$pdf->Cell(21,5,utf8_decode($rowH[16]),'BR',0,'C',0);
		$pdf->Cell(0,5,'U$ '.$rowH[18],'BR',0,'R',0);
	}
	$pdf->Ln();
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,4,'Procedencia / Origin','LR',0,'L',0);
	$pdf->Cell(64,4,'Direccion / Address','R',0,'L',0);
	if ($rowH[30]!='1') {
			$pdf->Cell(0,4,'Telefono / Phone','R',0,'L',0);
	} else {
		$pdf->Cell(47,4,'Telefono / Phone','R',0,'L',0);
		$pdf->Cell(0,4,'Valor en Pesos','R',0,'L',0);
	}
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(55,5,utf8_decode($rowH[12]),'LBR',0,'L',0);
	$pdf->Cell(64,5,utf8_decode($rowH[21]),'BR',0,'L',0);
	if ($rowH[30]!='1') {
		$pdf->Cell(0,5,utf8_decode($rowH[22]),'BR',0,'L',0);
	} else {
		$pdf->Cell(47,5,utf8_decode($rowH[22]),'BR',0,'L',0);
		$pdf->Cell(0,5,'$ '.number_format($rowH[19],2,'.',','),'BR',0,'R',0);
	}
	$pdf->Ln();
	
	$pdf->Ln();
	$pdf->SetFillColor(170);
	$pdf->SetTextColor(255);
	$pdf->SetFont('Arial','B',9);
	if ($_GET["IDIOMA"]=="ENG") {
		$pdf->Cell(0,5,'CERTIFICATE OF COVERAGE - '.utf8_decode($rowH[10]),'',0,'C',1);
	} else {
		$pdf->Cell(0,5,'CERTIFICADO DE COBERTURA - '.utf8_decode($rowH[10]),'',0,'C',1);
	}
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(255);
	$pdf->Ln();
	$SQL="SELECT Nombre".$_GET["IDIOMA"]."_COB, Descripcion".$_GET["IDIOMA"]."_COB from klplanescobertura a, klemisiones b, klcotizaciones c where a.codigo_pla=c.codigo_pla and c.codigo_ctz=b.codigo_ctz and codigo_emi='".$rowH[2]."' order by orden_cob";
//	echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	$tamLetra=9;
	$tamEspacio=5;
	if ($contapersonas >3) {
		$tamLetra=8;
		$tamEspacio=4;
	}
	while ($row = mysqli_fetch_row($result)) {
		$pdf->SetFont('Arial','',$tamLetra);
		$pdf->Cell(160,$tamEspacio,utf8_decode($row[0]),'',0,'L',0);
		$pdf->Cell(0,$tamEspacio,utf8_decode(strtoupper($row[1])),'',0,'R',0);
		$pdf->Ln();
		
	}
	mysqli_free_result($result);
	// QR
	 
    $SQL="Select SHA1('".$polixa."')";
    $resultqr = mysqli_query($conexion, $SQL);
	if ($rowqr = mysqli_fetch_row($resultqr)) {
	
		$tempDir = '';      
	    $codeContents = 'http://verify.klud.axistravellers.com/?qr='.$rowqr[0]; 
	     
	    // we need to generate filename somehow,  
	    // with md5 or with database ID used to obtains $codeContents... 
	    $fileName = '_qrkl_'.$rowqr[0].'.png'; 
	     
	    $pngAbsoluteFilePath = $tempDir.$fileName; 
	    $urlRelativeFilePath = ''.$fileName; 
	     
	    // generating 
	    //if (!file_exists($pngAbsoluteFilePath)) { 
	       QRcode::png($codeContents, $pngAbsoluteFilePath); 
	    //} 
	     
	    // displaying 
	    $pdf->Image($urlRelativeFilePath,22,231,27);
	    $pdf->Image('../../qrverify.jpg',12,234,0);
	}
	mysqli_free_result($resultqr);
	// Enunciado Pie de Poliza
	$SQL="SELECT PageFooter".$_GET["IDIOMA"]."_KLD from klconfig";
    $resultft = mysqli_query($conexion, $SQL);
	if ($rowft = mysqli_fetch_row($resultft)) {
		$pdf->SetTextColor(100,0,20);
		$pdf->SetDrawColor(80,0,15);
		$pdf->SetY(238);
		$pdf->SetX(54);
		$pdf->SetFont('Courier','B',9);
		$pdf->MultiCell(150,4,utf8_decode($rowft[0]),1,'J');
		$pdf->SetDrawColor(0);
	}
	mysqli_free_result($resultft);
	
 }  
	mysqli_free_result($resultH);
	$pdf->Ln();

//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>