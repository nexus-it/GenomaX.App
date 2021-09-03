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
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',1,1,0);
$this->SetY(5);
$this->SetFont('Arial','B',12);
$this->MultiCell(0,7,strtoupper($NombreEmpresa)."\nNIT: ".$NIT,'','C',0); //Razon Social
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(22);
$this->SetFont('Arial','B',11);
$this->Cell(0,10,'CENSO DIARIO CONSOLIDADO','',0,'C',0);
$this->SetY(10);
$this->SetFont('Arial','',9);
$this->Cell(0,7,'Usuario: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'',0,'R',0); //Codigo Usuario
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
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from nxs_gnx.itreports, itconfig where codigo_rpt='censoconsolidado'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@SEDE",($_GET["SEDE"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('CENSO DIARIO');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
$SQL="Select p1.CodServicio, p1.nombre, count(hx.NomHab), p1.CodPab From bd.pabellones p1, bd.habitacion hx Where hx.CodPab=p1.CodPab and hx.Empresa=p1.Empresa and hx.Estado<>'X' and hx.Estado<>'D' and hx.Estado<>'R' group by p1.CodServicio, p1.nombre order by p1.CodServicio, p1.nombre";
$result = mysqli_query($conexion, $SQL);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(32);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,7,'Pabellon','TRLB',0,'C',0);
$pdf->Cell(23,7,'No camas','TRB',0,'C',0);
$pdf->Cell(23,7,'Ocupacion','TRB',0,'C',0);
$pdf->Cell(23,7,'Disponibles.','BTR',0,'C',0);
$pdf->Cell(23,7,'% Ocupacion','BTR',0,'C',0);
$pdf->Cell(23,7,'Desinfeccion','BTR',0,'C',0);
$pdf->Cell(23,7,'Reparacion','TRB',0,'C',0);
$pdf->Ln();
$pdf->SetFillColor(255);
$totalcamas=0;
$totalcupacion=0;
$totaldes=0;
$totalrep=0;
while($row = mysqli_fetch_row($result)) {

$pdf->SetFont('Arial','',9);
$pdf->Cell(55,7,$row[1],'LBR',0,'L',0); 
$pdf->Cell(23,7,$row[2],'BR',0,'C',0); 
$totalcamas=$totalcamas+$row[2];
//Ocupadas
$SQL="Select p1.nombre, count(h1.NomHab) From bd.habitacion h1, bd.pabellones p1, bd.admisiones a1 Where h1.CodPab=p1.CodPab and h1.Empresa=p1.Empresa and h1.Estado='O' and p1.estado='A' and a1.NoAdmision=h1.NoAdmision and a1.Estado<>'E' and a1.Estado<>'X' and p1.CodPab='".$row[3]."' group by p1.nombre";
$result0 = mysqli_query($conexion, $SQL);
$ocupada=0;
while($row0 = mysqli_fetch_row($result0)) {
    $ocupada=$row0[1];
}
mysqli_free_result($result0);
$totalcupacion=$totalcupacion+$ocupada;
$pdf->Cell(23,7,$ocupada,'BR',0,'C',0); 
$libres=($row[2]-$ocupada);
$pdf->Cell(23,7,$libres,'BR',0,'C',0); 
$porcentaje=($ocupada/$row[2])*100;
$decimales=2;
if ($porcentaje==100) {
    $decimales=0;
}
$pdf->Cell(23,7,number_format($porcentaje,$decimales,'.',',').'%','BR',0,'C',0); 
//Desinfeccion
$SQL="Select count(hx.NomHab), p1.CodPab From bd.pabellones p1, bd.habitacion hx Where hx.CodPab=p1.CodPab and hx.Empresa=p1.Empresa and hx.Estado='D' and p1.CodPab='".$row[3]."' group by p1.CodPab";
$result1 = mysqli_query($conexion, $SQL);
$des=0;
while($row1 = mysqli_fetch_row($result1)) {
    $des=$row1[0];
}
mysqli_free_result($result1);
$totaldes=$totaldes+$des;
$pdf->Cell(23,7,$des,'BR',0,'C',0); 
//Reparacion
$SQL="Select count(hx.NomHab), p1.CodPab From bd.pabellones p1, bd.habitacion hx Where hx.CodPab=p1.CodPab and hx.Empresa=p1.Empresa and hx.Estado='R' and p1.CodPab='".$row[3]."' group by p1.CodPab";
$result2 = mysqli_query($conexion, $SQL);
$rep=0;
while($row2 = mysqli_fetch_row($result2)) {
    $rep=$row2[0];
}
mysqli_free_result($result2);
$totalrep=$totalrep+$rep;
$pdf->Cell(23,7,$rep,'BR',0,'C',0); 

$pdf->Ln();
}
mysqli_free_result($result);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,7,'Total','RLB',0,'C',0);
$pdf->Cell(23,7,$totalcamas,'RB',0,'C',0);
$pdf->Cell(23,7,$totalcupacion,'RB',0,'C',0);
$pdf->Cell(23,7,$totalcamas-$totalcupacion,'BR',0,'C',0);
$pdf->Cell(23,7,number_format((($totalcupacion/$totalcamas)*100),2,'.',','),'BR',0,'C',0);
$pdf->Cell(23,7,$totaldes,'BR',0,'C',0);
$pdf->Cell(23,7,$totalrep,'RB',0,'C',0);
$pdf->Ln();

//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>