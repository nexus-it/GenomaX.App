<?php
$nivel=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<SCRIPT language="JavaScript" type="text/javascript">
function ShowDiv(NombreDiv) {
	alert (NombreDiv);
	if (document.getElementById(NombreDiv).style.display=='none') {
		document.getElementById(NombreDiv).style.display='block'
		}
	else {
		document.getElementById(NombreDiv).style.display='none'
		}
}
function SwapMenu(id){
    if(document.getElementById(id).style.display=='none'){
    document.getElementById(id).style.display='';
    }else{
    document.getElementById(id).style.display='none';
    }
}
// -->
</SCRIPT>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000066;
}
body {
	background-repeat: no-repeat;
	background-color: #5C7697;
	margin-left: 1px;
	margin-top: 0px;
	margin-right: 1px;
	margin-bottom: 0px;
}
#menu {
	background-color: #FEFEFE;
	background-repeat: no-repeat;
	width: 200px;
	left: 5px;
	top: 122px;
	position: absolute;
	overflow: auto;
	bottom: 10px;
	background-image: url(file:///C|/Users/JHON%20GOMEZ/Ubuntu%20One/Dropbox/images/arbol-helado.jpg);
	background-repeat: no-repeat;
	background-position: left bottom;
	background-attachment: fixed;
}
#menu2 {
	width: 200px;
	overflow: auto;
	position: absolute;
	top: 22px;
	background-color: #FEFEFE;
	left: 5px;
}
.carpeta:hover {
	font-style: italic;
	color: #CC3300;
	font-weight: bold;
	cursor: pointer;
}
.contenido {
	position: relative;
	left: 3px;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #CC9900;
}
a:link {
	color: #000066;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000066;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
</head>
<base target="frmdestino" >
<body>
<div id="menu2"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/jc_header_menu.png" width="200" height="100" /><a href="http://localhost/jsus/procesos_la_prado/procesos/contacto.html" ><?php echo $_SERVER['PHP_SELF'];?></a>
</div>
<div id="menu">
<?php
$ruta = "files/sgc-procesos/";
function listar_directorios_ruta($ruta, $level, $id){
// abrir un directorio y listarlo recursivo
if (is_dir($ruta)) {
if ($dh = opendir($ruta)) {
	echo '
	<div id="div_'.str_replace(" ","_",str_replace("/","_",$ruta)).$level.'"'; 
	if ($level!=0) echo ' class="contenido" style="display: none"';
	echo '>';
	$level++;
while (($file = readdir($dh)) !== false) {
//esta l�nea la utilizar�amos si queremos listar todo lo que hay en el directorio
//mostrar�a tanto archivos como directorios
//echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
if (is_dir($ruta . $file) && $file!="." && $file!=".."){
//solo si el archivo es un directorio, distinto que "." y ".."
echo '
<div class="carpeta" onclick="SwapMenu(\'div_'.str_replace(" ","_",str_replace("/","_",$ruta).$file)."_".$level.'\');"><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/contract2.png" width="20" height="20" border="0" align="absmiddle" />'." $file</div>";
listar_directorios_ruta($ruta.$file."/", $level, $file);
}
if (is_file($ruta . $file)){
if ($file!="web.config") {
echo '
<div><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/article_text.png" width="16" height="16" border="0" align="absmiddle" /><a href="'.$ruta.$file.'" target="sgc-destino">'.ucwords(strtolower(substr($file, 0, strlen($file)-4)))."</a></div>";
}
}
}
	echo '
	</div>';
closedir($dh);
}
}else
echo "
No es ruta valida";
}
listar_directorios_ruta($ruta, $nivel, '');
?>
</div>
<SCRIPT language="JavaScript" type="text/javascript">
	document.getElementByClass("contenido").style.display='none';
</SCRIPT>
</body>
</html>
