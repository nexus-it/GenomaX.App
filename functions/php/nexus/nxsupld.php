<?php
session_start(); 
$msg="No se cargó el archivo.";
if(!empty($_FILES['nxs_filez']['name'])){
    $uploadedFile = '';
    $msg="No está definido el tipo de archivo.";
    if(!empty($_FILES["nxs_filez"]["type"])){
    	$msg="No es posible crear directorio temporal.";
    	// Imagen en directorio temporal
		$imgtemp='../../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/'.session_id().'.jpg';
		//Se crea la carpeta si no existe...
		$RutaSESSION='../../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session';
		if (!(is_dir($RutaSESSION))) {
			mkdir ($RutaSESSION, 0777);
		}
		$valid_extensions = array("jpeg", "jpg");
        $temporary = explode(".", $_FILES["nxs_filez"]["name"]);
        $msg="Tipo de imagen debe ser .jpg.";
        $file_extension = end($temporary);
        if((($_FILES["nxs_filez"]["type"] == "image/jpg") || ($_FILES["nxs_filez"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
        	$msg="No se pudo crear el archivo temporal.";
        	// Si ya existe el archivo, lo borramos
        	if(is_file($imgtemp)) {
				unlink($imgtemp);
			}
	        $sourcePath = $_FILES['nxs_filez']['tmp_name'];
            if(move_uploaded_file($sourcePath,$imgtemp)){
                $uploadedFile = $imgtemp;
                $msg="ok";
            }
        }
    }
}
echo $msg;
?>