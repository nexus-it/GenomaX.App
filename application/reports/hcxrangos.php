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
function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Etiqueta
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extraer atributos
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Etiqueta de apertura
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Etiqueta de cierre
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modificar estilo y escoger la fuente correspondiente
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
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
	/* $this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,5,0); */
}


function TableHD()
{
	$this->SetFillColor(170);
	$this->SetTextColor(255);
	$this->SetFont('Arial','B',9);
	$this->Cell(20,4,'HISTORIA','',0,'C',1);
	$this->Cell(100,4,'PACIENTE','',0,'C',1);
	$this->Cell(50,4,'MUNICIPIO','',0,'C',1);
	$this->Cell(0,4,'DESCARGAR','',0,'C',1);
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
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='facturasaluddet'";
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
$pdf->Settitle('LISTA HC x RANGOS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
//Encabezado de la tabla
$pdf->SetFillColor(255);
//while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
$pdf->TableHD();
	
$SQL="SELECT sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='hcxrangos'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@SEDE",($_GET["SEDE"]),$SQL);
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
	$SQL=str_replace("@CONTRATO",($_GET["CONTRATO"]),$SQL);
	$SQL=str_replace("@PLAN",($_GET["PLAN"]),$SQL);
	$SQL=str_replace("@ORDERBY",($_GET["ORDERBY"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);
$resultH = mysqli_query($conexion, $SQL);
$urly= explode('application/reports/hcxrangos.php', $_SERVER['REQUEST_URI'], 2);
$Route59='http://'.$_SERVER["SERVER_NAME"] .$urly[0].'application/reports/';
while ($rowH = mysqli_fetch_row($resultH)) {
	$html='[ <a href="'.$Route59.'hc.php?HISTORIA='.$rowH[1].'&FOLIO_INICIAL='.$rowH[4].'&FOLIO_FINAL='.$rowH[5].'" target="_tab" >Vista Previa</a> ]';
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	// Agrupacion por Orden de Servicio
	$pdf->Cell(20,4,$rowH[1],'',0,'L|',1);
	$pdf->Cell(100,4,utf8_decode($rowH[2]),'',0,'L',1);
	$pdf->Cell(50,4,utf8_decode($rowH[3]),'',0,'L',1);
	$pdf->Cell(0,4,$pdf->WriteHTML($html),'',0,'C',1);
		
	}
	
	mysqli_free_result($resultH);
	$pdf->Ln();

//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>