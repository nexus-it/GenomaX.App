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
	$this->Image('../../logoods.jpg',7,10,45);
	$this->SetY(10);
	$this->SetFont('Arial','B',13);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'ESCALA IMPRESORES S.A.S.','',0,'L',0); 
	$this->Ln();
	$this->SetFont('Arial','B',10);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'ORDEN DE SERVICIO','',0,'L',0); 
	$this->Ln();
	$this->SetFont('Arial','B',12);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'CLASIFICACION DEL SERVICIO: ','',0,'L',0); 
	$this->Ln();
}
function Footer()
{
    $this->SetY(-10);
    $this->SetFont('Arial','',8);
    $this->SetTextColor(100,100,100);
	$this->Cell(40,4,'Vigente desde 25/06/2009','',0,'L');
    $this->SetFont('Arial','B',7);
	$this->Cell(0,4,'Proyecto MyEscala - Orden de Servicio - Intranet - Pagina 1 de 1','',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT page_rpt, orientacion_rpt, sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='myods'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$FormatoPagina=$row[0];
	$Orientation=$row[1];
	$SQLx=$row[2];
	$SQLx=str_replace("@ODS_INICIAL",($_GET["ODS_INICIAL"]),$SQLx);
	$SQLx=str_replace("@ODS_FINAL",($_GET["ODS_FINAL"]),$SQLx);
	$SQLx=str_replace("@TIPOODS",($_GET["TIPOODS"]),$SQLx);
	$SQLx=str_replace("@ESTADOODS",($_GET["ESTADOODS"]),$SQLx);
	$SQLx=str_replace("@RESPONSABLE",($_GET["RESPONSABLE"]),$SQLx);


}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('ODS Sistemas');
$pdf->SetCreator('@Skanner79');
$pdf->SetMargins(10, 22,10);
$pdf->SetAutoPageBreak(true, 15);
//echo $SQLx;
$conta=0;
$resultFPx = mysqli_query($conexion, $SQLx);
while($rowFPx = mysqli_fetch_row($resultFPx)) {
	$conta++;
	$pdf->AddPage();
	$pdf->SetY(30);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(111,10,'','',0,'L',0); 
	$pdf->Cell(0,10,$rowFPx[6],'',0,'L',0); 
	$pdf->SetY(10);
	$pdf->SetFont('Courier','B',13);
	$pdf->SetDrawColor(50);
	$pdf->Cell(175,18,'','',0,'C',0);	
	$pdf->Cell(0,18,$rowFPx[0],1,0,'C',0);	
	$pdf->Ln();
	$pdf->SetFillColor(225);
	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.1);
	$pdf->Line(10, 50, 206, 50);
	$pdf->SetY(50);
	$pdf->SetFont('Arial','',10);
	$pdf->SetDrawColor(255);
	$pdf->Cell(159,5,' ',1,0,'R',0);
	$pdf->Cell(0,5,'Estado ODS: '.$rowFPx[5],1,0,'R',1);
	$pdf->SetY(60);
	$pdf->SetFont('Arial','',9);
	$pdf->SetDrawColor(255);
	$pdf->Cell(50,5,'NOMBRE DEL SOLICITANTE',1,0,'L',1);	
	$pdf->Cell(5,5,'',1,0,'L',0);	
	$pdf->Cell(47,5,utf8_decode($rowFPx[9]),'',0,'L',0);	
	$pdf->Cell(40,5,'FECHA SOLICITUD',1,0,'L',1);	
	$pdf->Cell(5,5,'','',0,'L',0);	
	$pdf->Cell(0,5,$rowFPx[3],'',0,'L',0);	
	$pdf->Ln();
	$pdf->Cell(45,5,'AREA',1,0,'L',1);	
	$pdf->Cell(10,5,'','',0,'L',0);	
	$pdf->Cell(47,5,utf8_decode($rowFPx[19]),'',0,'L',0);	
	$pdf->Cell(40,5,'FECHA PROGRAMACION',1,0,'L',1);	
	$pdf->Cell(5,5,'','',0,'L',0);	
	$pdf->Cell(0,5,$rowFPx[4],'',0,'L',0);	
	$pdf->Ln();

	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.05);
	$pdf->Line(10, 73, 206, 73);

	$pdf->Ln();
	$pdf->SetDrawColor(255);
	$pdf->Cell(38,5,'SOLICITUD',1,0,'L',1);	
	$pdf->Cell(7,5,'','',0,'L',0);	
	$pdf->SetDrawColor(220);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,5,utf8_decode($rowFPx[1]),1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();

	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.05);
	$pdf->Line(10, 83, 206, 83);

	$pdf->Ln();
	$pdf->SetDrawColor(255);
	$pdf->Cell(38,5,'DESCRIPCION',1,0,'L',1);	
	$pdf->Cell(7,5,'','',0,'L',0);	
	$pdf->SetDrawColor(220);
	$pdf->MultiCell(0, 4, utf8_decode($rowFPx[2]), 1);
	
	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.05);
	$pdf->Line(10, 83, 206, 83);

	$pdf->Ln();

	$pdf->SetDrawColor(255);
	$pdf->Cell(0,5,'TAREAS REALIZADAS',1,0,'C',1);
	$pdf->Ln();
	$SQL="Select Tarea_ODS, FechaTarea_ODS From myodsres Where Codigo_ODS='".$rowFPx[0]."' Order By FechaTarea_ODS";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$pdf->SetDrawColor(220);
		$pdf->Cell(40,5,$row[1],"TR",0,'L',0);
		$pdf->MultiCell(0, 4, utf8_decode($row[0]), "T");
		$pdf->Ln();
	}
	mysqli_free_result($result);
	
	//calificacion del servicio.
	$pdf->SetY(244);
	$pdf->SetFont('Arial','',7);
	$pdf->Image('../../files/images/ods'.$rowFPx[7].'.png',178,245,30);
	$pdf->Cell(0,6,utf8_decode('Calificación del servicio'),0,0,'R',0);	

	$pdf->SetY(238);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(22,6,'',0,0,'L',0);	
	$pdf->Cell(55,6,'Revisador por',0,0,'L',0);	
	$pdf->Cell(45,6,'',0,0,'L',0);	
	$pdf->Cell(0,6,'Recibi Conforme',0,0,'L',0);	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(22,4,'',0,0,'L',0);	
	$pdf->Cell(20,4,'Nombre',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(55,4,utf8_decode($rowFPx[12]),0,0,'L',0);	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,4,'Nombre',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,4,utf8_decode($rowFPx[9]),0,0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(22,4,'',0,0,'L',0);	
	$pdf->Cell(20,4,'Cargo',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(55,4,utf8_decode($rowFPx[16]),0,0,'L',0);	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,4,'Cargo',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,4,utf8_decode($rowFPx[15]),0,0,'L',0);	
	$porcimg=45;
	if ($conta % 2==0) {
		$porcimg=40;
	}else{
		if ($conta % 3==0){
			$porcimg=43;
		}
	}
	if ($rowFPx[18]!="") {
		$pdf->Image('../../files/images/firmas/'.$rowFPx[18].'.png',51,231,$porcimg);
	}
	
	
	$firmaporc=45;
	$firmax=129;
	$firmay=229;
	if ($conta % 7==0) {
		$firmaporc=46;
	}else{
		if ($conta % 5==0){
			$firmaporc=43;
			$firmax=131;
		}else {
			if ($conta % 3==0){
				$firmaporc=44;
				$firmay=230;
			}else{
				if ($conta % 2==0){
					$firmaporc=42;
					$firmax=130;
					$firmay=228;
				}
			} 
		}
	}
	
	$SQL="Select Me_Firma_MyEscala From  Me_usuarios Where Me_Nombre_MyEscala='".$rowFPx[1]."'";
	$reFPfirma = mssql_query($SQL, $conexionFPx);
	if ($rowFirma = mssql_fetch_row($reFPfirma)) {
		if (!(is_null($rowFirma[0]))) {
			$pdf->Image('../../files/images/firmas/'.$rowFirma[0],$firmax,$firmay,$firmaporc);
		}
	}
}
mysqli_free_result($resultFPx);

$pdf->Output();
?>