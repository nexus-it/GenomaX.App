<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
date_default_timezone_set('America/Bogota');

function nxs_chk($name, $window) {
  echo '<div class="checkbox checkbox-success">
        <input name="chk_'.$name.'ok'.$window.'" id="chk_'.$name.'ok'.$window.'" type="checkbox" value=""  onclick="javascript:nxs_chkd(\''.$name.$window.'\');" class="styled"><label for="chk_'.$name.'ok'.$window.'"></label>
      </div><input name="hdn_'.$name.$window.'" type="hidden" id="hdn_'.$name.$window.'" value="0" />';
}

function nxs_yesno($name, $window) {
  echo '<select name="'.$name.$window.'" id="'.$name.$window.'">
          <option value="0">NO</option>
          <option value="1">SI</option>
        </select>';
}

function FechaNow() {
  $SQL="Select curdate();";  
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
  while($row = mysqli_fetch_row($result)) {
    echo trim($row[0]);
  } 
  mysqli_free_result($result);
}

function ultimo_dia_mes_actual() { 
    $month = date('m');
    $year = date('Y');
    $day = date("d", mktime(0,0,0, $month+1, 0, $year));

    return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
};
 
  /** Actual month first day **/
function primer_dia_mes_actual() {
    $month = date('m');
    $year = date('Y');
    return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
}

function PutLogo() {
  $SQL="Select Logo_DCD, NIT_DCD from itconfig";
  $conexion=conexion();
  $resultLogo = mysqli_query($conexion, $SQL);
  if ($rowLogo = mysqli_fetch_row($resultLogo)) {
    $LeLogos='../../files/logo'.$rowLogo[1].'.jpg';
    if (file_exists($LeLogos)) {
      file_put_contents($LeLogos, $rowLogo[0]);
    }
  }
  mysqli_free_result($resultLogo); 

}

//realizado leandro castro 2021/10/05
function verficarEmpresaReg(){
   $SQL="Select  NIT_DCD from itconfig";
   $conexion=conexion();
   $resultadoEmp = mysqli_query($conexion, $SQL);
   if ($rowEmp = mysqli_fetch_row($resultadoEmp)) {
      $nitEmp = $rowEmp[0]; 
   }
   return $nitEmp;
   //error_log($nitEmp);
 }

 function datosEnvioMail($factura){
   $SQL = "SELECT a.NIT_DCD, a.Razonsocial_DCD,  e.ID_TER, e.Nombre_TER, e.Correo_TER
   From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, czterceros g, cztipoid h, gxplanes i
   Where c.Codigo_AFC = b.Codigo_AFC and d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_ADM =c.Codigo_ADM 
   and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA
   and c.Codigo_FAC = '$factura' and c.EnvioFacCli_FAC = '0'
   Order By c.Codigo_FAC";
   $conexion=conexion();
   $resultadoEmp = mysqli_query($conexion, $SQL);
   if ($rowEmp = mysqli_fetch_row($resultadoEmp)) {
      return $rowEmp;
   }
 }

 function actualizarEstadoEnvioFact($factura){
    $SQL = "UPDATE gxfacturas SET EnvioFacCli_FAC = 1 WHERE Codigo_FAC = '$factura' ";
    $conexion=conexion();
    $resultadoEmp = mysqli_query($conexion, $SQL);
    return $resultadoEmp;
 }

 function NombreMes($mes){
   switch($mes) {
       case '01': return 'Enero'; break;
       case '02': return 'Febrero'; break;
       case '03': return 'Marzo'; break;
       case '04': return 'Abril'; break;
       case '05': return 'Mayo'; break;
       case '06': return 'Junio'; break;
       case '07': return 'Julio'; break;
       case '08': return 'Agosto'; break;
       case '09': return 'Septiembre'; break;
       case '10': return 'Octubre'; break;
       case '11': return 'Noviembre'; break;
       case '12': return 'Diciembre'; break;
   }
}

function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case 1: return 31; break;
       case 2: return $dias_febrero; break;
       case 3: return 31; break;
       case 4: return 30; break;
       case 5: return 31; break;
       case 6: return 30; break;
       case 7: return 31; break;
       case 8: return 31; break;
       case 9: return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
} 
function ShowVersion()
{
	$SQL="Select Version_DCD from itconfig";
	$conexion=conexion();
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo 'Version '.($row[0]);
	} else {
		echo '<span class="error">No se pudo acceder a la versión del sistema.</span>';
	}
	mysqli_free_result($result);	
}

function acento($cadena){
$cadena = str_replace ("&aacute;", chr(225), $cadena);
$cadena = str_replace ("&eacute;", chr(233), $cadena);
$cadena = str_replace ("&iacute;", chr(237), $cadena);
$cadena = str_replace ("&oacute;", chr(243), $cadena);
$cadena = str_replace ("&uacute;", chr(250), $cadena);
$cadena = str_replace ("&Aacute;", chr(193), $cadena);
$cadena = str_replace ("&Eacute;", chr(201), $cadena);
$cadena = str_replace ("&Iacute;", chr(205), $cadena);
$cadena = str_replace ("&Oacute;", chr(211), $cadena);
$cadena = str_replace ("&Uacute;", chr(218), $cadena); 
$cadena = str_replace ("&ntilde;", "ñ", $cadena); 
$cadena = str_replace ("&Ntilde;", "Ñ", $cadena); 
return $cadena;

}

function edad($fecha_nacimiento) 
{ 
  $fecha_actual = date('d/m/Y'); 
  $fecha_nacimiento= FormatoFecha($fecha_nacimiento);
   // separamos en partes las fechas  
   $array_nacimiento = explode ( "/", $fecha_nacimiento );  
   $array_actual = explode ( "/", $fecha_actual );  
   $anos =  $array_actual[2] - $array_nacimiento[2]; // calculamos años  
   $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses  
   $dias =  $array_actual[0] - $array_nacimiento[0]; // calculamos días  
   //ajuste de posible negativo en $días  
   if ($dias < 0)  
   {  
      --$meses;  
      //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual  
      switch ($array_actual[1]) {  
         case 1:  
            $dias_mes_anterior=31; 
            break;  
         case 2:      
            $dias_mes_anterior=31; 
            break;  
         case 3:   
            if (bisiesto($array_actual[2]))  
            {  
               $dias_mes_anterior=29; 
               break;  
            }  
            else  
            {  
               $dias_mes_anterior=28; 
               break;  
            }  
         case 4: 
            $dias_mes_anterior=31; 
            break;  
         case 5: 
            $dias_mes_anterior=30; 
            break;  
         case 6: 
            $dias_mes_anterior=31; 
            break;  
         case 7: 
            $dias_mes_anterior=30; 
            break;  
         case 8: 
            $dias_mes_anterior=31; 
            break;  
         case 9: 
            $dias_mes_anterior=31; 
            break;  
         case 10: 
            $dias_mes_anterior=30; 
            break;  
         case 11: 
            $dias_mes_anterior=31; 
            break;  
         case 12: 
            $dias_mes_anterior=30; 
            break;  
      }  
      $dias=$dias + $dias_mes_anterior; 
      if ($dias < 0) 
      { 
         --$meses; 
         if($dias == -1) 
         { 
            $dias = 30; 
         } 
         if($dias == -2) 
         { 
            $dias = 29; 
         } 
      } 
   }  
   //ajuste de posible negativo en $meses  
   if ($meses < 0)  
   {  
      --$anos;  
      $meses=$meses + 12;  
   } 
   $tiempo = $anos.' años '.$meses.' meses '.$dias.' dias'; 
   return $tiempo; 
} 

function edadhc($fecha_nacimiento, $fecha_hc) 
{ 
  $fecha_actual = FormatoFecha($fecha_hc);
  $fecha_nacimiento= FormatoFecha($fecha_nacimiento);
   // separamos en partes las fechas  
   $array_nacimiento = explode ( "/", $fecha_nacimiento );  
   $array_actual = explode ( "/", $fecha_actual );  
   $anos =  $array_actual[2] - $array_nacimiento[2]; // calculamos años  
   $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses  
   $dias =  $array_actual[0] - $array_nacimiento[0]; // calculamos días  
   //ajuste de posible negativo en $días  
   if ($dias < 0)  
   {  
      --$meses;  
      //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual  
      switch ($array_actual[1]) {  
         case 1:  
            $dias_mes_anterior=31; 
            break;  
         case 2:      
            $dias_mes_anterior=31; 
            break;  
         case 3:   
            if (bisiesto($array_actual[2]))  
            {  
               $dias_mes_anterior=29; 
               break;  
            }  
            else  
            {  
               $dias_mes_anterior=28; 
               break;  
            }  
         case 4: 
            $dias_mes_anterior=31; 
            break;  
         case 5: 
            $dias_mes_anterior=30; 
            break;  
         case 6: 
            $dias_mes_anterior=31; 
            break;  
         case 7: 
            $dias_mes_anterior=30; 
            break;  
         case 8: 
            $dias_mes_anterior=31; 
            break;  
         case 9: 
            $dias_mes_anterior=31; 
            break;  
         case 10: 
            $dias_mes_anterior=30; 
            break;  
         case 11: 
            $dias_mes_anterior=31; 
            break;  
         case 12: 
            $dias_mes_anterior=30; 
            break;  
      }  
      $dias=$dias + $dias_mes_anterior; 
      if ($dias < 0) 
      { 
         --$meses; 
         if($dias == -1) 
         { 
            $dias = 30; 
         } 
         if($dias == -2) 
         { 
            $dias = 29; 
         } 
      } 
   }  
   //ajuste de posible negativo en $meses  
   if ($meses < 0)  
   {  
      --$anos;  
      $meses=$meses + 12;  
   } 
   $tiempo="";
   if ($anos!=0) {
    $tiempo = $tiempo.$anos.' años '; 
   }
   if ($meses!=0) {
    $tiempo = $tiempo.$meses.' meses '; 
   }
   if ($dias!=0) {
    $tiempo = $tiempo.$dias.' dias '; 
   }
   return $tiempo; 
} 
 
function bisiesto($anio_actual){  
   $bisiesto=false;  
   //probamos si el mes de febrero del año actual tiene 29 días  
     if (checkdate(2,29,$anio_actual))  
     {  
      $bisiesto=true;  
   }  
   return $bisiesto;  
} 
function add_ceros($numero,$ceros) {
	$order_diez = explode(".",$numero); 
	$dif_diez = $ceros - strlen($order_diez[0]); 
	for($m = 0 ; 
	$m < $dif_diez;
	$m++) 
	{ 
		@$insertar_ceros .= 0;
	} 
	return $insertar_ceros .= $numero; 
}

function FormatoFecha($fecha){ 
	list($anio,$mes,$dia)=explode("-",$fecha); 
	return trim($dia)."/".trim($mes)."/".trim($anio); 
} 

function MyFecha($fecha){ 
	list($dia,$mes,$anio)=explode("/",$fecha); 
	return trim($anio)."-".trim($mes)."-".trim($dia); 
} 

function Conexion()
{
  if (isset($_SESSION["DB_NAME"])) {
	 $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
  } else {
   $conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  }
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);
	return $conexion;
}

function Conectar($host, $usuario, $clave, $database) 
{ 
   if (!($link=@mysqli_connect($host, $usuario, $clave, $database))) 
   { 
      return "Error conectando a la base de datos."; 
   }
   else
   { 
   return "Ok"; 
   }
}

function CrearDBase()
{
	
}
function UpdateDBase()
{
	
}

function numerotexto ($numero) { 
    // Primero tomamos el numero y le quitamos los caracteres especiales y extras 
    // Dejando solamente el punto "." que separa los decimales 
    // Si encuentra mas de un punto, devuelve error. 
    // NOTA: Para los paises en que el punto y la coma se usan de forma 
    // inversa, solo hay que cambiar la coma por punto en el array de "extras" 
    // y el punto por coma en el explode de $partes 
     
    $extras= array("/[\$]/","/ /","/,/","/-/"); 
    $limpio=preg_replace($extras,"",$numero); 
    $partes=explode(".",$limpio); 
    if (count($partes)>2) { 
        return "Error, el numero no es correcto"; 
        exit(); 
    } 
     
    // Ahora explotamos la parte del numero en elementos de un array que 
    // llamaremos $digitos, y contamos los grupos de tres digitos 
    // resultantes 
     
    $digitos_piezas=chunk_split ($partes[0],1,"#"); 
    $digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1); 
    $digitos=explode("#",$digitos_piezas); 
    $todos=count($digitos); 
    $grupos=ceil (count($digitos)/3); 
     
    // comenzamos a dar formato a cada grupo 
     
    $unidad = array   ('un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve'); 
    $decenas = array ('diez','once','doce', 'trece','catorce','quince'); 
    $decena = array   ('dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'); 
    $centena = array   ('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'); 
    $resto=$todos; 
     
    for ($i=1; $i<=$grupos; $i++) { 
         
        // Hacemos el grupo 
        if ($resto>=3) { 
            $corte=3; } else { 
            $corte=$resto; 
        } 
            $offset=(($i*3)-3)+$corte; 
            $offset=$offset*(-1); 
         
        // la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 
         
        $num=implode("",array_slice ($digitos,$offset,$corte)); 
        $resultado[$i] = ""; 
        $cen = (int) ($num / 100);              //Cifra de las centenas 
        $doble = $num - ($cen*100);             //Cifras de las decenas y unidades 
        $dec = (int)($num / 10) - ($cen*10);    //Cifra de las decenas 
        $uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 
        if ($cen > 0) { 
           if ($num == 100) $resultado[$i] = "cien"; 
           else $resultado[$i] = $centena[$cen-1].' '; 
        }//end if 
        if ($doble>0) { 
           if ($doble == 20) { 
              $resultado[$i] .= " veinte"; 
           }elseif (($doble < 16) and ($doble>9)) { 
              $resultado[$i] .= $decenas[$doble-10]; 
           }else { 
              $resultado[$i] .=' '. $decena[$dec-1]; 
           }//end if 
           if ($dec>2 and $uni<>0) $resultado[$i] .=' y '; 
           if (($uni>0) and ($doble>15) or ($dec==0)) { 
              if ($i==1 && $uni == 1) $resultado[$i].="uno"; 
              elseif ($i==2 && $num == 1) $resultado[$i].=""; 
              else $resultado[$i].=$unidad[$uni-1]; 
           } 
        } 

        // Le agregamos la terminacion del grupo 
        switch ($i) { 
            case 2: 
            $resultado[$i].= ($resultado[$i]=="") ? "" : " mil "; 
            break; 
            case 3: 
            $resultado[$i].= ($num==1) ? " millon " : " millones "; 
            break; 
        } 
        $resto-=$corte; 
    } 
     
    // Sacamos el resultado (primero invertimos el array) 
    $resultado_inv= array_reverse($resultado, TRUE); 
    $final=""; 
    foreach ($resultado_inv as $parte){ 
        $final.=$parte; 
    } 
    return ucfirst(trim($final)); 
} 

function ValorLetras($numero) { 
    // Primero tomamos el numero y le quitamos los caracteres especiales y extras 
    // Dejando solamente el punto "." que separa los decimales 
    // Si encuentra mas de un punto, devuelve error. 
    // NOTA: Para los paises en que el punto y la coma se usan de forma 
    // inversa, solo hay que cambiar la coma por punto en el array de "extras" 
    // y el punto por coma en el explode de $partes 
     
    $extras= array("/[\$]/","/ /","/,/","/-/"); 
    $limpio=preg_replace($extras,"",$numero); 
    $partes=explode(".",$limpio); 
    if (count($partes)>2) { 
        return "Error, el numero no es correcto"; 
        exit(); 
    } 
     
    // Ahora explotamos la parte del numero en elementos de un array que 
    // llamaremos $digitos, y contamos los grupos de tres digitos 
    // resultantes 
     
    $digitos_piezas=chunk_split ($partes[0],1,"#"); 
    $digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1); 
    $digitos=explode("#",$digitos_piezas); 
    $todos=count($digitos); 
    $grupos=ceil (count($digitos)/3); 
     
    // comenzamos a dar formato a cada grupo 
     
    $unidad = array   ('un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve'); 
    $decenas = array ('diez','once','doce', 'trece','catorce','quince'); 
    $decena = array   ('dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'); 
    $centena = array   ('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'); 
    $resto=$todos; 
     
    for ($i=1; $i<=$grupos; $i++) { 
         
        // Hacemos el grupo 
        if ($resto>=3) { 
            $corte=3; } else { 
            $corte=$resto; 
        } 
            $offset=(($i*3)-3)+$corte; 
            $offset=$offset*(-1); 
         
        // la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 
         
        $num=implode("",array_slice ($digitos,$offset,$corte)); 
        $resultado[$i] = ""; 
        $cen = (int) ($num / 100);              //Cifra de las centenas 
        $doble = $num - ($cen*100);             //Cifras de las decenas y unidades 
        $dec = (int)($num / 10) - ($cen*10);    //Cifra de las decenas 
        $uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 
        if ($cen > 0) { 
           if ($num == 100) $resultado[$i] = "cien"; 
           else $resultado[$i] = $centena[$cen-1].' '; 
        }//end if 
        if ($doble>0) { 
           if ($doble == 20) { 
              $resultado[$i] .= " veinte"; 
           }elseif (($doble < 16) and ($doble>9)) { 
              $resultado[$i] .= $decenas[$doble-10]; 
           }else { 
              $resultado[$i] .=' '. $decena[$dec-1]; 
           }//end if 
           if ($dec>2 and $uni<>0) $resultado[$i] .=' y '; 
           if (($uni>0) and ($doble>15) or ($dec==0)) { 
              if ($i==1 && $uni == 1) $resultado[$i].="uno"; 
              elseif ($i==2 && $num == 1) $resultado[$i].=""; 
              else $resultado[$i].=$unidad[$uni-1]; 
           } 
        } 

        // Le agregamos la terminacion del grupo 
        switch ($i) { 
            case 2: 
            $resultado[$i].= ($resultado[$i]=="") ? "" : " mil "; 
            break; 
            case 3: 
            $resultado[$i].= ($num==1) ? " millon " : " millones "; 
            break; 
        } 
        $resto-=$corte; 
    } 
     
    // Sacamos el resultado (primero invertimos el array) 
    $resultado_inv= array_reverse($resultado, TRUE); 
    $final=""; 
    foreach ($resultado_inv as $parte){ 
        $final.=$parte; 
    } 
	if ($partes[1]=='00') {
    	return ucfirst(trim($final)).' pesos'; 
	} else {
		// return ucfirst(trim($final)).' pesos con '.numerotexto($partes[1]).' centavos'; 
      return ucfirst(trim($final)).' pesos'; 
	}
}

function GuardarImagen($Imagen, $tercero, $tipo) {
	if (file_exists($Imagen.".png")){ 
	    $Formato="png"; 
	}
	if (file_exists($Imagen.".jpeg")){ 
	   $Formato="jpeg"; 
	}
	if (file_exists($Imagen.".jpg")){ 
	   $Formato="jpg"; 
	}
	if (file_exists($Imagen.".gif")){ 
	   $Formato="gif";
	}
	$Imagen=$Imagen.'.'.$Formato;
	if ($Formato=="jpg") {$Formato="jpeg";}
	if ($Formato=="gif") {
		$image = imagecreatefromgif($Imagen); 
		ob_start(); 
		imagegif($image); 
	}
	if ($Formato=="jpeg") {
		$image = imagecreatefromjpeg($Imagen); 
		ob_start(); 
		imagejpeg($image); 
	}
	if ($Formato=="png") {
		$image = imagecreatefrompng($Imagen); 
		ob_start(); 
		imagepng($image); 
	}
	$jpg = ob_get_contents();
	ob_end_clean();
	$jpg = str_replace('##','##',mysqli_escape_string($jpg));
	if ($tipo=="terceros") {
		$SQL="Update czterceros Set Imagen_TER='".$jpg."', FormatImg_TER='".$Formato."' Where Codigo_TER='".$tercero."';";
	} else {
		$SQL="Update itusuarios Set Imagen_USR='".$jpg."' Where Codigo_USR='".$tercero."';";
	}
	$result = mysqli_query($SQL);
}

function ExtraerImagen($tipo, $codigo) {
	if ($tipo=="users") {
		$SQL="SELECT Imagen_USR, 'png' FROM itusuarios WHERE Codigo_USR='".$codigo."';";
	} else {
		if ($tipo=="terceros") {
			$SQL="SELECT Imagen_TER, FormatImg_TER FROM czterceros WHERE Codigo_TER='".$codigo."';";
		}
	}
	$result = mysqli_query($SQL);
	$result_array = mysqli_fetch_array($result);
	$formato="jpg";

	$data = $result_array[0];
	$im = imagecreatefromstring($data);
	if ($im !== false) {
		if ($formato=="png") {
			if ($tipo=="terceros") {
				imagepng($im, '../../../files/images/terceros/'.$codigo.'.'.$formato);
			} else {
				imagepng($im, '../../../files/images/users/'.$tipo.$codigo.'.'.$formato);
			}
		} else {
			if (($formato=="jpg")||($formato=="jpeg")) {
				imagejpeg($im, '../../../files/images/terceros/'.$codigo.'.'.$formato, 85);
			} else {
				imagegif($im, '../../../files/images/terceros/'.$codigo.'.'.$formato);
			}
		}
		imagedestroy($im);
	} else {
	echo $formato;
	}
}
	
function EliminarRefImagenes($archivo) {
	if (file_exists($archivo.".png")){ 
	    unlink($archivo.".png"); 
	}
	if (file_exists($archivo.".jpeg")){ 
	   unlink($archivo.".jpeg"); 
	}
	if (file_exists($archivo.".jpg")){ 
	   unlink($archivo.".jpg"); 
	}
	if (file_exists($archivo.".gif")){ 
	   unlink($archivo.".gif");
	}
}

function nxs_mailing($desde, $nombre1, $para, $nombre2, $titulo, $mensaje) {
	require '../../../PHPMailerAutoload.php';
	include("../../../class.smtp.php");
	$mail = new PHPMailer;
	$mail->PluginDir = "../../../";
	
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->SMTPAuth = true;
	$mail->Port = 465;
/*	$mail->Host = 'mail.escalaimp.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'intranet@escalaimp.com';                 // SMTP username
	$mail->Password = 'escalaimp123';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
	
	$mail->From = 'intranet@escalaimp.com';
	$mail->FromName = 'Mensaje Interno';
*/	

	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->Username = 'chcclinica@gmail.com';                 // SMTP username
	$mail->Password = 'chcclinica*123';                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
	
	$mail->From = 'chcclinica@gmail.com';
	$mail->FromName = $nombre1;
		
	$mail->Timeout=120;
	$mail->addAddress($para, $nombre2);               // Name is optional
  /*
  $SQL="Select Email_USR From itusuarios where ODS_USR='2'";
  $resulti = mysqli_query($conexion, $SQL);
  while($rowi = mysqli_fetch_row($resulti)) {
    $mail->AddCC($rowi[0]);
  } 
  mysqli_free_result($resulti);
  */
	$mail->addReplyTo($desde, $nombre1);
	
	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	
	$mail->Subject = utf8_decode($titulo);

	$mail->AltBody = utf8_decode($titulo.': '.$mensaje);

	$mensaje = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=320, target-densitydpi=device-dpi"><title>'.utf8_decode($titulo).'</title>
	  <style type="text/css">
/* Mobile-specific Styles */
@media only screen and (max-width: 660px) { 
table[class=w0], td[class=w0] { width: 0 !important; }
table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
table[class=h0], td[class=h0] { height: 0 !important; }
p[class=footer-content-left] { text-align: center !important; }
#headline p { font-size: 30px !important; }
.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
img { height: auto; line-height: 100%;}
 } 
/* Client-specific Styles */
#outlook a { padding: 0; }	/* Force Outlook to provide a "view in browser" button. */
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */
/* Reset Styles */
body { background-color: #f7f7f7; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }
/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */  
table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
}	
code {
  white-space: normal;
  word-break: break-all;
}
#background-table { background-color: #f7f7f7; }
/* Webkit Elements */
#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #3D4599; color: #ebeaed; }
#top-bar a { font-weight: bold; color: #ffffff; text-decoration: none;}
#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
/* Fonts and Content */
body, td { font-family: HelveticaNeue, sans-serif; }
.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */
.header-content { font-size: 12px; color: #ebeaed; }
.header-content a { font-weight: bold; color: #ffffff; text-decoration: none; }
#headline p { color: #444444; font-family: HelveticaNeue, sans-serif; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:30px; }
#headline p a { color: #444444; text-decoration: none; }
.article-title { font-size: 18px; line-height:24px; color: #3d4599; font-weight:bold; margin-top:0px; margin-bottom:18px; font-family: HelveticaNeue, sans-serif; }
.article-title a { color: #3d4599; text-decoration: none; }
.article-title.with-meta {margin-bottom: 0;}
.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
.article-content { font-size: 13px; line-height: 18px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: HelveticaNeue, sans-serif; }
.article-content a { color: #0c7d47; font-weight:bold; text-decoration:none; }
.article-content img { max-width: 100% }
.article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }
.article-content li { font-size: 13px; line-height: 18px; color: #444444; }
.article-content li a { color: #0c7d47; text-decoration:underline; }
.article-content p {margin-bottom: 15px;}
.footer-content-left { font-size: 12px; line-height: 15px; color: #ededed; margin-top: 0px; margin-bottom: 15px; }
.footer-content-left a { color: #ffffff; font-weight: bold; text-decoration: none; }
.footer-content-right { font-size: 11px; line-height: 16px; color: #ededed; margin-top: 0px; margin-bottom: 15px; }
.footer-content-right a { color: #ffffff; font-weight: bold; text-decoration: none; }
#footer { background-color: #3D4599; color: #ededed; }
#footer a { color: #ffffff; text-decoration: none; font-weight: bold; }
#permission-reminder { white-space: normal; }
#street-address { color: #b0b0b0; white-space: normal; }
</style>
<!--[if gte mso 9]>
<style _tmplitem="7723" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px;
   padding: 0;
   list-style-position: inside;
}
</style>
<![endif]--></head>
<body><table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table" style="table-layout:fixed" align="center">
	<tbody><tr>
		<td align="center" bgcolor="#f7f7f7">
        	<table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
            	<tbody><tr><td class="w640" width="640" height="20"></td></tr>
                
            	<tr>
                	<td class="w640" width="640">
                        <table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
    <tbody><tr>
        <td class="w15" width="15"></td>
        <td class="w325" width="350" valign="middle" align="left">
            <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr><td class="w325" width="350" height="8"></td></tr>
            </tbody></table>
            <div class="header-content"></div>
            <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr><td class="w325" width="350" height="8"></td></tr>
            </tbody></table>
        </td>
        <td class="w30" width="30"></td>
        <td class="w255" width="255" valign="middle" align="right">
            <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr><td class="w255" width="255" height="8"></td></tr>
            </tbody></table>
            <table cellpadding="0" cellspacing="0" border="0">
    <tbody><tr>
        
        
        
        <td class="w10" width="10"></td>
        <td valign="middle"><forwardtoafriend lang="es-ES"><img src="https://img.createsend1.com/img/templatebuilder/forward-glyph.png" border="0" width="19" height="14" alt="Forward icon"=""></forwardtoafriend></td>
        <td width="3"></td>
        <td valign="middle"><div class="header-content"><forwardtoafriend lang="es-ES">Reenviar</forwardtoafriend></div></td>
        
    </tr>
</tbody></table>
            <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr><td class="w255" width="255" height="8"></td></tr>
            </tbody></table>
        </td>
        <td class="w15" width="15"></td>
    </tr>
</tbody></table>
                        
                    </td>
                </tr>
                <tr>
                <td id="header" class="w640" width="640" align="center" bgcolor="#ffffff">
    
    <div align="left" style="text-align: left">
        <a href="http://central/">
        <img id="customHeaderImage" label="Header Image" editable="true" width="210" src="http://cehoca.co/recursos/logocgsd.png" class="w640" border="0" align="top" style="display: inline">
        </a>
    </div>
    
    
</td>
                </tr>
		<tr><td class="w640" width="640" height="30" bgcolor="#e5e6e8"></td></tr>
                <tr id="simple-content-row"><td class="w640" width="640" bgcolor="#e5e6e8">
    <table align="left" class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
        <tbody><tr>
            <td class="w30" width="30"></td>
            <td class="w580" width="580">
                <repeater>
                    
                    <layout label="Text only">
                        <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                            <tbody><tr>
                                <td class="w580" width="580">
                                    <p align="left" class="article-title"><singleline label="Title">'.utf8_decode($titulo).'</singleline></p>
                                    <div align="left" class="article-content">
                                        <multiline label="Description">'.utf8_decode($mensaje).'
		</multiline>
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="w580" width="580" height="10"></td></tr>
                        </tbody></table>
                    </layout>
	</repeater>
            </td>
            <td class="w30" width="30"></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr><td class="w640" width="640" height="15" bgcolor="#e5e6e8"></td></tr>
                
                <tr>
                <td class="w640" width="640">
    <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#3D4599">
        <tbody><tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="30"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr>
        <tr>
            <td class="w30" width="30"></td>
            <td class="w580" width="360" valign="top">
            <span class="hide"><p id="permission-reminder" align="left" class="footer-content-left"><span>No responda a este correo.</span></p></span>
            <p align="left" class="footer-content-left"><preferences lang="es-ES">CEHOCA</preferences> | <unsubscribe>Intranet</unsubscribe></p>
            </td>
            <td class="hide w0" width="60"></td>
            <td class="hide w0" width="160" valign="top">
            <p id="street-address" align="right" class="footer-content-right"><span>Mensaje generado autom&aacute;ticamente.</span></p>
            </td>
            <td class="w30" width="30"></td>
        </tr>
        <tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="15"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr>
    </tbody></table>
</td>
                </tr>
                <tr><td class="w640" width="640" height="60"></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table></body></html>
	';
	$mail->Body = $mensaje;

	if(!$mail->send()) {
		return 'Correo no pudo ser enviado.<br>Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'Fue enviado correo a '.$para;
	}
}
?>