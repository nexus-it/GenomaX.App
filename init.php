<?php
$_GET["suffixdb"]=$_GET["prefix"]; 
$_SESSION["DB_SUFFIX"]=strtolower ($_GET["prefix"]);
include_once  'config.php';
require_once('settings.php');
?>