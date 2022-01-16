<?php 
session_start();
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='".$_GET["nxsrpt"]."'";
$result = mysqli_query($conexion, $SQL);
error_log($SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $SQL2="Select Campo_RPT From nxs_gnx.itreportsparam Where Codigo_RPT='".$_GET["nxsrpt"]."'";
    $result2 = mysqli_query($conexion, $SQL2);
    while($row2 = mysqli_fetch_row($result2)) {
    	$SQL=str_replace("@".$row2[0],$_GET[$row2[0]],$SQL);
    }
	mysqli_free_result($result2);    
}
mysqli_free_result($result);

$rawdata = array();
 $i=0;
 error_log($SQL);
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result))
{
    $rawdata[$i] = $row;
    $i++;
}
mysqli_free_result($result);
//echo json_encode($rawdata);
$count = count($rawdata);

$data = array(
  'draw'=>1, 
  'recordsTotal'=>intval($count), 
  'recordsFiltered'=>intval($count), 
  'data'=>$rawdata,
);
//send data as json format
echo json_encode($data);
?>  
