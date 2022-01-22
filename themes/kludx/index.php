<?php
$SQL="Select Update_DCD  From itconfig";
$resultrt = mysqli_query($conexion, $SQL);
$version="0";
if ($rowrt = mysqli_fetch_array($resultrt)) {
	$version=$rowrt[0];
	$_SESSION["VERSION_CONTROL"]= $version;
}
mysqli_free_result($resultrt);
KargarHead($version);
$NoSession="";
if (isset($_GET["nxsdb"])){
	$NoSession="?nxsdb=".$_GET["nxsdb"];
}
?>
<body id="bdy_kludx" class="body-kludx">
<?php 
	KargarFoot($version);
	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/plugins.php';
?> 
</body>
</html>
