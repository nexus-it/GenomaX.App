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
     //$this->Image('FURIPS_1.jpg','2','-10','210','320','JPG'); 

     //$this->Image('FURIPS_2.jpg','2','-10','210','320','JPG'); 
     //IMAGE (RUTA,X,Y,ANCHO,ALTO,EXTEN)
}
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-18);
    //Arial italic 8
    $this->SetFont('Courier','',8);
    //Número de página
	//$this->Cell(40,10,'Impreso por: '.$_SESSION["it_CodigoUSR"].' - '.$_SESSION["it_user"],'B',0,'L',0);	
    //$this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}','B',0,'R');
    //$this->Image('FURIPS_1.jpg','0','0','200','300','JPG'); 
}
}
$FormatoPagina="Letter";
$Orientation="P";
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='furips'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $Orientation=$row[2];
    $FormatoPagina=$row[1];
    $SQL=str_replace("@CODIGO_INICIAL",($_GET["CODIGO_INICIAL"]),$SQL);
    $SQL=str_replace("@CODIGO_FINAL",($_GET["CODIGO_INICIAL"]),$SQL);
}
mysqli_free_result($result);

$pdf=new PDF($Orientation,'mm',$FormatoPagina);
$pdf->AliasNbPages();
//Datos generales internos del documento
$pdf->SetSubject('http://nexus-it.co');
$pdf->Settitle('FURIPS');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 10);
//echo $SQL;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) {


$pdf->AddPage();
$pdf->Image('FURIPS_1.jpg','2','-10','210','320','JPG'); 
//Encabezado de la tabla
$pdf->SetY(1);
$pdf->SetFont('Arial','B',11);

 //$pdf->Cell(92,68,'1  2   1  2   2  0  2  2','',0,'C',0);
 $pdf->Cell(92,68,$row['fecha_rad'],'',0,'C',0);
 $pdf->Cell(-19,68,$row['rg'],'',0,'C',0);
 $pdf->Cell(130,65,$row['no_rad'],'',0,'C',0);

 $pdf->Ln();
 $pdf->Cell(92,-50,$row['no_rad_ant'],'',0,'C',0);
 $pdf->Cell(109,-50,$row['no_fact_cta_co'],'',0,'C',0);

 $pdf->Ln();
 $pdf->SetFont('Arial','B',8);
 $pdf->Cell(200,72,$row['razon_social'],'',0,'C',0);

 $pdf->Ln();
 $pdf->SetFont('Arial','B',8);
 $pdf->Cell(92,-63,$row['cod_hab'],'',0,'C',0);
 $pdf->Cell(92,-63,$row['nit_razon_social'],'',0,'C',0);

 //$pdf->Ln();
 $pdf->SetFont('Arial','B',8);
 $pdf->Cell(-92,-43,$row['Apellido1_PAC'],'',0,'C',0);
 $pdf->Cell(-92,-43,$row['Apellido2_PAC'],'',0,'C',0);

 //$pdf->Ln();
 $pdf->Cell(92,-29,$row['Nombre1_PAC'],'',0,'C',0);
 $pdf->Cell(92,-29,$row['Nombre2_PAC'],'',0,'C',0);

 //AQUI ES DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC
 if($row['td_PAC'] == 1){
     $pdf->Ln();
     $pdf->Cell(70,45,'X','',0,'C',0);
     $pdf->Cell(112,45,$row['doc_PAC'],'',0,'C',0);
 }

 if($row['td_PAC'] == 2){
     $pdf->Ln();
     $pdf->Cell(80,45,'X','',0,'C',0);
     $pdf->Cell(95,45,$row['doc_PAC'],'',0,'C',0);
 }

 if($row['td_PAC'] == 3){
     $pdf->Ln();
     $pdf->Cell(90,45,'X','',0,'C',0);
     $pdf->Cell(75,45,$row['doc_PAC'],'',0,'C',0);
 }
 
 if($row['td_PAC'] == 5){
     $pdf->Ln();
     $pdf->Cell(100,45,'X','',0,'C',0);
     $pdf->Cell(55,45,$row['doc_PAC'],'',0,'C',0);
 }

 if($row['td_PAC'] == 4){
     $pdf->Ln();
     $pdf->Cell(110,45,'X','',0,'C',0);
     $pdf->Cell(35,45,$row['doc_PAC'],'',0,'C',0);
 }

 if($row['td_PAC'] == 6){
     $pdf->Ln();
     $pdf->Cell(120,45,'X','',0,'C',0);
     $pdf->Cell(15,45,$row['doc_PAC'],'',0,'C',0);
 }

 if($row['td_PAC'] == 7){
     $pdf->Ln();
     $pdf->Cell(130,45,'X','',0,'C',0);
     $pdf->Cell(-5,45,$row['doc_PAC'],'',0,'C',0);
 }

 //FINAL DE DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC


 $pdf->Ln();
 $pdf->Cell(80,-35,$row['FechaNac_PAC'],'',0,'C',0);
 if($row['sexo_PAC'] == 'F'){ $pdf->Cell(33,-35,'X','',0,'C',0); }
 if($row['sexo_PAC'] == 'M'){ $pdf->Cell(53,-35,'X','',0,'C',0); }

 $pdf->Ln();
 $pdf->Cell(190,45,"                                          ".$row['dir_PAC'],'',0,'L',0);

 $pdf->Ln();
 $pdf->Cell(92,-35,"                              ".$row['dpto_PAC'],'',0,'L',0);
 $pdf->Cell(92,-35,"                                          ".$row['cod_dpto_PAC'],'',0,'L',0);
 $pdf->Cell(92,-35,"".$row['tel_PAC'],'',0,'L',0);

 $pdf->Ln();
 $pdf->Cell(92,45,"                              ".$row['mun_PAC'],'',0,'L',0);
 $pdf->Cell(92,45,"                                          ".$row['cod_mun_PAC'],'',0,'L',0);


 $pdf->Ln();
 if($row['Conductor_FRP'] == 1){ $x1="x"; }else{ $x1= "";} $pdf->Cell(90,-37,$x1,'',0,'C',0);  //strtoupper($row['Conductor_FRP'])
 if($row['Peaton_FRP'] == 1){ $x2="x"; }else{ $x2= "";} $pdf->Cell(-25,-37,$x2,'',0,'C',0);  
 if($row['Ocupante_FRP'] == 1){ $x3="x"; }else{ $x3= "";} $pdf->Cell(92,-37,$x3,'',0,'C',0) ;
 if($row['Ciclista_FRP'] == 1){ $x4="x"; }else{ $x4= "";} $pdf->Cell(-14,-37,$x4,'',0,'C',0); 

 $pdf->Ln();
 if($row['acd_transito_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(100,65,$x1,'',0,'C',0);

 $pdf->Ln();
 if($row['sismo_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(100,-55,$x1,'',0,'C',0);
 if($row['maremoto_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-33,-55,$x1,'',0,'C',0);
 if($row['erupciones_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(107,-55,$x1,'',0,'C',0);
 if($row['huracan_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-38,-55,$x1,'',0,'C',0);

 $pdf->Ln();
 if($row['inundaciones_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(100,65,$x1,'',0,'C',0);
 if($row['avalancha_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-33,65,$x1,'',0,'C',0);
 if($row['des_tierra_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(107,65,$x1,'',0,'C',0);
 if($row['in_natural_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-38,65,$x1,'',0,'C',0);

  $pdf->Ln();
 if($row['explosion_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(100,-55,$x1,'',0,'C',0);
 if($row['masacre_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-33,-55,$x1,'',0,'C',0);
 if($row['mina_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(107,-55,$x1,'',0,'C',0);
 if($row['combate_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-38,-55,$x1,'',0,'C',0);
 

  $pdf->Ln();
 if($row['incendio_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(100,65,$x1,'',0,'C',0);
 if($row['ataques_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-33,65,$x1,'',0,'C',0);
// if($row['erupciones_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(107,65,$x1,'',0,'C',0);
// if($row['huracan_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-38,65,$x1,'',0,'C',0);

$pdf->Ln();
 if($row['otro_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(13,-55,$x1,'',0,'C',0);
 $pdf->Cell(45,-55,$row['cual_FRP'],'',0,'C',0);
 //if($row['mina_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(107,-55,$x1,'',0,'C',0);
 //if($row['combate_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-38,-55,$x1,'',0,'C',0);


 $pdf->Ln();
 $pdf->Cell(125,65,$row['dirocurrencia_FRP'],'',0,'C',0);

 $pdf->Ln();
 $pdf->Cell(90,-55,$row['fechaeven_FRP'],'',0,'C',0);
 $pdf->Cell(50,-55,$row['horaeven_FRP'],'',0,'C',0);


    $SQL_dpto="SELECT Nombre_DEP from czdepartamentos where Codigo_DEP='".$row['dptoeven_FRP']."'";
    $result_dpto = mysqli_query($conexion, $SQL_dpto);
    if ($row_dpto = mysqli_fetch_row($result_dpto)) {
        
        $nombre_depto=$row_dpto[0];
    }

 $pdf->Ln();
 $pdf->Cell(130,65,$nombre_depto,'',0,'C',0); 
 $pdf->Cell(-5,65,$row['dptoeven_FRP'],'',0,'C',0);

    $SQL_mun="SELECT Nombre_MUN from czmunicipios where Codigo_MUN='".$row['muneven_FRP']."' and Codigo_DEP='".$row['dptoeven_FRP']."'";
    $result_mun = mysqli_query($conexion, $SQL_mun);
    if ($row_mun = mysqli_fetch_row($result_mun)) {
        
        $nombre_mun=$row_mun[0];
    }

 $pdf->Ln();
 $pdf->Cell(130,-55,$nombre_mun,'',0,'C',0);
 $pdf->Cell(-5,-55,$row['muneven_FRP'],'',0,'C',0);
 if($row['zonaeven_FRP'] == 'U'){ $x1="X"; }else{ $x1= "";} $pdf->Cell(65,-55,$x1,'',0,'C',0);
 if($row['zonaeven_FRP'] == 'R'){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-45,-55,$x1,'',0,'C',0);

 $pdf->Ln();
 $pdf->SetY(173);
 $pdf->MultiCell(0,4,$row['deseven_FRP'],2);



 $pdf->Ln();
 $pdf->SetY(189);
 if($row['asegurado_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(110,6,$x1,'',0,'C',0);
 if($row['noasegurado_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-53,6,$x1,'',0,'C',0);
 if($row['vehifantasma_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(117,6,$x1,'',0,'C',0);
 if($row['polizafalsa_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-68,6,$x1,'',0,'C',0);
 if($row['vehienfuga_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(128,6,$x1,'',0,'C',0);

 $pdf->Ln();
 $pdf->Cell(80,5,$row['marca_FRP'],'',0,'C',0);
 $pdf->Cell(105,5,$row['placa_FRP'],'',0,'C',0);

 $pdf->Ln();
 if($row['particular_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(80,6,$x1,'',0,'C',0);
 if($row['publico_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-42,6,$x1,'',0,'C',0);
 if($row['oficial_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(80,6,$x1,'',0,'C',0);
 if($row['vehiemergencia_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-5,6,$x1,'',0,'C',0);
 if($row['diplomaticoconsultar_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(130,6,$x1,'',0,'C',0);

    $pdf->Ln();
    if($row['transportemasivo_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(125,4,$x1,'',0,'C',0);
    if($row['escolar_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-55,4,$x1,'',0,'C',0);

    $pdf->Ln();
    $pdf->Cell(90,4,$row['codigoaseguradora_FRP'],'',0,'C',0);


    $pdf->Ln();
    $pdf->Cell(90,6,$row['poliza_FRP'],'',0,'C',0);
    if($row['siintervencion_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(168,6,$x1,'',0,'C',0);
    if($row['nointervencion'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-130,6,$x1,'',0,'C',0);

    $pdf->Ln();
    $pdf->Cell(90,4,$row['vigenciadesde_FRP'],'',0,'C',0);
    $pdf->Cell(-20,4,$row['vigenciahasta_FRP'],'',0,'C',0);
    if($row['sicobropoliza_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(208,4,$x1,'',0,'C',0);
    if($row['nocobropoliza_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-170,4,$x1,'',0,'C',0);


    $pdf->Ln();
    $pdf->Cell(92,15,$row['primerapellido_FRP'],'',0,'C',0);
    $pdf->Cell(92,15,$row['segundoapellido_FRP'],'',0,'C',0);

    $pdf->Ln();
    $pdf->Cell(92,-1,$row['primernombre_FRP'],'',0,'C',0);
    $pdf->Cell(92,.1,$row['segundonombre_FRP'],'',0,'C',0);


    $pdf->Ln();
    $pdf->Cell(92,-1,$row['primernombre_FRP'],'',0,'C',0);
    $pdf->Cell(92,.1,$row['segundonombre_FRP'],'',0,'C',0);


    //AQUI ES DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC
    
    if($row['tipodocumento_FRP'] == 'CC'){
         $pdf->Ln();
         $pdf->Cell(70,14,'X','',0,'C',0);
         $pdf->Cell(115,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_FRP'] == 'CE'){
         $pdf->Ln();
         $pdf->Cell(80,14,'X','',0,'C',0);
         $pdf->Cell(95,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }
     
     if($row['tipodocumento_FRP'] == 'PA'){
         $pdf->Ln();
         $pdf->Cell(90,14,'X','',0,'C',0);
         $pdf->Cell(75,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_FRP'] == 'NIT'){
         $pdf->Ln();
         $pdf->Cell(100,14,'X','',0,'C',0);
         $pdf->Cell(55,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_FRP'] == 'TI'){
         $pdf->Ln();
         $pdf->Cell(110,14,'X','',0,'C',0);
         $pdf->Cell(35,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_FRP'] == 'RC'){
         $pdf->Ln();
         $pdf->Cell(120,14,'X','',0,'C',0);
         $pdf->Cell(15,14,$row['numerodocumento_FRP'],'',0,'C',0);
     }

     //FINAL DE DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC


     $pdf->Ln();
     $pdf->Cell(92,-4,$row['direccionresidencia_FRP'],'',0,'C',0);


        $SQL_dpto="SELECT Nombre_DEP from czdepartamentos where Codigo_DEP='".$row['departamentopro_FRP']."'";
            $result_dpto = mysqli_query($conexion, $SQL_dpto);
            if ($row_dpto = mysqli_fetch_row($result_dpto)) {
                
                $nombre_depto=$row_dpto[0];
            }


        $SQL_mun="SELECT Nombre_MUN from czmunicipios where Codigo_MUN='".$row['municipiopro_FRP']."' and Codigo_DEP='".$row['departamentopro_FRP']."'";
            $result_mun = mysqli_query($conexion, $SQL_mun);
            if ($row_mun = mysqli_fetch_row($result_mun)) {
                
                $nombre_mun=$row_mun[0];
            }



     $pdf->Ln();
     $pdf->Cell(92,14,$nombre_depto,'',0,'C',0);
     $pdf->Cell(60,14,$row['departamentopro_FRP'],'',0,'C',0);
     $pdf->Cell(30,14,$row['telefonopro_FRPaqa'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(92,-4,$nombre_mun,'',0,'C',0);
     $pdf->Cell(60,-4,$row['municipiopro_FRP'],'',0,'C',0);







$pdf->AddPage();
$pdf->Image('FURIPS_2.jpg','2','-10','210','320','JPG'); 

    

    $pdf->Ln();
    $pdf->Cell(92,60,$row['primerapellido_ci_FRP'],'',0,'C',0);
    $pdf->Cell(92,60,$row['segundoapellido_ci_FRP'],'',0,'C',0);

    $pdf->Ln();
    $pdf->Cell(92,-47,$row['primernombre_ci_FRP'],'',0,'C',0);
    $pdf->Cell(92,-47,$row['segundonombre_ci_FRP'],'',0,'C',0);

    //AQUI ES DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC
    
    if($row['tipodocumento_ci_FRP'] == 'CC'){
         $pdf->Ln();
         $pdf->Cell(70,61,'X','',0,'C',0);
         $pdf->Cell(110,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_ci_FRP'] == 'CE'){
         $pdf->Ln();
         $pdf->Cell(80,61,'X','',0,'C',0);
         $pdf->Cell(90,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }
     
     if($row['tipodocumento_ci_FRP'] == 'PA'){
         $pdf->Ln();
         $pdf->Cell(90,61,'X','',0,'C',0);
         $pdf->Cell(70,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_ci_FRP'] == 'NIT'){
         $pdf->Ln();
         $pdf->Cell(100,61,'X','',0,'C',0);
         $pdf->Cell(50,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_ci_FRP'] == 'TI'){
         $pdf->Ln();
         $pdf->Cell(110,61,'X','',0,'C',0);
         $pdf->Cell(30,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_ci_FRP'] == 'RC'){
         $pdf->Ln();
         $pdf->Cell(120,61,'X','',0,'C',0);
         $pdf->Cell(10,61,$row['numerodocumento_ci_FRP'],'',0,'C',0);
     }

     //FINAL DE DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC


     $pdf->Ln();
     $pdf->Cell(100,-52,$row['direccionresidencia_ci_FRP'],'',0,'C',0);


        $SQL_dpto="SELECT Nombre_DEP from czdepartamentos where Codigo_DEP='".$row['departamentopro_ci_FRP']."'";
            $result_dpto = mysqli_query($conexion, $SQL_dpto);
            if ($row_dpto = mysqli_fetch_row($result_dpto)) {
                
                $nombre_depto=$row_dpto[0];
            }


        $SQL_mun="SELECT Nombre_MUN from czmunicipios where Codigo_MUN='".$row['municipioresidencia_ci_FRP']."' and Codigo_DEP='".$row['departamentopro_ci_FRP']."'";
            $result_mun = mysqli_query($conexion, $SQL_mun);
            if ($row_mun = mysqli_fetch_row($result_mun)) {
                
                $nombre_mun=$row_mun[0];
            }



     $pdf->Ln();
     $pdf->Cell(92,62,$nombre_depto,'',0,'C',0);
     $pdf->Cell(60,62,$row['departamentopro_ci_FRP'],'',0,'C',0);
     $pdf->Cell(30,62,$row['telefono_ci_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(92,-53,$nombre_mun,'',0,'C',0);
     $pdf->Cell(120,-53,$row['municipioresidencia_ci_FRP'],'',0,'C',0);


     $pdf->Ln();
     if($row['remision_dr_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(90,70,$x1,'',0,'C',0);
     if($row['orden_servicio_dr_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-17,70,$x1,'',0,'C',0);


     $pdf->Ln();
     $pdf->Cell(83,-60,$row['fecha_remision_FRP'],'',0,'C',0);
     $pdf->Cell(25,-60,$row['hora_remision_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,70,$row['prestador_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,-61,$row['inscripcion_remite_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,70,$row['proremite_FRP'],'',0,'C',0);
     $pdf->Cell(115,70,$row['cargo_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,-55,$row['fecha_aceptacion_FRP'],'',0,'C',0);
     $pdf->Cell(25,-55,$row['hora_remision_acep_FRP'],'',0,'C',0);


     $pdf->Ln();
     $pdf->Cell(83,64,$row['prestador_recibe_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,-55,$row['inscripcion_recibe_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,65,$row['prorecibe_FRP'],'',0,'C',0);
     $pdf->Cell(115,65,$row['cargo_recibe_FRP'],'',0,'C',0);


     $pdf->Ln();
     $pdf->Cell(123,-32,$row['placa_vehiculo_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(83,45,$row['transporte_desde_FRP'],'',0,'C',0);
     $pdf->Cell(115,45,$row['transporte_hasta_FRP'],'',0,'C',0);


     $pdf->Ln();
     if($row['ambulancia_basica_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(108,-38,$x1,'',0,'C',0);
     if($row['ambulancia_medicada_FRP'] == 1){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-34,-38,$x1,'',0,'C',0);
     if($row['zona_recoge_FRP'] == 'U'){ $x1="X"; }else{ $x1= "";} $pdf->Cell(165,-38,$x1,'',0,'C',0);
     if($row['zona_recoge_FRP'] == 'R'){ $x1="X"; }else{ $x1= "";} $pdf->Cell(-153,-38,$x1,'',0,'C',0);


     $pdf->Ln();
     $pdf->Cell(65,58,$row['fechaingreso_FRP'],'',0,'C',0);
     $pdf->Cell(30,58,$row['horaingreso_FRP'],'',0,'C',0);
     $pdf->Cell(75,58,$row['fechaegreso_FRP'],'',0,'C',0);
     $pdf->Cell(25,58,$row['horaegreso_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(95,-49,$row['otrocodigoingreso_FRP'],'',0,'C',0);
     $pdf->Cell(113,-49,$row['otrocodigoegreso_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(95,59,$row['otrocodigoingreso_p_FRP'],'',0,'C',0);
     $pdf->Cell(113,59,$row['otrocodigoegreso_p_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(95,-50,$row['otrocodigoingreso_s_FRP'],'',0,'C',0);
     $pdf->Cell(113,-50,$row['otrocodigoegreso_s_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(65,62,$row['primerapellido_ca_FRP'],'',0,'C',0);
     $pdf->Cell(113,62,$row['segundoapellido_ca_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(65,-48,$row['primernombre_ca_FRP'],'',0,'C',0);
     $pdf->Cell(113,-48,$row['segundonombre_ca_FRP'],'',0,'C',0);


     //AQUI ES DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC
    
    if($row['tipodocumento_ca_FRP'] == 'CC'){
         $pdf->Ln();
         $pdf->Cell(70,61,'X','',0,'C',0);
         $pdf->Cell(110,61,$row['numerodocumento_ca_FRP'],'',0,'C',0);
     }

     if($row['tipodocumento_ca_FRP'] == 'CE'){
         $pdf->Ln();
         $pdf->Cell(80,61,'X','',0,'C',0);
         $pdf->Cell(90,61,$row['numerodocumento_ca_FRP'],'',0,'C',0);
     }
     
     if($row['tipodocumento_ca_FRP'] == 'PA'){
         $pdf->Ln();
         $pdf->Cell(90,61,'X','',0,'C',0);
         $pdf->Cell(70,61,$row['numerodocumento_ca_FRP'],'',0,'C',0);
     }

     //FINAL DE DONDE HUBICO LAS CASILLAS DEL TIPO DE DOC

     $pdf->Ln();
     $pdf->Cell(250,-52,$row['noregistromedico_FRP'],'',0,'C',0);
     
     
     $pdf->Ln();
     $pdf->Cell(180,85,$row['Valortotalfacturado_gmq_FRP'],'',0,'C',0);
     $pdf->Cell(-120,85,$row['Valorreclamadoalfosyga_gmq_FRP'],'',0,'C',0);

     $pdf->Ln();
     $pdf->Cell(180,-80,$row['Valortotalfacturado_gtmv_FRP'],'',0,'C',0);
     $pdf->Cell(-120,-80,$row['Valorreclamadoalfosyga_gtmv_FRP'],'',0,'C',0);

}
mysqli_free_result($result);



//mysqli_close();
//Mostramos el informe
$pdf->Output();
?>