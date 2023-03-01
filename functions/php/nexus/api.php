<?php

function llamarApi($url,$metodo,$datos,$bearer){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => $metodo,
  CURLOPT_POSTFIELDS =>json_encode($datos),
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer '.$bearer.''
  ),
));

$response = curl_exec($curl);
//var_dump($response);exit();

if($errno = curl_errno($curl)) {
  $error_message = curl_strerror($errno);
  echo "cURL error ({$errno}):\n {$error_message}";
  var_dump($errno);
}

curl_close($curl);
//echo $response;
return $response;
}



function llenarSelect($sql,$filtrado){
  $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  
    $result = mysqli_query($conexion, $sql);
    $result1 = mysqli_query($conexion, $filtrado); 
  $llenarSelect = array();
	while($row = mysqli_fetch_array($result)) {
    $llenarSelect[] = '<option value="'.$row[0].'">'.$row[1].'</option>';
  }
  if(!empty($filtrado)){
    $row = mysqli_fetch_array($result1);
    $llenarSelect[] = '<option value="'.$row[0].'" selected >'.$row[1].'</option>';
  }
  return $llenarSelect;
}

function validarRegistroEmp($nit){
  $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  $cadena = explode("-",$nit);
  $sql = "SELECT * FROM `Billing`.`companies` t1, certificates t2, software t3, users t4 where t1.id = t2.company_id and t1.id = t3.company_id and t1.user_id = t4.id and  identification_number = ".$cadena[0];
  $result = mysqli_query($conexion, $sql);
  $datosEmp = mysqli_fetch_array($result);
  
  return $datosEmp;
}

function validarRegistroEmpRes($nit){
  $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  $cadena = explode("-",$nit);
  $sql = "SELECT * FROM `Billing`.`companies` t1, resolutions t2, type_documents t3 where t1.id = t2.company_id and t2.type_document_id = t3.id and identification_number = ".$cadena[0];
  $result = mysqli_query($conexion, $sql);
    echo "<table class='table'><thead><tr>";
    echo "<td>Resolucion No</td>";
    echo "<td>Tipo</td>";
    echo "<td>Prefijo</td>";
    echo "<td>Fecha Resol</td>";
    echo "<td>Llave Tecnica</td>";
    echo "<td>Desde</td>";
    echo "<td>Hasta</td>";
    echo "</tr></thead>";
  while($datosRes = mysqli_fetch_array($result)){
    echo "<tbody><tr>";
    echo "<td>".$datosRes['resolution']."</td>";
    echo "<td>".$datosRes['name']."</td>";
    echo "<td>".$datosRes['prefix']."</td>";
    echo "<td>".$datosRes['resolution_date']."</td>";
    echo "<td>".$datosRes['technical_key']."</td>";
    echo "<td>".$datosRes['from']."</td>";
    echo "<td>".$datosRes['to']."</td>";
    echo "</tr><tbody>";
  }
  echo "</table>";

}