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

function WriteHTML($html)
{
    // Intérprete de HTML
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Etiqueta
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extraer atributos
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Etiqueta de apertura
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Etiqueta de cierre
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modificar estilo y escoger la fuente correspondiente
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Escribir un hiper-enlace
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
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

$SQL="SELECT sql_rpt from nxs_gnx.itreports where codigo_rpt='hc'";
$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	$SQL=$rowH[0];
	$SQL=str_replace("@HISTORIA",($_GET["HISTORIA"]),$SQL);
	$SQL=str_replace("@FOLIO_INICIAL",($_GET["FOLIO_INICIAL"]),$SQL);
	$SQL=str_replace("@FOLIO_FINAL",($_GET["FOLIO_FINAL"]),$SQL);
}
//echo $SQL;
mysqli_free_result($resultH);

$resultH = mysqli_query($conexion, $SQL);
if ($rowH = mysqli_fetch_row($resultH)) {
	if (strlen($rowH[0])>=50 ) {
		$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,6,55);
	} else {
		$this->Image('../../files/logo'.$_SESSION["DB_SUFFIX"].'.jpg',4,2,55);	
	}
	$this->SetFillColor(255);
	$this->SetY(3);
	if (strlen($rowH[0])>=40 ) {
		if (strlen($rowH[0])>=50 ) {
			$this->SetFont('Arial','B',10);
		} else {
			$this->SetFont('Arial','B',12);
		}
	} else {
		$this->SetFont('Arial','B',13);
	}
	$this->Cell(0,8,strtoupper($rowH[0]),'',0,'C',0); //Razon Social
	$this->SetY(9);
	$this->SetFont('Arial','',10);
	$this->Cell(0,5,'NIT: '.$rowH[1],'',0,'C',0);
	$this->SetY(14);
	$this->Cell(0,5,$rowH[2].' Tel.'.$rowH[3],'',0,'C',0);
	$this->SetY(19);
	$this->SetFont('Arial','B',12);
	if ($_GET["FOLIO_FINAL"]==$_GET["FOLIO_INICIAL"]) {
		if ($rowH[5]=="REGISTRO DE ENFERMERIA") {
			$SQL="Select dispositivo_HC, curacion_HC from hc_ENFERMERIA a, czterceros b, hcfolios c Where c.Codigo_HCF=a.Codigo_HCF and a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["HISTORIA"]."' and Folio_HCF='".$_GET["FOLIO_INICIAL"]."';";
			$resultEnf = mysqli_query($conexion, $SQL);
			if ($rowEnf = mysqli_fetch_row($resultEnf)) {
				if ($rowEnf[0]!="") {
					$this->Cell(0,7,/*'CAMBIO DE DISPOSITIVOS MEDICOS'*/'REGISTRO DE ENFERMERIA','',0,'C',0);
				} else {
					if ($rowEnf[1]!=0) {
						$this->Cell(0,7,/*'CURACIONES'*/'REGISTRO DE ENFERMERIA','',0,'C',0);
					} else {
						$this->Cell(0,7,$rowH[5],'',0,'C',0);
					}
				}
			}
			mysqli_free_result($resultEnf);
		} else {
			$this->Cell(0,7,$rowH[5],'',0,'C',0);
		}
	} else {
		$this->Cell(0,7,'HISTORIA CLINICA','',0,'C',0);
	}
	$this->Ln();
	$this->SetY(28);
	$this->SetFillColor(170);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,5,'HISTORIA No. '.$_GET["HISTORIA"],'TB',0,'R',0);
	$this->Ln();


	}
	mysqli_free_result($resultH);
}
function Footer()
{
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query($conexion, "SET time_zone = '".$_SESSION["DB_TIMEZONE"]."'");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	
	$SQL="Select DATE_FORMAT(curdate(), '%d/%m/%Y'), CURTIME();";	
	$resultD = mysqli_query($conexion, $SQL);
	while($rowD = mysqli_fetch_row($resultD)) {
		$PrintFecha= trim($rowD[0].' '.$rowD[1]);
	} 
	mysqli_free_result($resultD);
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',7);
    //Número de página
	$this->SetTextColor(200,200,200);
    $this->Cell(19,5,utf8_decode('Powered By:'),'T',0,'L');
    $this->SetFont('Arial','B',7);
    $this->Cell(10,5,utf8_decode('GenomaX'),'T',0,'R');
    $this->SetFont('Arial','',6);
    $this->Cell(3,5,utf8_decode('.co'),'T',0,'R');
    $this->SetFont('Arial','',7);
    $this->Cell(145,5,'Impreso por: {'.$_SESSION["it_CodigoUSR"].'} - '.$_SESSION["it_user"].'    Fecha: '.$PrintFecha,'T',0,'C');
	$this->SetFont('Courier','B',7);
	$this->SetTextColor(100,100,100);
	$this->SetFillColor(220);
    $this->Cell(0,5,utf8_decode('Pág').$this->PageNo().'/{nb}','T',0,'R',1);
}
function firmas($Firma, $Tercero, $NombreDoc, $RM, $PosYe){
	//Extraigo la firma de la bd
	$LeFirma='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/hc/'.$Tercero.'.jpg';
	file_put_contents($LeFirma, $Firma);
	//Muestro la foto
	$Posy=$PosYe;
	if ($Firma=="") {
    	$this->Image('../../files/_all/images/firmas/white.jpg',150,$Posy,40);
	} else {
		$this->Image($LeFirma,150,$Posy,40);
	}
	$this->SetY($Posy+11);
	$this->Ln();
	$this->SetFont('Arial','B',8);
	$this->Cell(130,4,"",'',0,'C',0);
	$this->Cell(0,3,utf8_decode($NombreDoc),'T',0,'C',0);
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select b.Nombre_ESP From gxmedicosesp a, gxespecialidades b Where a.Codigo_ESP=b.Codigo_ESP and b.Estado_ESP='1' and  Codigo_TER='".$Tercero."' Order By a.Tipo_ESP";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$this->Ln();
		$this->SetFont('Arial','',8);
		$this->Cell(130,3,"",'',0,'C',0);
		$this->Cell(0,3,utf8_decode($rowx2[0]),'',0,'C',0);	
	}
	mysqli_free_result($resultx2);
	$this->Ln();
	$this->SetFont('Arial','',8);
	$this->Cell(130,3,"",'',0,'C',0);
	$this->Cell(0,3,'R.M. '.utf8_decode($RM),'',0,'C',0);
}
function encabezadoz($titulo, $folioint){
	$LineaOne=35;
	if ($titulo!='') {
		/*$Pagina=$this->PageNo();
		if ($Pagina!=1) {
			$this->AddPage();
		}*/
		$LineaOne=40;
		$this->SetFillColor(255);
		$this->SetFont('Arial','B',12);
		$this->Cell(45,5,'','',0,'C',0);
		$this->Cell(108,5,$titulo,'',0,'C',1);
		$this->Cell(0,5,'','',0,'C',0);
		$this->Ln();
	}
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select k.Sigla_TID, b.ID_TER, b.Nombre_TER, a.EstCivil_PAC, a.fechanac_pac, j.Nombre_SEX, a.Actividad_PAC, b.direccion_ter, b.telefono_ter, l.Nombre_DEP, m.Nombre_MUN, a.Barrio_PAC, c.Acudiente_ADM, c.Telefono_ADM, a.Padre_PAC, a.Madre_PAC, a.Parentesco_PAC, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, i.Codigo_HCF, Folio_HCF, Fecha_HCF from gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h, hcfolios i, gxtiposexo j, cztipoid k, czdepartamentos l, czmunicipios m where j.Codigo_SEX=a.Codigo_SEX and k.Codigo_TID=b.Codigo_TID and l.Codigo_DEP=a.Codigo_DEP and m.Codigo_DEP=l.Codigo_DEP and m.Codigo_MUN=a.Codigo_MUN and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Codigo_ADM=i.Codigo_ADM and b.ID_TER='".$_GET["HISTORIA"]."' and i.Codigo_HCF=".$folioint." order by i.Codigo_HCF desc limit 1";
	$result0 = mysqli_query($conexion, $SQL);
	if ($row0 = mysqli_fetch_row($result0)) {
	 // echo $SQL;
		$this->SetY($LineaOne);
		$this->SetFillColor(255);

		$this->SetFont('Arial','B',9);
		$this->Cell(19,5,'Documento','LB',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(30,5,$row0[0]." ".$row0[1] ,'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(13,5,'Nombre','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(108,5,utf8_decode($row0["2"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(9,5,'Sexo','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(0,5,$row0["5"],'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',9);
		$this->Cell(19,5,'Estado Civil','LB',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(22,5,utf8_decode($row0["3"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(18,5,'Fecha Nac.','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(22,5,formatofecha($row0["4"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(9,5,'Edad','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(33,5,utf8_decode(edad($row0["4"])),'BR',0,'L',1);

		$this->SetFont('Arial','B',9);
		$this->Cell(18,5,'Ocupacion','B',0,'L',1);
		$this->SetFont('Arial','',9);
		$this->Cell(0,5,utf8_decode($row0["6"]),'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(14,5,'Direccion','LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(34,5,utf8_decode($row0["7"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(14,5,'Telefono','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(26,5,utf8_decode($row0["8"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(10,5,'Barrio','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(24,5,utf8_decode($row0["11"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(15,5,'Municipio','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["10"]).' ('.utf8_decode($row0["9"]).')','BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,utf8_decode('Acompañante'),'LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,utf8_decode($row0["12"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(5,5,'Tel.','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(26,5,utf8_decode($row0["13"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,utf8_decode('Responsable'),'B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(40,5,utf8_decode($row0["14"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(5,5,'Tel.','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["15"]),'BR',0,'L',1);

		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(18,5,utf8_decode('Parentesco'),'LB',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,utf8_decode($row0["16"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(12,5,'Entidad','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(55,5,utf8_decode($row0["17"]),'BR',0,'L',1);

		$this->SetFont('Arial','B',8);
		$this->Cell(10,5,'Plan','B',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->Cell(35,5,utf8_decode($row0["18"]),'BR',0,'L',1);

		$this->SetFont('Arial','',8);
		$this->Cell(0,5,utf8_decode($row0["19"]),'BR',0,'L',1);
		$this->Ln();

		if ($titulo!="") {
			$this->SetFillColor(220);
			$this->SetFont('Courier','B',10);
			$this->Cell(60,5,"FECHA: ".$row0[22],'TL',0,'L',1);
			$this->Cell(0,5,"FOLIO: ".$row0[21],'TR',0,'R',1);
			$this->SetFillColor(255);
			$this->Ln();
			$this->SetFont('Arial','',8);
		}
	}
	mysqli_free_result($result0);
	// Fin encabezado - Datos Personales
}
function NewItem($Bold, $Titulo) {
	$this->SetX(10);
	$this->SetDrawColor(143);
	$this->SetFont('Arial',$Bold,8);
	$this->SetFillColor(180);
	$this->Cell(1,5,"",'LB',0,'L',1);			
	$this->SetFillColor(218);			
	$this->Cell(1,5,"",'B',0,'L',1);	
	$this->SetFillColor(255);
	if ($Bold=="") {
		$this->MultiCell(0,5,utf8_decode($Titulo),'B','L',1);
	} else {
		$this->Cell(0,5,utf8_decode($Titulo),'B',0,'L',0);
	}
	$this->SetDrawColor(90);
}
function loadOdonto($Tercero, $Folio, $Theme) {
	$Nota="";
	$conexion=mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select Estados_ODG, Nota_ODG From hcodontograma a, czterceros c Where a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$Folio."' and c.ID_TER='".$Tercero."'";
	$resultodont = mysqli_query($conexion, $SQL);
	if ($rowodont = mysqli_fetch_row($resultodont)) {
		$estados = explode("__", $rowodont[0]);
		$Nota = $rowodont[1];
	}
	$simbolos="";
	mysqli_free_result($resultodont);
	foreach ($estados as $estado) {
		error_log($estado);
	    $dientes = explode("_", $estado);
	    $diente = $dientes[0];
	    $cara = $dientes[1];
	    $valor = $dientes[2];
	    $simbolo = explode("-", $valor);
	    error_log(substr($diente,1,1));
	    switch (substr($diente,1,1)) {
			case '1':
				$dienteY=87;
				$dienteX=95;
			break;
			case '2':
				$dienteY=87;
				$dienteX=105;
			break;
			case '5':
				$dienteY=112;
				$dienteX=95;
			break;
			case '6':
				$dienteY=112;
				$dienteX=105;
			break;
			case '8':
				$dienteY=142;
				$dienteX=95;
			break;
			case '7':
				$dienteY=142;
				$dienteX=105;
			break;
			case '4':
				$dienteY=168;
				$dienteX=95;
			break;
			case '3':
				$dienteY=168;
				$dienteX=105;
			break;
	    }
	    if ($dienteX==95) {
	    	switch (substr($diente,2,1)) {
				case '1':
					$dienteX=99;
				break;
				case '2':
					$dienteX=87;
				break;
				case '3':
					$dienteX=75;
				break;
				case '4':
					$dienteX=64;
				break;
				case '5':
					$dienteX=52;
				break;
				case '6':
					$dienteX=40;
				break;
				case '7':
					$dienteX=29;
				break;
				case '8':
					$dienteX=17;
				break;
		    }
	    } else {
	    	switch (substr($diente,2,1)) {
				case '1':
					$dienteX=117;
				break;
				case '2':
					$dienteX=128;
				break;
				case '3':
					$dienteX=140;
				break;
				case '4':
					$dienteX=151;
				break;
				case '5':
					$dienteX=163;
				break;
				case '6':
					$dienteX=175;
				break;
				case '7':
					$dienteX=186;
				break;
				case '8':
					$dienteX=198;
				break;
		    }
	    }
	    $position="A";
	    $SQL="Select Tipo_OGS from hcodontogramasimbolos Where Codigo_OGS='".$simbolo[0]."';";
	    $resultodont = mysqli_query($conexion, $SQL);
		if ($rowodont = mysqli_fetch_row($resultodont)) {
			$position = $rowodont[0];
		}
		mysqli_free_result($resultodont);
		switch ($position) {
			case 'T':
				$dienteY=$dienteY+15;
			break;
			case 'U':
				$dienteY=$dienteY-12;
			break;
			case 'D':
				$dienteY=$dienteY+12;
			break;
			case 'F':
				switch ($cara) {
					case 'C1':
						$dienteX=$dienteX-3;
					break;
					case 'C2':
						$dienteY=$dienteY-3;
					break;
					case 'C3':
						$dienteX=$dienteX+3;
					break;
					case 'C4':
						$dienteY=$dienteY+4;
					break;
				}
			break;
			
		}
		$ElSimbolo="";
		$ElSimbolo=$simbolo[0];
		if ($ElSimbolo!="") {
		    $this->Image('http://cdn.genomax.co/media/image/odontog/'.$simbolo[0].'.png',$dienteX,$dienteY,0);
		    $simbolos=$simbolos."'".$simbolo[0]."', ";
		}
	}
	if ($Nota!="") {
		$this->SetY(190);
		$this->SetFont('Arial','B',8);
		$this->Cell(23,3,'DESCRIPCION:','',0,'',0);
		$this->SetFont('Arial','',8);
		$this->MultiCell(0,3,utf8_decode($Nota),'','L',0);
		$this->Ln();
		$this->Ln();
	}
	$SQL="SELECT distinct Codigo_OGS, Descripcion_OGS From hcodontogramasimbolos Where Codigo_OGS in (".$simbolos."'');";
	$resultodont = mysqli_query($conexion, $SQL);
	$this->SetY(205);
	while ($rowodont = mysqli_fetch_row($resultodont)) {
		$positionY = $this->GetY();
		$this->Image('http://cdn.genomax.co/media/image/odontog/'.$rowodont[0].'.png',10,$positionY,0);
		$this->Cell(6,6,'','',0,'',0);
		$this->Cell(0,6,$rowodont[1],'',0,'',0);
		$this->Ln();
	}
	mysqli_free_result($resultodont);
}
function Antexedentes($AntTable, $Foliox, $Name) {
	$conexion=mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select a.Codigo_TER From ".$AntTable." a, czterceros c Where a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$Foliox."' and c.ID_TER='".$_GET["HISTORIA"]."'";
	
	$resulttbl = mysqli_query($conexion, $SQL);
	if ($rowtbl = mysqli_fetch_row($resulttbl)) {
		$this->SetFont('Courier','B',7);
		$this->Ln();
		$this->SetFillColor(250);
		$this->Cell(56,3,str_repeat ('-', 20),'',0,'R',1);
		$this->Cell(84,3,utf8_decode($Name),'RBLT',0,'C',1);
		$this->Cell(56,3,str_repeat ('-', 20),'',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->SetFillColor(255);
		$this->Ln();
		$SQL="Select * From ".$AntTable." a, czterceros c Where a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$Foliox."' and c.ID_TER='".$_GET["HISTORIA"]."'";
		$resultANT = mysqli_query($conexion, $SQL);
		if ($rowANT = mysqli_fetch_row($resultANT)) {
			$SQL="SELECT COLUMN_NAME, COLUMN_TYPE, COLUMN_COMMENT, ORDINAL_POSITION FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = '".$AntTable."' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER') ORDER BY ORDINAL_POSITION;";
			$resultANT1 = mysqli_query($conexion, $SQL);
			$kontcols=0;
			$lstcontrol="multi";
			$zection="";
			while ($rowANT1 = mysqli_fetch_row($resultANT1)) {
				if ($AntTable=="hcriegoobs") {
					$zectionAnt=$zection;
					if($rowANT1[3]<=14) { 
						$zection="I. Historia reproductiva"; 
					} else {
						if($rowANT1[3]<=38) {
							$zection="II. Condiciones Médicas Asociadas";
						} else {
							if($rowANT1[3]<=56) {
								$zection="Escala Riesgo Sicosocial [Herrera y Hurtado]";
							} else {
								if($rowANT1[3]<=60) {
									$zection="Violencia Doméstica";
								} else {
									if($rowANT1[3]<=96) {
										$zection="III. Embarazo actual";
									} else {
										$zection="Puntaje de riesgo obstétrico";	
									}
								}
							}
						}
					}
					if($zectionAnt!=$zection) {
						$this->Ln();
						$this->NewItem("B", $zection);
						$this->Ln();
					}
				}
				$lstcontrol="square";
				switch ($rowANT1[1]) {
				case 'char(1)':
					$kontcols++;
					$sheked="";
					$boldie="";
					$kolong=40;
					$kolnum=4;
					if ($AntTable=="hcriegoobs") {
						if($zection=="Violencia Doméstica") {
							$kolong=190;
							$kolnum=1;
						} else {
							if ($zection!="I. Historia reproductiva"){
								if ($zection=="Puntaje de riesgo obstétrico"){
									$kolong=90;
									$kolnum=2;
								} else {
									$kolong=56;
									$kolnum=3;
								}
							}
						}
					}
					if($rowANT[$rowANT1[3]-1]=="1") {
						$sheked="*";
						$boldie="B";
					}
					$this->SetFont('Arial',$boldie,8);
					$this->SetFillColor(230);
					$this->Cell($kolong,5,utf8_decode($rowANT1[2]),'',0,'L',1);
					$this->SetFillColor(255);
					$this->SetDrawColor(143);
					$this->SetFont('Arial',$boldie,14);
					$this->Cell(6,5,utf8_decode($sheked),'BRTL',0,'C',1);
					$this->SetFont('Arial',$boldie,8);
					$this->Cell(4,5,"",'L',0,'C',1);
					$this->SetDrawColor(90);
					if(fmod($kontcols,$kolnum)==0) {
						$this->Ln();
					}
				break;
				case 'varchar(50)':
					$kontcols++;
					$boldie="";
					if($rowANT[$rowANT1[3]-1]!="") {
						$boldie="B";
					}
					$this->SetFont('Arial',$boldie,8);
					$this->SetFillColor(230);
					$this->Cell(38,5,utf8_decode($rowANT1[2]),'',0,'L',1);
					$this->SetFillColor(255);
					$this->SetDrawColor(143);
					$this->Cell(8,5,utf8_decode($rowANT[$rowANT1[3]-1]),'BRTL',0,'C',1);
					$this->Cell(4,5,"",'L',0,'C',1);
					$this->SetDrawColor(90);
					if(fmod($kontcols,4)==0) {
						$this->Ln();
					}

				break;
				case 'int(11)':
					$kontcols++;
					$boldie="";
					if($rowANT[$rowANT1[3]-1]!=0) {
						$boldie="B";
					}
					$this->SetFont('Arial',$boldie,8);
					$this->SetFillColor(230);
					$this->Cell(38,5,utf8_decode($rowANT1[2]),'',0,'L',1);
					$this->SetFillColor(255);
					$this->SetDrawColor(143);
					$this->Cell(8,5,utf8_decode($rowANT[$rowANT1[3]-1]),'BRTL',0,'R',1);
					$this->Cell(4,5,"",'L',0,'C',1);
					$this->SetDrawColor(90);
					if(fmod($kontcols,4)==0) {
						$this->Ln();
					}

				break;
				case 'date':
					$kontcols++;
					$boldie="";
					if($rowANT[$rowANT1[3]-1]!='0000-00-00') {
						$boldie="B";
					}
					$this->SetFont('Arial',$boldie,8);
					$this->SetFillColor(230);
					$this->Cell(30,5,utf8_decode($rowANT1[2]),'',0,'L',1);
					$this->SetFillColor(255);
					$this->SetDrawColor(143);
					$this->Cell(16,5,utf8_decode($rowANT[$rowANT1[3]-1]),'BRTL',0,'R',1);
					$this->Cell(4,5,"",'L',0,'C',1);
					$this->SetDrawColor(90);
					if(fmod($kontcols,4)==0) {
						$this->Ln();
					}

				break;
				default:
					$lstcontrol="multicell";
					if($kontcols!=0) {
						$kontcols=0;
						$this->Ln();
					}
					$this->NewItem("B", $rowANT1[2]);
					$this->Ln();
					$TxtAnt=$rowANT[$rowANT1[3]-1];
					if($TxtAnt=="") {
						$TxtAnt=" NIEGA";
					}
					$this->SetFont('Arial','',8);
					$this->MultiCell(0,5,utf8_decode($TxtAnt),'RT','L',1);
				break;
			}
			}
			mysqli_free_result($resultANT);
			}
		mysqli_free_result($resultANT);
		$this->SetFont('Courier','B',7);
		if($lstcontrol!="multicell") {
			$this->Ln();
		}
		$this->SetFillColor(250);
		$this->Cell(56,3,str_repeat ('-', 20),'',0,'R',1);
		$this->Cell(84,3,str_repeat ('-', 55),'',0,'C',1);
		$this->Cell(56,3,str_repeat ('-', 20),'',0,'L',1);
		$this->SetFont('Arial','',8);
		$this->SetFillColor(255);
		$this->Ln();
		}
	mysqli_free_result($resulttbl);
}
}
$FormatoPagina="Letter";
$Orientation="P";
$NombreEmpresa="";
$SQL="SELECT page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='hc'";
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
$pdf->Settitle('HISTORIA CLINICA');
$pdf->SetCreator('@Skanner79');
//Se construyen los márgenes y saltos de página
$pdf->SetMargins(10, 10,10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();
//Encabezado de la tabla
$UnFolio=0;
$SQL="SELECT * from hcencabezadosdet where codigo_hch='1'";
if ($_GET["FOLIO_FINAL"]==$_GET["FOLIO_INICIAL"]) {
	$UnFolio=1;
	$SQL="SELECT a.* from hcencabezadosdet a, hctipos b, hcfolios c where a.codigo_hch=b.codigo_hch and b.codigo_hct=c.codigo_hct";
}
$result1 = mysqli_query($conexion, $SQL);
if ($row1 = mysqli_fetch_row($result1)) {
	if ($row1["Logo2_HCH"]!="") {
		$pdf->Image('../../files/images/logos/'.$_SESSION["DB_SUFFIX"].'/'.$row1["Logo2_HCH"].'.jpg',4,2,0);
	}
	if ($row1["Paciente_HCH"]=="1") {
		$pdf->Cell(30,5,'Nombre Completo','BL',0,'L',0);
		$pdf->Cell(80,5,$row0["1"],'BL',0,'L',0);
	}
}
//echo $SQL;
mysqli_free_result($result1);

//Datos del folio
if (isset($_GET["FORMATO"])) {
	if ($_GET["FORMATO"]=='*') {
		$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, Incapacidad_HCT, RiesgoEspecif_HCT, AntGineObs_HCT, EmbarazoAct_HCT, RiesgoObst_HCT, CtrlParacObs_HCT, CtrlPreNat_HCT, RiesgoCardV_HCT, Framingham_HCT, Ordenes_HCT, Qx_HCT, Insumos_HCT, Odontograma_HCT from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and c.Folio_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by 4, 5";
	} else {
		$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, Incapacidad_HCT, RiesgoEspecif_HCT, AntGineObs_HCT, EmbarazoAct_HCT, RiesgoObst_HCT, CtrlParacObs_HCT, CtrlPreNat_HCT, RiesgoCardV_HCT, Framingham_HCT, Ordenes_HCT, Qx_HCT, Insumos_HCT, Odontograma_HCT from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and c.Folio_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and b.Codigo_HCT='".$_GET["FORMATO"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by 4, 5";
	}
} else {
	$SQL="Select b.Nombre_HCT, c.Codigo_HCF, c.Codigo_ADM, a.Fecha_ADM, c.Fecha_HCF, c.Hora_HCF, d.Nombre_ARE, b.SV_HCT, b.Antecedentes_HCT, b.Dx_HCT, b.AyudasDiag_HCT, b.Med_HCT, b.Indicaciones_HCT, b.Img_HCT, c.Nota_HCF, c.FecNota_HCF, f.Nombre_TER, e.RM_MED, e.Firma_MED, c.Medico2_HCF, b.Codigo_HCT, e.Codigo_TER, a.Codigo_TER, Folio_HCF, Incapacidad_HCT, RiesgoEspecif_HCT, AntGineObs_HCT, EmbarazoAct_HCT, RiesgoObst_HCT, CtrlParacObs_HCT, CtrlPreNat_HCT, RiesgoCardV_HCT, Framingham_HCT, Ordenes_HCT, Qx_HCT, Insumos_HCT, Odontograma_HCT from hctipos b, hcfolios c, gxadmision a, gxareas d, gxmedicos e, czterceros f, czterceros g where f.Codigo_TER=e.Codigo_TER and e.Codigo_USR=c.Codigo_USR and d.Codigo_ARE=c.Codigo_ARE and a.Codigo_ADM=c.Codigo_ADM and b.codigo_hct=c.codigo_hct and c.Folio_HCF between '".$_GET["FOLIO_INICIAL"]."' and '".$_GET["FOLIO_FINAL"]."' and c.Codigo_TER=g.Codigo_TER and g.ID_TER='".$_GET["HISTORIA"]."' order by 4, 5";
}
error_log($SQL);
$resultx = mysqli_query($conexion, $SQL);
$kntfolix=0;
while ($rowx = mysqli_fetch_row($resultx)) {
	$kntfolix++;
	if ($kntfolix==1) {
		$pdf->SetY(19);
		$pdf->encabezadoz('',$rowx[1]);
	}
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFillColor(220);
	$pdf->SetFont('Arial','BI',10);
	if ($UnFolio==0) {
		if ($rowx[0]=="REGISTRO DE ENFERMERIA") {
			$SQL="Select dispositivo_HC, curacion_HC from hc_ENFERMERIA a, czterceros b Where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["HISTORIA"]."' and Codigo_HCF='".$rowx[1]."';";
			$resultEnf = mysqli_query($conexion, $SQL);
			if ($rowEnf = mysqli_fetch_row($resultEnf)) {
				if ($rowEnf[0]!="") {
					$pdf->Cell(150,5,'REGISTRO DE ENFERMERIA'/*'CAMBIO DE DISPOSITIVOS MEDICOS'*/,'TL',0,'L',1);
				} else {
					if ($rowEnf[1]!=0) {
						$pdf->Cell(150,5,'CURACIONES','TL',0,'L',1);
					} else {
						$pdf->Cell(150,5,$rowH[5],'TL',0,'L',1);
					}
				}
			}
			mysqli_free_result($resultEnf);
		} else {
			$pdf->Cell(150,5,$rowx[0],'TL',0,'L',1);
		}
		
	} else {
		$pdf->Cell(150,5,"",'TL',0,'L',1);
	}
	$pdf->SetFont('Courier','B',10);
	$pdf->Cell(0,5,"FOLIO: ".$rowx[23],'TR',0,'R',1);
	$pdf->SetFillColor(255);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$InfoADM="";
	$SQL="Select ShowFechaADM_XHC from itconfig_hc";
	$resultADM = mysqli_query($conexion, $SQL);
	if ($rowADM = mysqli_fetch_row($resultADM)) {
		if ($rowADM[0]=="1") {
		$InfoADM=" - Fecha Ingreso: ".$rowx[3];
		}
	}
	mysqli_free_result($resultADM);
	$pdf->Cell(0,5,utf8_decode("Admisión: ".$rowx[2].$InfoADM),'B',0,'R',1);
	$pdf->Ln();
	$pdf->SetFont('Courier','B',9);
	$pdf->Cell(80,5,"Area: ".$rowx[6],'T',0,'L',1);
	$pdf->Cell(70,5,"Fecha: ".$rowx[4],'T',0,'L',1);
	$InfoTME="";
	$SQL="Select ShowHoraHCF_XHC from itconfig_hc";
	$resultADM = mysqli_query($conexion, $SQL);
	if ($rowADM = mysqli_fetch_row($resultADM)) {
		if ($rowADM[0]=="1") {
		$InfoTME="Hora: ".$rowx[5];
		}
	}
	mysqli_free_result($resultADM);
	$pdf->Cell(0,5,$InfoTME,'T',0,'R',1);
	$pdf->Cell(0,3,"",'',0,'R',1);
	$pdf->Ln();
	$pdf->Ln();
	// ANTECEDENTES
	$SQL="Select count(*) From hcantecedentes a, hctipoantecedentes b, czterceros c Where a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$_GET["HISTORIA"]."'";
	$resultANT = mysqli_query($conexion, $SQL);
	if ($rowANT = mysqli_fetch_row($resultANT)) {
		if ($rowANT[0]!=0) {
			$pdf->Ln();
			$pdf->NewItem("B", "Antecedentes");
			$pdf->Cell(0,5,"",'B',0,'L',1);
			$pdf->Ln();
			$SQL="Select b.Nombre_HCA, a.Descripcion_HCA From hcantecedentes a, hctipoantecedentes b, czterceros c Where a.Codigo_HCA=b.Codigo_HCA and a.Codigo_TER=c.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and c.ID_TER='".$_GET["HISTORIA"]."'";
			$resultANT1 = mysqli_query($conexion, $SQL);
			while ($rowANT1 = mysqli_fetch_row($resultANT1)) {
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(0,5,utf8_decode($rowANT1[0]),'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Ln();
				$pdf->MultiCell(0,4,utf8_decode($rowANT1[1]),0,'J',1);
			}
			mysqli_free_result($resultANT1);
			$pdf->Cell(0,2,"",'',0,'R',1);
			$pdf->Ln();
		}
	}
	mysqli_free_result($resultANT);
	if($rowx[8]=="1") {
		// NUEVOS ANTECEDENTES
		$pdf->Ln();
		$pdf->Antexedentes('hcant_personales', $rowx[1], 'Antecedentes Personales');
		$pdf->Antexedentes('hcant_toxicologico', $rowx[1], 'Antecedentes Toxicológicos');
		$pdf->Antexedentes('hcant_alergico', $rowx[1], 'Antecedentes Alérgicos');
		$pdf->Antexedentes('hcant_familiar', $rowx[1], 'Antecedentes Familiares');
		$pdf->Antexedentes('hcant_ginecobst', $rowx[1], 'Antecedentes Gineco-Obstétricos');
	}
	// SIGNOS VITALES	
	if ($rowx[7]!="0") {
		$SQL="Select c.Sigla_HSV, a.Valor_HSV, c.Codigo_HSV, c.Prefijo_HSV, c.Sufijo_HSV From hcsignosvitales a, czterceros b, hcsv2 c Where a.Codigo_TER=b.Codigo_TER and c.Codigo_HSV=a.Codigo_HSV and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 3";
		$resultx2 = mysqli_query($conexion, $SQL);
		$pdf->NewItem("B", "Signos Vitales");
		$pdf->SetFillColor(225);
		$kountSV=0;
		$pdf->Ln();
		$pdf->Cell(0,1,'','',0,'L',0);
		$pdf->Ln();
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			$kountSV++;
			if ($kountSV%6==0){
				$pdf->Ln();
				$pdf->Cell(0,1,'','',0,'L',0);
				$pdf->Ln();
			}
			$pdf->Cell(2,4,'','',0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(17,4,utf8_decode($rowx2[0]),'',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,utf8_decode($rowx2[3].' '.$rowx2[1].' '.$rowx2[4]),'',0,'L',1);
		}
		mysqli_free_result($resultx2);
		$pdf->SetFillColor(255);
		$pdf->Cell(0,5,'','',0,'L',1);
		$pdf->Ln();
		$pdf->Cell(0,2,"",'',0,'R',1);
		$pdf->Ln();	
	}
	// DIAGNOSTICOS
	if ($rowx[9]!="0") {
		$SQL="Select c.Codigo_DGN, c.Descripcion_DGN, a.Tipo_DGN, g.Nombre_TDG, d.Codigo_DGN, d.Descripcion_DGN, e.Codigo_DGN, e.Descripcion_DGN, f.Codigo_DGN, f.Descripcion_DGN, a.Manejo_DGN From gxtipodiag g, czterceros b, gxdiagnostico c, hcdiagnosticos a left join gxdiagnostico d on a.CodigoR_DGN=d.Codigo_DGN left join gxdiagnostico e on a.CodigoR2_DGN=e.Codigo_DGN left join gxdiagnostico f on a.CodigoR3_DGN=f.Codigo_DGN Where a.Codigo_TER=b.Codigo_TER and g.Codigo_TDG=a.Tipo_DGN and c.Codigo_DGN=a.Codigo_DGN and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."'";
		$resultx2 = mysqli_query($conexion, $SQL);
		$pdf->NewItem("B", "Diagnóstico");
		$pdf->Ln();
		if ($rowx2 = mysqli_fetch_row($resultx2)) {
			$pdf->Cell(2,4,'','T',0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,4,"Principal",'T',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[0].' - '.$rowx2[1]),'T',0,'L',1);
			$pdf->Ln();
			$pdf->Cell(2,4,'','',0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,4,"Tipo Dx.",'',0,'L',1);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[2].' - '.$rowx2[3]),'',0,'L',1);
			$pdf->Ln();
			if ($rowx2[4]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[4].' - '.$rowx2[5]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[6]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado 2",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[6].' - '.$rowx2[7]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[8]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,4,"Relacionado 3",'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(0,4,utf8_decode($rowx2[8].' - '.$rowx2[9]),'',0,'L',1);
				$pdf->Ln();
			}
			if ($rowx2[10]!="") {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(32,4,utf8_decode("Diagnóstico de Manejo"),'',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->MultiCell(0,4,utf8_decode($rowx2[10]),'','L',1);
				$pdf->Ln();
			}
		}
		mysqli_free_result($resultx2);
		$pdf->Cell(0,3,"",'',0,'R',1);
		$pdf->Ln();
	}
	// campos del formato de la hc
	$Posx=10;
	$Posy=$pdf->GetY();
	$Posyfin=$Posy;
	$TamW=196;
	$pdf->SetX($Posx);
	$SQL="Select a.* From hc_". $rowx[20]." a, czterceros b Where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."';";
	$resultx2 = mysqli_query($conexion, $SQL);
	$DatosHC = mysqli_fetch_array($resultx2);
	mysqli_free_result($resultx2);
	$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='0' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
	$resultx2 = mysqli_query($conexion, $SQL);
	$Indice=2;
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		//if ($DatosHC[$Indice]!="") {
			//CURACIONES
			if ($rowx2[0]=="curacion") {
				if ($DatosHC[$Indice]!="0") {
					$SQL= "Select Nombre_HTC from hctipocuraciones Where Codigo_HTC='".$DatosHC[$Indice]."'";
					$resultxC = mysqli_query($conexion, $SQL);
					if ($rowxC = mysqli_fetch_row($resultxC)) {
						$pdf->SetFont('Arial','B',9);
						$pdf->SetFillColor(230);
						$pdf->Cell(0,6,utf8_decode("Curación ".$rowxC[0]),'TB',0,'R',1);
						$pdf->SetFillColor(255);
						$pdf->SetFont('Arial','',8);
						$pdf->Ln();
					}
					mysqli_free_result($resultxC);
				}
				$Indice=$Indice+1;
			} else {
				//SI NO SON CURACIONES
				if ($rowx2[3]!="well") {

					if ($rowx2[3]=="check") {
						$Posx=$pdf->GetX();
						if ($Posx>= ($TamW-5)) {
							$pdf->Ln();
							$pdf->Cell(0,1,'','',0,'L',0);
							$pdf->Ln();
						}
						if ($Posx== 0) {
							$pdf->Ln();
						}
						$pdf->SetFont('Arial','',8);
						$pdf->SetFillColor(222);
						$pdf->Cell(1,5,'','',0,'L',0);
						$pdf->Cell(($TamW*$rowx2[4]/12)-6,5,utf8_decode($rowx2[2]),'LBT',0,'L',1);		
						$pdf->SetFillColor(255);
						//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
						$pdf->SetFont('Courier','B',7);
					} else {
						if ($rowx2[3]=="select") {
							$Posy=$pdf->GetY();
							$pdf->NewItem('',$rowx2[2]);
							$Posy2=$pdf->GetY();
							$pdf->SetFont('Arial','',8);
							
						} else {
							if ($rowx2[3]=="label") {
								$pdf->SetFont('Arial','I',8);
								$pdf->MultiCell(0,4,utf8_decode($rowx2[2]),'','L',1);
								$pdf->SetFillColor(255);
								//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
								$pdf->SetFont('Arial','',8);
								
							} else {
								$pdf->NewItem("B", $rowx2[2]);
								$pdf->SetFont('Arial','',8);
								$pdf->Ln();
							}
						}
					}
				}
				switch ($rowx2[3]) {
					case 'label':
				 		$pdf->Ln();
				 		break;
					case 'select':
						if ($Posy<255) {
					 		$pdf->SetY($Posy);
					 	} else {
					 		$pdf->SetY(33);
					 	}
				 		$pdf->SetX(120);
						$pdf->SetFont('Arial','B',8);
				 		$pdf->Cell(0,5,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
				 		$pdf->SetFont('Arial','',8);
				 		$pdf->Ln();
				 		if ($Posy2<252) {
					 		$pdf->SetY($Posy2);
					 	}
				 		$Indice=$Indice+1;
				 		break;
				 	case 'well':
				 	case 'collapse':
				 		$pdf->SetFont('Courier','B',7);
				 		$pdf->Ln();
				 		$pdf->SetFillColor(250);
				 		$pdf->Cell(56,3,str_repeat ('-', 20),'',0,'R',1);
						$pdf->Cell(84,3,utf8_decode($rowx2[2]),'RBLT',0,'C',1);
						$pdf->Cell(56,3,str_repeat ('-', 20),'',0,'L',1);
						$pdf->SetFont('Arial','',8);
						$pdf->SetFillColor(255);
						$pdf->Ln();
						$SQL="Select a.Codigo_HCC, a.Orden_HCC, a.Etiqueta_HCC, a.Tipo_HCC, a.Largo_HCC, a.Codigo_HCT from hccampos a, hcfolios b, czterceros c where a.Codigo_HCT=b.Codigo_HCT and Grupo_HCC='".$rowx2[1]."' and b.Codigo_TER=c.Codigo_TER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' Order By Orden_HCC;";
						$resultx3 = mysqli_query($conexion, $SQL);
						while ($rowx3 = mysqli_fetch_row($resultx3)) {
							if ($DatosHC[$Indice]!="") {
								if ($rowx3[3]=="check") {
									$Posx=$pdf->GetX();
									if ($Posx>= ($TamW-5)) {
										$pdf->Ln();
										$pdf->Cell(0,1,'','',0,'L',0);
										$pdf->Ln();
									}
									if ($Posx== 0) {
										$pdf->Ln();
									}
									$pdf->SetFont('Arial','',8);
									$pdf->SetFillColor(222);
									$pdf->Cell(1,5,'','',0,'L',0);
									$pdf->Cell(($TamW*$rowx3[4]/12)-6,5,utf8_decode($rowx3[2]),'LBT',0,'L',1);			
									$pdf->SetFillColor(255);
									//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
									$pdf->SetFont('Courier','B',8);
								} else {
									if ($rowx3[3]=="select") {
										$Posy=$pdf->GetY();
										$pdf->NewItem('',$rowx3[2]);
										$pdf->SetFont('Arial','',8);
										$Posy2=$pdf->GetY();
									} else {
										if ($rowx3[3]=="label") {
											$pdf->SetFont('Arial','I',8);
											$html=utf8_decode($rowx3[2]);
											$pdf->WriteHTML($html);
											//$pdf->MultiCell(0,4,utf8_decode(),'','L',1);
											$pdf->SetFillColor(255);				
											$pdf->SetFont('Arial','',8);
										} else {
											$pdf->NewItem("B", $rowx3[2]);
											$pdf->SetFont('Arial','',8);
											$pdf->Ln();
										}
									}
								}
								switch ($rowx3[3]) {
								 	case 'label':
								 		$pdf->Ln();
								 		break;
								 	case 'textarea':
								 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
								 		break;
								 	case 'select':
								 		if ($Posy<255) {
									 		$pdf->SetY($Posy);
									 	} else {
									 		$pdf->SetY(33);
									 	}
								 		$pdf->SetX(120);
								 		$pdf->SetFont('Arial','B',8);
								 		$pdf->Cell(0,5,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
								 		$pdf->SetFont('Arial','',8);
								 		$pdf->Ln();
								 		if ($Posy2<252) {
									 		$pdf->SetY($Posy2);
									 	}
								 		break;
								 	case 'image':
								 		$pdf->Cell($TamW*$rowx3[4]/12,40,' ','TBLR',0,'C',1);
								 		/*
								 		$Posy=$pdf->GetY();
								 		$pdf->Image('../../files/_all/images/firmas/white.jpg',20,$Posy,$TamW*$rowx3[4]/12);
								 		*/
								 		$pdf->Ln();
								 		break;
								 	case 'check':
								 		$chekea="";
								 		if ($DatosHC[$Indice]=="1") {
								 			$chekea="X";
								 		}
								 		$pdf->Cell(5,5,utf8_decode($chekea),'TRB',0,'C',1);
								 		break;
								 	default:
								 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
								 		break;
								}
							}
							if($rowx3[3]!="label") {
								$Indice=$Indice+1;
							}
						}
						//$pdf->SetY($Posyfin-5);
						$pdf->Ln();
						$pdf->SetFont('Courier','B',7);
						$pdf->SetFillColor(250);
						$pdf->Cell(0,2,str_repeat ('-', 86),'',0,'C',0);
						$pdf->SetFillColor(255);
						$pdf->Ln();
						mysqli_free_result($resultx3);				
						break;
				 	case 'textarea':
				 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
				 		$Indice=$Indice+1;
				 		break;
				 	case 'check':
				 		$chekea="";
				 		if ($DatosHC[$Indice]=="1") {
				 			$chekea="X";
				 		}
				 		$pdf->Cell(5,5,utf8_decode($chekea),'TRLB',0,'C',1);
				 		$Indice=$Indice+1;
				 		break;
				 	default:
				 		$pdf->MultiCell($TamW,4,utf8_decode($DatosHC[$Indice]),'T','L',1);
				 		//$pdf->Cell($TamW,4,utf8_decode($DatosHC[$Indice]),'',0,'L',1);
				 		$Indice=$Indice+1;
				 		break;
				}
			}
		/*}
		else {
			if ($rowx2[3]=='image') {
				$pdf->SetFont('Arial','B',8);
				$pdf->SetFillColor(180);
				$pdf->Cell(2,5,"",'LTR',0,'L',1);			
				$pdf->Cell(32,5,utf8_decode($rowx2[2]),'TR',0,'L',0);
				$pdf->SetFillColor(255);
				//$pdf->Cell($TamW,4,utf8_decode($rowx2[2]),'B',0,'L',1);
				$pdf->SetFont('Arial','',8);
				$pdf->Ln();
			}
		}*/
		
	}
	mysqli_free_result($resultx2);
	$pdf->Cell(0,3,"",'',0,'L',1);
	$pdf->Ln();		
	// PLUGINS
	if ($rowx[25]!="0") {
	// Identificación de Riesgos Especificos
	$pdf->Antexedentes('hcidriesgoesp', $rowx[1], 'Identificación de Riesgos Especificos');
	}
	if ($rowx[31]!="0") {
	// Factores de Riesgo Cardiovascular
	$pdf->Antexedentes('hcriegocv', $rowx[1], 'Factores de Riesgo Cardiovascular');
	// Clasificación TFG
	$pdf->Antexedentes('hctfg', $rowx[1], 'Clasificación TFG');
	}
	if ($rowx[32]!="0") {
	// Test Framingham
	$pdf->Antexedentes('hcframingham', $rowx[1], 'Test Framingham');
	}
	if ($rowx[27]!="0") {
	// Embarazo Actual
	$pdf->Antexedentes('hcembactual', $rowx[1], 'Embarazo Actual');
 	}
 	if ($rowx[28]!="0") {
	// Calificación del Riesgo Obstétrico
	$pdf->Antexedentes('hcriegoobs', $rowx[1], 'Calificación del Riesgo Obstétrico');
	}
	if ($rowx[29]!="0") {
	// Control Paraclinicos 
	// $pdf->Antexedentes('hcctrlparaobs', $rowx[1], 'Control Paraclínicos ');
	}
	if ($rowx[30]!="0") {
	// Control Pre Natal
	$pdf->Antexedentes('hcctrlprentl', $rowx[1], 'Control Pre Natal');
	}
	
	// EXAMENES LABORATORIOS
	if ($rowx[31]!="0") {
		$SQL="SELECT distinct b.Codigo_SER, d.Nombre_SER, Codigo_PQT, Orden_PQT FROM hcpqservicios a, hclabsrcv b, gxservicios d, czterceros e WHERE a.Codigo_SER=b.Codigo_SER AND d.Codigo_SER=b.Codigo_SER AND b.Codigo_TER=e.Codigo_TER and e.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' and Codigo_PQT in ('Laboratorios RCV 1', 'Laboratorios RCV 2') ORDER BY 3,4 ";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumLab=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumLab==0) {
				$pdf->NewItem("B", "Laboratorios");
				$pdf->Ln();
				$pdf->Ln();
			}
			$NumLab=$NumLab+1;
			$SQL="SELECT b.Codigo_SER, date(b.Fecha_LAB), b.Valor_LAB FROM hclabsrcv b, czterceros e WHERE b.Codigo_TER=e.Codigo_TER and e.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_SER='".$rowx2[0]."' and b.Codigo_HCF='".$rowx[1]."' ORDER BY 1,2 ";

			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(60,6,utf8_decode($rowx2[1]),'BRL',0,'L',1);
			$resultxlb = mysqli_query($conexion, $SQL);
			while ($rowxlb = mysqli_fetch_row($resultxlb)) {
				$pdf->SetFont('Courier','',7);
				$pdf->Cell(40,6,utf8_decode($rowxlb[1].' | '.$rowxlb[2]),'B',0,'L',1);
			}
			$pdf->Ln();
			mysqli_free_result($resultxlb);
		}
		$pdf->Ln();
		mysqli_free_result($resultx2);
	}

	// INDICACIONES Y TRATAMIENTO	
	if ($rowx[12]!="0") {
		$SQL="Select a.Indicacion_HTT, a.Codigo_HTT From hctratamiento a, czterceros b where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				$pdf->NewItem("B", "Tratamiento");
				$pdf->Ln();
			}
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			if ($NumIndi=="1") {
				$pdf->Cell(2,4,'','T',0,'L',1);
				$pdf->MultiCell(0,4,utf8_decode($NumIndi.'- '.$rowx2[0]),'T','L',1);
			} else {
				$pdf->Cell(2,4,'','',0,'L',1);
				$pdf->MultiCell(0,4,utf8_decode($NumIndi.'- '.$rowx2[0]),'','L',1);
			}
		}
		mysqli_free_result($resultx2);

		$SQL="Select a.Analisis_HCA From hcanalisis a, czterceros b where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' ";
		$resultx2a = mysqli_query($conexion, $SQL);
		if ($rowx2a = mysqli_fetch_row($resultx2a)) {
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(2,4,'','',0,'L',1);
			$pdf->Cell(60,4,utf8_decode('Análisis e Indicaciones'),'B',0,'L',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(2,4,'','',0,'L',1);
			$pdf->MultiCell(0,4,utf8_decode($rowx2a[0]),'','L',1);
		}
		mysqli_free_result($resultx2a);		
		/*
		$pdf->Cell(0,5,'','T',0,'L',1);
		$pdf->Ln();
		*/
		$pdf->Cell(0,1,"",'',0,'R',1);
		$pdf->Ln();	
	}
	// NOTAS ACLARATORIAS DEL FOLIO
	$SQL="Select Fecha_HCN, Nota_HCN From hcnotas  Where Codigo_TER='".$rowx[22]."' and Codigo_HCF='".$rowx[1]."' Order By Fecha_HCN;";
	$resultx2 = mysqli_query($conexion, $SQL);
	while ($rowx2 = mysqli_fetch_row($resultx2)) {
		$pdf->SetFillColor(180);
		$pdf->SetFont('Courier','B',9);
		$pdf->Cell(70,5,"* NOTA ACLARATORIA",'TBL',0,'L',1);
		$pdf->Cell(0,5,"FECHA: ".$rowx2[0],'TBR',0,'R',1);
		$pdf->Ln();
		$pdf->SetFillColor(255);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(0,4,utf8_decode($rowx2[1]),'RLB','L',1);
		$pdf->Ln();	
	}
	mysqli_free_result($resultx2);

	// FIRMA PROFESIONAL
	$pdf->Ln();	
	$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());

	// ODONTOGRAMA
	if ($rowx[36]!="0") {
		if ($UnFolio==1) {
			$pdf->AddPage();
			$pdf->encabezadoz('ODONTOGRAMA', $rowx[1]);
			$pdf->SetFillColor(180);
		} else {
			$pdf->NewItem("B", "Odontograma");
			$pdf->Cell(0,5,'','B',0,'L',0);
			$pdf->Ln();
		}
		$pdf->Image('http://cdn.genomax.co/media/image/odontog/0.png',10,75,200);
		$pdf->Ln();	
		$pdf->loadOdonto($_GET["HISTORIA"], $rowx[1], 'ghenx');
	// FIRMA PROFESIONAL
		$PosYFirma=230;
		$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $PosYFirma);
	}

	// ORDENES DE MEDICAMENTOS
	if ($rowx[11]!="0") {
		$SQL="Select c.CUM_MED, c.Nombre_MED, Dosis_HCM, Descripcion_VIA, Descripcion_FRC, Duracion_HCM, Estado_HCM, Observaciones_HCM, Cantidad_HCM From hcordenesmedica a, czterceros b, gxmedicamentos c, gxviasmed d, gxfrecuenciamed e where e.Codigo_FRC=Frecuencia_HCM and d.Codigo_VIA=Via_HCM and a.Codigo_TER=b.Codigo_TER and c.Codigo_SER=a.Codigo_SER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' and Estado_HCM='O' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDEN DE MEDICAMENTOS', $rowx[1]);
					$pdf->SetFillColor(180);
				} else {
					$pdf->NewItem("B", "Orden Medicamentos");
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->Ln();
				}
				/*
				$pdf->SetFont('Courier','B',8);
				$pdf->Cell(2,4,' ','',0,'L',0);
				$pdf->Cell(18,4,'DOSIS','TL',0,'C',0);
				$pdf->Cell(20,4,'VIA','TL',0,'C',0);
				$pdf->Cell(22,4,'FRECUENCIA','TL',0,'C',0);
				$pdf->Cell(25,4,'DURACION','TL',0,'C',0);
				*/
				$pdf->Cell(0,3,'','',0,'C',0);
				$pdf->Ln();
				$pdf->SetFillColor(255);
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(43,4,'Medicamento: '.utf8_decode($rowx2[0]),'TL',0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,4,utf8_decode($rowx2[1]),'TR','L',0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(150,4,utf8_decode('Dosis: '.$rowx2[2].' vía '.$rowx2[3].' cada '.$rowx2[4].' durante '.$rowx2[5]),'L',0,'L',0);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(0,4,utf8_decode('Cantidad: '.$rowx2[8]),'R',0,'R',0);
			$pdf->Ln();
			$pdf->SetFont('Times','I',8);
			$pdf->MultiCell(0,4,utf8_decode('Nota: '.$rowx2[7]),'LBR','L',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// INSUMOS
	if ($rowx[35]!="0") {
		$SQL="Select c.Nombre_MED, Cantidad_SER From hcordenesins a, czterceros b, gxmedicamentos c Where a.Codigo_TER=b.Codigo_TER and c.Codigo_SER=a.Codigo_SER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDEN DE INSUMOS', $rowx[1]);
					$pdf->SetFillColor(180);
				} else {
					$pdf->NewItem("B", "Orden Insumos");
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->Ln();
				}
				$pdf->Cell(0,3,'','',0,'C',0);
				$pdf->Ln();
				$pdf->SetFillColor(170);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(170,5,'PRODUCTO ','',0,'C',1);
				$pdf->Cell(0,5,'CANTIDAD','',0,'C',1);
				$pdf->SetFillColor(255);
				$pdf->Ln();
				
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(170,4,utf8_decode($rowx2[0]),'B',0,'L',0);
			$pdf->Cell(0,4,utf8_decode($rowx2[1]),'B',0,'R',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}
	}

	// INCAPACIDAD
	if ($rowx[24]!="0") {
		$SQL="Select f.Codigo_DGN, g.Descripcion_DGN, date(Fecha_INC), Nombre_HCI, Nombre_HMI, Nombre_HTI, FechaIni_HCI, FechaFin_HCI, Dias_HCI, Observaciones_INC  From hcincapacidades a, czterceros b, hctipoincapacidad c, hcmotivoincapacidad d, hcclaseincapacidad e, hcdiagnosticos f, gxdiagnostico g where a.Codigo_TER=f.Codigo_TER and a.Codigo_HCF=f.Codigo_HCF and f.Codigo_DGN=g.Codigo_DGN and a.Codigo_TER=b.Codigo_TER and c.Codigo_HTI=a.Codigo_HTI and d.Codigo_HMI=a.Codigo_HMI and e.Codigo_HCI=a.Codigo_HCI and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."'";
		$resultx2 = mysqli_query($conexion, $SQL);
		if ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($UnFolio==1) {
				$pdf->AddPage();
				$pdf->encabezadoz('INCAPACIDAD MEDICA', $rowx[1]);
				$pdf->SetFillColor(180);
			} else {
				$pdf->NewItem("B", "Incapacidad Médica");
				$pdf->Cell(0,5,'','B',0,'L',0);
				$pdf->Ln();
			}
			$pdf->Cell(0,3,'','',0,'C',0);
			$pdf->Ln();
			$pdf->SetFillColor(255);
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(33,5,utf8_decode('Diágnóstico: '.$rowx2[0]),'TL',0,'L',0);
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(0,5,utf8_decode($rowx2[1]),'TR','L',0);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(48,5,utf8_decode('Fecha: '.$rowx2[2]),'LTR',0,'L',0);
			$pdf->Cell(48,5,utf8_decode('Clase de Incapacidad: '.$rowx2[3]),'TR',0,'L',0);
			$pdf->Cell(48,5,utf8_decode('Motivo: '.$rowx2[4]),'RT',0,'L',0);
			$pdf->Cell(0,5,utf8_decode('Tipo: '.$rowx2[5]),'RT',0,'L',0);
			$pdf->Ln();
			$pdf->SetFont('Courier','',10);
			$pdf->Cell(45,6,utf8_decode('Periodo Incapacidad'),'LBT',0,'L',0);
			$pdf->SetFont('Courier','B',10);
			$pdf->Cell(20,6,utf8_decode($rowx2[8].' Días'),'BT',0,'L',0);
			$pdf->SetFont('Courier','',10);
			$pdf->Cell(40,6,utf8_decode('Desde el '),'BT',0,'R',0);
			$pdf->SetFont('Courier','B',10);
			$pdf->Cell(25,6,utf8_decode($rowx2[6]),'BT',0,'L',0);
			$pdf->SetFont('Courier','',10);
			$pdf->Cell(40,6,utf8_decode('Hasta el '),'BT',0,'R',0);
			$pdf->SetFont('Courier','B',10);
			$pdf->Cell(0,6,utf8_decode($rowx2[7]),'BRT',0,'L',0);
			$pdf->Ln();
			$pdf->SetFont('Times','I',9);
			$pdf->MultiCell(0,5,utf8_decode('Observaciones: '.$rowx2[9]),'LBR','L',0);
			$pdf->Ln();
			
		// FIRMA PROFESIONAL
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	
	}

	// ORDENES MEDICAS Dx
	if ($rowx[10]!="0") {
		$SQL="Select a.Nombre_CUP, d.CUPS_PRC, d.Nombre_PRC, b.Cantidad_HCS, b.Observaciones_HCS, Tercerizar_PRC From gxgruposcups a, hcordenesdx b, czterceros c, gxprocedimientos d Where left(d.CUPS_PRC,2)=a.Codigo_CUP and a.Tipo_CUP='G' and b.Codigo_TER=c.Codigo_TER and d.Codigo_SER=b.Codigo_SER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' order by 1,6,2";
		$resultx2 = mysqli_query($conexion, $SQL);
		$NombreCUP="";
		$TercerizarPRC="";
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$TercerizarPRC=$rowx2[5];
					$NombreCUP=$rowx2[0];
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES DIAGNOSTICAS', $rowx[1]);
					$pdf->SetFont('Arial','B',10);
					$pdf->SetFillColor(180);
					$pdf->Cell(0,2,'','',0,'L',0);
					$pdf->Ln();
					$pdf->Cell(0,4,utf8_decode($NombreCUP),'TLBR',0,'C',1);
					$pdf->Ln();
					
				} else {
					$pdf->NewItem("B", "Orden Paraclínicos");
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->Ln();
					
					$pdf->SetFont('Arial','B',8);
				}
			}
			if ($NombreCUP!=$rowx2[0]) {
				$NombreCUP=$rowx2[0];
				$TercerizarPRC=$rowx2[5];
				if ($UnFolio==1) {
					if ($NumIndi!=0) {
						$pdf->Ln();	
						$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
					}
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES DIAGNOSTICAS', $rowx[1]);
					$pdf->SetFont('Arial','B',10);
					$pdf->SetFillColor(180);
				}
				$pdf->Cell(0,2,'','',0,'L',0);
				$pdf->Ln();
				$pdf->Cell(0,4,utf8_decode($NombreCUP),'TLBR',0,'C',1);
				$pdf->Ln();
			}else {
				if ($TercerizarPRC!=$rowx2[5]) {
				/* if ($NombreCUP!="LABORATORIO CLÍNICO") { */
					if ($UnFolio==1) {
						if ($NumIndi!=0) {
							$pdf->Ln();	
							$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
						}
						$pdf->AddPage();
						$pdf->encabezadoz('ORDENES DIAGNOSTICAS', $rowx[1]);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetFillColor(180);
					}
					$pdf->Cell(0,2,'','',0,'L',0);
					$pdf->Ln();
					$pdf->Cell(0,4,utf8_decode($NombreCUP),'TLBR',0,'C',1);
					$pdf->Ln();
				}
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			/*$pdf->Cell(2,4,' ','',0,'L',0);*/
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25,4,'EXAMEN: ','TL',0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,4,utf8_decode($rowx2[2]),'TR','L',0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(150,4,utf8_decode('CUPS: '.$rowx2[1]),'L',0,'L',0);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(0,4,utf8_decode('Cantidad: '.$rowx2[3]),'R',0,'R',0);
			if ($rowx2[4]!="") {
				$pdf->Ln();
				$pdf->SetFont('Times','I',8);
				$pdf->MultiCell(0,4,utf8_decode('Observaciones: '.$rowx2[4]),'LBR','L',0);
			} else {
				$pdf->Ln();
				$pdf->Cell(0,1,'','LBR','C',0);		
			}
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// ORDENES PROCEDIMIENTOS
	if ($rowx[34]!="0") {
		$SQL="Select left(d.CUPS_PRC,1), d.CUPS_PRC, d.Nombre_PRC, b.Cantidad_HCS, b.Observaciones_HCS From gxservicios a, hcordenesqx b, czterceros c, gxprocedimientos d Where a.Codigo_SER=b.Codigo_SER and b.Codigo_TER=c.Codigo_TER and d.Codigo_SER=b.Codigo_SER and c.ID_TER='".$_GET["HISTORIA"]."' and b.Codigo_HCF='".$rowx[1]."' order by 2";
		$resultx2 = mysqli_query($conexion, $SQL);
		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES PROCEDIMIENTOS', $rowx[1]);
					$pdf->SetFont('Arial','B',10);
				} else {
					$pdf->SetFont('Arial','B',8);
				}
				$pdf->NewItem("B", "Orden Procedimientos");
				$pdf->Cell(0,5,'','B',0,'L',0);
				$pdf->Ln();
			}
			$pdf->Cell(0,1,'','',0,'L',0);
			$pdf->Ln();
			$pdf->Ln();
			$NumIndi=$NumIndi+1;
			/*$pdf->Cell(2,4,' ','',0,'L',0);*/
			$pdf->SetFont('Arial','',7);
			$pdf->SetFillColor(180);	
			$pdf->Cell(10,4,utf8_decode('Cód.'),'TLB',0,'C',1);
			$pdf->SetFont('Courier','B',9);
			$pdf->Cell(16,4,add_ceros($rowx2[1], 2),'TL',0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->MultiCell(0,3,utf8_decode($rowx2[2]),'TLR','L',1);
			$pdf->SetFillColor(255);
			$pdf->SetFont('Courier','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,'CANTIDAD','TL',0,'C',0);
			$pdf->Cell(0,4,'OBSERVACIONES','TLR',0,'C',0);
			$pdf->Ln();
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(2,4,' ','',0,'L',0);
			$pdf->Cell(18,4,add_ceros($rowx2[3],2),'TLB',0,'C',0);
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(0,4,utf8_decode($rowx2[4]),'TLRB',0,'L',0);
			$pdf->Ln();
			
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// ORDENES DE SERVICIOS
	if ($rowx[33]!="0") {
		$SQL="Select a.TipoSer_HCS, e.Descripcion_FRC, a.Cantidad_HCS, a.Observaciones_HCS From hcordenesservicios a, czterceros b, gxfrecuenciaserv e Where e.Codigo_FRC=a.Frecuencia_HCS and a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF='".$rowx[1]."' and b.ID_TER='".$_GET["HISTORIA"]."' order by 1";
		$resultx2 = mysqli_query($conexion, $SQL);		
		$NumIndi=0;
		while ($rowx2 = mysqli_fetch_row($resultx2)) {
			if ($NumIndi==0) {
				if ($UnFolio==1) {
					$pdf->AddPage();
					$pdf->encabezadoz('ORDENES DE SERVICIO', $rowx[1]);
				} else {
					$pdf->NewItem("B", "Ordenes de Servicio");
					$pdf->Cell(0,5,'','B',0,'L',0);
					$pdf->Ln();
				}
				$pdf->Cell(0,2,'','',0,'L',0);
				$pdf->Ln();
				$pdf->SetFont('Courier','B',8);
				$pdf->Cell(15,4,'CANTIDAD','TL',0,'C',0);
				$pdf->Cell(140,4,'SERVICIO','TL',0,'C',0);
				$pdf->Cell(0,4,'FRECUENCIA','TLR',0,'C',0);
				$pdf->Ln();

			}
			$NumIndi=$NumIndi+1;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,utf8_decode($rowx2[2]),'TLB',0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(140,4,utf8_decode($rowx2[0]),'TLB',0,'L',0);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(0,4,utf8_decode($rowx2[1]),'TLBR',0,'L',0);
			$pdf->Ln();
			if ($rowx2[3]!="") {
				$pdf->SetFont('Arial','',7);
				$pdf->MultiCell(0,5,'OBSERVACIONES: '.utf8_decode($rowx2[3]),0,'J',0);
				/* $pdf->Ln(); */
			}
			
		}
		mysqli_free_result($resultx2);
		$pdf->Ln();	

	// FIRMA PROFESIONAL
		if ($NumIndi!=0) {
			$pdf->Ln();	
			$pdf->firmas($rowx[18], $rowx[21], $rowx[16], $rowx[17], $pdf->GetY());
		}

	}
	// $pdf->Ln();	
	
}
mysqli_free_result($resultx);


$pdf->Ln();

//Mostramos el informe
if (isset($_GET["download"])) {
	$pdf->Output($_GET["HISTORIA"].".pdf", "D");
} else {
	$pdf->Output();
}
?>