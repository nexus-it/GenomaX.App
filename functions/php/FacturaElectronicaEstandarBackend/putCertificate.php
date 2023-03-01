<?php
//var_dump($_POST);exit();
include('params.php');
$payload= array('certificate'=>$_POST['certificado'],'password'=>$_POST['password']);
$payload = json_encode($payload);
$bearer = ValidarBearer($_POST['nit']);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'config/certificate',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>$payload,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'cache-control: no-cache',
    'Connection: keep-alive',
    'Accept-Encoding: gzip, deflate',
    'Host: localhost',
    'accept: application/json',
    'X-CSRF-TOKEN: ',
    'Authorization: Bearer '.$bearer
  ),
));

$response = curl_exec($curl);

if($errno = curl_errno($curl)) {
  $error_message = curl_strerror($errno);
  echo "cURL error ({$errno}):\n {$error_message}";
  var_dump($errno);
}

curl_close($curl);
echo $response;