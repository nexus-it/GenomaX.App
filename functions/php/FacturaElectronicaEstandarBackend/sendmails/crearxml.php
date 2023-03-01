<?php


session_start();
include '../../nexus/database.php';
include 'mail.php';




    set_time_limit (24 * 60 * 60);

    $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

    $SQL= "SELECT c.Codigo_FAC, fecha_fac,SUBSTRING_INDEX(a.NIT_DCD, '-', 1), a.Razonsocial_DCD,  e.ID_TER, e.Nombre_TER, e.Correo_TER, d.EmailContact_EPS
    From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, czterceros g, cztipoid h, gxplanes i
    Where c.Codigo_AFC = b.Codigo_AFC and d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_ADM =c.Codigo_ADM 
    and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA
    and e.Nombre_TER LIKE '%MUTUAL%' AND fecha_fac >= '2021-11-19' 
    Order By c.Codigo_FAC"; //AND c.Codigo_FAC = 'BQ16361'
 

$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {

    $factura = $rowH['Codigo_FAC']; // $_POST['factura'];
    $cadenaxml = explode("fv",$_POST['ad_xml']);
    $ad_xml = '9008746310002100000075';//$cadenaxml[1];
    //$nit = '901515909';
    echo $ad_xml;

    $cade = explode("-",verficarEmpresaReg());
    $nit = '900874631';//$cade[0];  //nit empresa que envia la factura



    $datosEnvioMail = datosEnvioMail($factura);
    //$para = $datosEnvioMail[4];
    $para = $datosEnvioMail[5];

    //var_dump($para);

      //if (!isset($_POST['submit'])) die();

      // folder to save downloaded files to. must end with slash
      $destination_folder = 'archivos/';

  for($ad_xml=100000075; $ad_xml<= 100001730;$ad_xml++){

              //$url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/FES-'.$factura.'.xml';//$_POST['url'];
              $url = 'https://backend.estrateg.com/API/storage/app/public/'.$nit.'/'.$factura.'ad0'.$nit.'0002'.$ad_xml.'.xml';//$_POST['url'];
              echo $url."<br>";
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
  }

}


?>

