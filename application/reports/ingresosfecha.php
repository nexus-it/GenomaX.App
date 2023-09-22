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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='ingresosfecha'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$Orientation=$row[2];
	$FormatoPagina=$row[1];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('INGRESOS ADMISIONES');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
$pdf->AddPage();
//Encabezado de la tabla
if (trim($row[15])=="A") {
	$pdf->Image('../../anulado.jpg',25,1,0);
}
$pdf->SetY(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,6,'Fecha: ','',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,6,date('d/m/Y'),'',0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(150,6,strtoupper($row[1]),'',0,'C',0); //Razon Social
$pdf->Cell(30,6,'Usuario: '.$row[28],'',0,'L',0); //Codigo Usuario
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(12,6,'Hora: ','B',0,'R',0);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15,6,date('H:i:s'),'B',0,'L',0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(150,6,'HOJA DE ADMISION No. '.$row[0],'B',0,'C',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(19,6,strtoupper($row[29]),'B',0,'C',0); //Nick usuario

$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Paciente: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,$row[21],'',0,'L',0); //Nombre paciente
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'No. Historia: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[20],'',0,'L',0); //Identificacion
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Identificacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,$row[19].' '.$row[20],'',0,'L',0); //Identificacion paciente
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Fecha Nacimiento: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,FormatoFecha($row[16]),'',0,'L',0); //Fecha nacimiento
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Entidad: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[24]).' - '.strtoupper($row[25]),'',0,'L',0); //Contrato
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Edad: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,html_entity_decode(edad($row[16])),'',0,'L',0); //Edad
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Plan: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[26]).' - '.strtoupper($row[27]),'',0,'L',0); //plan
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Rango Salarial: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[38],'',0,'L',0); //rango
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,7,'Afiliacion: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,7,strtoupper($row[18]),'B',0,'L',0); //tipo
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,7,'Regimen: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,7,$row[31],'B',0,'L',0); //regimen

$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Departamento: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[39]),'',0,'L',0); //departamento
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Municipio: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[40],'',0,'L',0); //rango
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Direccion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[22]),'',0,'L',0); //direccion
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Barrio: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,strtoupper($row[41]),'',0,'L',0); //barrio
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Telefono: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[23]),'B',0,'L',0); //telefono
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Sexo: ','B',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,strtoupper($row[17]),'B',0,'L',0); //sexo
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Ingreso Por: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[30]),'',0,'L',0); //ingreso por
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Ingreso: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,strtoupper($row[32]),'',0,'L',0); //Fecha Ingreso
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Tipo Riesgo: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$riesgo="";
switch ($row[42]) {
case '1': $riesgo='Enf. General y Maternidad';
break;
case '2': $riesgo='Accidente de Transito';
break;
case '3': $riesgo='Catastrofe';
break;	
}
$pdf->Cell(104,6,$row[42].' - '.strtoupper($riesgo),'',0,'L',0); //autorizacion
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Hora Ingreso: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,strtoupper($row[33]),'',0,'L',0); //Hora Ingreso
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Autorizacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[12]),'',0,'L',0); //Autorizacion
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Autorizacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,FormatoFecha($row[13]),'',0,'L',0); //fecha autorizacion
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Remision: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[5]),'',0,'L',0); //Remision
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Remision: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,FormatoFecha($row[6]),'',0,'L',0); //fecha remision
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'I.P.S.: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[7]),'',0,'L',0); //ips
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Valor Remision: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,'$ '.number_format($row[4], 2, ',', '.'),'',0,'L',0); //valor remision
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'No. Cama: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[34]).' - '.strtoupper($row[35]),'',0,'L',0); //cama
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Fecha Hospitalizacion: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,FormatoFecha($row[3]),'',0,'L',0); //fecha hosp
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Motivo Consulta: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[8]),'',0,'L',0); //motivo
$pdf->SetFont('Arial','B',10);
$pdf->Cell(26,6,'Diagnostico: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(41,6,$row[36],'',0,'L',0); //diagnostico
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Acudiente: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(104,6,strtoupper($row[9]).' - Direccion: '.$row[10].' - Tel.:'.$row[11],'',0,'L',0); //acudiente
$pdf->Ln();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Observaciones: ','',0,'R',0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,$row[14],'',0,'L',0); //obs
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>