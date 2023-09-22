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
	$this->Image('../../logo.jpg',2,1,45);
	$this->SetY(7);
	$this->SetFont('Arial','B',15);
	$this->Cell(0,7,'COTIZACIONES EFECTIVAS '.strtoupper(NombreMes($_GET["MES_INICIAL"])).' '.$_GET["ANYO"],'',0,'C',0); //Razon Social
	$this->Ln();
}
function Footer()
{
    $this->SetY(-12);
    $this->SetFont('Arial','',8);
    $this->SetTextColor(200,200,200);
	$this->Cell(0,4,'Impreso el '.date('d/m/Y'),'T',0,'R');
}
function fondomes($NumeroMes) {
	switch ($NumeroMes) {
	case 1:	
		$this->SetFillColor(204, 255, 255);
	break;
	case 2:	
		$this->SetFillColor(242, 221, 220);
	break;
	case 3:	
		$this->SetFillColor(234, 241, 221);
	break;
	case 4:	
		$this->SetFillColor(229, 224, 236);
	break;
	case 5:	
		$this->SetFillColor(219, 238, 243);
	break;
	case 6:	
		$this->SetFillColor(251, 231, 215);
	break;
	case 7:	
		$this->SetFillColor(242, 238, 248);
	break;
	case 8:	
		$this->SetFillColor(255, 255, 204);
	break;
	case 9:	
		$this->SetFillColor(194, 204, 154);
	break;
	case 10:	
		$this->SetFillColor(250, 192, 144);
	break;
	case 11:	
		$this->SetFillColor(147, 205, 221);
	break;
	case 12:	
		$this->SetFillColor(240, 247, 145);
	break;
	
	}
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT page_rpt, orientacion_rpt, sql_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='mycotiefect1'";
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
$pdf->Settitle('COTIZACIONES EFECTIVAS');
$pdf->SetCreator('@Skanner79');
$pdf->SetMargins(10, 22,10);
$pdf->SetAutoPageBreak(true, 15);
//echo $SQL;
$pdf->AddPage("L");
$pdf->SetY(20);
$ywall=45;
$xfloor=190;
//Se eliminan registros de consultas anteriores
$SQL="Delete From mycotizaciongen";
mysqli_query($conexion, $SQL);
$SQL="Delete From mycotizaciondet";
mysqli_query($conexion, $SQL);
//Conectamos con Fomplus...
$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala;";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	//echo $row[1].'-'.$row[2].'-'.$row[3].'-'.$row[0];
	$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
	mssql_select_db($row[0], $conexionFPx);
}
$year2=$_GET["ANYO"];
$year1=$_GET["ANYO"];
$month2=$_GET["MES_INICIAL"];
$month1=($_GET["MES_INICIAL"]-$_GET["MESES"])+1;
if ($month1<=0) {
	$year1=$_GET["ANYO"]-1;
	$month1=13+($_GET["MES_INICIAL"]-$_GET["MESES"]);
}
$year3=$_GET["ANYO"];
$month3=$_GET["MES_INICIAL"]+1;
if ($month3==13) {
	$month3="01";
	$year3=$year3+1;
}
if ($year1!=$year2) {
	$SQL="Select B.[Nombre Vendedor], month(A.[fechacotizacion]), count(distinct(A.[numcotizacion])), count(distinct(C.[numerocotizacion])), year(A.[fechacotizacion]) 
From Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden] 
Where B.[ID Vendedor]=A.[vendedor] and year(A.[fechacotizacion]) ='$year1' and month(A.[fechacotizacion])>='$month1' 
Group By B.[Nombre Vendedor], year(A.[fechacotizacion]), month(A.[fechacotizacion])
Union 
Select B.[Nombre Vendedor], month(A.[fechacotizacion]), count(distinct(A.[numcotizacion])), count(distinct(C.[numerocotizacion])), year(A.[fechacotizacion]) 
From Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden] 
Where B.[ID Vendedor]=A.[vendedor] and year(A.[fechacotizacion]) ='$year2' and month(A.[fechacotizacion])<='$month2'
Group By B.[Nombre Vendedor], year(A.[fechacotizacion]), month(A.[fechacotizacion])
Order By 1, 5, 2";
} else {
	$SQL="Select B.[Nombre Vendedor], month(A.[fechacotizacion]), count(distinct(A.[numcotizacion])), count(distinct(C.[numerocotizacion])), year(A.[fechacotizacion]) From Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden] Where B.[ID Vendedor]=A.[vendedor] and  year(A.[fechacotizacion]) ='".$year1."' and month(A.[fechacotizacion])<='".$month2."' and month(A.[fechacotizacion])>='".$month1."' Group By B.[Nombre Vendedor], year(A.[fechacotizacion]), month(A.[fechacotizacion])";
}
//echo $SQL;
$resultFPx = mssql_query($SQL, $conexionFPx);
while($rowFPx = mssql_fetch_row($resultFPx)) {
	$SQL="Insert Into mycotizaciongen(Vendedor_MCG, Mes_MCG, Cotizaciones_MCG, Efectivas_MCG, F1_MCG, F2_MCG) Values('$rowFPx[0]', '".NombreMes($rowFPx[1])."', '$rowFPx[2]', '$rowFPx[3]', '".$rowFPx[1]."', '".$rowFPx[4]."');";
//echo ''.$SQL;
	mysqli_query($conexion, $SQL);
}
mssql_free_result($resultFPx);


$pdf->SetFillColor(239, 242, 248);
$pdf->SetDrawColor(134, 134, 134);
//Cuadro de imagen donde ubicar la grafica
$pdf->SetY(15);
$pdf->SetX(110);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,5,'INDICADOR MENSUAL',1,0,'C',0);
$pdf->Rect($ywall-15,$xfloor-106,220,$xfloor-74);
// Recuadro interno
$pdf->SetFont('Arial','',11);
$pdf->Rect($ywall,$xfloor-100,200,100, 'F');
$pdf->Text($ywall-12,$xfloor-98,"100%");
$pdf->Text($ywall-10,$xfloor-88,"90%");
$pdf->Text($ywall-10,$xfloor-78,"80%");
$pdf->Text($ywall-10,$xfloor-68,"70%");
$pdf->Text($ywall-10,$xfloor-58,"60%");
$pdf->Text($ywall-10,$xfloor-48,"50%");
$pdf->Text($ywall-10,$xfloor-38,"40%");
$pdf->Text($ywall-10,$xfloor-28,"30%");
$pdf->Text($ywall-10,$xfloor-18,"20%");
$pdf->Text($ywall-10,$xfloor-8,"10%");
$pdf->Text($ywall-8,$xfloor+2,"0%");
$pdf->Line($ywall-2,$xfloor-100,$ywall+200,$xfloor-100);
$pdf->Line($ywall-2,$xfloor-90,$ywall+200,$xfloor-90);
$pdf->Line($ywall-2,$xfloor-80,$ywall+200,$xfloor-80);
$pdf->Line($ywall-2,$xfloor-70,$ywall+200,$xfloor-70);
$pdf->Line($ywall-2,$xfloor-60,$ywall+200,$xfloor-60);
$pdf->Line($ywall-2,$xfloor-50,$ywall+200,$xfloor-50);
$pdf->Line($ywall-2,$xfloor-40,$ywall+200,$xfloor-40);
$pdf->Line($ywall-2,$xfloor-30,$ywall+200,$xfloor-30);
$pdf->Line($ywall-2,$xfloor-20,$ywall+200,$xfloor-20);
$pdf->Line($ywall-2,$xfloor-10,$ywall+200,$xfloor-10);
$pdf->Line($ywall-2,$xfloor,$ywall+200,$xfloor);

$distancia=200/$_GET["MESES"];
$ancho=$distancia*0.9;
$conta=1;
$ejex=$ywall;
$SQL="SELECT Mes_MCG, sum(Cotizaciones_MCG), sum(Efectivas_MCG), F1_MCG, F2_MCG FROM mycotizaciongen Group By Mes_MCG, F1_MCG, F2_MCG Order By F2_MCG, F1_MCG";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
	$porc=($row[2]/$row[1])*100;
	$desde=($distancia*0.05)+$ejex;
	$ejex=$distancia*$conta+$ywall;
	//Separadores de serie
	$pdf->Line($ejex,$xfloor,$ejex,$xfloor+2);
	$pdf->SetFillColor(79, 129, 189);
	$pdf->SetDrawColor(77, 127, 187);
	$pdf->Rect($desde,$xfloor-$porc,$ancho,$porc, 'FD');
	$pdf->SetY($xfloor);
	$pdf->SetX($desde);
	if ($_GET["MESES"]>7){
		$pdf->SetFont('Arial','',10);
	}
	if ($_GET["MESES"]>9){
		$pdf->SetFont('Arial','',9);
	}
	$pdf->Cell($ancho,6,$row[0],'',0,'C',0);
	$pdf->SetY($xfloor-5-$porc);
	$pdf->SetX($desde);
	$pdf->Cell($ancho,6,number_format($porc, 2, ",", ".").'%','',0,'C',0);
	$pdf->SetDrawColor(134, 134, 134);
	//Seleccionamos el color a mostrar segun el mes
	$pdf->fondomes($row[3]);

	$pdf->SetY(15+(5*$conta));
	$pdf->SetX(110);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(30,5,$row[0],'RLB',0,'C',1);
	$pdf->Cell(25,5,number_format($porc, 2, ",", ".").'%','RLB',0,'C',1);
	$conta++;
}
mysqli_free_result($result);
$pdf->AddPage("L");
$pdf->SetFont('Arial','B',9);
$distancia=165/$_GET["MESES"];
$pdf->SetY(55);
$pdf->SetDrawColor(1, 1, 1);
$pdf->SetFillColor(219, 229, 241);
$pdf->Cell(45,5,"",'RLT',0,'C',1);
$pdf->Cell(165,5,"MESES",'RT',0,'C',1);
$pdf->SetFillColor(197, 217, 241);
$pdf->Cell(16,5,"",'RT',0,'C',1);
$pdf->Cell(16,5,"",'RT',0,'C',1);
$pdf->SetFillColor(219, 229, 241);
$pdf->Cell(0,5,"INDICADOR",'RT',1,'C',1);
$pdf->Cell(45,5,"ASESORES",'RL',0,'C',1);
$mes=0;
if ($_GET["MESES"]>7){
	$pdf->SetFont('Arial','B',8);
}
if ($_GET["MESES"]>9){
	$pdf->SetFont('Arial','B',7);
}
$SQL="SELECT distinct F1_MCG FROM mycotizaciongen Order By F2_MCG asc, F1_MCG asc";
$resultm = mysqli_query($conexion, $SQL);
while($rowm = mysqli_fetch_row($resultm)) {
	$pdf->fondomes($rowm[0]);
	$pdf->Cell($distancia,5,strtoupper(NombreMes($rowm[0])),'RT',0,'C',1);
}
mysqli_free_result($resultm);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(197, 217, 241);
$pdf->Cell(16,5,"Total",'R',0,'C',1);
$pdf->Cell(16,5,"Total",'R',0,'C',1);
$pdf->SetFillColor(219, 229, 241);
$pdf->Cell(0,5,"POR",'R',1,'C',1);
$pdf->Cell(45,5,"",'RBL',0,'C',1);
$mes=0;
if ($_GET["MESES"]>7){
	$pdf->SetFont('Arial','B',8);
}
if ($_GET["MESES"]>9){
	$pdf->SetFont('Arial','B',7);
}
$SQL="SELECT distinct F1_MCG FROM mycotizaciongen Order By F2_MCG asc, F1_MCG asc";
$resultm1 = mysqli_query($conexion, $SQL);
while($rowm1 = mysqli_fetch_row($resultm1)) {
	$pdf->fondomes($rowm1[0]);
	$pdf->Cell($distancia/2,5,"C.R.",'RBT',0,'C',1);
	$pdf->Cell($distancia/2,5,"C.E.",'RTB',0,'C',1);
}
mysqli_free_result($resultm1);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(197, 217, 241);
$pdf->Cell(16,5,"Suma C.R.",'RB',0,'C',1);
$pdf->Cell(16,5,"Suma C.E.",'RB',0,'C',1);
$pdf->SetFillColor(219, 229, 241);
$pdf->Cell(0,5,"ASESOR",'RB',1,'C',1);
$SQL="SELECT distinct Vendedor_MCG FROM mycotizaciongen Order By 1";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_row($result)) {
	$Cotix=0;
	$Efecx=0;
	$pdf->SetFont('Arial','B',8.5);
	$pdf->Cell(45,5,$row[0],'RBL',0,'L',1);
	$SQL="SELECT distinct F1_MCG, F2_MCG FROM mycotizaciongen Order By F2_MCG asc, F1_MCG asc";
	$resultmx = mysqli_query($conexion, $SQL);
	while($rowmx = mysqli_fetch_row($resultmx)) {
		$SQL="SELECT Cotizaciones_MCG, Efectivas_MCG FROM mycotizaciongen Where Vendedor_MCG='".$row[0]."' and F2_MCG='".$rowmx[1]."' and F1_MCG='".$rowmx[0]."'";
		$result2 = mysqli_query($conexion, $SQL);
		$Coti="0";
		$Efec="0";
		while($row2 = mysqli_fetch_row($result2)) {
			$Coti=$row2[0];
			$Efec=$row2[1];
		}
		mysqli_free_result($result2);
		$pdf->fondomes($rowmx[0]);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell($distancia/2,5,$Coti,'RBT',0,'C',1);
		$pdf->Cell($distancia/2,5,$Efec,'RTB',0,'C',1);
		$Cotix=$Cotix+$Coti;
		$Efecx=$Efecx+$Efec;
	}
	mysqli_free_result($resultmx);
	$pdf->SetFillColor(197, 217, 241);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(16,5,$Cotix,'RB',0,'C',1);
	$pdf->Cell(16,5,$Efecx,'RB',0,'C',1);
	$pdf->SetFillColor(219, 229, 241);
	
	$pdf->Cell(0,5,number_format(($Efecx/$Cotix)*100, 0, ",", ".").'%','RB',1,'R',1);
}
mysqli_free_result($result);
$Cotix=0;
$Efecx=0;
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(45,5,"Total General",'RBL',0,'L',1);
$pdf->SetFont('Arial','B',9);
$SQL="SELECT distinct F1_MCG, F2_MCG FROM mycotizaciongen Order By F2_MCG asc, F1_MCG asc";
$resultmx = mysqli_query($conexion, $SQL);
while($rowmx = mysqli_fetch_row($resultmx)) {
	$SQL="SELECT sum(Cotizaciones_MCG), sum(Efectivas_MCG) FROM mycotizaciongen Where F2_MCG='".$rowmx[1]."' and F1_MCG='".$rowmx[0]."'";
	$result2 = mysqli_query($conexion, $SQL);
	$Coti="0";
	$Efec="0";
	while($row2 = mysqli_fetch_row($result2)) {
		$Coti=$row2[0];
		$Efec=$row2[1];
	}
	mysqli_free_result($result2);
	$pdf->fondomes($rowmx[0]);
	$pdf->Cell($distancia/2,5,$Coti,'RBT',0,'C',1);
	$pdf->Cell($distancia/2,5,$Efec,'RTB',0,'C',1);
	$Cotix=$Cotix+$Coti;
	$Efecx=$Efecx+$Efec;
}
mysqli_free_result($resultmx);
$pdf->SetFillColor(197, 217, 241);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(16,5,$Cotix,'RB',0,'C',1);
$pdf->Cell(16,5,$Efecx,'RB',0,'C',1);
$pdf->SetFillColor(219, 229, 241);

$pdf->Cell(0,5,number_format(($Efecx/$Cotix)*100, 0, ",", ".").'%','RB',1,'R',1);
if ($_GET["DETALLE"]=="SI") {
	$pdf->AddPage("P");
	if ($year1!=$year2) {
		$SQL="Select distinct B.[Nombre Vendedor], month(A.[fechacotizacion]), (A.[numcotizacion]), rtrim(A.Titulo), rtrim(D.[Nombre Cliente]), case isnull(C.[numerocotizacion], 0) when '0' then 'N' else 'S' end From Z_Clientes as D, Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden]	Where B.[ID Vendedor]=A.[vendedor] and D.[ID Cliente]=A.[cliente] and year(A.[fechacotizacion])='".$year1."' and month(A.[fechacotizacion])>='".$month1."'  		
		Union 		
Select distinct B.[Nombre Vendedor], month(A.[fechacotizacion]), (A.[numcotizacion]), rtrim(A.Titulo), rtrim(D.[Nombre Cliente]), case isnull(C.[numerocotizacion], 0) when '0' then 'N' else 'S' end From Z_Clientes as D, Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden]	Where B.[ID Vendedor]=A.[vendedor] and D.[ID Cliente]=A.[cliente] and year(A.[fechacotizacion])='".$year2."' and month(A.[fechacotizacion])<='".$month2."' ";
	} else {
		$SQL="Select distinct B.[Nombre Vendedor], month(A.[fechacotizacion]), (A.[numcotizacion]), rtrim(A.Titulo), rtrim(D.[Nombre Cliente]), case isnull(C.[numerocotizacion], 0) when '0' then 'N' else 'S' end From Z_Clientes as D, Z_Vendedores as B, cotizaciones1 as A left join ordenespla1 as C On A.[numcotizacion]=C.[numerocotizacion] and A.[fechacotizacion]<=C.[fechaorden]	Where B.[ID Vendedor]=A.[vendedor] and D.[ID Cliente]=A.[cliente] and year(A.[fechacotizacion])='".$year1."' and month(A.[fechacotizacion])>='".$month1."' and month(A.[fechacotizacion])<='".$month2."'";
	}
//	echo $SQL;
	$resultFPx = mssql_query($SQL, $conexionFPx);
	while($rowFPx = mssql_fetch_row($resultFPx)) {
		$SQL="Insert Into mycotizaciondet(Vendedor_MCD, Mes_MCD, Cotizacion_MCD, Producto_MCD, Cliente_MCD, Efectiva_MCD) Values('$rowFPx[0]', '".NombreMes($rowFPx[1])."', '$rowFPx[2]', '$rowFPx[3]', '$rowFPx[4]', '$rowFPx[5]');";
		mysqli_query($conexion, $SQL);
	}
	mssql_free_result($resultFPx);
	$pdf->SetY(25);
	$pdf->SetFont('Arial','B',7.5);
	$pdf->Cell(35,5,"ASESOR",'RBLT',0,'C',1);
	$pdf->Cell(15,5,"MES",'RBLT',0,'C',1);
	$pdf->Cell(18,5,"COTIZACION",'TRBL',0,'C',1);
	$pdf->Cell(70,5,"PRODUCTO",'RBLT',0,'C',1);
	$pdf->Cell(45,5,"CLIENTE",'RBLT',0,'C',1);
	$pdf->Cell(0,5,"EFECTIVA",'RBLT',1,'C',1);	
	$pdf->SetFillColor(255, 255, 255);
	$SQL="SELECT Vendedor_MCD, Mes_MCD, Cotizacion_MCD, Producto_MCD, Cliente_MCD, Efectiva_MCD FROM mycotizaciondet Order By 1, 2, 3, 4";
	$resultd = mysqli_query($conexion, $SQL);
	while($rowd = mysqli_fetch_row($resultd)) {
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(35,5,$rowd[0],'RBL',0,'L',1);
		$pdf->Cell(15,5,$rowd[1],'RBL',0,'L',1);
		$pdf->Cell(18,5,$rowd[2],'RBL',0,'L',1);
		$pdf->Cell(70,5,substr($rowd[3],0,50),'RBL',0,'L',1);
		$pdf->Cell(45,5,$rowd[4],'RBL',0,'L',1);
		$pdf->Cell(0,5,$rowd[5],'RBL',1,'C',1);
	}
	mysqli_free_result($resultd);
}
mssql_close($conexionFPx);

$pdf->Ln();

$pdf->Output();
?>