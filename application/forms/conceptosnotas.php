<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">

		<div class="col-md-2">

	<div class="form-group">
		<label for="txt_codigo<?php echo $NumWindow; ?>">Codigo </label>
		<div class="input-group">	
			<input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" maxlength="10" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CNotas" onclick="javascript:CargarSearch('ConceptosNotas', 'txt_codigo<?php echo $NumWindow; ?>', '');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>

		</div>
		<div class="col-md-4">

	<div class="form-group">
		<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre Concepto</label>
		<input name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" maxlength="50" />
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="txt_ccontable<?php echo $NumWindow; ?>">Cuenta Contable</label>
		<div class="input-group">	
			<input name="txt_ccontable<?php echo $NumWindow; ?>" id="txt_ccontable<?php echo $NumWindow; ?>" type="text" maxlength="10" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="CContable" onclick="javascript:CargarSearch('CuentaContable', 'txt_ccontable<?php echo $NumWindow; ?>', '');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-4">
	
	<div class="form-group">
		<label for="txt_nombrec<?php echo $NumWindow; ?>">Nombre Cuenta</label>
		<input name="txt_nombrec<?php echo $NumWindow; ?>" id="txt_nombrec<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-12">

	  <div class="row well well-sm">
		<div class="col-md-6">
	
<div class="checkbox checkbox-success">
	<input name="chk_retencion<?php echo $NumWindow; ?>" id="chk_retencion<?php echo $NumWindow; ?>" type="checkbox" value=""  onclick="javascript:accssdflt<?php echo $NumWindow; ?>();" class="styled">
	<label for="chk_retencion<?php echo $NumWindow; ?>">Aplica Retención</label>
</div>
<input name="hdn_ret<?php echo $NumWindow; ?>" type="hidden" id="hdn_ret<?php echo $NumWindow; ?>" value="0" />

	  	</div>
	  	<div class="col-md-6">

<div class="checkbox checkbox-success">
	<input name="chk_terceros<?php echo $NumWindow; ?>" id="chk_terceros<?php echo $NumWindow; ?>" type="checkbox" value=""  onclick="javascript:accssdflt<?php echo $NumWindow; ?>();" class="styled">
	<label for="chk_terceros<?php echo $NumWindow; ?>">Utilizar Terceros</label>
</div>
<input name="hdn_tercero<?php echo $NumWindow; ?>" type="hidden" id="hdn_tercero<?php echo $NumWindow; ?>" value="0" />

	  	</div>

	  	</div>
	  </div>
		
	
 

<div class="col-md-12">

	<label class="label label-default">Campos</label>
	  <div class="row well well-sm">

		<div class="col-md-2">
	
	<div class="form-group">
		<label for="txt_ncampo<?php echo $NumWindow; ?>">Nombre Campo</label>
	  	<input name="txt_ncampo<?php echo $NumWindow; ?>" id="txt_ncampo<?php echo $NumWindow; ?>" type="text" maxlength="50" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_tipo<?php echo $NumWindow; ?>">Tipo Campo</label>
	  <select name="cmb_tipo<?php echo $NumWindow; ?>" id="cmb_tipo<?php echo $NumWindow; ?>">
	  	<option value="text">TEXTO</option>
	  	<option value="textarea">AREA DE TEXTO</option>
	  	<option value="select">LISTA DE SELECCION</option>
	  	<option value="check">CUADRO DE CHEQUEO</option>
	  	<option value="check">GRUPO DE CAMPOS</option>
	  </select>

	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group">
		<label for="cmb_largo<?php echo $NumWindow; ?>">Columnas</label>
	  <select name="cmb_largo<?php echo $NumWindow; ?>" id="cmb_largo<?php echo $NumWindow; ?>">
	  	<option value="1">1</option>
	  	<option value="2">2</option>
	  	<option value="3">3</option>
	  	<option value="4">4</option>
	  	<option value="5">5</option>
	  	<option value="6">6</option>
	  	<option value="7">7</option>
	  	<option value="8">8</option>
	  	<option value="9">9</option>
	  	<option value="10">10</option>
	  	<option value="11">11</option>
	  	<option value="12">12</option>
	  </select>

	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_lineas<?php echo $NumWindow; ?>">Lineas</label>
	  	<input name="txt_lineas<?php echo $NumWindow; ?>" id="txt_lineas<?php echo $NumWindow; ?>" type="text" maxlength="1" value="1"/>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_maximo<?php echo $NumWindow; ?>">Máx. Carac.</label>
	  	<input name="txt_maximo<?php echo $NumWindow; ?>" id="txt_maximo<?php echo $NumWindow; ?>" type="text" maxlength="4"  value="50"/>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_defecto<?php echo $NumWindow; ?>">Defecto</label>
	  	<input name="txt_defecto<?php echo $NumWindow; ?>" id="txt_defecto<?php echo $NumWindow; ?>" type="text" maxlength="255" />
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="cmb_grupo<?php echo $NumWindow; ?>">Grupo</label>
	  	<select name="cmb_grupo<?php echo $NumWindow; ?>" id="cmb_grupo<?php echo $NumWindow; ?>">
	  		<option value="0">NO</option>
	  	</select>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="cmb_obligado<?php echo $NumWindow; ?>">Obligatorio</label>
	  	<select name="cmb_obligado<?php echo $NumWindow; ?>" id="cmb_obligado<?php echo $NumWindow; ?>">
	  		<option value="0">NO</option>
	  		<option value="1">SI</option>
	  	</select>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_param<?php echo $NumWindow; ?>">Parametros</label>
	  	<input name="txt_param<?php echo $NumWindow; ?>" id="txt_param<?php echo $NumWindow; ?>" type="text" maxlength="255" disabled="disabled"/>
	</div>

		</div>

		<div class="col-md-1">
	<label for="txt_param<?php echo $NumWindow; ?>">Adicionar</label>
	<button type="button" class="btn btn-success btn-block"> <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> </button>

		</div>


	  </div>
</div>

</div>
</div>
</form>

<script >

	$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
