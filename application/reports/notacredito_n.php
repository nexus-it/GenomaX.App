<?php

session_start();
include 'rutafpdf.php';
include '../../functions/php/nexus/database.php';	
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Courier','',8);
    //Número de página
	$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'B',0,'L',0);	
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','B',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='notacredito'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@TIPO_NOTA",$_GET["TIPO_NOTA"],$SQL);
    $SQL=str_replace("@CODIGO_INICIAL",$_GET["CODIGO_INICIAL"],$SQL);
    $SQL=str_replace("@CODIGO_FINAL",$_GET["CODIGO_FINAL"],$SQL);
}
//echo $SQL;
mysqli_free_result($result);

if($_GET["TIPO_NOTA"] == "C"){
    $tipo = "CRÉDITO";
}else{
    $tipo = "DÉBITO";
}

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('NOTA '.$tipo.' A FACTURA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
// echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();



    $CUFE = $row[17]; 
    //echo "CUFE=".$CUFE;
    $cadena='NumFac: '.$row[0].PHP_EOL
					.'FecFac: '.$row[11].PHP_EOL
					.'HorFac: 00:00:00'.PHP_EOL
					.'NitND: '.$row[2].PHP_EOL
					.'DocAdq: '.$row[5].PHP_EOL
					.'ValFac: '.$row[8].PHP_EOL
					.'ValIva: 0.00'.PHP_EOL
					.'ValOtroIm: 0.00'.PHP_EOL
					.'ValTotal: '.$row[8].PHP_EOL
					.'CUFE: '.$CUFE.PHP_EOL
					.'QRCode: https://catalogo-vpfe.dian.gov.co/document/ShowDocumentToPublic/'.$CUFE
					;
    $currentDir = str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    $pdf->Image("http://" . $_SERVER['HTTP_HOST'].$currentDir."qr_generator.php?code=". urlencode($cadena),180,234,27,27 , "png");
    $pdf->SetY(6);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0,210,'CUFE: '.$CUFE,'',0,'L',0);
//Encabezado de la tabla
if (trim($row[15])=="A") {
    $pdf->Image('../../anulado.jpg',25,1,0);
}
$pdf->SetY(5);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,6,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,6,'NIT '.$row[2],'',0,'C',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,6,utf8_decode('COMPROBANTE NOTA '.$tipo.' '),'B',0,'C',0);
$pdf->SetY(9);
$pdf->Ln();
$pdf->SetFont('Courier','B',13);
$pdf->Cell(0,6,'No. '.$row[0],'',0,'R',0); //Numero NC 

$pdf->SetY(25);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,utf8_decode('Fecha NC: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,$row[3],'',0,'L',0); //Fecha NC
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Documento: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,5,$row[4],'',0,'L',0); //No Factura
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'ID. Tercero: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,utf8_decode($row[5]).' '.$row[20],'',0,'L',0); //Identificacion eps
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Tercero: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(41,5,utf8_decode($row[6]),'',0,'L',0); //Nombre Tercero
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Concepto: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(90,5,utf8_decode($row[7]),'',0,'L',0); //Concepto Nota
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Valor NC: ','',0,'L',0);
$pdf->SetFont('Courier','B',11);
$pdf->Cell(41,5,'$ '.number_format($row[8],2,'.',','),'',0,'L',0); //valor NC
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Valor letras:','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(0,5,utf8_decode(strtoupper(ValorLetras($row[8]))),0); //Descripcion
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,utf8_decode('Descripción'),'',0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,5,utf8_decode($row[9]),0); //Descripcion

$pdf->SetFont('Arial','B',8);
$pdf->Cell(0,3,utf8_decode('Datos Factura Afectada'),'T',0,'R',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Fecha Factura: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(70,5,FormatoFecha($row[11]),'',0,'L',0); //fecha fac
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,utf8_decode('Admisión: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,strtoupper($row[12]),'',0,'L',0); //tipo
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Paciente: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(70,5,$row[13],'',0,'L',0); //ced pte
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,utf8_decode('Nombre: '),'',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,utf8_decode($row[14]),'',0,'L',0); //nombre pte
$pdf->Ln();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Plan: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(70,5,utf8_decode($row[15]),'',0,'L',0); //departamento
$pdf->SetFont('Arial','B',9);
$pdf->Cell(26,5,'Saldo Factura: ','',0,'L',0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,'$ '.number_format($row[16],2,'.',','),'',0,'L',0); //rango
$pdf->Ln();

if($_GET["TIPO_NOTA"] == "C"){
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(0,3,utf8_decode('Detalle Nota '.$tipo),'T',0,'R',0);
        $pdf->Ln();
        $pdf->SetFillColor(170);
        $pdf->SetTextColor(255);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(25,4,'CUENTA','',0,'C',1);
        $pdf->Cell(25,4,'CODIGO','',0,'C',1);
        $pdf->Cell(82,4,'NOMBRE SERVICIO','',0,'C',1);
        $pdf->Cell(25,4,'VAL. UNIT.','',0,'C',1);
        $pdf->Cell(13,4,'CANT.','',0,'C',1);
        $pdf->Cell(0,4,'VALOR TOTAL','',0,'C',1);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(255);
        $pdf->SetFont('Arial','',8);



        $SQL="Select a.Codigo_CUE, f.Codigo_SER, f.Nombre_SER, avg(e.ValorEntidad_ORD), (a.ValorDet_NCT/ avg(e.ValorEntidad_ORD)), a.ValorDet_NCT From cznotascontablesdet a, cznotascontablesenc b, gxfacturas c, gxordenescab d, gxordenesdet e, gxservicios f Where a.Codigo_NCT=b.Codigo_NCT and b.NumeroDoc_NCT=c.Codigo_FAC and c.Codigo_ADM=d.Codigo_ADM and d.Codigo_ORD=e.Codigo_ORD and a.Codigo_SER=e.Codigo_SER and e.Codigo_SER=f.Codigo_SER and a.Codigo_NCT='".$row[0]."' group by a.Codigo_CUE, f.Codigo_SER, f.Nombre_SER, a.ValorDet_NCT";
        $resultX = mysqli_query($conexion, $SQL);
        //  echo $SQL;
        while ($rowx = mysqli_fetch_row($resultX)) {
            $pdf->Ln();
            $pdf->Cell(25,4,$rowx[0],'',0,'C',1);
            $pdf->Cell(25,4,$rowx[1],'',0,'C',1);
            $pdf->Cell(82,4,utf8_decode($rowx[2]),'',0,'L',1);
            $pdf->Cell(25,4,number_format($rowx[3],2,'.',','),'',0,'R',1);
            $pdf->Cell(13,4,number_format($rowx[4],0,'.',','),'',0,'R',1);
            $pdf->Cell(0,4,number_format($rowx[5],2,'.',','),'',0,'R',1);

        }
}
mysqli_free_result($resultX);
$pdf->Ln();     
$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,5,'Firma y Sello: ','T',0,'L',0);
$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(46,5,'ELABORADA ['.$row[10].']','T',0,'L',0); //direccion
$pdf->Cell(4,5,'','',0,'L',0); //direccion
$pdf->Cell(46,5,'REVISADA','T',0,'L',0); //direccion
$pdf->Cell(4,5,'','',0,'L',0); //direccion
$pdf->Cell(46,5,'AUTORIZADA','T',0,'L',0); //direccion
$pdf->Cell(4,5,'','',0,'L',0); //direccion
$pdf->Cell(46,5,'CONTABILIZADA','T',0,'L',0); //direccion
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>