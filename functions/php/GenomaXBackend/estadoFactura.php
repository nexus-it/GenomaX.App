<?php
include('params.php');
$curl = curl_init();

$var =  trim($_POST['zipkey']);

$url = strval($prefixUrl.'status/zip/'.$var);

var_dump($url);//exit();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"sendmail": false,
    "sendmailtome": false,
    "atacheddocument_name_prefix": "SETP-"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer '.$bearer
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


