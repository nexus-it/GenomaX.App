<?php 
/*
function __autoload($class) {
    include "include/$class.php";
}
public function getBlogInfo() {
        $query = $this->db->prepare("SELECT name, last_name, email, contact_no, address, salary FROM personal");
        $query->execute();

        $result = $query->fetchAll();
        return $result;
    }
$srch = new Search();
$blogInfo = $srch->getBlogInfo();
$count = count($blogInfo);

$data = array(
  'draw'=>1, 
  'recordsTotal'=>intval($count), 
  'recordsFiltered'=>intval($count), 
  'data'=>$blogInfo,
);
//send data as json format
echo json_encode($data);*/

session_start();
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt from nxs_gnx.itreports where codigo_rpt='".$_GET["nxsrpt"]."'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
    $SQL=$row[0];
    $SQL2="Select Campo_RPT From nxs_gnx.nxs_gnx.itreportsparam Where Codigo_RPT='".$_GET["nxsrpt"]."'";
    $result2 = mysqli_query($conexion, $SQL2);
    while($row2 = mysqli_fetch_row($result2)) {
    	$SQL=str_replace("@".$row2,$_GET[$row2],$SQL);
    }
	mysqli_free_result($result2);    
}
mysqli_free_result($result);

$rawdata = array();
 $i=0;
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result))
{
    $rawdata[$i] = $row;
    $i++;
}
mysqli_free_result($result);
echo json_encode($rawdata);
?>  
