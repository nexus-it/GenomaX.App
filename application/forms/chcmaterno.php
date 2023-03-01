<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
  <fieldset>
<legend>Información del Paciente:</legend>
    <label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
    <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="4" onkeypress="BuscarARE<?php echo $NumWindow; ?>(event);" />
    <label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="35" />
 <label for="cmb_cc<?php echo $NumWindow; ?>">Centro de Costo</label>
 <select name="cmb_cc<?php echo $NumWindow; ?>" id="cmb_cc<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_CCT, Nombre_CCT from czcentrocosto order by Codigo_CCT";
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
 <br />
<label for="txt_idempleado<?php echo $NumWindow; ?>">Responsable </label><input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" /><a href="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/showhelp.png"  alt="Buscar Empleado" align="absmiddle" title="Buscar Empleado" /></a> 
<input name="txt_responsable<?php echo $NumWindow; ?>" type="text" id="txt_responsable<?php echo $NumWindow; ?>" size="60" readonly="readonly" /> 
<br />
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1">Activo</option>
  <option value="0">Inactivo</option>
</select>
<br />
  </fieldset>
<?php flush; ?>
  <fieldset>
<legend>Listado de Areas:</legend>
<div id="listaareas<?php echo $NumWindow; ?>" >
Cargando...
</div>
</fieldset>
</form>

<script >
<?php
	if (isset($_GET["CodigoARE"])) {
	$SQL="Select Codigo_ARE, Nombre_ARE, Estado_ARE, Codigo_CCT, ID_TER, Nombre_TER from czareas a, czterceros b Where a.Codigo_TER=b.Codigo_TER and Codigo_ARE='".$_GET["CodigoARE"]."'";
	echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoARE"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_ARE"]."';
			document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row["Estado_ARE"]."';		
			document.frm_form".$NumWindow.".cmb_cc".$NumWindow.".value='".$row["Codigo_CCT"]."';
			document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
			document.frm_form".$NumWindow.".txt_responsable".$NumWindow.".value='".$row["Nombre_TER"]."';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarARE<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/areascz.php', '<?php echo $NumWindow; ?>', '&CodigoARE=0');
	} else {
		AbrirForm('application/forms/areascz.php', '<?php echo $NumWindow; ?>', '&CodigoARE='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  
  }
}

function ListadoAreas<?php echo $NumWindow; ?>(Destino) 
{
	$.get(Funciones,{'Func':'ListadoAreas', 'ventana':'<?php echo $NumWindow; ?>'},function(data){ 
		document.getElementById(Destino).innerHTML=data;
	}); 
}

ListadoAreas<?php echo $NumWindow; ?>('listaareas<?php echo $NumWindow; ?>');

</script>
