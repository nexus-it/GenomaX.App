<?php
error_reporting(E_ERROR | E_PARSE);
define('DB_SUFFIX', $_SESSION['DB_SUFFIX']);
include_once  'settings/connections/nxs_gnx.php';
 
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NXS);
if (!$conexion) {
    header('Location: 404.html');
    exit;
}
$SQL="Select concat(DB_PREFIX,DB_NAME) from gnxconect where CODE_NAME='".DB_SUFFIX."' and STATE_CONN='1';";
$result0 = mysqli_query($conexion, $SQL);
if($row0 = mysqli_fetch_row($result0)) {
    define('DB_NAME',$row0[0]);
}
mysqli_free_result($result0);
?>