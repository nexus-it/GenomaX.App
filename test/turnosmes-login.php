<?php
session_start();
$login=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso al Sistema</title>
<style type="text/css">
<!--
body {
	background-image: url(images/background.jpg);
}
.logo {	left: 10px;
	top: 5px;
	position: absolute;
}
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
	color: #333333;
}
.Estilo2 {	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
}
.EstiloR {	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #990000;
}
.Estilo3 {	font-size: 13px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
	text-align: center;
}
.Estilo7 {
	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.Estilo9 {
	color: #003366;
	font-weight: bold;
	font-style: italic;
}
-->
</style>
<script language="javascript" type="text/javascript">
function AbreVentana() {
<?php
if (isset($_POST["txt_usuario"])) {
	$SQL="Select Codigo_PRF From itusuarios Where ID_USR='".$_POST["txt_usuario"]."' and Clave_USR='".$_POST["txt_clave"]."' and Activo_USR='1'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if ($row=mysqli_fetch_array($result)) {
		$login=1;
		$_SESSION["usu_nivel"] = $row[0];
		$_SESSION["usu_codigo"] = $_POST["txt_usuario"];
		if ($_SESSION["usu_nivel"]=='0') {
			echo 'window.location= ("turnosmes.php");
			';
		}
		else {
		//
			$SQL="Select CodArea, CodEmpre From TurnosEmple Where CodEmple='".$_POST["txt_usuario"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				echo 'window.location= ("turnosmes-view.php?txt_anyo='.date("Y").'&cmb_mes='.date("m").'&cmb_areas='.$row1[0].'&codempre='.$row1[1].'");';
			}
			mysqli_free_result($result1);
		}
	}
	else {
		$login=0;
	}
	////include "functions/desconectar.php";
}
?>
}
</script>
</head>
<body onload="javascript: AbreVentana();" >
<div align="center" class="Estilo5">
  <p>&nbsp;</p>
  <p class="Estilo3">&nbsp;</p>
  <p>&nbsp;</p>
</div>
<form id="frm_access" name="frm_access" method="post" action="">
  <div align="center">
    <p class="EstiloR">&nbsp;<?php if ($login=='0') echo '- USUARIO NO VÁLIDO -'; ?></p>
  </div>
  <table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="Estilo7">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC">
        <tr>
          <td><img src="images/jc_key.png" width="16" height="16" align="absmiddle" /> <span class="Estilo9">ACCESO AL SISTEMA </span></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#EFEFEF" class="Estilo2">
        <tr>
          <td width="50%" align="right" valign="middle"><strong>USUARIO:</strong></td>
          <td width="50%" align="left" valign="middle"><input name="txt_usuario" type="text" class="Estilo3" id="txt_usuario" size="10" /></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><strong>CLAVE:</strong></td>
          <td width="50%" align="left" valign="middle"><input name="txt_clave" type="password" class="Estilo3" id="txt_clave" size="10" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="30" bgcolor="#EFEFEF"><div align="right"><a href="javascript: document.frm_access.reset()"><img src="images/cancel.png" width="16" height="16" border="0" title="CANCELAR" /></a> 
      	<img src="images/background.jpg" width="10" height="1" border="0" /><a href="javascript:document.frm_access.submit()"><img src="images/accept.png" width="16" height="16" border="0" title="ACEPTAR" /></a></div></td>
    </tr>
  </table>
</form>
</body>
</html>
