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
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL="SELECT sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='hc'";
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
	//PutLogo();
	// Se coloca el logo de la bd
	/*
	$SQL="Select Logo_DCD, NIT_DCD from itconfig";
	$resultLogo = mysqli_query($conexion, $SQL);
	if ($rowLogo = mysqli_fetch_row($resultLogo)) {
		$LeLogos='logo'.$rowLogo[1].'.jpg';
		if (file_exists($LeLogos)) {
			file_put_contents($LeLogos, $rowLogo[0]);
		}
	}
	mysqli_free_result($resultLogo);	
	$this->Image($LeLogos,4,2,0);
	*/
	// Fin logo

	$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,2,0);
	$this->SetFillColor(255);
	$this->SetY(3);
	if (strlen($rowH[0])>=40 ) {
		if (strlen($rowH[0])>=50 ) {
			$this->SetFont('Arial','B',11);
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
	$this->Cell(0,7,'CLASIFICACION DE TRIAGE','',0,'C',0);
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
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='hc'";
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
if ($_GET["FOLIO_FINAL"]==$_GET["FOLIO_INICIAL"]) {
	$UnFolio=1;
	$SQL="SELECT a.* from hcencabezadosdet a, hctipos b, hcfolios c where a.codigo_hch=b.codigo_hch and b.codigo_hct=c.codigo_hct";
}
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

$pdf->SetY(28);
$pdf->SetFillColor(170);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,'HISTORIA No. '.$_GET["HISTORIA"],'TB',0,'R',0);
$pdf->Ln();
$SQL="SELECT c.Codigo_TRG, a.Fecha_HCF, c.Estado_TRG, c.Fecha2_TRG, c.Edad_TRG, g.Nombre_CNS , h.Nombre_USR, b.tipollegada_HC, b.reingres72_HC, b.estconciencia_HC, b.alientalcohl_HC, b.motconsulta_HC, b.observaciones_HC, b.hallazgos_HC, e.Nombre_TER From hcfolios a, hctriage c , czterceros e, gxpacientes f, gxconsultorios g, itusuarios h, hc_TRIAGE b Where e.Codigo_TER=a.Codigo_TER AND c.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=c.Codigo_TER AND f.Codigo_TER=e.Codigo_TER AND g.Codigo_CNS=c.Codigo_CNS AND h.Codigo_USR=a.Codigo_USR AND b.Codigo_TER=a.Codigo_TER AND b.Codigo_HCF=a.Codigo_HCF  and e.ID_TER='".$_GET["Historia"]."' and a.Codigo_HCF<='".$_GET["FOLIO_FINAL"]."' Order By a.Fecha_HCF desc, a.Hora_HCF, a.Codigo_HCF DESC ";

$SQL="SELECT c.Codigo_TRG, a.Fecha_HCF, c.Estado_TRG, c.Fecha2_TRG, c.Edad_TRG, b.Nombre_EPS , '', '', '', '', '', '', '', '', e.Nombre_TER From hcfolios a, hctriage c , czterceros e, gxeps b Where b.Codigo_EPS=c.Codigo_EPS and e.Codigo_TER=a.Codigo_TER AND c.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=c.Codigo_TER AND e.ID_TER='".$_GET["HISTORIA"]."' and a.Codigo_HCF<='".$_GET["FOLIO_FINAL"]."' Order By a.Fecha_HCF desc, a.Hora_HCF, a.Codigo_HCF DESC ";
// echo $SQL;
$result0 = mysqli_query($conexion, $SQL);
if ($row0 = mysqli_fetch_row($result0)) {

	$pdf->SetFillColor(255);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(19,5,'Documento','LB',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,5,$_GET["HISTORIA"] ,'BR',0,'L',1);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(13,5,'Nombre','B',0,'L',1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(0,5,utf8_decode($row0["14"]),'BR',0,'L',1);

	$pdf->Ln();

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(14,5,'Edad','LB',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(34,5,utf8_decode($row0["4"]),'BR',0,'L',1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(14,5,'Entidad','B',0,'L',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,utf8_decode($row0["5"]),'BR',0,'L',1);

}
mysqli_free_result($result0);
// Fin encabezado - Datos Personales

//Datos del folio
$SQL="SELECT 'CLASIFICACION TRIAGE', c.Codigo_HCF, c.Codigo_ADM, a.Fecha2_TRG, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, a.Codigo_HTR, '', '', '', '', '', '', '', '', f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, '', e.Codigo_TER, a.Codigo_TER from  hcfolios c, hctriage a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF=c.Codigo_HCF and c.Codigo_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by 2, 4, 5";

$SQL="SELECT 'CLASIFICACION TRIAGE', c.Codigo_HCF, c.Codigo_ADM, a.Fecha2_TRG, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, a.Codigo_HTR, '', '', '', '', '', '', '', '', 'MEDICO TRIAGE', '', '', c.Medico2_HCF, '', '', a.Codigo_TER from  hcfolios c, hctriage a, gxareas d, czterceros g where  d.Codigo_ARE=c.Codigo_ARE and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF=c.Codigo_HCF and c.Codigo_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by 2, 4, 5";
/* echo $SQL; */
$resultx = mysqli_query($conexion, $SQL);
while ($rowx = mysqli_fetch_row($resultx)) {
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFillColor(220);
	$pdf->SetFont('Arial','BI',10);
	$pdf->Cell(150,5,"",'TL',0,'L',1);
	$pdf->SetFont('Courier','B',12);
	$pdf->Cell(0,5,"Clasificacion: TRIAGE ".$rowx[7],'TR',0,'R',1);
	$pdf->SetFillColor(255);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	/* $pdf->Cell(0,5,utf8_decode("Admisión: ".$rowx[2]." - Fecha Ingreso: ".$rowx[3]),'B',0,'R',1); */
	$pdf->Ln();
	$pdf->SetFont('Courier','B',9);
	$pdf->Cell(80,5,"Area: URGENCIAS",'T',0,'L',1);
	$pdf->Cell(70,5,"",'T',0,'L',1);
	$pdf->Cell(0,5,"Fecha y Hora: ".$rowx[3],'T',0,'R',1);
	$pdf->Cell(0,3,"",'',0,'R',1);
	$pdf->Ln();
	$pdf->Ln();
	// ANTECEDENTES
	$SQL="Select count(*) From hcantecedentes a, hctipoantecedentes b, czterceros c Where a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$_GET["HISTORIA"]."'";
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
			$SQL="Select b.Nombre_HCA, a.Descripcion_HCA From hcantecedentes a, hctipoantecedentes b, czterceros c Where a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$_GET["HISTORIA"]."'";
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
		$SQL="Select c.Sigla_HSV, a.Valor_HSV, c.Codigo_HSV, c.Prefijo_HSV, c.Sufijo_HSV From hcsignosvitales a, czterceros b, hcsv2 c Where a.Codigo_TER=b.Codigo_TER and c.Codigo_HSV=a.Codigo_HSV and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 3";
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
	// campos del formato de la hc
	$Posx=10;
	$Posy=$pdf->GetY();
	$Posyfin=$Posy;
	$TamW=196;
	$pdf->SetX($Posx);
	$SQL="Select a.* From hc_". $rowx[20]." a, czterceros b Where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."';";
	$resultx2 = mysqli_query($conexion, $SQL);
	$DatosHC = mysqli_fetch_array($resultx2);
	mysqli_free_result($resultx2);
	$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='0' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
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
							$pdf->Cell(44,5,utf8_decode($rowx2[2]),'TRB',0,'L',0);
							$pdf->SetFillColor(255);
							//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
							$pdf->SetFont('Arial','',8);
							
						} else {
							$pdf->SetFont('Arial','B',8);
							$pdf->SetFillColor(180);
							$pdf->Cell(2,5,"",'LTR',0,'L',1);			
							$pdf->Cell(44,5,utf8_decode($rowx2[2]),'TR',0,'L',0);
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
						$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC, a.Codigo_HCT from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='".$rowx2[1]."' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
						//echo $SQL;
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
										$pdf->Cell(44,5,utf8_decode($rowx3[2]),'TRB',0,'L',0);
										$pdf->SetFillColor(255);				
										//$pdf->Cell($TamW,4,utf8_decode($rowx3[2]),'B',0,'L',1);
										$pdf->SetFont('Arial','',8);
									} else {
										$pdf->SetFont('Arial','B',8);
										$pdf->SetFillColor(180);
										$pdf->Cell(2,5,"",'LTR',0,'L',1);			
										$pdf->Cell(44,5,utf8_decode($rowx3[2]),'TR',0,'L',0);
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
						$pdf->Cell(0,3,str_repeat ('-', 86),'',0,'C',0);
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
	$pdf->Cell(0,5,"",'',0,'L',1);
	$pdf->Ln();		


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
	$pdf->Cell(0,3,utf8_decode($rowx[16]),'T',0,'C',0);
	$SQL="Select b.Nombre_ESP From gxmedicosesp a, gxespecialidades b Where a.Codigo_ESP=b.Codigo_ESP and b.Estado_ESP='1' and  Codigo_TER='".$rowx[21]."' Order By a.Tipo_ESP";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$pdf->Ln();
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(130,3,"",'',0,'C',0);
		$pdf->Cell(0,3,utf8_decode($rowx2[0]),'',0,'C',0);	
	}
	mysqli_free_result($resultx2);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(130,3,"",'',0,'C',0);
	$pdf->Cell(0,3,'R.M. '.utf8_decode($rowx[17]),'',0,'C',0);
	
}
mysqli_free_result($resultx);


$pdf->Ln();

//Mostramos el informe
$pdf->Output();
?>