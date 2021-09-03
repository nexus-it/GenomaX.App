<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" >
<fieldset>
<legend>Empleado:</legend>
<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />

<label for="txt_idempleado<?php echo $NumWindow; ?>">Id.</label>
<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" />
<a href="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><img src="http://cdn.genomax.co/media/image/showhelp.png"  alt="Buscar Empleado" align="absmiddle" title="Buscar Empleado" /></a>
<span id="Empleado<?php echo $NumWindow; ?>" class="nombre"></span>
</fieldset>
<?php  ?>
<fieldset>
  <legend>Historial Salarios:</legend>
  <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicio</label>
  <input name="txt_fechaini<?php echo $NumWindow; ?>" type="date" id="txt_fechaini<?php echo $NumWindow; ?>" >
<label for="txt_valor<?php echo $NumWindow; ?>">Valor Salario</label>
<input name="txt_valor<?php echo $NumWindow; ?>" type="text" id="txt_valor<?php echo $NumWindow; ?>" size="15" maxlength="15">
 <a href="javascript:AgregarFilaSalario(document.frm_form<?php echo $NumWindow; ?>.txt_fechaini<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_valor<?php echo $NumWindow; ?>.value, '<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.hdn_controw<?php echo $NumWindow; ?>.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>');"><img src="http://cdn.genomax.co/media/image/add.png" alt="Agregar al historial" align="absmiddle" title="Agregar al historial" /></a><br />
<hr align="center" width="95%" size="1"  class="anulado" />
 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord" >
<table  width="95%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
      <th id="th1<?php echo $NumWindow; ?>">Fecha Inicio</td> 
      <th id="th2<?php echo $NumWindow; ?>">Salario</td> 
      <th id="th2<?php echo $NumWindow; ?>">[ - ]</td> 
</tr> 
<?php 
	$SQL="";
	if (isset($_GET["emp"])) {
	$SQL="Select FechaIni_SLR, Valor_SLR From czsalariosemp where Codigo_TER='".$_GET["emp"]."' Order By FechaIni_SLR;";
	}
	if (isset($_GET["idemp"])) {
	$SQL="Select FechaIni_SLR, Valor_SLR From czsalariosemp a, czterceros c where c.Codigo_TER=a.Codigo_TER and ID_TER='".$_GET["idemp"]."' Order By FechaIni_SLR;";
	}
	if ($SQL!="") {
	$result = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($row = mysqli_fetch_array($result)) {
		$contarow++;
		echo '  <tr id="tr'.$contarow.$NumWindow.'">
    <td><input name="hdn_fechaini'.$contarow.$NumWindow.'" type="hidden" id="hdn_fechaini'.$contarow.$NumWindow.'" value="'.FormatoFecha($row[0]).'" />'.FormatoFecha($row[0]).'</td>
    <td><input name="hdn_valorslr'.$contarow.$NumWindow.'" type="hidden" id="hdn_valorslr'.$contarow.$NumWindow.'" value="'.$row[1].'" />'.$row[1].'</td>
    <td><a href="javascript:EliminarFilaOrden(\''.$contarow.'\',\''.$NumWindow.'\');"><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar salario del empleado" /></a></td>
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
	document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
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
	document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
	document.getElementById('Empleado".$NumWindow."').innerHTML='".$row["Nombre_TER"]."';
	";
}
mysqli_free_result($result); 
}
echo "document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".focus();";
?>

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/salariosemp.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/salariosemp.php', '<?php echo $NumWindow; ?>', '&idemp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
  }
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	
</script>