<?php
include('params.php');
include '../nexus/database.php';

$bearer = ValidarBearer(verficarEmpresaReg());

$curl = curl_init();

//print_r($_POST['cufe']);exit();


curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'status/document/'.$_POST['cufe'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"sendmail": false,
    "atacheddocument_name_prefix": "'.$_POST['factura'].'"
}',
CURLOPT_SSL_VERIFYPEER => false, 
  
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer '.$bearer
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
