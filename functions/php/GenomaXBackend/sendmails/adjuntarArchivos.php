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
    $nit = $cade[0];  //nit empresa que envia la factura


    $datosEnvioMail = datosEnvioMail($factura); 
    //$para = $datosEnvioMail[4];
    $para = $datosEnvioMail[5];

    //var_dump($para);

      //if (!isset($_POST['submit'])) die();

      // folder to save downloaded files to. must end with slash
      $destination_folder = 'archivos/';

      //$url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/FES-'.$factura.'.xml';//$_POST['url'];
      $url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/'.$factura.'ad'.$ad_xml.'.xml';//$_POST['url'];
      //echo $url;
      $newfname = $destination_folder . basename($url);


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


      $Consecutivo = preg_replace('/[^0-9]/', '', $factura);
      $cadena = explode($Consecutivo,$factura);
      $Pref = $cadena[0];


       //print_r("http://localhost/GenomaX_dev/application/reports/facturasaluddet_SV.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"]);
    $payload = file_get_contents("http://localhost/GenomaX/application/reports/facturasaluddet_SV.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"]);
      
     $url = "http://localhost/GenomaX_dev/application/reports/facturasaluddet.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"];
     
     
     // echo $url;
     //error_log($url);

    


  // Creamos un instancia de la clase ZipArchive
  $zip = new ZipArchive();
  // Creamos y abrimos un archivo zip temporal
  $zip->open("archivos/FES-$factura.zip",ZipArchive::CREATE);
  // A�adimos un directorio
  //$dir = 'documentos';
  //$zip->addEmptyDir($dir);
  // A�adimos un archivo en la raid del zip.
  $zip->addFile('archivos/FES-'.$factura.'.pdf',"FES-$factura.pdf");
  $zip->addFile('archivos/'.$factura.'ad'.$ad_xml.'.xml',"FES-$factura.xml");
  //A�adimos un archivo dentro del directorio que hemos creado
  //$zip->addFile('archivos/FES-'.$factura.'.pdf',$dir."/FES-$factura.pdf");
  //$zip->addFile('archivos/FES-'.$factura.'.xml',$dir."/FES-$factura.xml");
  // Una vez a�adido los archivos deseados cerramos el zip.
  $zip->close();
  // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
  header("Content-type: application/octet-stream");
  header("Content-disposition: attachment; filename=miarchivo.zip");
  // leemos el archivo creado
  //readfile("archivos/FES-$factura.zip");
  // Por �ltimo eliminamos el archivo temporal creado
  //unlink('miarchivo.zip');//Destruye el archivo temporal


 //$para="gerencia@nexus-it.co";

// var_dump ($para);exit();

$indice=$factura;
if($para){
  // while($indice<='UTC677'){
      send($para,$indice,$datosEnvioMail);
      $indice++;
    // }
}
/*
unlink("archivos/FES-$factura.pdf");//Destruye el archivo temporal
unlink("archivos/FES-$factura.xml");//Destruye el archivo temporal
unlink("archivos/FES-$factura.zip");//Destruye el archivo temporal
*/
?>

