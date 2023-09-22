[<?php


session_start();
include '../../../config.php';
include 'database.php';	
$conexion=Conexion();

// recuperamos el criterio de la busqueda
$criterio = strtolower($_GET["term"]);
if (!$criterio) return;

if ($_GET["type"]=="servicios") {
	$SQL="SELECT Nombre_SER, Codigo_SER  FROM gxservicios  WHERE Estado_SER='1' ;";
}
if ($_GET["type"]=="emple") {
	$SQL="SELECT Nombre_TER, A.Codigo_TER, ID_TER FROM czterceros A, czempleados B WHERE A.Codigo_TER=B.Codigo_TER and Estado_EMP='1' and Nombre_TER like '%".$criterio."%';";
}
$result = mysqli_query($conexion, $SQL);
$json = array();
while ($row = mysqli_fetch_assoc($result)) { 
	$json[] = $row[1];
} 
mysqli_free_result($result); 
echo json_encode($json);
?>]