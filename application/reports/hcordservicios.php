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
function PDF($orientation='P',$unit='mm',$format='halfletter')
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

$SQL="SELECT sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='hcordservicios'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@HISTORIA",($_GET["HISTORIA"]),$SQL);
	$SQL=str_replace("@FOLIO_INICIAL",($_GET["FOLIO_INICIAL"]),$SQL);
	$SQL=str_replace("@FOLIO_FINAL",($_GET["FOLIO_FINAL"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,2,58);
	$this->SetFillColor(255);
	$this->SetY(4);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,7,strtoupper($rowH[0]),'',0,'C',0); //Razon Social
	$this->SetY(9);
	$this->SetFont('Arial','',9);
	$this->Cell(0,4,'NIT: '.$rowH[1],'',0,'C',0);
	$this->SetY(13);
	$this->Cell(0,4,$rowH[2].' Tel.'.$rowH[3],'',0,'C',0);
	$this->SetY(18);
	$this->SetFont('Arial','B',11);
	$this->Cell(0,6,'ORDENES MEDICAS','',0,'C',0);
	$this->Ln();

	}
	mysqli_free_result($resultH);
}
function Footer()
{
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query($conexion, "SET time_zone = '".$_SESSION["DB_TIMEZONE"]."'");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
	$SQL="Select DATE_FORMAT(curdate(), '%d/%m/%Y'), CURTIME();";	
	$resultD = mysqli_query($conexion, $SQL);
	while($rowD = mysqli_fetch_row($resultD)) {
		$PrintFecha= trim($rowD[0].' '.$rowD[1]);
	} 
	mysqli_free_result($resultD);
    //Posición: a 1,5 cm del final
    $this->SetY(-10);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(15,4,utf8_decode('Powered By:  '),'T',0,'L');
    $this->SetFont('Arial','B',7);
    $this->Cell(10,4,utf8_decode('GenomaX  '),'T',0,'L');
    $this->SetFont('Arial','',7);
    $this->Cell(150,4,'Impreso por: {'.$_SESSION["it_CodigoUSR"].'} - '.$_SESSION["it_user"].'    Fecha: '.$PrintFecha,'T',0,'C');
	$this->SetFont('Arial','',8);
	$this->SetTextColor(100,100,100);
	$this->SetFillColor(175);
    $this->Cell(0,4,'Pag. '.$this->PageNo().'/{nb}','T',0,'R',1);
}
}
$FormatoPagina="halfletter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='hcordservicios'";
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
$pdf->Settitle('ORDENES MEDICAS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 9);
$TipoDx="";
$pdf->AddPage();
//Encabezado de la tabla
$SQL="SELECT * from hcencabezadosdet where codigo_hch='1'";
$result1 = mysqli_query($conexion, $SQL);
if ($row1 = mysqli_fetch_row($result1)) {
	if ($row1["Logo2_HCH"]!="") {
		$pdf->Image('../../files/images/logos/'.$_SESSION["DB_SUFFIX"].'/'.$row1["Logo2_HCH"].'.jpg',4,2,0);
	}
	if ($row1["Paciente_HCH"]=="1") {
		$pdf->Cell(30,4,'Nombre Completo','BL',0,'L',0);
		$pdf->Cell(80,4,$row0["1"],'BL',0,'L',0);
	}
}
//echo $SQL;
mysqli_free_result($result1);

$pdf->SetY(25);
$pdf->SetFillColor(170);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,4,'HISTORIA No. '.$_GET["HISTORIA"],'TB',0,'R',0);
$pdf->Ln();
$SQL="Select k.Sigla_TID, b.ID_TER, b.Nombre_TER, a.EstCivil_PAC, a.fechanac_pac, j.Nombre_SEX, a.Actividad_PAC, b.direccion_ter, b.telefono_ter, l.Nombre_DEP, m.Nombre_MUN, a.Barrio_PAC, c.Acudiente_ADM, c.Telefono_ADM, a.Padre_PAC, a.Madre_PAC, a.Parentesco_PAC, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, i.Codigo_HCF, Folio_HCF from gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h, hcfolios i, gxtiposexo j, cztipoid k, czdepartamentos l, czmunicipios m where j.Codigo_SEX=a.Codigo_SEX and k.Codigo_TID=b.Codigo_TID and l.Codigo_DEP=a.Codigo_DEP and m.Codigo_DEP=l.Codigo_DEP and m.Codigo_MUN=a.Codigo_MUN and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Codigo_ADM=i.Codigo_ADM and b.ID_TER='".$_GET["HISTORIA"]."' and i.Folio_HCF<='".$_GET["FOLIO_FINAL"]."' order by i.Codigo_HCF desc limit 1";
// echo $SQL;
$result0 = mysqli_query($conexion, $SQL);
if ($row0 = mysqli_fetch_row($result0)) {

	$pdf->SetFillColor(255);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(19,4,'Documento','LB',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,4,$row0[0]." ".$row0[1] ,'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(13,4,'Nombre','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(108,4,$row0["2"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(9,4,'Sexo','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,4,$row0["5"],'BR',0,'L',1);

	$pdf->Ln();

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(19,4,'Estado Civil','LB',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(22,4,$row0["3"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(18,4,'Fecha Nac.','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(22,4,formatofecha($row0["4"]),'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(9,4,'Edad','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(33,4,utf8_decode(edad($row0["4"])),'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(18,4,'Ocupacion','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,4,$row0["6"],'BR',0,'L',1);

	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(14,4,'Direccion','LB',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(34,4,$row0["7"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(14,4,'Telefono','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(26,4,$row0["8"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,4,'Barrio','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(24,4,$row0["11"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,4,'Municipio','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,4,$row0["10"].' ('.$row0["9"].')','BR',0,'L',1);

	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,4,utf8_decode('Acompañante'),'LB',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,4,$row0["12"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(5,4,'Tel.','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(26,4,$row0["13"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,4,utf8_decode('Responsable'),'B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,4,$row0["14"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(5,4,'Tel.','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,4,$row0["15"],'BR',0,'L',1);

	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(18,4,utf8_decode('Parentesco'),'LB',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,4,$row0["16"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(12,4,'Entidad','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(55,4,$row0["17"],'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(10,4,'Plan','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(35,4,$row0["18"],'BR',0,'L',1);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,4,$row0["19"],'BR',0,'L',1);
}
mysqli_free_result($result0);
// Fin encabezado - Datos Personales
//Datos del folio
$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and c.Folio_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by  4, 5";
$resultx = mysqli_query($conexion, $SQL);
while ($rowx = mysqli_fetch_row($resultx)) {
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,4,utf8_decode("Admisión: ".$rowx[2]." - Fecha Ingreso: ".$rowx[3]." - Folio: ".$rowx["Folio_HCF"]),'B',0,'R',1);
	$pdf->Ln();
	$pdf->SetFont('Courier','B',9);
	$pdf->Cell(80,4,"Area: ".$rowx[6],'T',0,'L',1);
	$pdf->Cell(70,4,"Fecha: ".$rowx[4],'T',0,'L',1);
	$pdf->Cell(0,4,"Hora: ".$rowx[5],'T',0,'R',1);
	$pdf->Cell(0,3,"",'',0,'R',1);
	$pdf->Ln();
	// DIAGNOSTICOS
	if ($rowx[9]!="0") {
		$SQL="Select c.Codigo_DGN, c.Descripcion_DGN, a.Tipo_DGN, g.Nombre_TDG, d.Codigo_DGN, d.Descripcion_DGN, e.Codigo_DGN, e.Descripcion_DGN, f.Codigo_DGN, f.Descripcion_DGN, a.Manejo_DGN From gxtipodiag g, czterceros b, gxdiagnostico c Where a.Codigo_TER=b.Codigo_TER and c.Codigo_TDG=a.Tipo_DGN and c.Codigo_DGN=a.Codigo_DGN and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."'";
		$resultx2 = mysqli_query($conexion, $SQL);
		if ($rowx2 = mysqli_fetch_row($resultx2)) {
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(180);
			$pdf->Cell(2,4,"",'LTR',0,'L',1);			
			$pdf->Cell(32,4,utf8_decode("Diagnóstico"),'TR',0,'L',0);
			$pdf->SetFillColor(255);
			$pdf->Ln();
			$pdf->Cell(2,4,'','T',0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,4,"Principal",'T',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[0].' - '.$rowx2[1]),'T',0,'L',1);
			$pdf->Ln();
			$pdf->Cell(2,4,'','',0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,4,"Tipo Dx.",'',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[2].' - '.$rowx2[3]),'',0,'L',1);
			$pdf->Ln();
			
		}
		mysqli_free_result($resultx2);
		$pdf->Cell(0,3,"",'',0,'R',0);
		
	}
	// campos del formato de la hc
	$pdf->Ln();	
	
	// ORDENES DE SERVICIO
		$SQL="Select a.TipoSer_HCS, e.Descripcion_FRC, a.Cantidad_HCS, a.Observaciones_HCS From hcordenesservicios a, czterceros b, gxfrecuenciaserv e Where e.Codigo_FRC=a.Frecuencia_HCS and a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 1";
		$resultx2 = mysqli_query($conexion, $SQL);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(180);
		$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
		$pdf->Cell(32,5,utf8_decode("Ordenes de Servicio"),'TBR',0,'L',0);
		$pdf->Cell(0,5,'','B',0,'L',0);
		$pdf->SetFillColor(255);
		$pdf->Ln();
		$pdf->Cell(0,2,'','',0,'L',0);
		$pdf->Ln();
		$pdf->SetFont('Courier','B',8);
		$pdf->Cell(15,4,'CANTIDAD','TL',0,'C',0);
		$pdf->Cell(140,4,'SERVICIO','TL',0,'C',0);
		$pdf->Cell(0,4,'FRECUENCIA','TLR',0,'C',0);
		$pdf->Ln();
		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,utf8_decode($rowx2[2]),'TLB',0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(140,4,utf8_decode($rowx2[0]),'TLB',0,'L',0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[1]),'TLBR',0,'L',0);
			$pdf->Ln();
			if ($rowx2[3]!="") {
				$pdf->SetFont('Arial','',7);
				$pdf->MultiCell(0,5,'OBSERVACIONES: '.utf8_decode($rowx2[3]),0,'J',0);
				$pdf->Ln();
			}
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();		

	
	// FIRMA PROFESIONAL
	//Extraigo la firma de la bd
	$LeFirma='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/hc/'.$rowx[21].'.jpg';
	file_put_contents($LeFirma, $rowx[18]);
	//Muestro la foto
	$Posy=$pdf->GetY();
	if ($rowx[18]=="") {
    	$pdf->Image('../../files/_all/images/firmas/white.jpg',150,$Posy,40);
	} else {
		$pdf->Image($LeFirma,150,$Posy,40);
	}
	$pdf->SetY($Posy+12);
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(130,4,"",'',0,'C',0);
	$pdf->Cell(0,4,utf8_decode($rowx[16]),'T',0,'C',0);
	$SQL="Select b.Nombre_ESP From gxmedicosesp a, gxespecialidades b Where a.Codigo_ESP=b.Codigo_ESP and b.Estado_ESP='1' and  Codigo_TER='".$rowx[21]."' Order By a.Tipo_ESP";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(130,3,"",'',0,'C',0);
		$pdf->Cell(0,3,utf8_decode($rowx2[0]),'',0,'C',0);	
	}
	mysqli_free_result($resultx2);
	$pdf->Ln();
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(130,3,"",'',0,'C',0);
	$pdf->Cell(0,3,'R.M. '.utf8_decode($rowx[17]),'',0,'C',0);
	
}
mysqli_free_result($resultx);



//Mostramos el informe
$pdf->Output();
?>