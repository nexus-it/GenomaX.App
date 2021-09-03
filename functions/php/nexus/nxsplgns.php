<?php
session_start();

$conexion=Conexion();
if ($_SESSION["it_CodigoPRF"]=='0') {
    $SQL="Select a.* From itplugins a Where Estado_PLG='1' Limit 3";
} else {
    $SQL="Select a.* From itplugins a, itperfilplugins b Where a.Codigo_PLG=b.Codigo_PLG and Estado_PLG='1' and Codigo_PRF='".$_SESSION["it_CodigoPRF"]."' Limit 3";
}
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) {
    include 'plugins/'.$row["Ruta_PLG"].'.php'; 
}
mysqli_free_result($result);
?>