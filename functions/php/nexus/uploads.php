<?php


session_start();
include 'database.php';	
//Se selecciona directorio destino
$destination_path = '../../../files/'.$_SESSION["DB_SUFFIX"].'/'.$_GET["route"].'/';
$result_upl = 0; 
//Se genera el nombre del archivo final
$target_path = $destination_path.$_POST["hdn_".$_GET["class"].$_GET["wind"]].'.'.ExtFile($_FILES['upl_file'.$_GET['wind']]['name']); 
//Si se trata de una imagen, eliminamos posibles referencias anteriores
EliminarRefImagenes($destination_path.$_POST["hdn_".$_GET["class"].$_GET["wind"]]);
//Se copia el archivo desde la ruta temporal
if(@move_uploaded_file($_FILES['upl_file'.$_GET['wind']]['tmp_name'], $target_path)) { 
	$result_upl = 1; 
	//Si se trata de una imagen, optimizamos su tamaño

	//Si se trata de una foto de perfil, se ajusta el tamaño a la proporcion 5/4
	if ($_GET["style"]=='profile') {
		AjustarFotoPerfil($target_path, ExtFile($_FILES['upl_file'.$_GET['wind']]['name']));
	}
} 
sleep(1); 

//Funcion para extraer la extencion del archivo
function ExtFile($str) {
	$archivito=explode(".", $str);
	return end($archivito);
}

//Funcion para optimizar el tamaño de la imagen de perfil
function AjustarFotoPerfil($imagen, $extension) {
	if ($extension=='png') {
		$img_origen = imagecreatefrompng($imagen);
	} else{
		if (($extension=='jpg')||($extension=='jpeg')) {
			$img_origen = imagecreatefromjpeg($imagen);
		} else{
			if ($extension=='gif') {
				$img_origen = imagecreatefromgif($imagen);
			}
		}
	}
	$ancho_origen = imagesx( $img_origen );//se ontiene el ancho de la imagen
	$alto_origen = imagesy( $img_origen );//se obtiene el alto de la imagen
	$ancho_limite=96;
	$alto_limite=120;
	if($ancho_origen>$alto_origen){// para foto horizontal
		
		$alto_origen=$alto_limite;
		$ancho_origen=$alto_limite*imagesx( $img_origen )/imagesy( $img_origen );		
		
	}else{//para fotos verticales

		$ancho_origen=$ancho_limite;
		$alto_origen=$ancho_limite*imagesy( $img_origen )/imagesx( $img_origen );
	}
	$img_destino = imagecreatetruecolor($ancho_origen ,$alto_origen );// se crea la imagen segun las dimensiones dadas
	// copy/resize as usual
	imagecopyresized( $img_destino, $img_origen, 0, 0, 0, 0, $ancho_origen, $alto_origen, imagesx( $img_origen ), imagesy( $img_origen ) );
	//se guarda la nueva foto 
	if ($extension=='png') {
		imagepng( $img_destino, $imagen );
	} else{
		if (($extension=='jpg')||($extension=='jpeg')) {
			imagejpeg( $img_destino, $imagen );
		} else{
			if ($extension=='gif') {
				imagegif( $img_destino, $imagen );
			}
		}
	}
	//imagedestroy( $img_origen );
}

?>
