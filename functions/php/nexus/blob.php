<?php 


session_start();
include '../../../config.php';
$codigo=$_GET["codigo"];
$tipo=$_GET["tipo"];
include 'database.php';
$conexion=Conexion();
switch ($tipo) {
	case "users":
		$SQL="SELECT Imagen_USR, 'png' FROM itusuarios WHERE Codigo_USR='".$codigo."';";
	break;
	case "terceros":
		$SQL="SELECT Imagen_TER, FormatImg_TER FROM czterceros WHERE Codigo_TER='".$codigo."';";
	break;
	case "firmamed":
		$SQL="SELECT Firma_MED, 'jpg' FROM gxmedicos WHERE Codigo_TER='".$codigo."';";
	break;
}
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_array($result)) { 
	header("Content-type: image/".$row[1]); 
	echo $row[0]; 
} else {

}
mysqli_free_result($result); 
?>