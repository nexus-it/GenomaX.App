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
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQLH="Select RazonSocial_DCD, NIT_DCD, Direccion_DCD, Telefonos_DCD, Ciudad_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
    $direccion=$rowH[2];
    $telefono=$rowH[3];
    $ciudad=$rowH[4];
}
mysqli_free_result($resultH);
$this->SetTextColor(0);
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',1,1,40);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->Cell(0,5,strtoupper($NombreEmpresa),'',0,'C',0); //Razon Social
$this->SetFont('Arial','',10);
$this->Ln();
$this->Cell(0,4,'NIT '.$NIT,'',0,'C',0);
$this->Ln();
$this->Cell(0,4,'','',0,'C',0);
$this->Ln();
$this->Cell(0,4,' ','',0,'C',0);

$this->SetY(7);
$this->SetFont('Arial','',6);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(10);
$this->SetFont('Arial','',6);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(23);
$this->SetFont('Arial','B',11);
$this->SetTextColor(255);
$this->SetFillColor(190);
$this->Cell(0,5,'- PROGRAMACION DE CITAS -'.$row[0],'',0,'C',1);      
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(100,5,html_entity_decode('Powered By: GenomaX.co '),'T',0,'L');
	$this->SetFont('Arial','',8);
    $this->Cell(0,5,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$OtraPage="";
$notacx="";
$FormatoPagina="halfletter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD, NotaCita_XCX from itconfig_cx, nxs_gnx.itreports, itconfig where codigo_rpt='citasprogramadasusuario'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
    $notacx=$row[4];
	$SQL=str_replace("@FECHA_INICIAL",($_GET["FECHA_INICIAL"]),$SQL);
	$SQL=str_replace("@FECHA_FINAL",($_GET["FECHA_FINAL"]),$SQL);
    $SQL=str_replace("@PACIENTE",$_GET["PACIENTE"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('PROGRAMACION DE CITAS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 18);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
//Encabezado de la tabla
$array_dias['Sunday'] = "Domingo";
$array_dias['Monday'] = "Lunes";
$array_dias['Tuesday'] = "Martes";
$array_dias['Wednesday'] = "Miércoles";
$array_dias['Thursday'] = "Jueves";
$array_dias['Friday'] = "Viernes";
$array_dias['Saturday'] = "Sábado";
while($row = mysqli_fetch_row($result)) {
    $Concat=$row[0].$row[1].$row[2].$row[3].$row[4].$row[5];
    if ($Concat!=$OtraPage) {
        $pdf->AddPage();
        $pdf->SetFillColor(255);
        $pdf->SetTextColor(0);
        $OtraPage=$Concat;
        $fecha = $row[0];
        $pdf->SetY(29);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Paciente ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[7].' '.$row[8].' - '.$row[9]),'',0,'L',0); 
        $pdf->Ln();     
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Fecha Cita ','',0,'L',0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($array_dias[date('l', strtotime($fecha))].', '.formatofecha($fecha).' - '.$row[6]),'',0,'L',0);      
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Area ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[1]),'',0,'L',0); 
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'lugar ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[2]),'',0,'L',0); 
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Profesional ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[4]),'',0,'L',0); 
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Especialidad ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[5]),'',0,'L',0); 
        $pdf->Ln();
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(25,5,'Entidad ','',0,'L',0);      
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,5,utf8_decode($row[14]),'',0,'L',0); 
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(0,5,utf8_decode($row[16]),'',0,'C',0);
        $pdf->Ln();
        $pdf->SetTextColor(255);
        $pdf->SetFillColor(190);
        $pdf->SetFont('Arial','BI',8);
        $pdf->Cell(0,4,'"'.utf8_decode($notacx).'"','',0,'C',1);    
    }

}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>