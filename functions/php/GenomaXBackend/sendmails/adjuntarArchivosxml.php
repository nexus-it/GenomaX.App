<?php
ob_end_clean();
session_start();
include '../../nexus/database.php';
include 'mail.php';


    set_time_limit (24 * 60 * 60);

    $factura = $_POST['factura'];
    $cadenaxml = explode("fv",$_POST['ad_xml']);
    $ad_xml = $cadenaxml[1];
    //$nit = '901515909';
    //echo $ad_xml;

    $cade = explode("-",verficarEmpresaReg());
    $nit = trim($cade[0]);  //nit empresa que envia la factura



    $datosEnvioMail = datosEnvioMail($factura);
    //$para = $datosEnvioMail[4];
    $para = $datosEnvioMail[5];

    //var_dump($para);

      //if (!isset($_POST['submit'])) die();

      // folder to save downloaded files to. must end with slash
      $destination_folder = 'archivos/';

      //$url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/FES-'.$factura.'.xml';//$_POST['url'];
      $url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/'.$factura.'ad'.$ad_xml.'.xml';//$_POST['url']; //'https://backend.estrateg.com/API/storage/app/public/'.
      //print_r($url);exit();

      
      $newfname = $destination_folder . basename($url);

      //echo $newfname;
     

     


      $file = fopen ($url, "rb");
      if ($file) {
        $newf = fopen ($newfname, "wb");

        if ($newf)
        while(!feof($file)) {
          fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
        }
      }

      if ($file) {
        fclose($file);
      }

      if ($newf) {
        fclose($newf);
      }

     

     // Creamos un instancia de la clase ZipArchive
  $zip = new ZipArchive();
  // Creamos y abrimos un archivo zip temporal
  $zip->open("archivos/FES-$factura.zip",ZipArchive::CREATE);
  // Añadimos un directorio
  //$dir = 'documentos';
  //$zip->addEmptyDir($dir);
  // Añadimos un archivo en la raid del zip.
  
  $zip->addFile('archivos/'.$factura.'ad'.$ad_xml.'.xml',"FES-$factura.xml");
  //Añadimos un archivo dentro del directorio que hemos creado
  //$zip->addFile('archivos/FES-'.$factura.'.pdf',$dir."/FES-$factura.pdf");
  //$zip->addFile('archivos/FES-'.$factura.'.xml',$dir."/FES-$factura.xml");
  // Una vez añadido los archivos deseados cerramos el zip.
  $zip->close();
  // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
  //header("Content-type: application/octet-stream");
  //header("Content-disposition: attachment; filename=miarchivo.zip");
  // leemos el archivo creado
  //readfile(dirname(__DIR__,2).'\GenomaXBackend\sendmails\archivos\FES-'.$factura.'.zip', $factura.'.zip');
  // Por último eliminamos el archivo temporal creado
  //unlink('miarchivo.zip');//Destruye el archivo temporal
  

  echo "FES-".$factura.".zip";//$url ;
  //echo '/GenomaXBackend/sendmails/archivos/FES-'.$factura.'.zip';


  

      
?>


