<?php
function listar_directorios_ruta($ruta, $ver){
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
					case "css":
						$css=$css.'<link type="text/css" href="'.$ruta.$value.'?v='.$ver.'" rel="stylesheet" />
';
					break;
					
					}
				}
				if (is_dir($ruta . $value) && $value!="." && $value!=".."){
					listar_directorios_ruta($ruta.$value."/", $ver);
				}
			}
			echo $css;
			echo $js;
		closedir($dh);
		}
	}else{
	echo "
	No es ruta valida";
	}
}
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
	No es ruta valida";
	}
}
function CargarHead($ver)
{
	include 'functions/php/nexus/database.php';
	define ('NAME_APP', $_SESSION["NOMBRE_APP"]);
	include 'functions/php/nexus/permisos.php';
	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/menu.php';
	echo '<!DOCTYPE html">
<html lang="es">
<head>
<meta charset="utf-8"> 
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="themes/'.$_SESSION["THEME_DEFAULT"].'/images/favicon.ico">
';
	listar_directorios_ruta("settings/css/", $ver);
	listar_directorios_ruta("themes/".$_SESSION['THEME_DEFAULT']."/", $ver);
	echo '
<script src="functions/js/browser.js?v='.$ver.'"></script>
<script src="functions/js/nexus.js?v='.$ver.'"></script>
<script src="functions/js/validar.js?v='.$ver.'"></script>
<script src="functions/js/highcharts.src.js?v='.$ver.'"></script>
';
include 'themes/'.$_SESSION["THEME_DEFAULT"].'/header.php';
echo '
	<title>'.$_SESSION["NOMBRE_APP"].'</title>
</head>
';
}

function LoadHead($ver)
{
	include 'functions/php/nexus/database.php';
	define ('NAME_APP', $_SESSION["NOMBRE_APP"]);
	include 'functions/php/nexus/permisos.php';
	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/menu.php';
	echo '<!DOCTYPE html">
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>'.$_SESSION["NOMBRE_APP"].'</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="themes/'.$_SESSION["THEME_DEFAULT"].'/img/favicon.ico">
  ';
	listar_directorios_ruta("settings/css/", $ver);
	/*listar_directorios_ruta("themes/".$_SESSION['THEME_DEFAULT']."/", $ver);*/
	echo '
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/css/AdminLTE.min.css">
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="themes/'.$_SESSION["THEME_DEFAULT"].'/css/klud_style.css">

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  ';
  include 'themes/'.$_SESSION["THEME_DEFAULT"].'/header.php';
  echo '
</head>
';
}

function LoadFoot($ver)
{
	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/footer.php';
listar_directorios_rutajs("themes/".$_SESSION["THEME_DEFAULT"]."/js/", $ver);
listar_directorios_rutajs("functions/js/", $ver);

echo '
<script type="text/javascript">
	NombreEmpresa("razonsocial");
	/*
	$("#MainMenu li:eq(1) a").tab("show");
	document.getElementById("ShowOptions").style.display = "none";
	HideOptions();
	ShowDashboard();
	$("#btn_AddNote").toggle();
	$("#gxtabs a:last").tab("show");
	LoadFavs();
	*/
	/* $("#gxtabs").tabCollapse(); */
	
';
CargarPlgns();
echo '
/*
document.getElementByClass("highcharts-credits").style.display = "none";
*/
</script>
</body>
</html>
';
}

function CargarFoot($ver)
{
	include 'themes/'.$_SESSION["THEME_DEFAULT"].'/footer.php';
}
function EncriptNxS()
{
	echo AddSlashes(Reverse('Ftuf!ft!fm!ufyup!efm!=c?!Bdfsdb!ef////=0c?'));
}

function Reverse($Chain)
{
	$Num=0;
	$Collar="";
	while ($Num<strlen($Chain)) {
		$Collar=$Collar.chr(ord(substr($Chain, $Num, 1))-1);
		$Num++;
	}
	return $Collar;
}

function Reverse2($Chain)
{
	$Num=0;
	$Collar="";
	while ($Num<strlen($Chain)) {
		$Num++;
		$Collar=$Collar.chr(ord(substr($Chain, $Num, 1))+1);
	}
	return $Collar;
}

function CargarPlgns()
{
	include 'nxsplgns.php'; 
}

?>