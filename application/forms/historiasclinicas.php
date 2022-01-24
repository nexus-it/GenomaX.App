<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target<?php echo $NumWindow; ?>" onreset="document.frm_form<?php echo $NumWindow; ?>.hdn_terceros<?php echo $NumWindow; ?>.value='<?php echo session_id(); ?>';FirmaMed<?php echo $NumWindow; ?>('white.png');">
	<div class="row well well-sm">

		<div class="col-md-1">

	<div class="form-group">
		<label for="cmb_tipoid<?php echo $NumWindow; ?>">Tipo </label>
		<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" >
		<?php 
		$SQL="Select Codigo_TID, Sigla_TID, Sigla_TID from cztipoid order by Codigo_TID";
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

		</div>
		<div class="col-md-3">

	<div class="form-group">
		<label for="txt_idempleado<?php echo $NumWindow; ?>">Identificación</label>
		<div class="input-group">	
			<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Medico" onclick="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-7">
	
	<div class="form-group">
		<label for="txt_medico<?php echo $NumWindow; ?>">Nombre Completo</label>
	  	<input name="txt_medico<?php echo $NumWindow; ?>" id="txt_medico<?php echo $NumWindow; ?>" type="text" disabled="disabled"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group">
	  <label for="txt_tp<?php echo $NumWindow; ?>">T.P. No.</label>
	  <input name="txt_tp<?php echo $NumWindow; ?>" type="text" id="txt_tp<?php echo $NumWindow; ?>" >
	</div> 

		</div>
		<div class="col-md-3">

	<div class="form-group">
	  <label for="txt_nombre1<?php echo $NumWindow; ?>">Primer Nombre</label>
	  <input name="txt_nombre1<?php echo $NumWindow; ?>" type="text"  id="txt_nombre1<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group">
	  <label for="txt_nombre2<?php echo $NumWindow; ?>">Segundo Nombre</label>
	  <input name="txt_nombre2<?php echo $NumWindow; ?>" type="text"  id="txt_nombre2<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group">
	  <label for="txt_apellido1<?php echo $NumWindow; ?>">Primer Apellido</label>
	  <input name="txt_apellido1<?php echo $NumWindow; ?>" type="text"  id="txt_apellido1<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group">
	  <label for="txt_apellido2<?php echo $NumWindow; ?>">Segundo Apellido</label>
	  <input name="txt_apellido2<?php echo $NumWindow; ?>" type="text"  id="txt_apellido2<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-4">
			
	<div class="form-group">
	  <label for="cmb_espe1<?php echo $NumWindow; ?>">Especialidad 1</label>
	  <select name="cmb_espe1<?php echo $NumWindow; ?>" id="cmb_espe1<?php echo $NumWindow; ?>">
	  	<option value="XXX">Seleccione:</option>
	<?php 
	$SQL="Select Codigo_ESP, Nombre_ESP from gxespecialidades where Estado_ESP='1' order by 2";
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

		</div>
		<div class="col-md-4">
			
	<div class="form-group">
	  <label for="cmb_espe2<?php echo $NumWindow; ?>">Especialidad 2</label>
	  <select name="cmb_espe2<?php echo $NumWindow; ?>" id="cmb_espe2<?php echo $NumWindow; ?>">
	  	<option value="XXX">Seleccione (Opcional):</option>
	<?php 
	$SQL="Select Codigo_ESP, Nombre_ESP from gxespecialidades where Estado_ESP='1' order by 2";
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

		</div>
		<div class="col-md-4">
			
	<div class="form-group">
	  <label for="cmb_espe3<?php echo $NumWindow; ?>">Especialidad 3</label>
	  <select name="cmb_espe3<?php echo $NumWindow; ?>" id="cmb_espe3<?php echo $NumWindow; ?>">
	  	<option value="XXX">Seleccione (Opcional):</option>
	<?php 
	$SQL="Select Codigo_ESP, Nombre_ESP from gxespecialidades where Estado_ESP='1' order by 2";
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

		</div>
		<div class="col-md-1">

	<div class="form-group">
	  <label for="txt_fechanac<?php echo $NumWindow; ?>">Fecha Nac</label>
	  <input name="txt_fechanac<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fechanac<?php echo $NumWindow; ?>" maxlength="10" value="00/00/0000">
	</div> 

		</div>
		<div class="col-md-2">
			
	<div class="form-group">
	  <label for="cmb_Sexo<?php echo $NumWindow; ?>">Sexo</label>
	  <select name="cmb_Sexo<?php echo $NumWindow; ?>" id="cmb_Sexo<?php echo $NumWindow; ?>">
	<?php 
	$SQL="Select Codigo_SEX, Nombre_SEX from gxtiposexo order by Codigo_SEX";
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

		</div>
		<div class="col-md-3">

<div class="form-group">
  <label for="txt_Direccion<?php echo $NumWindow; ?>">Direccion</label>
  <input type="text" name="txt_Direccion<?php echo $NumWindow; ?>" id="txt_Direccion<?php echo $NumWindow; ?>" />
</div>

		</div>
		<div class="col-md-3">

<div class="form-group">
  <label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefonos</label>
  <input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" />
</div>

		</div>
		<div class="col-md-3">

<div class="form-group">
  <label for="txt_Mail<?php echo $NumWindow; ?>">Correo</label>
  <input type="text" name="txt_Mail<?php echo $NumWindow; ?>" id="txt_Mail<?php echo $NumWindow; ?>" />
</div>

		</div>

</div>
<div class="row well well-sm">

		<div class="col-md-3">

<div class="form-group">
  <label for="txt_usuario<?php echo $NumWindow; ?>">Usuario</label>
  <div class="input-group">	
  	<input type="text" name="txt_usuario<?php echo $NumWindow; ?>" id="txt_usuario<?php echo $NumWindow; ?>" />
  	<span class="input-group-btn">	
		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Usuario" onclick="javascript:CargarSearch('UsuariosNoMed', 'txt_usuario<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
	</span>
  </div>
</div>

<div class="form-group">
  <label for="txt_pass<?php echo $NumWindow; ?>">Contraseña</label>
  <input type="password" name="txt_pass<?php echo $NumWindow; ?>" id="txt_pass<?php echo $NumWindow; ?>" />
</div>

<div class="form-group">
  <label for="txt_pass2<?php echo $NumWindow; ?>">Repetir</label>
  <input type="password" name="txt_pass2<?php echo $NumWindow; ?>" id="txt_pass2<?php echo $NumWindow; ?>" />
</div>

<div class="checkbox checkbox-success">
	<input name="chk_defpass<?php echo $NumWindow; ?>" id="chk_defpass<?php echo $NumWindow; ?>" type="checkbox" value=""  onclick="javascript:accesohc'.$NumWindow.'();" class="styled">
	<label for="chk_defpass<?php echo $NumWindow; ?>">Utilizar clave por defecto</label>
</div>
<input name="hdn_defaultpass<?php echo $NumWindow; ?>" type="hidden" id="hdn_defaultpass<?php echo $NumWindow; ?>" value="0" />

		</div>
		<div class="col-md-5">

			<label >Acceso a Historias Clínicas</label>

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive altura100" >
<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
	<th id="th1<?php echo $NumWindow; ?>">Tipo de H.C.</th> 
	<th id="th2<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></th> 
          
</tr> 
	 <?php 
	$SQL="Select Codigo_HCT, Nombre_HCT from hctipos where Activo_HCT='1' order by 2";
	$result = mysqli_query($conexion, $SQL);
	$contarow=0;
	while($row = mysqli_fetch_array($result)) 
		{
			$contarow=$contarow+1;
			echo '
	  <tr ><td><input name="hdn_tipohc'.$contarow.$NumWindow.'" type="hidden" id="hdn_tipohc'.$contarow.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td><td align="center"><div class="checkbox checkbox-success"><input name="chk_hcok'.$contarow.$NumWindow.'" id="chk_hcok'.$contarow.$NumWindow.'" type="checkbox" value=""  onclick="javascript:accesohc'.$NumWindow.'();" class="styled"><label for="chk_hcok'.$contarow.$NumWindow.'"></label></div><input name="hdn_hc'.$contarow.$NumWindow.'" type="hidden" id="hdn_hc'.$contarow.$NumWindow.'" value="0" /></td></tr>
	  ';
		}
	mysqli_free_result($result); 
	 ?>  

</tbody>
</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
 </div>

		</div>
		<div class="col-md-4">

	<div class="form-group">
	  <label for="cmb_perfil<?php echo $NumWindow; ?>">Perfil</label>
	  <select name="cmb_perfil<?php echo $NumWindow; ?>" id="cmb_perfil<?php echo $NumWindow; ?>">
	<?php 
	$SQL="Select Codigo_PRF, Nombre_PRF from itperfiles where Activo_PRF='1' order by 2";
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
	  			<label >Firma</label>

<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />
<div id="div_foto<?php echo $NumWindow; ?>" class="img-thumbnail img-responsive center-block">
<div id="div_preupload<?php echo $NumWindow; ?>" class="preuploadx" style="visibility:hidden"></div>
<div id="div_cmd<?php echo $NumWindow; ?>" class="firma_cmd" >
<img src="http://cdn.genomax.co/media/image/add-mini.png"  alt="Cambiar Foto" width="16" height="16" align="absmiddle" title="Actualizar Firma" class="pic_add" onclick="upl_file<?php echo $NumWindow; ?>.click();"/> 
<img src="http://cdn.genomax.co/media/image/remove-mini.png"  alt="Eliminar Foto" width="16" height="16" align="absmiddle" title="Eliminar Firma" class="pic_remove" onclick="KillPic('files/images/terceros/',document.getElementById('hdn_terceros<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');"/>
<input name="upl_file<?php echo $NumWindow; ?>" type="file" class="input_file_upload" id="upl_file<?php echo $NumWindow; ?>" size="1" accept="image/x-png, image/gif, image/jpeg"/ onchange="frm_form<?php echo $NumWindow; ?>.submit();startUpload('<?php echo $NumWindow; ?>', 'terceros');" >
<iframe id="upload_target<?php echo $NumWindow; ?>" style="width:0; height:0;border: 0px solid #ffffff;" name="upload_target<?php echo $NumWindow; ?>"  width="320" height="240" ></iframe>
</div></div>


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

</script>
