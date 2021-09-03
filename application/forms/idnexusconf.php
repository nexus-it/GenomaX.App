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
<legend>Configuración:</legend>
<label for="txt_maxfingerst<?php echo $NumWindow; ?>">Huellas por empleado</label>
<input name="txt_maxfingerst<?php echo $NumWindow; ?>" type="text" id="txt_maxfingerst<?php echo $NumWindow; ?>" size="2" maxlength="2" readonly="readonly" /> 
<div id="sld_maxfingers<?php echo $NumWindow; ?>"></div>
<cite>
Número de plantillas que serán guardadas para cada empleado. El empleado podrá realizar su marcación con cualquiera de éstas.</cite>
<br />
<br />
<hr align="center" width="94%" size="1" />
<br />
<label for="txt_umbralt<?php echo $NumWindow; ?>">Umbral de marcaciones</label>
<input name="txt_umbralt<?php echo $NumWindow; ?>" type="text" id="txt_umbralt<?php echo $NumWindow; ?>" size="2" maxlength="1" readonly="readonly" />
<div id="sld_umbral<?php echo $NumWindow; ?>"></div>
<cite>
Representa el tiempo, en minutos, en que diferentes marcaciones de un mismo empleado se tomarán como un solo registro.</cite>
<br /><br />
</fieldset>
<fieldset>
<legend>Tipos de Marcaciones:</legend>
<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="0" class="tblDetalle" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
  <tr>
    <th scope="col">#</th>
    <th scope="col">Descripción</th>
    <th scope="col">Tipo</th>
    <th scope="col">Estado</th>
  </tr>
<?php
	$SQL="SELECT Codigo_MRC, Nombre_MRC, Tipo_MRC, Estado_MRC FROM idtipomarcacion Order By Codigo_MRC";
	$result = mysqli_query($conexion, $SQL);
	$conta=0;
	while($row = mysqli_fetch_array($result)) {
		$conta++;
?>  
  <tr>
    <td align="center" valign="middle"><?php echo $row[0]; ?>
      <input name="hdn_codigo<?php echo $conta.$NumWindow; ?>" type="hidden" id="hdn_codigo<?php echo $conta.$NumWindow; ?>" value="<?php echo $row[0]; ?>" /></td>
    <td align="center" valign="middle"><input name="txt_descripcion<?php echo $conta.$NumWindow; ?>" type="text" value="<?php echo $row[1]; ?>" size="15" maxlength="15" id="txt_descripcion<?php echo $conta.$NumWindow; ?>" /></td>
    <td align="center" valign="middle">
      <select name="cmb_tipo<?php echo $conta.$NumWindow; ?>" id="cmb_tipo<?php echo $conta.$NumWindow; ?>">
        <option value="1" <?php if ($row[2]=="1") { echo 'selected="selected"'; } ?>>Entrada</option>
        <option value="2" <?php if ($row[2]=="2") { echo 'selected="selected"'; } ?>>Salida</option>
      </select>      
	</td>
    <td align="center" valign="middle">
      <select name="cmb_estado<?php echo $conta.$NumWindow; ?>" id="cmb_estado<?php echo $conta.$NumWindow; ?>">
        <option value="1" <?php if ($row[3]=="1") { echo 'selected="selected"'; } ?>>Activo</option>
        <option value="0" <?php if ($row[3]=="0") { echo 'selected="selected"'; } ?>>Inactivo</option>
      </select>      
    </td>
  </tr>
<?php
	}
?>
</tbody>
</table>
</fieldset>
</form>
<script>
<?php
	$SQL="Select MaxFinger_IDC, Umbral_IDC From idconfig";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
?>
$(function() {
	$( "#sld_maxfingers<?php echo $NumWindow; ?>" ).slider({
		range: "min",
		min: 1,
		max: 10,
		value: <?php echo $row[0]; ?>,
		slide: function( event, ui ) {
			$( "#txt_maxfingerst<?php echo $NumWindow; ?>" ).val( ui.value );
		}
	});
	$( "#txt_maxfingerst<?php echo $NumWindow; ?>" ).val( $( "#sld_maxfingers<?php echo $NumWindow; ?>" ).slider( "value" ) );
	
	$( "#sld_umbral<?php echo $NumWindow; ?>" ).slider({
		range: "min",
		min: 1,
		max: 5,
		value: <?php echo $row[1]; ?>,
		slide: function( event, ui ) {
			$( "#txt_umbralt<?php echo $NumWindow; ?>" ).val( ui.value );
		}
	});
	$( "#txt_umbralt<?php echo $NumWindow; ?>" ).val( $( "#sld_umbral<?php echo $NumWindow; ?>" ).slider( "value" ) );
});
<?php
	}
?>
</script>