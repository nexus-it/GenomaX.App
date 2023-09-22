<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" >
<fieldset>
<legend>Empleado:</legend>
<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />

<div class="form-group">
	<label for="txt_idemplead<?php echo $NumWindow; ?>">Id.</label>
	<div class="input-group">	
		<input name="txt_idemplead<?php echo $NumWindow; ?>" id="txt_idemplead<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Empleado" onclick="javascript:CargarSearch('Empleado', 'txt_idemplead<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>

</fieldset>
<fieldset>
  <legend>Areas a las que pertenece:</legend>
  
  <input name="txt_fechaini<?php echo $NumWindow; ?>" type="text" disabled="disabled"  id="txt_fechaini<?php echo $NumWindow; ?>" size="1" maxlength="1">
  
<div class="form-group">
  <label for="cmb_cargo<?php echo $NumWindow; ?>">Area</label>
<select name="cmb_cargo<?php echo $NumWindow; ?>" id="cmb_cargo<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_ARE, Nombre_ARE from czareas where Estado_ARE='1' order by Nombre_ARE";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>
</select>
</div>

 <a href="javascript:NuevaFilaArea();"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/add.png" alt="Agregar area" align="absmiddle" title="Agregar area" /></a><br />
<hr align="center" width="95%" size="1"  class="anulado" />
 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord" >
<table  width="95%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
      <th id="th2<?php echo $NumWindow; ?>">Area</th> 
      <th id="th2<?php echo $NumWindow; ?>">[ - ]</th> 
</tr> 
<?php 
	$SQL="";
	if (isset($_GET["emp"])) {
	$SQL="Select Nombre_ARE, a.Codigo_ARE From czareasterceros a, czareas b where a.Codigo_ARE=b.Codigo_ARE and Codigo_TER='".$_GET["emp"]."' Order By Nombre_ARE;";
	}
	if (isset($_GET["idemp"])) {
	$SQL="Select Nombre_ARE, a.Codigo_ARE From czareasterceros a, czareas b, czterceros c where a.Codigo_ARE=b.Codigo_ARE and c.Codigo_TER=a.Codigo_TER and ID_TER='".$_GET["idemp"]."' Order By Nombre_ARE;";
	}
	if ($SQL!="") {
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		echo '  <tr id="tr'.$contarow.$NumWindow.'">
    <td><input name="hdn_codarea'.$contarow.$NumWindow.'" type="hidden" id="hdn_codarea'.$contarow.$NumWindow.'" value="'.$row[1].'" />'.$row[0].'</td>
    <td><a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="'.$_SESSION["NEXUS_CDN"].'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar area asignada" /></a></td>
  </tr>
';
	}
	mysqli_free_result($result); 
}
?>     
</tbody>
</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
 </div>
  
</fieldset>
</form>

<script >
<?php
if (isset($_GET["emp"])) {
$SQL="Select ID_TER, Nombre_TER from czterceros Where Codigo_TER='".$_GET["emp"]."';";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_array($result)) {
echo "
	document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$_GET["emp"]."';
	document.frm_form".$NumWindow.".txt_idemplead".$NumWindow.".value='".$row["ID_TER"]."';
	document.getElementById('Empleado".$NumWindow."').innerHTML='".$row["Nombre_TER"]."';
	";
}
mysqli_free_result($result);
}
if (isset($_GET["idemp"])) {
$SQL="Select ID_TER, Nombre_TER, Codigo_TER from czterceros Where ID_TER='".$_GET["idemp"]."';";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_array($result)) {
echo "
	document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$row["Codigo_TER"]."';
	document.frm_form".$NumWindow.".txt_idemplead".$NumWindow.".value='".$row["ID_TER"]."';
	document.getElementById('Empleado".$NumWindow."').innerHTML='".$row["Nombre_TER"]."';
	";
}
mysqli_free_result($result); 
}
echo "document.frm_form".$NumWindow.".txt_idemplead".$NumWindow.".focus();";
?>

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idemplead<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/areasemp.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/areasemp.php', '<?php echo $NumWindow; ?>', '&idemp='+document.getElementById('txt_idemplead<?php echo $NumWindow; ?>').value);
	}  
  }
}

function NuevaFilaArea() {
var combo = document.getElementById("cmb_cargo<?php echo $NumWindow; ?>");
var totfilas = document.getElementById("hdn_controw<?php echo $NumWindow; ?>");
AgregarFilaArea(combo.value, combo.options[combo.selectedIndex].text, '<?php echo $NumWindow; ?>', totfilas.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>')
}
document.getElementById('txt_fechaini<?php echo $NumWindow; ?>').style.visibility='hidden';

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

</script>