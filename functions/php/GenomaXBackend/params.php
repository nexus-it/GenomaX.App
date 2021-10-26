<?php
 $prefixUrl="https://backend.estrateg.com/nexusIt/public/api/ubl2.1/";
 $bearer = "4ec827f8bca31484ba62f9d54bd5fc9ab546be928f765b1eead483f8d6c7ddcb";  //AUTORIZACION TECNOWEBS

 function ValidarCUfe($nit,$prefix,$number){
    $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing");
    mysqli_query ($conexion, "SET NAMES 'utf8'");
    $cadena = explode("-",$nit);
    $sql = "SELECT * FROM `Billing`.`documents` where identification_number =".$cadena[0]." AND CUFE IS NOT NULL and prefix = '".$prefix."' and number = ".$number ;
    $result = mysqli_query($conexion, $sql);
    $datosEmp = mysqli_fetch_array($result);
    
    //return $sql;
    return $datosEmp['cufe'];
  }

?>