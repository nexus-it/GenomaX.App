<?php 

function llenarSelect($sql,$bd){
  $conexion = mysqli_connect("127.0.0.1", "gnx", "Clave12345*", $bd);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  $result = mysqli_query($conexion, $sql);
  $llenarSelect = array();
	while($row = mysqli_fetch_array($result)) {
    $llenarSelect[] = $row[1]." -- ".$row[2];//'<option value="'.$row[0].'">'.$row[1].' - '.$row[2].'</option>';
  }
  //echo json_encode($llenarSelect);
  return json_encode($llenarSelect);
}

function verficarEmpresaReg(){
  $conexion = mysqli_connect("127.0.0.1", "gnx", "Clave12345*", "php_factura_shaima");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  $SQL="Select  NIT_DCD from itconfig";
  $resultadoEmp = mysqli_query($conexion, $SQL);
  if ($rowEmp = mysqli_fetch_row($resultadoEmp)) {
     $nitEmp = $rowEmp[0]; 
  }
  return $nitEmp;
  //error_log($nitEmp);
}

function datosEnvioMail($factura){
  $conexion = mysqli_connect("127.0.0.1", "gnx", "Clave12345*", "php_factura_shaima");
	mysqli_query ($conexion, "SET NAMES 'utf8'");
  $SQL = "SELECT * FROM factura_orden t1, factura_clientes t2 , factura_usuarios t3, factura_companies t4
  where t1.order_receiver_nit = concat(t2.identification_number,'-',t2.dv)
  AND t1.user_id = t3.id
  AND t3.id = t4.user_id
   and CONCAT(t1.order_prefix,'',t1.order_id) = '$factura'";
  $resultadoEmp = mysqli_query($conexion, $SQL);
  if ($rowEmp = mysqli_fetch_array($resultadoEmp)) {
     return $rowEmp;
  }
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" />
