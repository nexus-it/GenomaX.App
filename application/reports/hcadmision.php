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

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='hcadmision'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@CODIGO_FINAL",($_GET["CODIGO_FINAL"]),$SQL);
	$SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	if (strlen($rowH[0])>=50 ) {
		$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,6,0);
	} else {
		$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,2,0);	
	}
	$this->SetFillColor(255);
	$this->SetY(3);
	if (strlen($rowH[0])>=40 ) {
		if (strlen($rowH[0])>=50 ) {
			$this->SetFont('Arial','B',10);
		} else {
			$this->SetFont('Arial','B',12);
		}
	} else {
		$this->SetFont('Arial','B',13);
	}
	$this->Cell(0,8,strtoupper($rowH[0]),'',0,'C',0); //Razon Social
	$this->SetY(9);
	$this->SetFont('Arial','',10);
	$this->Cell(0,5,'NIT: '.$rowH[1],'',0,'C',0);
	$this->SetY(14);
	$this->Cell(0,5,$rowH[2].' Tel.'.$rowH[3],'',0,'C',0);
	$this->SetY(19);
	$this->SetFont('Arial','B',12);
	$this->Cell(0,7,'HISTORIA CLINICA','',0,'C',0);
	$this->Ln();
	$this->SetY(28);
	$this->SetFillColor(170);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,5,'HISTORIA No. '.$rowH[6],'TB',0,'R',0);
	$this->Ln();


	}
	mysqli_free_result($resultH);
}
function Footer()
{
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query($conexion, "SET time_zone = '".$_SESSION["DB_TIMEZONE"]."'");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
	$SQL="Select DATE_FORMAT(curdate(), '%d/%m/%Y'), CURTIME();";	
	$resultD = mysqli_query($conexion, $SQL);
	while($rowD = mysqli_fetch_row($resultD)) {
		$PrintFecha= trim($rowD[0].' '.$rowD[1]);
	} 
	mysqli_free_result($resultD);
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(15,5,utf8_decode('Powered By:  '),'T',0,'L');
    $this->SetFont('Arial','B',7);
    $this->Cell(10,5,utf8_decode('GenomaX  '),'T',0,'L');
    $this->SetFont('Arial','',7);
    $this->Cell(150,5,'Impreso por: {'.$_SESSION["it_CodigoUSR"].'} - '.$_SESSION["it_user"].'    Fecha: '.$PrintFecha,'T',0,'C');
	$this->SetFont('Arial','',8);
	$this->SetTextColor(100,100,100);
	$this->SetFillColor(175);
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R',1);
}
function firmas($Firma, $Tercero, $NombreDoc, $RM, $PosYe){
	//Extraigo la firma de la bd
	$LeFirma='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/hc/'.$Tercero.'.jpg';
	file_put_contents($LeFirma, $Firma);
	//Muestro la foto
	$Posy=$PosYe;
	if ($Firma=="") {
    	$this->Image('../../files/_all/images/firmas/white.jpg',150,$Posy,40);
	} else {
		$this->Image($LeFirma,150,$Posy,40);
	}
	$this->SetY($Posy+10);
	$this->Ln();
	$this->SetFont('Arial','B',8);
	$this->Cell(130,4,"",'',0,'C',0);
	$this->Cell(0,3,utf8_decode($NombreDoc),'T',0,'C',0);
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select b.Nombre_ESP From gxmedicosesp a, gxespecialidades b Where a.Codigo_ESP=b.Codigo_ESP and b.Estado_ESP='1' and  Codigo_TER='".$Tercero."' Order By a.Tipo_ESP";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$this->Ln();
		$this->SetFont('Arial','',8);
		$this->Cell(130,3,"",'',0,'C',0);
		$this->Cell(0,3,utf8_decode($rowx2[0]),'',0,'C',0);	
	}
	mysqli_free_result($resultx2);
	$this->Ln();
	$this->SetFont('Arial','',8);
	$this->Cell(130,3,"",'',0,'C',0);
	$this->Cell(0,3,'R.M. '.utf8_decode($RM),'',0,'C',0);
}
function encabezadoz($titulo){
	if ($titulo!='') {
		$this->SetY(19);
		$this->SetFillColor(255);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,5,$titulo,'',0,'C',1);
		$this->Ln();
	}
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select k.Sigla_TID, b.ID_TER, b.Nombre_TER, a.EstCivil_PAC, a.fechanac_pac, j.Nombre_SEX, a.Actividad_PAC, b.direccion_ter, b.telefono_ter, l.Nombre_DEP, m.Nombre_MUN, a.Barrio_PAC, c.Acudiente_ADM, c.Telefono_ADM, a.Padre_PAC, a.Madre_PAC, a.Parentesco_PAC, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, i.Codigo_HCF, Folio_HCF from gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h, hcfolios i, gxtiposexo j, cztipoid k, czdepartamentos l, czmunicipios m where j.Codigo_SEX=a.Codigo_SEX and k.Codigo_TID=b.Codigo_TID and l.Codigo_DEP=a.Codigo_DEP and m.Codigo_DEP=l.Codigo_DEP and m.Codigo_MUN=a.Codigo_MUN and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Codigo_ADM=i.Codigo_ADM and c.Codigo_ADM='".$_GET["CODIGO_FINAL"]."' order by i.Codigo_HCF desc limit 1";
	$result0 = mysqli_query($conexion, $SQL);
	if ($row0 = mysqli_fetch_row($result0)) {
	 // echo $SQL;
		$this->SetY(35);
		$this->SetFillColor(255);

		$this->SetFont('Arial','B',9);
		$this->Cell(19,5,'Documento','LB',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(30,5,$row0[0]." ".$row0[1] ,'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(13,5,'Nombre','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(108,5,utf8_decode($row0["2"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(9,5,'Sexo','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(0,5,$row0["5"],'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',9);
		$this->Cell(19,5,'Estado Civil','LB',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(22,5,utf8_decode($row0["3"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(18,5,'Fecha Nac.','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(22,5,formatofecha($row0["4"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(9,5,'Edad','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(33,5,utf8_decode(edad($row0["4"])),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(18,5,'Ocupacion','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(0,5,utf8_decode($row0["6"]),'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(14,5,'Direccion','LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(34,5,utf8_decode($row0["7"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(14,5,'Telefono','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(26,5,utf8_decode($row0["8"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(10,5,'Barrio','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(24,5,utf8_decode($row0["11"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(15,5,'Municipio','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["10"]).' ('.utf8_decode($row0["9"]).')','BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,utf8_decode('Acompañante'),'LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,utf8_decode($row0["12"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(5,5,'Tel.','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(26,5,utf8_decode($row0["13"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,utf8_decode('Responsable'),'B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode($row0["14"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(5,5,'Tel.','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["15"]),'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(18,5,utf8_decode('Parentesco'),'LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,utf8_decode($row0["16"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(12,5,'Entidad','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(55,5,utf8_decode($row0["17"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(10,5,'Plan','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(35,5,utf8_decode($row0["18"]),'BR',0,'L',1);

		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["19"]),'BR',0,'L',1);
		$this->Ln();
	}
	mysqli_free_result($result0);
	// Fin encabezado - Datos Personales
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='hcadmision'";
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
$pdf->Settitle('HISTORIA CLINICA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();
//Encabezado de la tabla
$UnFolio=0;
$SQL="SELECT * from hcencabezadosdet where codigo_hch='1'";
$result1 = mysqli_query($conexion, $SQL);
if ($row1 = mysqli_fetch_row($result1)) {
	if ($row1["Logo2_HCH"]!="") {
		$pdf->Image('../../files/images/logos/'.$_SESSION["DB_SUFFIX"].'/'.$row1["Logo2_HCH"].'.jpg',4,2,0);
	}
	if ($row1["Paciente_HCH"]=="1") {
		$pdf->Cell(30,5,'Nombre Completo','BL',0,'L',0);
		$pdf->Cell(80,5,$row0["1"],'BL',0,'L',0);
	}
}
//echo $SQL;
mysqli_free_result($result1);

$pdf->encabezadoz('');

//Datos del folio
if (isset($_GET["FORMATO"])) {
	if ($_GET["FORMATO"]=='*') {
		$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, g.ID_TER from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and a.Codigo_ADM between '".$_GET["CODIGO_INICIAL"]."' and '".$_GET["CODIGO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER order by 4, 5";
	} else {
		$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, g.ID_TER from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and a.Codigo_ADM between '".$_GET["CODIGO_INICIAL"]."' and '".$_GET["CODIGO_FINAL"]."' and b.Codigo_HCT='".$_GET["FORMATO"]."' and c.Codigo_TER=g.Codigo_TER  order by 4, 5";
	}
} else {
	$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, g.ID_TER from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and a.Codigo_ADM between '".$_GET["CODIGO_INICIAL"]."' and '".$_GET["CODIGO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER  order by 4, 5";
}
$resultx = mysqli_query($conexion, $SQL);
while ($rowx = mysqli_fetch_row($resultx)) {
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFillColor(220);
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(150,5,"",'TL',0,'L',1);
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(0,5,"FOLIO: ".$rowx[23],'TR',0,'R',1);
	$pdf->SetFillColor(255);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,utf8_decode("Admisión: ".$rowx[2]." - Fecha Ingreso: ".$rowx[3]),'B',0,'R',1);
	$pdf->Ln();
	$pdf->SetFont('Courier','B',9);
	$pdf->Cell(80,5,"Area: ".$rowx[6],'T',0,'L',1);
	$pdf->Cell(70,5,"Fecha: ".$rowx[4],'T',0,'L',1);
	$pdf->Cell(0,5,"Hora: ".$rowx[5],'T',0,'R',1);
	$pdf->Cell(0,3,"",'',0,'R',1);
	$pdf->Ln();
	$pdf->Ln();
	// ANTECEDENTES
	$SQL="Select count(*) From hcantecedentes a, hctipoantecedentes b, czterceros c, hcfolios d Where d.Codigo_TER=c.Codigo_TER and a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$rowx[24]."'";
	$resultANT = mysqli_query($conexion, $SQL);
	if ($rowANT = mysqli_fetch_row($resultANT)) {
		if ($rowANT[0]!=0) {
			$pdf->Ln();
			$pdf->SetFont('Arial','B',8);
			$pdf->SetFillColor(180);
			$pdf->Cell(2,5,"",'LTR',0,'L',1);			
			$pdf->Cell(32,5,"Antecedentes",'TR',0,'L',0);
			$pdf->SetFillColor(255);
			$pdf->Cell(0,5,"",'B',0,'L',1);
			$pdf->Ln();
			$SQL="Select b.Nombre_HCA, a.Descripcion_HCA From hcantecedentes a, hctipoantecedentes b, czterceros c, hcfolios d Where d.Codigo_TER=c.Codigo_TER and a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$rowx[24]."'";
			$resultANT1 = mysqli_query($conexion, $SQL);
			while ($rowANT1 = mysqli_fetch_row($resultANT1)) {
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(0,5,utf8_decode($rowANT1[0]),'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Ln();
				$pdf->MultiCell(0,4,utf8_decode($rowANT1[1]),0,'J',1);
			}
			mysqli_free_result($resultANT1);
			$pdf->Cell(0,2,"",'',0,'R',1);
			$pdf->Ln();
		}
	}
	mysqli_free_result($resultANT);
	// SIGNOS VITALES	
	if ($rowx[7]!="0") {
		$SQL="Select c.Sigla_HSV, a.Valor_HSV, c.Codigo_HSV, c.Prefijo_HSV, c.Sufijo_HSV From hcsignosvitales a, czterceros b, hcsv2 c Where a.Codigo_TER=b.Codigo_TER and c.Codigo_HSV=a.Codigo_HSV and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."' order by 3";
		$resultx2 = mysqli_query($conexion, $SQL);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(180);
		$pdf->Cell(2,5,"",'LTR',0,'L',1);			
		$pdf->Cell(32,5,"Signos Vitales",'TR',0,'L',0);
		$pdf->SetFillColor(225);
		$pdf->Ln();
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			$pdf->Cell(2,4,'','T',0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(6,4,utf8_decode($rowx2[0]),'T',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,utf8_decode($rowx2[3].' '.$rowx2[1].' '.$rowx2[4]),'T',0,'L',1);
		}
		mysqli_free_result($resultx2);
		$pdf->SetFillColor(255);
		$pdf->Cell(0,5,'','T',0,'L',1);
		$pdf->Ln();
		$pdf->Cell(0,2,"",'',0,'R',1);
		$pdf->Ln();	
	}
	// DIAGNOSTICOS
	if ($rowx[9]!="0") {
		$SQL="Select c.Codigo_DGN, c.Descripcion_DGN, a.Tipo_DGN, g.Nombre_TDG, d.Codigo_DGN, d.Descripcion_DGN, e.Codigo_DGN, e.Descripcion_DGN, f.Codigo_DGN, f.Descripcion_DGN, a.Manejo_DGN From gxtipodiag g, czterceros b, gxdiagnostico c, hcdiagnosticos a left join gxdiagnostico d on a.CodigoR_DGN=d.Codigo_DGN left join gxdiagnostico e on a.CodigoR2_DGN=e.Codigo_DGN left join gxdiagnostico f on a.CodigoR2_DGN=f.Codigo_DGN Where a.Codigo_TER=b.Codigo_TER and g.Codigo_TDG=a.Tipo_DGN and c.Codigo_DGN=a.Codigo_DGN and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."'";
		$resultx2 = mysqli_query($conexion, $SQL);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFillColor(180);
		$pdf->Cell(2,5,"",'LTR',0,'L',1);			
		$pdf->Cell(32,5,utf8_decode("Diagnóstico"),'TR',0,'L',0);
		$pdf->SetFillColor(255);
		$pdf->Ln();
		if ($rowx2 = mysqli_fetch_row($resultx2)) {
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
			if ($rowx2[4]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[4].' - '.$rowx2[5]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[6]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado 2",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[6].' - '.$rowx2[7]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[8]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado 3",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[8].' - '.$rowx2[9]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[10]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(32,4,utf8_decode("Diagnóstico de Manejo"),'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->MultiCell(0,4,utf8_decode($rowx2[10]),'','L',1);
				$pdf->Ln();
			}
		}
		mysqli_free_result($resultx2);
		$pdf->Cell(0,3,"",'',0,'R',1);
		$pdf->Ln();
	}
	// campos del formato de la hc
	$Posx=10;
	$Posy=$pdf->GetY();
	$Posyfin=$Posy;
	$TamW=196;
	$pdf->SetX($Posx);
	$SQL="Select a.* From hc_". $rowx[20]." a, czterceros b Where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."';";
	$resultx2 = mysqli_query($conexion, $SQL);
	$DatosHC = mysqli_fetch_array($resultx2);
	mysqli_free_result($resultx2);
	$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='0' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$rowx[24]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
	$resultx2 = mysqli_query($conexion, $SQL);
	$Indice=2;
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		//if ($DatosHC[$Indice]!="") {
			//CURACIONES
			if ($rowx2[0]=="curacion") {
				if ($DatosHC[$Indice]!="0") {
					$SQL= "Select Nombre_HTC from hctipocuraciones Where Codigo_HTC='".$DatosHC[$Indice]."'";
					$resultxC = mysqli_query($conexion, $SQL);
					if ($rowxC = mysqli_fetch_row($resultxC)) {
						$pdf->SetFont('Arial','B',9);
						$pdf->SetFillColor(230);
						$pdf->Cell(0,6,utf8_decode("Curación ".$rowxC[0]),'TB',0,'R',1);
						$pdf->SetFillColor(255);
						$pdf->SetFont('Arial','',8);
						$pdf->Ln();
					}
					mysqli_free_result($resultxC);
				}
				$Indice=$Indice+1;
			} else {
				//SI NO SON CURACIONES
				if ($rowx2[3]!="well") {
					if ($rowx2[3]=="check") {
						$Posx=$pdf->GetX();
						if ($Posx>= ($TamW-5)) {
							$pdf->Ln();
							$pdf->Cell(0,1,'','',0,'L',0);
							$pdf->Ln();
						}
						if ($Posx== 0) {
							$pdf->Ln();
						}
						$pdf->SetFont('Arial','',8);
						$pdf->SetFillColor(222);
						$pdf->Cell(1,5,'','',0,'L',0);
						$pdf->Cell(($TamW*$rowx2[4]/12)-6,5,utf8_decode($rowx2[2]),'LBT',0,'L',1);		
						$pdf->SetFillColor(255);
						//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
						$pdf->SetFont('Courier','B',7);
					} else {
						if ($rowx2[3]=="select") {
							$pdf->SetFont('Arial','B',8);
							$pdf->SetFillColor(180);
							$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
							$pdf->Cell(34,5,utf8_decode($rowx2[2]),'TRB',0,'L',0);
							$pdf->SetFillColor(255);
							//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
							$pdf->SetFont('Arial','',8);
							
						} else {
							$pdf->SetFont('Arial','B',8);
							$pdf->SetFillColor(180);
							$pdf->Cell(2,5,"",'LTR',0,'L',1);			
							$pdf->Cell(34,5,utf8_decode($rowx2[2]),'TR',0,'L',0);
							$pdf->SetFillColor(255);
							//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
							$pdf->SetFont('Arial','',8);
							$pdf->Ln();
						}
					}
				}
				switch ($rowx2[3]) {
					case 'select':
				 		$pdf->Cell(0,5,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
				 		$pdf->Ln();
				 		$Indice=$Indice+1;
				 		break;
				 	case 'well':
				 		$pdf->SetFont('Courier','B',7);
				 		$pdf->Ln();
				 		$pdf->SetFillColor(250);
				 		$pdf->Cell(65,3,str_repeat ('-', 20),'',0,'R',1);
						$pdf->Cell(66,3,utf8_decode($rowx2[2]),'RBLT',0,'C',1);
						$pdf->Cell(65,3,str_repeat ('-', 20),'',0,'L',1);
						$pdf->SetFont('Arial','',8);
						$pdf->SetFillColor(255);
						$pdf->Ln();
						$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC, a.Codigo_HCT from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='".$rowx2[1]."' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$rowx[24]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
						$resultx3 = mysqli_query($conexion, $SQL);
						while ($rowx3 = mysqli_fetch_row($resultx3)) {
							if ($DatosHC[$Indice]!="") {
								if ($rowx3[3]=="check") {
									$Posx=$pdf->GetX();
									if ($Posx>= ($TamW-5)) {
										$pdf->Ln();
										$pdf->Cell(0,1,'','',0,'L',0);
										$pdf->Ln();
									}
									if ($Posx== 0) {
										$pdf->Ln();
									}
									$pdf->SetFont('Arial','',8);
									$pdf->SetFillColor(222);
									$pdf->Cell(1,5,'','',0,'L',0);
									$pdf->Cell(($TamW*$rowx3[4]/12)-6,5,utf8_decode($rowx3[2]),'LBT',0,'L',1);			
									$pdf->SetFillColor(255);
									//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
									$pdf->SetFont('Courier','B',8);
								} else {
									if ($rowx3[3]=="select") {
										$pdf->SetFont('Arial','B',8);
										$pdf->SetFillColor(180);
										$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
										$pdf->Cell(34,5,utf8_decode($rowx3[2]),'TRB',0,'L',0);
										$pdf->SetFillColor(255);				
										//$pdf->Cell($TamW,4,utf8_decode($rowx3[2]),'B',0,'L',1);
										$pdf->SetFont('Arial','',8);
									} else {
										$pdf->SetFont('Arial','B',8);
										$pdf->SetFillColor(180);
										$pdf->Cell(2,5,"",'LTR',0,'L',1);			
										$pdf->Cell(34,5,utf8_decode($rowx3[2]),'TR',0,'L',0);
										$pdf->SetFillColor(255);				
										//$pdf->Cell($TamW,4,utf8_decode($rowx3[2]),'B',0,'L',1);
										$pdf->SetFont('Arial','',8);
										$pdf->Ln();
									}
								}
								switch ($rowx3[3]) {
								 	case 'textarea':
								 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
								 		break;
								 	case 'select':
								 		$pdf->Cell(0,5,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
								 		$pdf->Ln();
								 		break;
								 	case 'image':
								 		$pdf->Cell($TamW*$rowx3[4]/12,40,' ','TBLR',0,'C',1);
								 		/*
								 		$Posy=$pdf->GetY();
								 		$pdf->Image('../../files/_all/images/firmas/white.jpg',20,$Posy,$TamW*$rowx3[4]/12);
								 		*/
								 		$pdf->Ln();
								 		break;
								 	case 'check':
								 		$chekea="";
								 		if ($DatosHC[$Indice]=="1") {
								 			$chekea="X";
								 		}
								 		$pdf->Cell(5,5,utf8_decode($chekea),'TRB',0,'C',1);
								 		break;
								 	default:
								 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
								 		break;
								}
							}
							$Indice=$Indice+1;
						}
						//$pdf->SetY($Posyfin-5);
						$pdf->Ln();
						$pdf->SetFont('Courier','B',7);
						$pdf->SetFillColor(250);
						$pdf->Cell(0,2,str_repeat ('-', 86),'',0,'C',0);
						$pdf->SetFillColor(255);
						$pdf->Ln();
						mysqli_free_result($resultx3);				
						break;
				 	case 'textarea':
				 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
				 		$Indice=$Indice+1;
				 		break;
				 	case 'check':
				 		$chekea="";
				 		if ($DatosHC[$Indice]=="1") {
				 			$chekea="X";
				 		}
				 		$pdf->Cell(5,5,utf8_decode($chekea),'TRLB',0,'C',1);
				 		$Indice=$Indice+1;
				 		break;
				 	default:
				 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
				 		//$pdf->Cell($TamW,4,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
				 		$Indice=$Indice+1;
				 		break;
				}
			}
		/*}
		else {
			if ($rowx2[3]=='image') {
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(180);
				$pdf->Cell(2,5,"",'LTR',0,'L',1);			
				$pdf->Cell(32,5,utf8_decode($rowx2[2]),'TR',0,'L',0);
				$pdf->SetFillColor(255);
				//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Ln();
			}
		}*/
		
	}
	mysqli_free_result($resultx2);
	$pdf->Cell(0,3,"",'',0,'L',1);
	$pdf->Ln();		

	// INDICACIONES Y TRATAMIENTO	
	if ($rowx[12]!="0") {
		$SQL="Select a.Indicacion_HTT, a.Codigo_HTT From hctratamiento a, czterceros b where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(180);
				$pdf->Cell(2,5,"",'LTR',0,'L',1);			
				$pdf->Cell(32,5,utf8_decode("Tratamiento"),'TR',0,'L',0);
				$pdf->SetFillColor(255);
				$pdf->Ln();
			}
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			if ($NumIndi=="1") {
				$pdf->Cell(2,4,'','T',0,'L',1);
				$pdf->MultiCell(0,4,utf8_decode($NumIndi.'- '.$rowx2[0]),'T','L',1);
			} else {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->MultiCell(0,4,utf8_decode($NumIndi.'- '.$rowx2[0]),'','L',1);
			}
		}
		mysqli_free_result($resultx2);
		/*
		$pdf->Cell(0,5,'','T',0,'L',1);
		$pdf->Ln();
		*/
		$pdf->Cell(0,1,"",'',0,'R',1);
		$pdf->Ln();	
	}
	// NOTAS ACLARATORIAS DEL FOLIO
	$SQL="Select Fecha_HCN, Nota_HCN From hcnotas  Where Codigo_TER='".$rowx[22]."' and Codigo_HCF='".$rowx[1]."' Order By Fecha_HCN;";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$pdf->SetFillColor(180);
		$pdf->SetFont('Courier','B',9);
		$pdf->Cell(70,5,"* NOTA ACLARATORIA",'TBL',0,'L',1);
		$pdf->Cell(0,5,"FECHA: ".$rowx2[0],'TBR',0,'R',1);
		$pdf->Ln();
		$pdf->SetFillColor(255);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(0,4,utf8_decode($rowx2[1]),'RLB','L',1);
		$pdf->Ln();	
	}
	mysqli_free_result($resultx2);

	// FIRMA PROFESIONAL
	$pdf->Ln();	
	$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());

	// ORDENES DE MEDICAMENTOS
	if ($rowx[11]!="0") {
		$SQL="Select c.CUM_MED, c.Nombre_MED, Dosis_HCM, Descripcion_VIA, Descripcion_FRC, Duracion_HCM, Estado_HCM, Observaciones_HCM, Cantidad_HCM From hcordenesmedica a, czterceros b, gxmedicamentos c, gxviasmed d, gxfrecuenciamed e where e.Codigo_FRC=Frecuencia_HCM and d.Codigo_VIA=Via_HCM and a.Codigo_TER=b.Codigo_TER and c.Codigo_SER=a.Codigo_SER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."' and Estado_HCM='O' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDEN DE MEDICAMENTOS');
					$pdf->SetFillColor(180);
				} else {
					$pdf->Ln();
					$pdf->SetFont('Arial','B',8);
					$pdf->SetFillColor(180);
					$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
					$pdf->Cell(32,5,utf8_decode("Orden Medicamentos"),'TBR',0,'L',0);
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->SetFillColor(255);
					$pdf->Ln();
				}
				/*
				$pdf->SetFont('Courier','B',8);
				$pdf->Cell(2,4,' ','',0,'L',0);
				$pdf->Cell(18,4,'DOSIS','TL',0,'C',0);
				$pdf->Cell(20,4,'VIA','TL',0,'C',0);
				$pdf->Cell(22,4,'FRECUENCIA','TL',0,'C',0);
				$pdf->Cell(25,4,'DURACION','TL',0,'C',0);
				$pdf->Cell(0,3,'','',0,'C',0);
				$pdf->Ln();
				$pdf->SetFillColor(255);
				*/
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(43,4,'Medicamento: '.utf8_decode($rowx2[0]),'TL',0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,4,utf8_decode($rowx2[1]),'TR','L',0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(150,4,utf8_decode('Dosis: '.$rowx2[2].' vía '.$rowx2[3].' cada '.$rowx2[4].' durante '.$rowx2[5]),'L',0,'L',0);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(0,4,utf8_decode('Cantidad: '.$rowx2[8]),'R',0,'R',0);
			$pdf->Ln();
			$pdf->SetFont('Times','I',8);
			$pdf->MultiCell(0,4,utf8_decode('Nota: '.$rowx2[7]),'LBR','L',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// ORDENES MEDICAS Dx
	if ($rowx[11]!="0") {
		$SQL="Select left(d.CUPS_PRC,1), d.CUPS_PRC, d.Nombre_PRC, b.Cantidad_HCS, b.Observaciones_HCS From gxservicios a, hcordenesdx b, czterceros c, gxprocedimientos d Where a.Codigo_SER=b.Codigo_SER and b.Codigo_TER=c.Codigo_TER and d.Codigo_SER=b.Codigo_SER and c.ID_TER='".$rowx[24]."' and b.Codigo_HCF='".$rowx[1]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES DIAGNOSTICAS');
					$pdf->SetFont('Arial','B',10);
				} else {
					$pdf->SetFont('Arial','B',8);
				}
				$pdf->SetFillColor(180);
				$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
				$pdf->Cell(32,5,utf8_decode("Orden Paraclínicos"),'TBR',0,'L',0);
				$pdf->Cell(0,5,'','B',0,'L',0);
				$pdf->SetFillColor(255);
				$pdf->Ln();
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			/*$pdf->Cell(2,4,' ','',0,'L',0);*/
			$pdf->SetFont('Arial','',7);
			$pdf->SetFillColor(180);	
			$pdf->Cell(10,4,utf8_decode('Cód.'),'TLB',0,'C',1);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(16,4,add_ceros($rowx2[1], 2),'TL',0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,3,utf8_decode($rowx2[2]),'TLR','L',1);
			$pdf->SetFillColor(255);
			$pdf->SetFont('Courier','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,'CANTIDAD','TL',0,'C',0);
			$pdf->Cell(0,4,'OBSERVACIONES','TLR',0,'C',0);
			$pdf->Ln();
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,add_ceros($rowx2[3],2),'TLB',0,'C',0);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(0,4,utf8_decode($rowx2[4]),'TLRB',0,'L',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// ORDENES PROCEDIMIENTOS
	if ($rowx[11]!="0") {
		$SQL="Select left(d.CUPS_PRC,1), d.CUPS_PRC, d.Nombre_PRC, b.Cantidad_HCS, b.Observaciones_HCS From gxservicios a, hcordenesqx b, czterceros c, gxprocedimientos d Where a.Codigo_SER=b.Codigo_SER and b.Codigo_TER=c.Codigo_TER and d.Codigo_SER=b.Codigo_SER and c.ID_TER='".$rowx[24]."' and b.Codigo_HCF='".$rowx[1]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES PROCEDIMIENTOS');
					$pdf->SetFont('Arial','B',10);
				} else {
					$pdf->SetFont('Arial','B',8);
				}
				$pdf->SetFillColor(180);
				$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
				$pdf->Cell(32,5,utf8_decode("Orden Procedimientos"),'TBR',0,'L',0);
				$pdf->Cell(0,5,'','B',0,'L',0);
				$pdf->SetFillColor(255);
				$pdf->Ln();
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			/*$pdf->Cell(2,4,' ','',0,'L',0);*/
			$pdf->SetFont('Arial','',7);
			$pdf->SetFillColor(180);	
			$pdf->Cell(10,4,utf8_decode('Cód.'),'TLB',0,'C',1);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(16,4,add_ceros($rowx2[1], 2),'TL',0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,3,utf8_decode($rowx2[2]),'TLR','L',1);
			$pdf->SetFillColor(255);
			$pdf->SetFont('Courier','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,'CANTIDAD','TL',0,'C',0);
			$pdf->Cell(0,4,'OBSERVACIONES','TLR',0,'C',0);
			$pdf->Ln();
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,add_ceros($rowx2[3],2),'TLB',0,'C',0);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(0,4,utf8_decode($rowx2[4]),'TLRB',0,'L',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// ORDENES DE SERVICIOS
	if ($rowx[11]!="0") {
		$SQL="Select a.TipoSer_HCS, e.Descripcion_FRC, a.Cantidad_HCS, a.Observaciones_HCS From hcordenesservicios a, czterceros b, gxfrecuenciaserv e Where e.Codigo_FRC=a.Frecuencia_HCS and a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$rowx[24]."' order by 1";
		$resultx2 = mysqli_query($conexion, $SQL);		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES DE SERVICIO');
				} else {
					$pdf->SetFont('Arial','B',8);
					$pdf->SetFillColor(180);
					$pdf->Cell(2,5,"",'LTRB',0,'L',1);			
					$pdf->Cell(32,5,utf8_decode("Ordenes de Servicio"),'TBR',0,'L',0);
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->SetFillColor(255);
					$pdf->Ln();
				}
				$pdf->Cell(0,2,'','',0,'L',0);
				$pdf->Ln();
				$pdf->SetFont('Courier','B',8);
				$pdf->Cell(15,4,'CANTIDAD','TL',0,'C',0);
				$pdf->Cell(140,4,'SERVICIO','TL',0,'C',0);
				$pdf->Cell(0,4,'FRECUENCIA','TLR',0,'C',0);
				$pdf->Ln();

			}
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
				/* $pdf->Ln(); */
			}
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// $pdf->Ln();	
	
}
mysqli_free_result($resultx);


$pdf->Ln();

//Mostramos el informe
$pdf->Output();
?>