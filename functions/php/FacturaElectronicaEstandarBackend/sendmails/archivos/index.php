<?php 
set_time_limit (24 * 60 * 60);
$url='https://backend.estrateg.com/API/storage/app/public/901487514/BQ2ad09014875140002200000102.xml';
$destination_folder = 'doc/';
$newfname = $destination_folder . basename($url);

$file = fopen ($url, 'rb');
//echo "archivo = ".$file;
    if ($file) {
        $newf = fopen ($newfname, "wb");

        if ($newf)
        while(!feof($file)) {
          fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
        }
      }else{ //echo " error no encontro "; 
      }

      if ($file) {
        fclose($file);
      }

      if ($newf) {
        fclose($newf);
      }

?>