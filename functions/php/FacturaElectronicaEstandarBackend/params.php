<?php
 $prefixUrl="https://backend.estrateg.com/API/public/api/ubl2.1/";



 function ValidarBearer ($nit){
  $cadena = explode("-",$nit);
  $sql = "SELECT api_token as bearer FROM `Billing`.`users` a, companies b where a.id = b.user_id and b.identification_number = ".  $cadena[0] ;
  error_log( $sql) ;
  ///AQUI SACO EL autorizacion y settesid de la compañia
      $conexion1 = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
    mysqli_query ($conexion1, "SET NAMES 'utf8'");
    
  $result = mysqli_query($conexion1, $sql);
    $datosEmp = mysqli_fetch_array($result);
  return $datosEmp['bearer'];
  }
    
  
   function ValidarCUfe($nit,$prefix,$number){
      $conexion = mysqli_connect("45.55.63.91", "makoto", "M@koto23*", "Billing", "3306");
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
      return $datosEmp['cufe'];//."-".$datosEmp1['municipality_id'];
    }
  
  ?>