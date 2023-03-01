<?php
//var_dump($_POST);exit();
include('params.php');

if($_POST['TipoDoc'] == 1){
    $payload= array('type_document_id'=>$_POST['TipoDoc'],
                    'prefix'=>$_POST['Prefijo'],
                    'resolution'=>$_POST['Resolucion'],
                    'resolution_date'=>$_POST['FechaRes'],
                    'technical_key'=>$_POST['LlaveTecnica'],
                    'from'=>$_POST['NumDesde'],
                    'to'=>$_POST['NumHasta'],
                    'generated_to_date'=> 0,
                    'date_from'=>$_POST['FechaNumdesde'],
                    'date_to'=>$_POST['FechaNumhasta']
    );
}
if($_POST['TipoDoc'] == 4 or $_POST['TipoDoc'] == 5){
    $payload= array('type_document_id'=>$_POST['TipoDoc'],
                    'prefix'=>$_POST['Prefijo'],
                    'from'=>$_POST['NumDesde'],
                    'to'=>$_POST['NumHasta'],
                    
    );
}
$payload = json_encode($payload);
$bearer = ValidarBearer($_POST['nit']);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'config/resolution',
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

curl_close($curl);
echo $response;