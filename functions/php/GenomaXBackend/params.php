﻿<?php



 $prefixUrl="https://backend.estrateg.com/API/public/api/ubl2.1/";
 //$bearer = "4ec827f8bca31484ba62f9d54bd5fc9ab546be928f765b1eead483f8d6c7ddcb";  //AUTORIZACION vision capital
 //$bearer = "5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec";  //AUTORIZACION TECNOWEBS


function ValidarBearer ($nit){
  ///AQUI SACO EL autorizacion y settesid de la compañia
	$conexion1 = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing","3306");
  mysqli_query ($conexion1, "SET NAMES 'utf8'");
  $cadena = explode("-",$nit);
  $sql = "SELECT api_token as bearer FROM `Billing`.`users` a, companies b where a.id = b.user_id and b.identification_number = ".  $cadena[0] ;
	
$result = mysqli_query($conexion1, $sql);
  $datosEmp = mysqli_fetch_array($result);
  //print_r($datosEmp['bearer']);exit();
return $datosEmp['bearer'];
}

function buscarid($tabla,$parametro){
  $conexion1 = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
  mysqli_query ($conexion1, "SET NAMES 'utf8'");
  $sql = "SELECT id  FROM `Billing`.`".$tabla."` where code = ".  $parametro ;
  $result = mysqli_query($conexion1, $sql);
  $dato = mysqli_fetch_array($result);
  return $dato['id'];
 
}

 function ValidarCUfe($nit,$prefix,$number){
    $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
    mysqli_query ($conexion, "SET NAMES 'utf8'");
    $cadena = explode("-",$nit);
    $sql = "SELECT * FROM `Billing`.`documents` where identification_number =".$cadena[0]." AND CUFE IS NOT NULL and prefix = '".$prefix."' and number = ".$number ;
    $result = mysqli_query($conexion, $sql);
    $datosEmp = mysqli_fetch_array($result);
    

    $sql1 = "SELECT municipality_id FROM `Billing`.`companies` where identification_number =".$cadena[0] ;
    $result1 = mysqli_query($conexion, $sql1);
    $datosEmp1 = mysqli_fetch_array($result1);

    //return $sql;
    //var_dump($sql);
    return $datosEmp['cufe']."-".$datosEmp1['municipality_id'];
  }

?>