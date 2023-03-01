<?php
error_reporting(E_ERROR | E_PARSE);
define('DB_SUFFIX', $_SESSION['DB_SUFFIX']);
include_once  'settings/connections/nxs_gnx.php';
 
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NXS, DB_PORT);
if (!$conexion) {
    echo "Conexion fallida (settings).".$_SESSION["DB_SUFFIX"].' '.DB_HOST.' '.DB_USER.' '.DB_NXS-' '.DB_PORT;
    exit;
}
$SQL="Select concat(DB_PREFIX,DB_NAME), Codigo_APP, cdn_nxs from gnxconect, nxs_params where CODE_NAME='".DB_SUFFIX."' and STATE_CONN='1';";
// error_log("Connecting sufix: ".DB_SUFFIX);
$result0 = mysqli_query($conexion, $SQL);
if($row0 = mysqli_fetch_row($result0)) {
    define('DB_NAME',$row0[0]);
    define('NEXUS_APP',$row0[1]);
    define('NEXUS_CDN',$row0[2]);
}
mysqli_free_result($result0);
?>