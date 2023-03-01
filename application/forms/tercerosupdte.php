<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>"  class="form-horizontal row well well-sm">

	<div class="col-md-3">
<div class="form-group" id="grp_txt_paciente<?php echo $NumWindow; ?>"> 
  <label for="txt_paciente<?php echo $NumWindow; ?>">Documento Errado</label>
  	<div class="input-group">
  		<input required name="txt_paciente<?php echo $NumWindow; ?>"  type="text" id="txt_paciente<?php echo $NumWindow; ?>" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'czterceros');IgualID<?php echo $NumWindow; ?>();" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);IgualID<?php echo $NumWindow; ?>();" onkeydown="if(event.keyCode==115){CargarSearch('Tercero', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL')};" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Tercero" onclick="javascript:CargarSearch('Tercero', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>

	<div class="col-md-3">
<div class="form-group" id="grp_txt_paciente<?php echo $NumWindow; ?>"> 
  <label for="txt_idreal<?php echo $NumWindow; ?>">Documento Correcto</label>  		
  		<input required name="txt_idreal<?php echo $NumWindow; ?>"  type="text" id="txt_idreal<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>
	<div class="col-md-6">
<div class="form-group">
	<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre Completo</label>
	<input name="txt_paciente2<?php echo $NumWindow; ?>" type="text"   id="txt_paciente2<?php echo $NumWindow; ?>" disabled="disabled"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>


<?php flush; ?>
</form>
<script >

function seltipoid<?php echo $NumWindow; ?>(CodID, SiglaID) {
	document.getElementById('hdn_codid<?php echo $NumWindow; ?>').value = CodID;
	document.getElementById('spn_tipoid<?php echo $NumWindow; ?>').innerHTML = SiglaID;
}

function seltipoidreal<?php echo $NumWindow; ?>(CodID, SiglaID) {
	document.getElementById('hdn_codidreal<?php echo $NumWindow; ?>').value = CodID;
	document.getElementById('spn_tipoidreal<?php echo $NumWindow; ?>').innerHTML = SiglaID;
}

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	NombreTercero('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value, 'czterceros');
  }
}

function IgualID<?php echo $NumWindow; ?>() {
	document.getElementById('txt_idreal<?php echo $NumWindow; ?>').value = document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value;
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

	$("input[type=text]").addClass("nxs_<?php echo $NumWindow; ?>");
    $("textarea").addClass("nxs_<?php echo $NumWindow; ?>");
	$("select").addClass("nxs_<?php echo $NumWindow; ?>");

</script>
