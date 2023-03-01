<?php
include('params.php');
include 'consultas.php';

if($_POST['cufe']){
  $cufe = $_POST['cufe'];
}else{
$nit = verficarEmpresaReg();
//echo $nit;exit();

$string = $_POST['factura'];
		
$number = preg_replace('/[^0-9]/', '', $string);
$cadena = explode($number,$string);
$prefix = $cadena[0];
$cufe = ValidarCUfe($nit,$prefix ,$number);
}
//echo "cufe = ".$cufe;exit();
//echo "prefix = ".$prefix;exit();
//echo "number = ".$number;exit();
$conexion = mysqli_connect("localhost","root", "Tg@82071560763", "php_factura_shaima");
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "update factura_orden Set cufe='".$cufe."' where order_id='".$number."' and order_prefix='".$prefix."' ;";

$resultH = mysqli_query($conexion, $SQL);

//echo $SQL;exit();
if ($cufe!="0") {
  $bearer = ValidarBearer(verficarEmpresaReg());

  //echo "bearer = ".$bearer;exit();
  //echo $prefixUrl.'status/document/'.$cufe;exit();

  $curl = curl_init();


  curl_setopt_array($curl, array(
    CURLOPT_URL => $prefixUrl.'status/document/'.$cufe,
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
  ob_end_clean();
  curl_close($curl);
  echo $response;
} else {
  echo 'Documento con errores en campos mandatorios';
}
