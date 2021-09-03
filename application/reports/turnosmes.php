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

$SQLH="SELECT O.RazonSocial_DCD, O.NIT_DCD, C.Fecha_TUR, B.Nombre_ARE, E.Nombre_TCL, '".$_GET["CODIGO_MES"]."', '".$_GET["CODIGO_ANYO"]."', I.Codigo_USR, I.ID_USR From itconfig AS O, czareas AS B, czturnosenc AS C, cztipocontratos AS E, itusuarios AS I Where B.Codigo_ARE='".$_GET["CODIGO_AREA"]."' AND E.Codigo_TCL='".$_GET["CODIGO_CONTRATO"]."' AND I.Codigo_USR=C.Codigo_USR  AND C.Nombre_TUR=CONCAT_WS('-','Mes','".$_GET["CODIGO_ANYO"]."', '".$_GET["CODIGO_MES"]."', '".$_GET["CODIGO_AREA"]."', '".$_GET["CODIGO_CONTRATO"]."')";
$resultH = mysqli_query($conexion, $SQLH);
if ($rowH = mysqli_fetch_row($resultH)) {
	$NombreEmpresa=$rowH[0];
	$NIT=$rowH[1];
    $FechaElab=$rowH[2];
    $NomArea=$rowH[3];
    $NomContra=$rowH[4];
    $NomMes=$rowH[5];
    $NomAnyo=$rowH[6];
    $CodUsu=$rowH[7];
    $IDUsu=$rowH[8];
}
//echo $SQLH;
mysqli_free_result($resultH);
$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',1,1,0);
$this->SetY(5);
$this->SetFont('Arial','B',11);
$this->Cell(0,7,strtoupper($NombreEmpresa),'',0,'C',0); //Razon Social
$this->Ln();
$this->Cell(0,7,"NIT: ".$NIT,'',0,'C',0);
$this->Ln();
$this->SetFont('Arial','B',10);
$this->Cell(0,7,'PROGRAMACION MENSUAL DE TURNOS DE PERSONAL','B',0,'C',0);
$this->SetY(5);
$this->SetFont('Arial','',9);
$this->Cell(0,6,'Impreso el '.date('d/m/Y H:i:s'),'',0,'R',0);
$this->SetY(10);
$this->Cell(0,6,'Elaborado por: '.$CodUsu.' - '.$IDUsu,'',0,'R',0); //Codigo Usuario
$this->SetY(26);
$this->SetFont('Arial','B',9);
$this->Cell(25,4,'AREA: ','',0,'R',0);
$this->SetFont('Arial','',9);
$this->Cell(0,4,strtoupper($NomArea),'',0,'L',0);
$this->Ln();
$this->SetFont('Arial','B',9);
$this->Cell(25,4,'CONTRATO: ','',0,'R',0);
$this->SetFont('Arial','',9);
$this->Cell(0,4,strtoupper($NomContra),'',0,'L',0);
$this->Ln();
$this->SetFont('Arial','B',9);
$this->Cell(25,4,'PERIODO: ','B',0,'R',0);
$this->SetFont('Arial','',9);
$this->Cell(105,4,strtoupper(NombreMes($NomMes))." / ".$NomAnyo,'B',0,'L',0);
$NumDia=0;
$totalh=0;
//SE CALCULAN LOS DIAS HABILES DEL MES * 8
while (UltimoDia($NomAnyo, $NomMes)> $NumDia) {
    $NumDia++;
    $SQLH="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$NomAnyo."-".$NomMes."-".$NumDia."'";
    $resultH = mysqli_query($conexion, $SQLH);
    if(!($rowH=mysqli_fetch_array($resultH))) {
        if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))!=0) {
            $totalh++;
        }
    }
    mysqli_free_result($resultH); 
}
$this->SetFont('Arial','B',9);
$this->Cell(105,4,'HORAS ORDINARIAS:','B',0,'R',0);
$this->SetFont('Arial','',9);
$this->Cell(25,4,($totalh*8),'B',0,'L',0);

$this->Ln();
$DescTurnos="";
$SQLH="Select distinct F.Codigo_TRN AS 'Cod Turno', F.Nombre_TRN AS 'Turno' From czturnosenc AS C, czturnosdet as D, cztipoturnos AS F Where C.Codigo_TUR=D.Codigo_TUR AND D.Codigo_TRN=F.Codigo_TRN AND C.Nombre_TUR=CONCAT_WS('-','Mes','".$NomAnyo."', '".$NomMes."', '".$_GET["CODIGO_AREA"]."', '".$_GET["CODIGO_CONTRATO"]."') Order By 1,2";
$resultH = mysqli_query($conexion, $SQLH);
while($rowH=mysqli_fetch_array($resultH)) {
    $DescTurnos=$DescTurnos."| ".$rowH[0].": ".$rowH[1]." ";
}
mysqli_free_result($resultH); 
$DescTurnos=$DescTurnos."|";
$this->SetFont('Arial','',7);
$this->Cell(0,5,$DescTurnos,'',0,'C',0);
$this->Ln();
$this->SetFillColor(240);
$this->SetTextColor(50);
$this->SetFont('Arial','B',8);
$this->Cell(45,4,'NOMBRE','LTR',0,'C',1);
$AnchoC=intval(220/(UltimoDia($NomAnyo, $NomMes)));
$NumDia=0;
while (UltimoDia($NomAnyo, $NomMes)> $NumDia) {
$NumDia++;
$SQLH="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$NomAnyo."-".$NomMes."-".$NumDia."'";
$resultH = mysqli_query($conexion, $SQLH);
if($rowH=mysqli_fetch_array($resultH)) {
    $this->SetFillColor(150);
    $this->SetTextColor(250);
}
else
{
    $this->SetFillColor(240);
    $this->SetTextColor(50);
}
mysqli_free_result($resultH); 
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==1) $Weekday= "Lu";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==2) $Weekday= "Ma";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==3) $Weekday= "Mi";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==4) $Weekday= "Ju";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==5) $Weekday= "Vi";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==6) $Weekday= "Sa";
if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))==0) 
{
    $Weekday= "Do";
    $this->SetFillColor(150);
    $this->SetTextColor(250);
}
    $this->Cell($AnchoC,4,$Weekday,'RBT',0,'C',1);
}
$this->Ln();
$this->SetFillColor(240);
$this->SetTextColor(50);
$this->SetFont('Arial','B',8);
$this->Cell(45,5,'EMPLEADO','LRB',0,'C',1);
$this->SetFillColor(255);
$NumDia=0;
$this->SetFillColor(248);
while (UltimoDia($NomAnyo, $NomMes)> $NumDia) {
    $NumDia++;
    $this->SetTextColor(200,0,0);
    $this->SetFillColor(235);
    $SQLH="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$NomAnyo."-".$NomMes."-".$NumDia."'";
    $resultH = mysqli_query($conexion, $SQLH);
    if(!($rowH=mysqli_fetch_array($resultH))) {
        if (date("w", mktime(0, 0, 0, $NomMes, $NumDia, $NomAnyo))!=0) {
            $this->SetTextColor(50);
            $this->SetFillColor(248);
        }
    }
    mysqli_free_result($resultH); 
    $this->Cell($AnchoC,5,$NumDia,'RBT',0,'C',1);
}

}

function Footer()
{
    //Posición: a 1,8 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    $Observaciones="66";
    $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
    mysqli_query ($conexion, "SET NAMES 'utf8'");
    $SQLF="Select Observaciones_TUR From czturnosenc AS C Where C.Nombre_TUR=CONCAT_WS('-','Mes','".$_GET["CODIGO_ANYO"]."', '".$_GET["CODIGO_MES"]."', '".$_GET["CODIGO_AREA"]."', '".$_GET["CODIGO_CONTRATO"]."')";
    $resultF = mysql_db_query($_SESSION["DB_NAME"], $SQLF, $conexion);
    //echo $SQLF;
    if($rowF=mysqli_fetch_array($resultF)) {
        $Observaciones=$rowF[0];
    }
    mysqli_free_result($resultF);
    $this->Cell(240,4,$Observaciones,'T',0,'L');
    //Número de página
    $this->Cell(0,4,'Pag. '.$this->PageNo().'/{nb}','T',0,'R');
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, RazonSocial_DCD from nxs_gnx.itreports, itconfig where codigo_rpt='turnosmes'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreEmpresa=$row[3];
	$SQL=str_replace("@CODIGO_CONTRATO",($_GET["CODIGO_CONTRATO"]),$SQL);
    $SQL=str_replace("@CODIGO_AREA",($_GET["CODIGO_AREA"]),$SQL);
    $SQL=str_replace("@CODIGO_ANYO",($_GET["CODIGO_ANYO"]),$SQL);
	$SQL=str_replace("@CODIGO_MES",($_GET["CODIGO_MES"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('PROGRAMACION DE TURNOS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();
//Encabezado de la tabla
$pdf->SetY(52);
$pdf->SetFillColor(255);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
$NombreEmp="";
$AnchoCell=intval(220/(UltimoDia($_GET["CODIGO_ANYO"], $_GET["CODIGO_MES"])));
$pdf->SetFont('Arial','',8);
while($row = mysqli_fetch_row($result)) {
    if ($NombreEmp!=$row[5]) {
        if ($NombreEmp!="") {
           $pdf->Ln();
        }
        $NombreEmp=$row[5];
        $pdf->Cell(45,4,ucwords(strtolower(utf8_decode($NombreEmp))),'LRB',0,'L',1);
    }
    $pdf->Cell($AnchoCell,4,$row[7],'RB',0,'C',1);
}
mysqli_free_result($result);
//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>