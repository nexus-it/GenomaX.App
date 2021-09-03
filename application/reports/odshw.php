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
	$this->Image('../../logoods'.$_SESSION["DB_SUFFIX"].'.jpg',7,10,45);
	$this->SetY(10);
	$this->SetFont('Arial','B',12);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'ESCALA IMPRESORES S.A.S.','',0,'L',0); 
	$this->Ln();
	$this->SetFont('Arial','B',10);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'ORDEN DE SERVICIO','',0,'L',0); 
	$this->Ln();
	$this->SetFont('Arial','B',15);
	$this->Cell(44,10,'','',0,'L',0); 
	$this->Cell(0,10,'MANTENIMIENTO DE HARDWARE','',0,'L',0); 
	$this->Ln();
}
function Footer()
{
    $this->SetY(-10);
    $this->SetFont('Arial','',8);
    $this->SetTextColor(100,100,100);
	$this->Cell(40,4,'Vigente desde 25/06/2009','',0,'L');
    $this->SetFont('Arial','B',7);
	$this->Cell(0,4,'Proyecto MyEscala - Orden de Servicio - Mantenimiento y desarrollo de Hardware-Pagina 1 de 1','',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT page_rpt, orientacion_rpt, sql_rpt from nxs_gnx.itreports where codigo_rpt='odshw'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$FormatoPagina=$row[0];
	$Orientation=$row[1];
	$SQLx=$row[2];
	$SQLx=str_replace("@ODS_INICIAL",($_GET["ODS_INICIAL"]),$SQLx);
	$SQLx=str_replace("@ODS_FINAL",($_GET["ODS_FINAL"]),$SQLx);


}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('ODS HW');
$pdf->SetCreator('@Skanner79');
$pdf->SetMargins(10, 22,10);
$pdf->SetAutoPageBreak(true, 15);
//Conectamos con Fomplus...
$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala;";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	//echo $row[1].'-'.$row[2].'-'.$row[3].'-'.$row[0];
	$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
	mssql_select_db("Intranet", $conexionFPx);
}
//echo $SQLx;
$conta=0;
$resultFPx = mssql_query($SQLx, $conexionFPx);
while($rowFPx = mssql_fetch_row($resultFPx)) {
	$conta++;
	$pdf->AddPage();
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
	$pdf->SetY(60);
	$pdf->SetFont('Arial','',9);
	$pdf->SetDrawColor(255);
	$pdf->Cell(50,5,'NOMBRE DEL SOLICITANTE',1,0,'L',1);	
	$pdf->Cell(5,5,'',1,0,'L',0);	
	$pdf->Cell(47,5,$rowFPx[1],'',0,'L',0);	
	$pdf->Cell(40,5,'FECHA SOLICITUD',1,0,'L',1);	
	$pdf->Cell(5,5,'','',0,'L',0);	
	$pdf->Cell(0,5,$rowFPx[2],'',0,'L',0);	
	$pdf->Ln();
	$pdf->Cell(45,5,'AREA',1,0,'L',1);	
	$pdf->Cell(10,5,'','',0,'L',0);	
	$pdf->Cell(47,5,$rowFPx[3],'',0,'L',0);	
	$pdf->Cell(40,5,'FECHA REALIZACION',1,0,'L',1);	
	$pdf->Cell(5,5,'','',0,'L',0);	
	$pdf->Cell(0,5,$rowFPx[5],'',0,'L',0);	
	$pdf->Ln();

	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.05);
	$pdf->Line(10, 73, 206, 73);

	$pdf->Ln();
	$pdf->SetDrawColor(255);
	$pdf->Cell(38,5,'REQUERIMIENTO',1,0,'L',1);	
	$pdf->Cell(7,5,'','',0,'L',0);	
	$pdf->SetDrawColor(220);
	$pdf->Cell(0,5,$rowFPx[4],1,0,'L',0);
	$pdf->Ln();

	$pdf->SetDrawColor(220);
	$pdf->SetLineWidth(0.05);
	$pdf->Line(10, 83, 206, 83);

	$pdf->Ln();
	$pdf->SetDrawColor(255);
	$pdf->Cell(38,5,'OBSERVACION',1,0,'L',1);	
	$pdf->Cell(7,5,'','',0,'L',0);	
	$pdf->SetDrawColor(220);
	$pdf->MultiCell(0, 4, $rowFPx[6], 1);
	$pdf->Ln();
	
	$pdf->SetY(238);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(25,6,'',0,0,'L',0);	
	$pdf->Cell(55,6,'Revisador por',0,0,'L',0);	
	$pdf->Cell(45,6,'',0,0,'L',0);	
	$pdf->Cell(0,6,'Recibi Conforme',0,0,'L',0);	
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(25,4,'',0,0,'L',0);	
	$pdf->Cell(20,4,'Nombre',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(55,4,'Danis Marquez',0,0,'L',0);	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,4,'Nombre',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,4,$rowFPx[1],0,0,'L',0);
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(25,4,'',0,0,'L',0);	
	$pdf->Cell(20,4,'Cargo',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(55,4,'Auxiliar de Sistemas',0,0,'L',0);	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,4,'Cargo',0,0,'L',0);	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,4,$rowFPx[7],0,0,'L',0);	
	$porcimg=45;
	if ($conta % 2==0) {
		$porcimg=40;
	}else{
		if ($conta % 3==0){
			$porcimg=43;
		}
	}
	$pdf->Image('../../files/images/firmas/00.png',54,231,$porcimg);
	
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
mssql_free_result($resultFPx);

$pdf->Output();
?>