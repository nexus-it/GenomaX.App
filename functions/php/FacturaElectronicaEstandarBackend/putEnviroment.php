<?php
include('params.php');

$bearer = ValidarBearer($_POST['nit']);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'config/environment',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
  "type_environment_id": 1,
  "payroll_type_environment_id": 1
}',
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$bearer,
    'Content-Type: application/json',
    'Accept: application/json'
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

?>

<?php
/*
//var_dump($_POST);exit();
include('params.php');

$curl = curl_init();


$bearer = ValidarBearer($_POST['nit']);

//var_dump($bearer);exit();

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'environment',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
  "type_environment_id": 1,
  "payroll_type_environment_id": 1
}',
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$bearer,
    'Content-Type: application/json',
    'Accept: application/json'
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

*/

?>