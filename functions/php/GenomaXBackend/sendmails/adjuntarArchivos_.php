<?php
include '../../nexus/database.php';
include 'mail.php';


    set_time_limit (24 * 60 * 60);

    $factura = $_POST['factura'];
    //$nit = '901515909';

    $cade = explode("-",verficarEmpresaReg());
    $nit = $cade[0];  //nit empresa que envia la factura



    $datosEnvioMail = datosEnvioMail($factura);
    $para = $datosEnvioMail[4];

    //var_dump($para);

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





      $indice=$factura;
      if($para){
        while($indice<='UTC3'){
            send($para,$indice,$datosEnvioMail);
            $indice++;
          }
      }