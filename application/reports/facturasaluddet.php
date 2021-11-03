<?php

session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';	
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

include '../../functions/php/GenomaXBackend/params.php';
require_once("phpqrcode/qrlib.php");
//create a QR Code and save it as a png image file named test.png
QRcode::png("coded number here","test.png");

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
	$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,5,0);
}
function PieFactura($subtotal, $totpcte, $notcred, $lineas, $lineas2, $codfac, $valcred, $subtotalfac, $conexion)
{
	/////ADICIONO EL QR  2021-11-03 LEANDRO CASTRO
	if(is_null($_SESSION["SiigoToken"])) {

		$SQL_INFO = "Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, c.Fecha_FAC, c.ValPaciente_FAC, c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, CONCAT(e.ID_TER,'-',e.DigitoVerif_TER), e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, LPAD(f.Codigo_ADM,10,'0'), CONCAT(h.Sigla_TID,' ', g.ID_TER), g.Nombre_TER, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD
		, SPLIT_STR(c.CODIGO_FAC, '-', 1) AS PREFIJO, SPLIT_STR(c.CODIGO_FAC, '-', 2) as NUMERACION, IdFE_FAC
		From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, 
		czterceros g, cztipoid h, gxplanes i WHERE c.Codigo_AFC = b.Codigo_AFC  and d.Codigo_EPS= c.Codigo_EPS  and e.Codigo_TER= d.Codigo_TER   and f.Codigo_ADM =c.Codigo_ADM   and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA 
		AND c.CODIGO_FAC = '$codfac'	";
		error_log($SQL_INFO);
		$RESULTADO_INFO = mysqli_query($conexion, $SQL_INFO);
		$row_INFO = mysqli_fetch_array($RESULTADO_INFO);
		
		if ($row_INFO['IdFE_FAC']!="0") {

			$string = $codfac;
			//var_dump($_POST["factura"]);
			$NUMERACION = preg_replace('/[^0-9]/', '', $string);
			$cadena = explode($NUMERACION,$string);
			$PREFIJO = $cadena[0];

			$CUFE = $row_INFO['IdFE_FAC']; // ValidarCUfe($row_INFO['NIT_DCD'],$PREFIJO,$NUMERACION);
			/* $cad = explode("-",ValidarCUfe($row_INFO['NIT_DCD'],$PREFIJO,$NUMERACION));
			$CUFE = $cad[0]; */

			$cadena='NumFac:'.$row_INFO['Codigo_FAC'].PHP_EOL
					.'FecFac:'.$row_INFO['Fecha_FAC'].PHP_EOL
					.'NitFac:'.$row_INFO['NIT_DCD'].PHP_EOL
					.'DocAdq:'.$row_INFO['ID_TER'].PHP_EOL
					.'ValFac:'.$row_INFO['ValTotal_FAC'].PHP_EOL
					.'ValIva:0.00'.PHP_EOL
					.'ValOtroIm:0.00'.PHP_EOL
					.'ValTotal:'.$row_INFO['ValTotal_FAC'].PHP_EOL
					.'CUFE:'.$CUFE.PHP_EOL
					.'https://catalogo-vpfe.dian.gov.co/document/ShowDocumentToPublic/'.$CUFE
					;
			$this->Image("http://" . $_SERVER['HTTP_HOST']."/his/application/reports/qr_generator.php?code=". urlencode($cadena),180,234,27,27 , "png");
			$this->SetY(-64);
			$this->SetFont('Arial','B',8);
			$this->Cell(0,5,'CUFE: '.$CUFE,'',0,'L',0);
			
		}
	}
	// FIN COD LEANDRO

	$this->SetY(-88);
	$this->SetFont('Arial','',10);
	$this->Cell(118,5,'','TLR',0,'R',0);
	$this->Cell(45,5,'SUBTOTAL','TLBR',0,'R',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(5,5,'$','TB',0,'C',0);
	$this->Cell(0,5,number_format($subtotal,2,'.',','),'TBR',0,'R',0); 
/*	$this->Cell(0,5,number_format($subtotalfac,2,'.',','),'TBR',0,'R',0);*/
	$this->Ln();
	$this->SetFont('Arial','',10);
	$this->Cell(118,5,'','LR',0,'R',0);
	$this->Cell(45,5,'VALOR PACIENTE','LBR',0,'R',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(5,5,'$','TB',0,'C',0);
	$this->Cell(0,5,number_format($totpcte,2,'.',','),'BR',0,'R',0);
	$this->Ln();
	$this->SetFont('Arial','',10);
	$this->Cell(118,5,'','BLR',0,'R',0);
	$this->Cell(45,5,'VALOR NOTAS CREDITO','LBR',0,'R',0);
	$this->SetFont('Arial','B',10);
	$this->Cell(5,5,'$','TB',0,'C',0);
	$this->Cell(0,5,number_format($notcred,2,'.',','),'BR',0,'R',0);
	$Cadena=explode('\n',$lineas);
	$this->SetFont('Arial','',7);
	$conteo = count($Cadena);
	$impar=1;
	for ($i = 0; $i < $conteo; $i = $i + 3) {
		$this->Ln();
		$this->Cell(163,3,$Cadena[$i].'   '.$Cadena[$i+1].'   '.$Cadena[$i+2],'LR',0,'C',0);
		if ($conteo!=($i+1)) {
			$this->Cell(0,3,'','R',0,'C',0);
		} else {
			$this->SetFont('Arial','B',11);
			$this->Cell(0,3,'TOTAL','R',0,'C',0);
		}
	}	
//	$this->MultiCell(163,5,$rowH[15],'BR',0,'R',0);
	$this->Ln();
	$this->Cell(163,5,'','TLBR',0,'R',0);
	$this->Cell(5,5,'$','TB',0,'C',0);
	if ($rowH[42]=="PARTIC") {
		$this->Cell(0,5,number_format($totpcte-$notcred,2,'.',','),'TBR',0,'R',0); 
	} else {
		$this->Cell(0,5,number_format($subtotal-$notcred,2,'.',','),'TBR',0,'R',0); 
	}

/*	$this->Cell(0,5,number_format($subtotalfac-$rowH[15],2,'.',','),'TBR',0,'R',0);*/
	$this->Ln();
/*	$this->Cell(0,4,ValorLetras($rowH[14]-$rowH[15]),'LBR',0,'L',0); */
	$this->Cell(0,4,ValorLetras($subtotalfac-$notcred),'LBR',0,'L',0);
	$Cadena2=explode('\n',$lineas2);
	$this->SetFont('Times','',7);
	$conteo = count($Cadena2);
	for ($i = 0; $i < $conteo; $i++) {
		$this->Ln();
		$this->Cell(0,3,(($Cadena2[$i])),'LR',0,'L',0);
	}	
	$this->Ln();
	$this->Cell(0,15,'','T',0,'L',0);
	$this->Ln();
	$this->SetFont('Arial','',9);
	$SQL="Select a.Codigo_USR, a.Nombre_USR, a.PieFirma_USR, Firma_USR From gxfacturas c, itusuarios a Where a.Codigo_USR=c.Codigo_USR and c.Codigo_FAC='".$codfac."' ";
	$result = mysqli_query($conexion, $SQL);
	
	while ($row = mysqli_fetch_row($result)) {
		if (!(file_exists('../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/users/'.$row[0].'.jpg'))) {
			$LeFirma='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/users/'.$row[0].'.jpg';
			file_put_contents($LeFirma, $row[3]);
		}	
		// $this->Image('../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/users/'.$row[0].'.jpg',11,234,40);
		$this->Cell(70,3,'Responsable: '.utf8_decode($row[1]),'T',0,'L',0);
		$this->Ln();
		$this->Cell(60,3,utf8_decode($row[2]),'',0,'L',0);
		}
		mysqli_free_result($result);
	/*if ($rowH[43]!="") {
	    $this->SetY(-87);
	    $this->SetX(11);
		$this->SetFont('Arial','',8);
		$this->MultiCell(116,4,utf8_decode($rowH[43]),'','L',1);
	}*/
	if ($valcred!="0") {
		$this->AddFont('SegoeScript','','segoescript.php');
		$this->Image('../../notacredito.jpg',125,242,40);			
		$SQL="Select a.Codigo_NCT From cznotascontablesenc a Where a.NumeroDoc_NCT='".$codfac."' and a.Estado_NCT='1'";
		$result = mysqli_query($conexion, $SQL);
		//echo $SQL;
		$this->SetFont('SegoeScript','',13);
		while ($row = mysqli_fetch_row($result)) {	
			$this->Cell(100,4,$row[0],'',0,'R',0);
		}
			mysqli_free_result($result);
	}
}
function CabFactura($rsocial, $nit, $dir, $tel, $ciudad, $estado, $contrato, $partic, $entid, $tipocont, $pacient, $client, $nitclient, $dirclient, $telclient, $numfact, $resdian, $fecdian, $predian, $inidian, $findian, $tiporesfc)
{
	$this->SetY(3);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,8,strtoupper($rsocial),'',0,'C',0); //Razon Social
	$this->SetY(28);
	$this->SetFont('Arial','B',10);
	$this->Cell(60,7,'NIT: '.$nit,'',0,'C',0);
	$this->SetY(10);
	$this->Cell(0,6,utf8_decode($dir),'',0,'C',0);
	$this->SetY(15);
	$this->Cell(0,6,'Tel. '.$tel,'',0,'C',0);
	$this->SetY(20);
	$this->Cell(0,6,utf8_decode($ciudad),'',0,'C',0);
	if ($estado=="0") {
		$this->Image('../../anulado.jpg',35,45,0);
	}
	$this->SetY(35);
	$this->SetFont('Arial','',9);
	$this->Cell(60,5,'Cliente:','LT',0,'L',0);
	$this->SetFont('Arial','B',9);
	$this->Cell(65,5,'Contrato: '.utf8_decode($contrato),'LTR',0,'R',0);
	$this->Ln();
	$this->SetFont('Arial','B',10);
	if ($tipocont=="PARTIC") {
		$this->Cell(60,5,utf8_decode($partic),'LR',0,'L',0);
		$this->SetFont('Arial','B',9);
		$this->Cell(65,5,'','LBR',0,'L',0);
		$this->Ln();
		$this->Cell(125,5,utf8_decode($pacient),'LR',0,'L',0);
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->Cell(125,5,'','LBR',0,'L',0);
	} else {
		$this->Cell(60,5,utf8_decode($entid),'LR',0,'L',0);
		$this->SetFont('Arial','B',9);
		$this->Cell(65,5,$nitclient,'LBR',0,'R',0);
		$this->Ln();
		$this->Cell(125,5,utf8_decode($client),'LR',0,'L',0);
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->Cell(125,5,utf8_decode($dirclient.' Tel. '.$telclient),'LBR',0,'L',0);
	}
		
	if ($tiporesfc=="3") {
		$this->SetY(14);
		$this->SetX(160);
		$this->SetFont('Arial','',7);
		$this->Cell(0,5,'FACTURA ELECTRONICA DE VENTA','LBTR',0,'C',0);
		$this->Ln();
		$this->SetX(160);
		$this->SetTextColor(255,20,10);
		$this->SetFont('Courier','B',12);
		$NoFact=trim($numfact);
		if (substr($NoFact,0,1 )=="-") {
			$NoFact=substr($NoFact,1,strlen($NoFact)-1);
		}
		$this->Cell(0,6,$NoFact,'LBR',0,'C',0);
	} else {
		$this->SetY(14);
		$this->SetX(165);
		$this->SetFont('Arial','',10);
		$this->Cell(0,5,'FACTURA DE VENTA','LBTR',0,'C',0);
		$this->Ln();
		$this->SetX(165);
		$this->SetTextColor(255,20,10);
		$this->SetFont('Courier','B',12);
		$NoFact=trim($numfact);
		if (substr($NoFact,0,1 )=="-") {
			$NoFact=substr($NoFact,1,strlen($NoFact)-1);
		}
		$this->Cell(0,6,$NoFact,'LBR',0,'C',0);
	}
	$this->SetTextColor(0);
	
	$this->SetY(55);
	$this->SetFont('Arial','',8);
	$this->Cell(0,5,'RESOLUCION DE LA DIAN No. '.$resdian.' DE '.FormatoFecha($fecdian).' DESDE EL No. '.$predian.' '.$inidian.' HASTA EL No. '.$predian.' '.$findian,'',0,'C',0);
	$this->Ln();
}
function TableHD()
{
	$this->SetFillColor(170);
	$this->SetTextColor(255);
	$this->SetFont('Arial','B',9);
	$this->Cell(15,4,'CODIGO','',0,'C',1);
	$this->Cell(95,4,'NOMBRE SERVICIO','',0,'C',1);
	$this->Cell(25,4,'AUTORIZACION','',0,'C',1);
	$this->Cell(10,4,'CANT.','',0,'C',1);
	$this->Cell(23,4,'VAL. UNIT.','',0,'C',1);
	$this->Cell(0,4,'TOTAL','',0,'C',1);
	$this->SetTextColor(0);
	$this->SetFillColor(255);
	
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,'FACTURACION EN SALUD [GenomaX.co]','T',0,'L');
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='facturasaluddet'";
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

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='facturasaluddet'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
	$SQL=str_replace("@CODIGO_FINAL",($_GET["CODIGO_FINAL"]),$SQL);
}
error_log($SQL);
mysqli_free_result($resultH);
error_log("Factura salud:". $SQL);
$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->AddPage();
	$pdf->CabFactura($rowH[0], $rowH[1], $rowH[2], $rowH[3], $rowH[29], $rowH[16], $rowH[40], $rowH[22], $rowH[17], $rowH[42], $rowH[23], $rowH[18], $rowH[41], $rowH[19], $rowH[20], $rowH[10], $rowH[8], $rowH[9], $rowH[36], $rowH[6], $rowH[7], $rowH[44]);
	$pdf->SetFont('Arial','',9);
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
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(17,5,'Direccion:','LB',0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,5,$rowH[30],'BR',0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(12,5,'Barrio:','LB',0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(38,5,$rowH[32],'BR',0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(13,5,'Ciudad:','LB',0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(38,5,$rowH[33],'BR',0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,5,'Telefono:','LB',0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,5,$rowH[31],'BR',0,'L',0);	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(22,5,'Diagnostico:','LB',0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(105,5,$rowH[34].' - '.$rowH[35],'BR',0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(17,5,'F. Ingreso:','LTB',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(18,5,FormatoFecha($rowH[38]),'BTR',0,'L',1);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,5,'F. Salida:','LTB',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,5,FormatoFecha($rowH[39]),'BTR',0,'L',1);	
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

	$pdf->SetY(82);
	$pdf->TableHD();
	// Agrupacion por Orden de Servicio
	if ($rowH[43]=="1") {
		$SQL="Select a.Codigo_ORD, Descripcion_ORD, SUM(b.CantidadOLD_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD))  FROM gxordenescab a, gxordenesdet b, gxservicios d WHERE a.Codigo_ORD=b.Codigo_ORD AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH[25]."' AND b.Codigo_PLA='".$rowH[26]."' AND LPAD(a.Codigo_ADM,10,'0')='".$rowH[21]."' GROUP BY a.Codigo_ORD, Descripcion_ORD";
	} else {
		$SQL="SELECT c.Codigo_CFC, c.Nombre_CFC, SUM(b.CantidadOLD_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD)) FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH[25]."' AND b.Codigo_PLA='".$rowH[26]."' AND LPAD(a.Codigo_ADM,10,'0')='".$rowH[21]."' GROUP BY c.Codigo_CFC, c.Nombre_CFC";
	}
	// error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	$subtotalfac=0;
	// echo $SQL;
	while ($row = mysqli_fetch_row($result)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		// Agrupacion por Orden de Servicio
		if ($rowH[43]=="1") {
			$pdf->Cell(16,3,$row[0].' - ','',0,'L',0);
		} else {
			$pdf->Cell(10,3,$row[0].' - ','',0,'C',0);
		}
		$pdf->Cell(0,3,strtoupper($row[1]),'',0,'L',0);
		$pdf->Ln();
		// Agrupacion por Orden de Servicio
		if ($rowH[43]=="1") {
			$SQL="SELECT left(Nombre_SER, 60), sum(b.CantidadOLD_ORD), (b.ValorPaciente_ORD+b.ValorEntidad_ORD), sum(b.CantidadOLD_ORD)*(b.ValorPaciente_ORD+b.ValorEntidad_ORD), d.Codigo_SER, Autorizacion_ORD, CASE d.Tipo_SER WHEN '1' THEN f.CUPS_PRC WHEN '2' then g.CUM_MED end  FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d left join gxprocedimientos f on d.Codigo_SER=f.Codigo_SER left join gxmedicamentos g on d.Codigo_SER=g.Codigo_SER WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH[25]."' AND b.Codigo_PLA='".$rowH[26]."' AND LPAD(a.Codigo_ADM,10,'0')='".$rowH[21]."' AND b.Codigo_ORD='".$row[0]."' GROUP BY left(Nombre_SER, 60), (b.ValorPaciente_ORD+b.ValorEntidad_ORD), d.Codigo_SER, Autorizacion_ORD, CASE d.Tipo_SER WHEN '1' THEN f.CUPS_PRC WHEN '2' then g.CUM_MED end  ";
		} else {
			$SQL="SELECT left(Nombre_SER, 60), sum(b.CantidadOLD_ORD), (b.ValorPaciente_ORD+b.ValorEntidad_ORD), sum(b.CantidadOLD_ORD)*(b.ValorPaciente_ORD+b.ValorEntidad_ORD), d.Codigo_SER, Autorizacion_ORD, CASE d.Tipo_SER WHEN '1' THEN f.CUPS_PRC WHEN '2' then g.CUM_MED end  FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d left join gxprocedimientos f on d.Codigo_SER=f.Codigo_SER left join gxmedicamentos g on d.Codigo_SER=g.Codigo_SER WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH[25]."' AND b.Codigo_PLA='".$rowH[26]."' AND LPAD(a.Codigo_ADM,10,'0')='".$rowH[21]."' AND d.Codigo_CFC='".$row[0]."' GROUP BY left(Nombre_SER, 60), (b.ValorPaciente_ORD+b.ValorEntidad_ORD), d.Codigo_SER, Autorizacion_ORD, CASE d.Tipo_SER WHEN '1' THEN f.CUPS_PRC WHEN '2' then g.CUM_MED end  ";
		}
		// error_log($SQL);
		$resultX = mysqli_query($conexion, $SQL);
		while ($rowX = mysqli_fetch_row($resultX)) {
			$TheY=$pdf->GetY();
			// Si llega a limite de la página, agregamos una nueva...
			if ($TheY>=190) {
				$pdf->PieFactura($rowH[14], $rowH[13], $rowH[15], $rowH[4], $rowH[5], $rowH[10], $rowH[37], $subtotalfac, $conexion);
				$pdf->AddPage();
				$pdf->CabFactura($rowH[0], $rowH[1], $rowH[2], $rowH[3], $rowH[29], $rowH[16], $rowH[40], $rowH[22], $rowH[17], $rowH[42], $rowH[23], $rowH[18], $rowH[41], $rowH[19], $rowH[20], $rowH[10], $rowH[8], $rowH[9], $rowH[36], $rowH[6], $rowH[7], $rowH[44]);
				$pdf->TableHD();
				$pdf->Ln();
			}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,3,$rowX[6],'',0,'L',1);
			$pdf->Cell(95,3,utf8_decode($rowX[0]),'',0,'L',0);
			$pdf->Cell(25,3,$rowX[5],'',0,'C',1);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(10,3,$rowX[1],'',0,'C',1);
			$pdf->Cell(23,3,$rowX[2],'',0,'R',1);
			$pdf->Cell(0,3,$rowX[3],'',0,'R',1);
			if ($rowH[43]=="0") {			
				$pdf->Ln();
			}
		}
		mysqli_free_result($resultX);
		if ($rowH[43]=="0") {
			$pdf->Cell(165,3,'','',0,'C',0);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,3,number_format($row[2],2,'.',','),'T',0,'R',1);
		}
		$subtotalfac=$subtotalfac+$row[2];
	}
	mysqli_free_result($result);
    $pdf->PieFactura($rowH[14], $rowH[13], $rowH[15], $rowH[4], $rowH[5], $rowH[10], $rowH[37], $subtotalfac, $conexion);
	
	}
	
	mysqli_free_result($resultH);
	$pdf->Ln();

//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>