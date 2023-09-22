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
<legend>Planes:</legend>

<div class="form-group">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
  <div class="input-group">
    <input class="form-control" name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="4" onkeypress="BuscarPLA<?php echo $NumWindow; ?>(event);" />
	  <span class="input-group-btn">
    	<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Planes" onclick="javascript:CargarSearch('Planes', 'txt_codigo<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  	  </span>
  </div>
</div>

<div class="form-group">
<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="35" />
</div>

<div class="form-group">
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1">Activo</option>
  <option value="0">Inactivo</option>
</select>
</div>

<br />
  </fieldset>
<?php flush; ?>
  <fieldset>
<legend>Listado de Planes:</legend>
<div id="listaplanes<?php echo $NumWindow; ?>" >
</div>
</fieldset>
</form>

<script >
ListadoPlanes('listaplanes<?php echo $NumWindow; ?>');

<?php
	if (isset($_GET["CodigoPLA"])) {
	$SQL="Select * from gxplanes Where Codigo_PLA='".$_GET["CodigoPLA"]."'";
	echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoPLA"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_PLA"]."';
			document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row["Estado_PLA"]."';		
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarPLA<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/planeseps.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/planeseps.php', '<?php echo $NumWindow; ?>', '&CodigoPLA='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

    $("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

</script>
