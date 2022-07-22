<?php

$payload= array(
          'fechaInicial'=>$_POST['fechainicial'], 
          'fechaFinal'=>$_POST['fechafinal']);

$payload = json_encode($payload);

//print_r($payload);exit();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '181.118.153.210:8085/api-indicadores/index.php/facturacion',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$payload,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: text/plain'
  ),
));

$response = curl_exec($curl);

curl_close($curl);



echo $response;

