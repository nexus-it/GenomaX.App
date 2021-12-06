<?php
include('params.php');
include '../nexus/database.php';

$sql = "update gxfacturas Set IdFE_FAC='".$_POST['cufe']."' where codigo_fac='".$_POST['factura']."';";
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
mysqli_query ($conexion, $sql);
if ($_POST['cufe']!="0") {
  $bearer = ValidarBearer(verficarEmpresaReg());

  $curl = curl_init();


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
} else {
  echo 'Documento con errores en campos mandatorios';
}
