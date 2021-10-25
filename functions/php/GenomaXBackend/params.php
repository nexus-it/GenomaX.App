<?php
 $prefixUrl="https://backend.estrateg.com/nexusIt/public/api/ubl2.1/";
 $bearer = "5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec";  //AUTORIZACION TECNOWEBS

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