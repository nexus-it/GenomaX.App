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
<legend>Cargos:</legend>
    
<div class="form-group">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
    <div class="input-group">	
    	<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="4" onkeypress="BuscarCRG<?php echo $NumWindow; ?>(event);" />
    	<span class="input-group-btn">	
    		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Cargos" onclick="javascript:CargarSearch('Cargos', 'txt_nombre<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
    	</span>
    </div>
 </div>

<div class="form-group">
<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>"  />
</div>

<div class="form-group">
 <label for="cmb_nivel<?php echo $NumWindow; ?>">Nivel</label>
 <select name="cmb_nivel<?php echo $NumWindow; ?>" id="cmb_nivel<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_NVL, Nombre_NVL, Nivel_NVL from czcargosniveles Where Estado_NVL='1' Order by Nivel_NVL";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>  
 </select> <br />
</div>

<div class="form-group">
<label for="txt_decripcion<?php echo $NumWindow; ?>">Descripción </label>
<input name="txt_decripcion<?php echo $NumWindow; ?>" type="text" id="txt_decripcion<?php echo $NumWindow; ?>" size="40" />
</div>

<div class="form-group">
<label for="cmb_area<?php echo $NumWindow; ?>">Area</label>
<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>">
  <?php 
$SQL="Select Codigo_ARE, Nombre_ARE from czareas Where Estado_ARE='1' Order by Nombre_ARE";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
  <?php
	}
mysqli_free_result($result); 
 ?>
</select><br />
</div>

<div class="form-group">
<label for="cmb_depende<?php echo $NumWindow; ?>">Dependencia</label>
<select name="cmb_depende<?php echo $NumWindow; ?>" id="cmb_depende<?php echo $NumWindow; ?>">
  <?php 
$SQL="Select Codigo_CRG, Nombre_CRG from czcargos Where Estado_CRG='1' Order by Nombre_CRG";
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

<div class="form-group">
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1">Activo</option>
  <option value="0">Inactivo</option>
</select><br />
</div>


  </fieldset>
<?php flush; ?>
  <fieldset>
<legend>Listado de Cargos:</legend>
<div id="listacargos<?php echo $NumWindow; ?>" >
Cargando...
</div>
</fieldset>
</form>

<script >
<?php
	if (isset($_GET["CodigoCRG"])) {
	$SQL="Select Codigo_CRG, Nombre_CRG, Estado_CRG, Codigo_NVL, Descripcion_CRG, Dependencia_CRG, Codigo_ARE from czcargos a Where Codigo_CRG='".$_GET["CodigoCRG"]."'";
	echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoCRG"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_CRG"]."';
			document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row["Estado_CRG"]."';		
			document.frm_form".$NumWindow.".cmb_nivel".$NumWindow.".value='".$row["Codigo_NVL"]."';
			document.frm_form".$NumWindow.".txt_decripcion".$NumWindow.".value='".$row["Descripcion_CRG"]."';
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".value='".$row["Codigo_ARE"]."';
			document.frm_form".$NumWindow.".cmb_depende".$NumWindow.".value='".$row["Dependencia_CRG"]."';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarCRG<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/cargos.php', '<?php echo $NumWindow; ?>', '&CodigoCRG=0');
	} else {
		AbrirForm('application/forms/cargos.php', '<?php echo $NumWindow; ?>', '&CodigoCRG='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  
  }
}

function ListadoCargos<?php echo $NumWindow; ?>(Destino) 
{
	$.get(Funciones,{'Func':'ListadoCargos', 'ventana':'<?php echo $NumWindow; ?>'},function(data){ 
		document.getElementById(Destino).innerHTML=data;
	}); 
}

ListadoCargos<?php echo $NumWindow; ?>('listacargos<?php echo $NumWindow; ?>');

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>