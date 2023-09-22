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
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
	$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'B',0,'L',0);	
    $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','B',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='egresosfecha'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$SQL=str_replace("@FECHA_FINAL",$_GET["FECHA_FINAL"],$SQL);
	$SQL=str_replace("@FECHA_INICIAL",$_GET["FECHA_INICIAL"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('EGRESOS ADMISIONES');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
if (trim($row[6])!="1") {
	$pdf->Image('../../anulado.jpg',25,1,0);
}
$pdf->SetY(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,6,'Fecha: ','',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,6,date('d/m/Y'),'',0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,6,strtoupper($row[8]),'',0,'C',0); //Razon Social
$pdf->Cell(30,6,'Usuario: '.$row[31],'',0,'L',0); //Codigo Usuario
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,6,'Hora: ','B',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,6,date('H:i:s'),'B',0,'L',0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(150,6,'EGRESO No. '.$row[0],'B',0,'C',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(19,6,strtoupper($row[32]),'B',0,'C',0); //Nick usuario

$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Paciente: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,$row[24],'',0,'L',0); //Nombre paciente
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'No. Historia: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[23],'',0,'L',0); //Identificacion
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Identificacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,$row[22].' '.$row[23],'',0,'L',0); //Identificacion paciente
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Fecha Nacimiento: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,FormatoFecha($row[19]),'',0,'L',0); //Fecha nacimiento
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Entidad: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[27]).' - '.strtoupper($row[28]),'',0,'L',0); //Contrato
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Estado: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,html_entity_decode(edad($row[19])),'',0,'L',0); //Edad
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Plan: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[29]).' - '.strtoupper($row[30]),'',0,'L',0); //plan
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Rango Salarial: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[40],'',0,'L',0); //rango
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Afiliacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[21]),'',0,'L',0); //tipo
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Regimen: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[33],'',0,'L',0); //regimen
$EstadoPac="";
switch ($row[5]){
	case "1":
		$EstadoPac="Mejor";
	break;
	case "2":
		$EstadoPac="Igual o Peor";
	break;
	case "3":
		$EstadoPac="Muerto antes de 48 horas";
	break;
	case "4":
		$EstadoPac="Muerto despues de 48 horas";
	break;
}

$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Direccion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[25]),'',0,'L',0); //direccion
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Sexo: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,strtoupper($row[20]),'',0,'L',0); //sexo
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Telefono: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[26]),'B',0,'L',0); //telefono
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Ingreso: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[7],'B',0,'L',0); //barrio
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Fecha Ingreso: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,($row[34]),'',0,'L',0); //fecha Ingreso
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Egreso: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[35],'',0,'L',0); //fecha egreso
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Hab./Cama: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,$row[36].' - '.$row[37],'',0,'L',0); //cama
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Hospitalizacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[10],'',0,'L',0); //Fecha hosp
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'No. Epicrisis: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,$row[1],'',0,'L',0); //epicrisis
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Diagnostico: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[38],'',0,'L',0); //diagnostico
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Estado Paciente: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($EstadoPac),'',0,'L',0); //estado paciente
$Embarazo="No";
if ($row[2]=="0") {
	$Embarazo="No";
} else {
	$Embarazo="Si";
}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Embarazo: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$Embarazo,'',0,'L',0); //embarazo
$pdf->Ln();
if ($Embarazo=="Si") {
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Fecha Parto: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,$row[3],'',0,'L',0); //fecha parto
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Estado Nacimiento: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[4],'',0,'L',0); //diagnostico
$pdf->Ln();

}
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Observaciones: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(171,6,strtoupper($row[17]),'',0,'L',0); //Observaciones
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Motivo Ingreso: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(171,6,strtoupper($row[11]),'',0,'L',0); //motivo ingreso
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Acudiente: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[12]).' - Direccion: '.$row[13].' - Tel.:'.$row[14],'',0,'L',0); //acudiente
$pdf->Ln();
}
mysqli_free_result($result);
//Mostramos el informe
$pdf->Output();
?>