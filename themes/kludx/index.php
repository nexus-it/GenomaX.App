<?php
$SQL="Select Version_DCD From itconfig";
$resultrt = mysqli_query($conexion, $SQL);
$version="0";
if ($rowrt = mysqli_fetch_array($resultrt)) {
	$version=$rowrt[0];
	$_SESSION["VERSION_CONTROL"]= $version;
}
mysqli_free_result($resultrt);
LoadHead($version);
$NoSession="";
if (isset($_GET["nxsdb"])){
	$NoSession="?nxsdb=".$_GET["nxsdb"];
}
?>
<body id="bdy_kludx" class="body-kludx">
<div class="cover_lazy" id="cvr_lazy"></div>
</body>
</html>
