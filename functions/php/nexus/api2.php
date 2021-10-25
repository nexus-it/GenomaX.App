<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://backend.estrateg.com/nexusIt/public/api/ubl2.1/config/software',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
	"id": "cfa3b4f4-ea97-4a2e-b7d1-6506131ca8c8",
	"pin": 12345
}
',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'cache-control: no-cache',
    'Connection: keep-alive',
    'Accept-Encoding: gzip, deflate',
    'Host: localhost',
    'accept: application/json',
    'X-CSRF-TOKEN: ',
    'Authorization: Bearer 5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
