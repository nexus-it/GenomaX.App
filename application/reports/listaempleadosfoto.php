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

$SQLH="SELECT RazonSocial_DCD, NIT_DCD from itconfig";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
}
mysqli_free_result($resultH);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->Cell(0,6,strtoupper($NombreEmpresa),'',0,'C',0);
$this->SetFont('Arial','B',10);
$this->Ln();
$this->Cell(0,5,"NIT: ".$NIT,'',0,'C',0);
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,4,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(17);
$this->SetFont('Arial','B',11);
$this->Cell(0,6,'LISTADO DE EMPLEADOS ACTIVOS','B',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,4,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
$this->SetY(30);
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
    $this->Cell(0,7,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from nxs_gnx.itreports, itconfig where codigo_rpt='listaempleadosfoto'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@CONTRATO",$_GET["CONTRATO"],$SQL);
	$SQL=str_replace("@CARGO",$_GET["CARGO"],$SQL);
	$SQL=str_replace("@NOMBRE",$_GET["NOMBRE"],$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('LISTADO EMPLEADOS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(30);
$pdf->SetFillColor(255);
$Ancho=95;
$Alto=35;
$x1=10;
$x2=111;
$SwitchPar=0;
$CurrentY=30;
while($row = mysqli_fetch_row($result)) {
	if ($CurrentY>=235) {
		$pdf->AddPage();
		$CurrentY=$pdf->GetY();
	}
	$pdf->SetY($CurrentY);
	if ($SwitchPar==0) {
		$pdf->SetX($x1);
		$SwitchPar=1;
	} else {
		$pdf->SetX($x2);
		$SwitchPar=0;
		$CurrentY=$CurrentY+$Alto+6;
	}
	$xActual=$pdf->GetX();
	$yActual=$pdf->GetY();
	//Marco del carnet
	$pdf->Cell($Ancho,$Alto,'','BTLR',0,'L',0);
	//Extraigo la foto de la bd
	$nuevo_archivo='../../files/images/terceros/'.$row[4].'.'.$row[5];
	file_put_contents($nuevo_archivo, $row[6]);
	//Muestro la foto
	if ($row[5]=="") {
    	$pdf->Image('../../files/images/terceros/0.png',($pdf->GetX()+3)-$Ancho,$pdf->GetY()+3,floor($Ancho/3)-6,$Alto-6,strtoupper($row[5]));
	} else {
		$pdf->Image($nuevo_archivo,($pdf->GetX()+3)-$Ancho,$pdf->GetY()+3,floor($Ancho/3)-6,$Alto-6,strtoupper($row[5]));
	}
	//Marco de la foto
	$pdf->SetY($yActual+2);
	$pdf->SetX($xActual+2);
	$pdf->Cell(floor($Ancho/3)-4,$Alto-4,'','BTLR',0,'L',0);
	//Marco de la información
	$pdf->SetY($yActual+2);
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,$Alto-4,'','BTLR',0,'L',0); 
	// Labels...
	$pdf->SetFont('Arial','',9);
	$pdf->SetY($yActual+2);
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,'NOMBRES','',0,'L',0); 
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,ucwords(strtolower(utf8_decode($row[1]))),'',0,'L',0); //Nombres

	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,'DOCUMENTO','',0,'L',0); 
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,ucwords(strtolower(utf8_decode($row[0]))),'',0,'L',0); //Documento

	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,'CARGO','',0,'L',0); 
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,utf8_decode($row[2]),'',0,'L',0); //Cargo

	$pdf->SetFont('Arial','B',9);
	$pdf->Ln();
	$pdf->Cell(floor($Ancho/3)*2,3,'','',0,'L',0); //Cargo
	$pdf->Ln();
	$pdf->SetX($xActual+floor($Ancho/3));
	$pdf->Cell(floor($Ancho/3)*2,4,utf8_decode($row[3]),'',0,'R',0); //Empresa

	$pdf->SetY($CurrentY);
/*
$pdf->Cell(25,6,$row[0],'',0,'C',0); //INGRESO
$pdf->Cell(32,7,$row[1],'',0,'C',0); //FECHA
$pdf->Cell(32,7,$row[2].' '.$row[3],'',0,'L',0); //DOCUMENTO
$pdf->Cell(55,6,ucwords(strtolower($row[4])),'',0,'L',0); //PACIENTE
$pdf->Cell(25,6,$row[8],'',0,'L',1); //TIPO
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,$row[10],'',0,'L',1); //ENTIDAD
$pdf->SetFont('Arial','',9);
$pdf->Cell(21,6,$row[6],'',0,'L',1); //ESTADO
$pdf->Cell(20,6,'{'.$row[11].'}'.$row[12],'',0,'L',1); //ESTADO
*/
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>