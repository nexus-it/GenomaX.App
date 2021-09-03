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
	//$this->Image('../../themes/'.$_SESSION["THEME_DEFAULT"].'/images/background2.jpg',30,60,0);
	//$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',6,11,25);
	/*
	$this->SetY(15);
	$this->SetFont('Arial','',8);
	$this->SetTextColor(100,100,100);
	$this->Cell(15,4,'','R',0,'R');
	$this->Cell(0,4,' AXISMEDICAL TRAVELLERS S.A.S.','L',0,'L');
	$this->Ln();
	$this->Cell(15,4,'','R',0,'R');
	$this->Cell(0,4,' Cra 9 No. 53 - 58 piso 6 Of. 608 ','L',0,'L');
	$this->Ln();
	$this->Cell(15,4,'','R',0,'R');
	$this->Cell(0,4,' Tel. +57 322 7414877','L',0,'L');
	$this->Ln();
	$this->Cell(15,4,'','R',0,'R');
	$this->Cell(0,4,utf8_decode(' Bogotá - Colombia'),'L',0,'L');
	$this->Ln();
	$this->Cell(15,4,'','R',0,'R');
	$this->Cell(0,4,' http://axistravellers.com/','L',0,'L');
	*/
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','B',8);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(150,5,' Kl\'ud ','T',0,'L');
    $this->SetFont('Arial','',7);
    $this->Cell(0,5,'  Powered by Nexus-it.co','T',0,'R');
    /*$this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');*/
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='klcertificaciones'";
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
$pdf->Settitle('CERTIFICACIONES');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(20, 20,20);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
//Encabezado de la tabla
$pdf->SetFillColor(255);
//while($row = mysqli_fetch_row($result)) {

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='klcertificaciones'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@PREFIJO",($_GET["PREFIJO"]),$SQL);
	$SQL=str_replace("@EMISION_INICIAL",($_GET["EMISION_INICIAL"]),$SQL);
	$SQL=str_replace("@EMISION_FINAL",($_GET["EMISION_FINAL"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_row($resultH)) {
	$pdf->AddPage();

	//Marca de agua;
	$LeWater='../../files/klud/images/logo02'.str_replace(" ","_",$rowH[8]).'.jpg';
	file_put_contents($LeWater, $rowH[26]);
	$pdf->Image($LeWater,30,60,0);
	//Logo
	$LeLogo='../../files/klud/images/logo01'.str_replace(" ","_",$rowH[8]).'.jpg';
	file_put_contents($LeLogo, $rowH[25]);
	$pdf->Image($LeLogo,6,11,25);
	
	if ($rowH[27]=='1') {
		$SQL="Select a.Nombre_AGE, concat('NIT ',b.ID_TER,'-',b.DigitoVerif_TER), b.Telefono_TER, concat( d.Nombre_MUN, ' - ', c.Nombre_DST), b.Web_TER From klagencias a, czterceros b, kldestinos c, czmunicipios d Where a.Codigo_TER=b.Codigo_TER and c.Codigo_DST=a.Codigo_PAI and d.Codigo_MUN= a.Codigo_MUN and a.Codigo_DEP=d.Codigo_DEP and a.Codigo_AGE='".$rowH[30]."'";
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

	$pdf->SetY(42);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,8,'Bogota, '.FormatoFecha($rowH[3]),'',0,'R',0); //Razon Social

	$pdf->SetY(65);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,8,$rsocial.' CERTIFICA','',0,'C',0); //Razon Social

	$pdf->SetY(15);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(100,100,100);
	$pdf->Cell(15,4,'','R',0,'R');
	$pdf->Cell(0,4,$rsocial,'L',0,'L');
	$pdf->Ln();
	$pdf->Cell(15,4,'','R',0,'R');
	$pdf->Cell(0,4,$direccionnit,'L',0,'L');
	$pdf->Ln();
	$pdf->Cell(15,4,'','R',0,'R');
	$pdf->Cell(0,4,'Tel. '.$telefono,'L',0,'L');
	$pdf->Ln();
	$pdf->Cell(15,4,'','R',0,'R');
	$pdf->Cell(0,4,utf8_decode($ubicacion),'L',0,'L');
	$pdf->Ln();
	$pdf->Cell(15,4,'','R',0,'R');
	$pdf->Cell(0,4,strtolower($website),'L',0,'L');
	
	/*$pdf->SetY(88);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,8,'REF: POLIZA '.$_GET["PREFIJO"]."-".str_pad($rowH[2], 10, "0", STR_PAD_LEFT),'',0,'R',0); //Razon Social
	*/
	$moneda="Dólares";
	$fin="";
	if ("UNION EURO AXIS"==$rowH[10]) {
		$moneda="Euros";
		$fin=" y todos los paìses pertenecientes del acuerdo Schengen";
	}
	if ("PROMO 2X1 EUROAXIS"==$rowH[10]) {
		$moneda="Euros";
		$fin=" y todos los paìses pertenecientes del acuerdo Schengen";
	}
	if ("PROMO EUROAXIS"==$rowH[10]) {
		$moneda="Euros";
		$fin=" y todos los paìses pertenecientes del acuerdo Schengen";
	}

	$html=utf8_decode("La expedición de la póliza No. ".$_GET["PREFIJO"]."-".str_pad($rowH[2], 10, "0", STR_PAD_LEFT)." a nombre de <b>".$rowH[6]."</b> con No. de pasaporte <b>".$rowH[5]."</b> quien adquirió una póliza de seguro médico con Plan ".$rowH[10].". Su viaje está programado con fecha de inicio para el día <b>".FormatoFecha($rowH[14])."</b> y con fecha de finalización el día <b>".FormatoFecha($rowH[15])."</b>. A continuación se detallan las coberturas en ".$moneda." hacia <b>".$rowH[13]."</b>".$fin.".");

	$pdf->SetY(96);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->WriteHTML($html);

	$pdf->SetY(122);
	if ($rowH[23]=="Anulado") {
		$pdf->Image('../../anulado.jpg',35,45,0);
	}
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,'COBERTURAS','',0,'C',0);
	$pdf->Ln();
	$SQL="SELECT Nombre_COB, Descripcion_COB from klplanescobertura a, klemisiones b, klcotizaciones c where a.codigo_pla=c.codigo_pla and c.codigo_ctz=b.codigo_ctz and codigo_emi='".$rowH[2]."' order by orden_cob LIMIT 6";
//	echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	while ($row = mysqli_fetch_row($result)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(160,5,$row[0],'',0,'L',0);
		$pdf->Cell(0,5,strtoupper($row[1]),'',0,'R',0);
	}
	mysqli_free_result($result);
	$html=utf8_decode("Cualquier información adicional que requiera, no dude en comunicarse con nosotros.");

	$pdf->SetY(166);
	$pdf->SetFont('Arial','',11);
	$pdf->WriteHTML($html);

	$pdf->SetY(186);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(11,5,'Nota: ','',0,'L',0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(0,5,'Este producto no requiere deducible.','',0,'L',0);

	$pdf->SetY(216);
	$pdf->Cell(0,5,'Cordialmente,','',0,'L',0);

	$pdf->SetY(230);
	if ($rowH[27]!='1') {
		$pdf->Image('../../selloaxis.jpg',10,215,0);
	}
	$pdf->SetY(238);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,5,'Dpto. Operaciones','',0,'L',0);
	$pdf->SetY(244);
	$pdf->Cell(0,5,$rsocial,'',0,'L',0);
 }  
	mysqli_free_result($resultH);
	$pdf->Ln();
//}
//mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>