<?php 
session_start();
if(isset($_SESSION["it_user"])) {
	$_GET["nxsdb"]=DB_NAME;
	header('Location: index.php?nxsdb='.$_GET["nxsdb"]);
}
include 'functions/php/nexus/database.php';
$SQL="Select Version_DCD, Plan_DCD, Update_DCD From itconfig";
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
$resultrt = mysqli_query($conexion, $SQL);
$revision="0";
if ($rowrt = mysqli_fetch_array($resultrt)) {
	$version=$rowrt[0];
	$plan=$rowrt[1];
	$revision=$rowrt[2];
	$_SESSION["VERSION_CONTROL"]= $revision;
}
mysqli_free_result($resultrt);

function listar_directorios_rutajs($ruta, $ver){
// abrir un directorio y listarlo recursivo
	$sum=0;
	if (is_dir($ruta)) {
		if ($dh = opendir($ruta)) {
			$css="";
			$js="";
			while (($file = readdir($dh)) !== false) {
				$store[$sum] = $file;
				$sum++;
			}	
			natcasesort($store);
			foreach($store as $item => $value){
				if (is_file($ruta . $value)){
					switch (substr(strrchr($value, '.'), 1)) {
					case "js":
						$js=$js.'<script src="'.$ruta.$value.'?v='.$ver.'"></script>
';
					break;
					
					}
				}
				if (is_dir($ruta . $value) && $value!="." && $value!=".."){
					listar_directorios_rutajs($ruta.$value."/", $ver);
				}
			}
			echo $css;
			echo $js;
		closedir($dh);
		}
	}else{
	echo "
	Actualizando sitio... <br> Intente mas tarde por favor. [Verificar ruta tema]";
	}
}
?>
<!DOCTYPE html>
<head>
<html lang="es">
<meta charset="utf-8"> 
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="http://cdn.genomax.co/media/image/favicon.ico">
<link rel="stylesheet" href="themes/<?php echo $_SESSION["THEME_DEFAULT"]; ?>/bower_components/bootstrap/dist/css/bootstrap.min.css?v=<?php echo $version; ?>">
<link rel="stylesheet" href="themes/<?php echo $_SESSION["THEME_DEFAULT"]; ?>/css/login.css?v=<?php echo $revision; ?>">
<link rel="stylesheet" href="themes/<?php echo $_SESSION["THEME_DEFAULT"]; ?>/bower_components/font-awesome/css/font-awesome.min.css?v=<?php echo $version; ?>">
<title>Inicio de Sesión</title>
</head>
<body>
<!-- <div class="col-md-12 col-xs-12 center-block">
	<p class="bg-danger" style="color: #FF0000;" align="center"> SITIO ACTUALIZANDO... INTENTE MAS TARDE </p>
</div> -->
<form name="frm_NiSha1" id="frm_NiSha1">
<?php
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	$SQL="Select NIT_DCD, Licencia_DCD from itconfig";
	$resultm = mysqli_query($conexion, $SQL);
	while($rowm = mysqli_fetch_array($resultm)) {
?>
<input name="hdn_ni0" type="hidden" id="hdn_ni0" value="<?php echo $rowm[0]; ?>" />
<input name="hdn_sha1" type="hidden" id="hdn_sha1" value="<?php echo $rowm[1]; ?>" />
<?php		
	}
	mysqli_free_result($resultm);
?>
</form>

<?php 
	$_GET["nxsdb"]=$_SESSION["DB_NAME"];
	echo '
	<div id="dvlgn">';
	include 'application/forms/login.php'; 
	echo '
	</div>
	<div id="dvauth">
	';
	include 'application/forms/authsecure.php'; 
	echo '</div>
	';

	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/loginjs.php';

listar_directorios_rutajs("themes/".$_SESSION["THEME_DEFAULT"]."/login/js/", $revision);
listar_directorios_rutajs("functions/js/", $revision);

?>

<script type="text/javascript">
	var div1 = document.getElementById('dvauth');
	div1.style.visibility = 'hidden';
	$("#dvlgn").show();
	nishal=$("#hdn_ni0").val();
	nisha2=$("#hdn_sha1").val();
	document.getElementById("hdn_browsername").value=BrowserDetect.browser;
	document.getElementById("hdn_browserversion").value=BrowserDetect.version;
	document.getElementById("hdn_plataforma").value=BrowserDetect.OS;
	document.getElementById("razonsocial").innerHTML ='Versión: <?php echo $version.' '.$plan.' ['.$revision.']'; ?>';
	authsecure(document.getElementById("hdn_ni0").value);
	function encrypt() {
		passl=$("#txt_loginpass").val();
		$("#txt_loginpass").attr('value', hex_md5(passl));
		$("#frm_login").submit();
	}
</script>

</body>
</html>