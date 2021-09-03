<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset>
  <legend>Mis Documentos:</legend>
<div id="barradocs<?php echo $NumWindow; ?>" class="barradocs"> Agregar Documento +</div>
<table width="99%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <th width="80%" scope="col">Archivo</th>
    <th colspan="3" scope="col">Opciones</th>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</fieldset>
<fieldset>
  <legend>Documentos Compartidos:</legend>

</fieldset>
</form>