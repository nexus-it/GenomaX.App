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
<legend>Contrato:</legend>
<div class="form-group">
<label for="txt_codigo<?php echo $NumWindow; ?>">Entidad</label>
<div class="input-group">
<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="10"  onkeypress="BuscarNombreEPS<?php echo $NumWindow; ?>(event)" />
<span class="input-group-btn">
  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_codigo<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
</span>
</div>
	</div>
</fieldset>

<?php flush; ?>
<fieldset>
<legend>Cubrimiento:</legend>


<div class="form-group">
<label for="txt_planeseps<?php echo $NumWindow; ?>">Plan de Atencion</label>
<select name="txt_planeseps<?php echo $NumWindow; ?>" id="txt_planeseps<?php echo $NumWindow; ?>" onchange="BuscarPlanEPS<?php echo $NumWindow; ?>();">
  <?php 
$SQL="Select Codigo_PLA, Nombre_PLA from gxplanes order by Codigo_PLA";
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
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
<label for="txt_tarifa<?php echo $NumWindow; ?>">Tarifa</label>
	<div class="input-group">
		<input name="txt_tarifa<?php echo $NumWindow; ?>" type="text" id="txt_tarifa<?php echo $NumWindow; ?>" size="3" onkeypress="BuscarNombreTarifa<?php echo $NumWindow; ?>(event);"/>
        <span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Tarifa" onclick="javascript:CargarSearch('Tarifa', 'txt_tarifa<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		</span>
	</div>
</div>
</fieldset>
</form>
<?php flush; ?>

<script >

<?php
	if (isset($_GET["IdEPS"])) {
		echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["IdEPS"]."';
		NombreEPS('".$NumWindow."', document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value);
		document.frm_form".$NumWindow.".txt_planeseps".$NumWindow.".value='".$_GET["IdPlan"]."';";
	$SQL="Select * from gxcontratos where Codigo_EPS='".$_GET["IdEPS"]."' and Codigo_PLA='".$_GET["IdPlan"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
		document.frm_form".$NumWindow.".txt_tarifa".$NumWindow.".value='".$row["Codigo_TAR"]."';
		NombreTarifa('".$NumWindow."', document.frm_form".$NumWindow.".txt_tarifa".$NumWindow.".value);
		document.frm_form".$NumWindow.".txt_tarifa".$NumWindow.".focus()
	";
	} else {
		echo "document.frm_form".$NumWindow.".txt_planeseps".$NumWindow.".focus()";
	}
	mysqli_free_result($result); 
	} else {
		echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarNombreEPS<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AbrirForm('application/forms/cubrimientocontrato.php', '<?php echo $NumWindow; ?>', '&IdEPS='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value+'&IdPlan='+document.getElementById('txt_planeseps<?php echo $NumWindow; ?>').value);
  }
}

function BuscarPlanEPS<?php echo $NumWindow; ?>(){
	AbrirForm('application/forms/cubrimientocontrato.php', '<?php echo $NumWindow; ?>', '&IdEPS='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value+'&IdPlan='+document.getElementById('txt_planeseps<?php echo $NumWindow; ?>').value);
}

function BuscarNombreTarifa<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	NombreTarifa('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_tarifa<?php echo $NumWindow; ?>.value);
  }
}

    $("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
