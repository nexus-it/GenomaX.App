<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

$method=$_SERVER['REQUEST_METHOD'];
$file=$_GET["query"];
$index=$_GET["index"];

include $method."/".$file.".php?".$index;

//En caso de no obtener una respuesta positiva
header("HTTP/1.1 400 Bad Request");

?>