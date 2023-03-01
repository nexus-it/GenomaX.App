<?php
session_start();
include '../../nexus/database.php';
include 'mail.php';


    set_time_limit (24 * 60 * 60);

    $factura = $_POST['factura'];
    //$nit = '901515909';

    $cade = explode("-",verficarEmpresaReg());
    $nit = $cade[0];  //nit empresa que envia la factura



    $datosEnvioMail = datosEnvioMail($factura);
    //$para = $datosEnvioMail[4];
    $para = $datosEnvioMail[5];

    //print_r("para = ".$para);exit();

      //if (!isset($_POST['submit'])) die();

      // folder to save downloaded files to. must end with slash
      $destination_folder = 'archivos/';

      $url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/FES-'.$factura.'.xml';//$_POST['url'];
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



       print_r("http://localhost/Genomax/application/reports/facturasaluddet_SV.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"]);
    $payload = file_get_contents("http://localhost/Genomax/application/reports/facturasaluddet_SV.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"]);
      
     $url = "http://localhost/Genomax/application/reports/facturasaluddet.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura."&DB_SUFFIX=".$_SESSION["DB_SUFFIX"]."&DB_HOST=".$_SESSION["DB_HOST"]."&DB_USER=".$_SESSION["DB_USER"]."&DB_PASSWORD=".$_SESSION["DB_PASSWORD"]."&DB_NAME=".$_SESSION["DB_NAME"];
     
     
     // echo $url;
     error_log($url);

    /*      
      //include "http://localhost/GenomaX.App-main/application/reports/facturasaluddet.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura;
      
      $url = "http://localhost/GenomaX.App-main/application/reports/facturasaluddet.php";
      //$url = "http://localhost/GenomaX.App-main/application/reports/facturasaluddet.php?PREFIJO=".$Pref."&CODIGO_INICIAL=".$Consecutivo."&CODIGO_FINAL=".$Consecutivo."&namedoc=".$factura;
      
      $payload= array('PREFIJO'=>$Pref,'CODIGO_INICIAL'=>$Consecutivo,'CODIGO_FINAL'=>$Consecutivo,'namedoc'=>$factura);
      

      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_COOKIESESSION, true);
      //Si lo deseamos podemos recuperar la salida de la ejecución de la URL
      $resultado = curl_exec($ch);
      //var_dump($resultado);exit();


      if($errno = curl_errno($ch)){
        $errno_message = curl_errno($errno);
        echo "cURL error ({$errno}):\n {$errno_message}";
        var_dump($errno);
      }

      error_log($resultado);
      //cerrar conexión
      curl_close($ch);

*/



  // Creamos un instancia de la clase ZipArchive
  $zip = new ZipArchive();
  // Creamos y abrimos un archivo zip temporal
  $zip->open("archivos/FES-$factura.zip",ZipArchive::CREATE);
  // Añadimos un directorio
  //$dir = 'documentos';
  //$zip->addEmptyDir($dir);
  // Añadimos un archivo en la raid del zip.
  $zip->addFile('archivos/FES-'.$factura.'.pdf',"FES-$factura.pdf");
  $zip->addFile('archivos/FES-'.$factura.'.xml',"FES-$factura.xml");
  //Añadimos un archivo dentro del directorio que hemos creado
  //$zip->addFile('archivos/FES-'.$factura.'.pdf',$dir."/FES-$factura.pdf");
  //$zip->addFile('archivos/FES-'.$factura.'.xml',$dir."/FES-$factura.xml");
  // Una vez añadido los archivos deseados cerramos el zip.
  $zip->close();
  // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
  header("Content-type: application/octet-stream");
  header("Content-disposition: attachment; filename=miarchivo.zip");
  // leemos el archivo creado
  readfile("archivos/FES-$factura.zip");
  // Por último eliminamos el archivo temporal creado
  //unlink('miarchivo.zip');//Destruye el archivo temporal



//$para="ing.leandro.castro@gmail.com";
//$para="jeancorrea1000@gmail.com";

$indice=$factura;
if($para){
  // while($indice<='UTC677'){
      send($para,$indice,$datosEnvioMail);
      $indice++;
    // }
}

unlink("archivos/FES-$factura.pdf");//Destruye el archivo temporal
unlink("archivos/FES-$factura.xml");//Destruye el archivo temporal
unlink("archivos/FES-$factura.zip");//Destruye el archivo temporal


?>

