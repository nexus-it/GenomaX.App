<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=users&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target<?php echo $NumWindow; ?>" onreset="document.frm_form<?php echo $NumWindow; ?>.hdn_users<?php echo $NumWindow; ?>.value='<?php echo session_id(); ?>';FotoUsu<?php echo $NumWindow; ?>('0.png');" class="container">

<div class="row">

		<div class="col-md-2">

	<div class="form-group">
	<label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
	<div class="input-group">
		<input  class="form-control" placeholder="Código" name="txt_codigo<?php echo $NumWindow; ?>" size="3" type="text" id="txt_codigo<?php echo $NumWindow; ?>" onkeypress="BuscarUsuarios<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Usuario" onclick="javascript:CargarSearch('Usuarios', 'txt_codigo<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		</span>
	</div>
	</div>

		</div>
		<div class="col-md-3">	

	<div class="form-group">
	<label for="txt_id<?php echo $NumWindow; ?>">Usuario:</label>
	    <input name="txt_id<?php echo $NumWindow; ?>" type="text" id="txt_id<?php echo $NumWindow; ?>" maxlength="50" class="form-control"/>
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group">
	<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
	<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" maxlength="120" class="form-control"/>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
	<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
	<select class="form-control" name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
	  <option value="1">Activo</option>
	  <option value="0">Inactivo</option>
	</select>
	</div>
		
		</div>
</div>

<div class="row">

		<div class="col-md-10">

			<div class="row">
				<div class="col-md-4">

	<div class="form-group">
	<label for="txt_perfil<?php echo $NumWindow; ?>">Perfil</label>
	<div class="input-group">
	  	<input name="txt_perfil<?php echo $NumWindow; ?>" type="text" id="txt_perfil<?php echo $NumWindow; ?>" class="form-control" size="3"  onkeypress="BuscarPerfiles<?php echo $NumWindow; ?>(event);" class="form-control"/>
	  	<span class="input-group-btn">
	  		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Perfil de usuario" onclick="javascript:CargarSearch('Perfiles', 'txt_perfil<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		</span>
	</div>
	</div>

				</div>
				<div class="col-md-8">
	<label for="txt_nombreperfil<?php echo $NumWindow; ?>">Descripción</label>
	<input name="txt_nombreperfil<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_nombreperfil<?php echo $NumWindow; ?>" size="35" class="form-control"/>
	
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">

	<div class="form-group">
	<label for="txt_email<?php echo $NumWindow; ?>">Correo</label>
  	<input name="txt_email<?php echo $NumWindow; ?>" type="email" id="txt_email<?php echo $NumWindow; ?>" size="20" class="form-control"/>
  	</div>

  				</div>
  				<div class="col-md-4">
  
  <div class="checkbox checkbox-success">
	<input name="chk_defpass<?php echo $NumWindow; ?>" id="chk_defpass<?php echo $NumWindow; ?>" type="checkbox" value=""  onclick="javascript:accssdflt<?php echo $NumWindow; ?>();" class="styled">
	<label for="chk_defpass<?php echo $NumWindow; ?>">Utilizar clave por defecto</label>
</div>
<input name="hdn_defaultpass<?php echo $NumWindow; ?>" type="hidden" id="hdn_defaultpass<?php echo $NumWindow; ?>" value="0" />

  				</div>
  			</div>

		</div>
		<div class="col-md-2">
<?php flush; ?>
  
	<input name="hdn_users<?php echo $NumWindow; ?>" type="hidden" id="hdn_users<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />
	<div id="div_foto<?php echo $NumWindow; ?>" class="foto_perfil">
	<div id="div_preupload<?php echo $NumWindow; ?>" class="preupload" style="visibility:hidden"></div>
	<div id="div_cmd<?php echo $NumWindow; ?>" class="foto_cmd" >
	<img src="http://cdn.genomax.co/media/image/icons/16x16/add.png"  alt="Cambiar Foto" width="16" height="16" align="absmiddle" title="Actualizar Foto" class="pic_add" onclick="upl_file<?php echo $NumWindow; ?>.click();"/> 
	<img src="http://cdn.genomax.co/media/image/icons/16x16/delete.png"  alt="Eliminar Foto" width="16" height="16" align="absmiddle" title="Eliminar Foto" class="pic_remove" onclick="KillPic('files/images/users/',document.getElementById('hdn_users<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');"/>
	<input name="upl_file<?php echo $NumWindow; ?>" type="file" class="input_file_upload" id="upl_file<?php echo $NumWindow; ?>" size="1" accept="image/x-png, image/gif, image/jpeg"/ onchange="frm_form<?php echo $NumWindow; ?>.submit();startUpload('<?php echo $NumWindow; ?>', 'users');" >
	<iframe id="upload_target<?php echo $NumWindow; ?>" style="width:0; height:0;border: 0px solid #ffffff;" name="upload_target<?php echo $NumWindow; ?>" width="320" height="240" ></iframe>
  </div></div>

		</div>
</div>

<div id="div_firma<?php echo $NumWindow; ?>" class="firma_perfil col-md-7">
<div id="div_preupload2<?php echo $NumWindow; ?>" class="preupload" style="visibility:hidden"></div>
<div id="div_cmd2<?php echo $NumWindow; ?>" class="firma_cmd" >
<img src="http://cdn.genomax.co/media/image/icons/16x16/pencil_add.png"  alt="Capturar Firma" width="16" height="16" align="absmiddle" title="Capturar Firma" class="pic_capt" onclick="CargarForm('application/forms/capturecanvas.php', 'Firma Usuario');"/> 
<img src="http://cdn.genomax.co/media/image/icons/16x16/add.png"  alt="Cambiar Firma" width="16" height="16" align="absmiddle" title="Actualizar Firma" class="pic_add" onclick="upl_file2<?php echo $NumWindow; ?>.click();"/> 
<img src="http://cdn.genomax.co/media/image/icons/16x16/delete.png"  alt="Borrar Firma" width="16" height="16" align="absmiddle" title="Eliminar Firma" class="pic_remove" onclick="KillFirma('files/images/users/',document.getElementById('hdn_users<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');"/>
<input name="upl_file2<?php echo $NumWindow; ?>" type="file" class="input_file_upload2" id="upl_file2<?php echo $NumWindow; ?>" size="1" accept="image/x-png, image/gif, image/jpeg"/ onchange="frm_form<?php echo $NumWindow; ?>.submit();startUpload2('<?php echo $NumWindow; ?>', 'users');" >
<iframe id="upload_target2<?php echo $NumWindow; ?>" style="width:0; height:0;border: 0px solid #ffffff;" name="upload_target2<?php echo $NumWindow; ?>" width="320" height="240" ></iframe>
</div></div>
  
</form>
<script >
<?php
	if (isset($_GET["CodigoUSU"])) {
	$SQL="Select * from itusuarios Where Codigo_USR='".$_GET["CodigoUSU"]."' and Codigo_USR<>'0'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
		    document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoUSU"]."';
			document.frm_form".$NumWindow.".txt_id".$NumWindow.".value='".$row["ID_USR"]."';
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".($row["Nombre_USR"])."';
			document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row["Activo_USR"]."';
			document.frm_form".$NumWindow.".txt_perfil".$NumWindow.".value='".$row["Codigo_PRF"]."';
			document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Email_USR"]."';
     		document.frm_form".$NumWindow.".hdn_users".$NumWindow.".value='".$row["Codigo_USR"]."';				
			NombrePerfil".$NumWindow."();
			document.getElementById('div_foto".$NumWindow."').style.backgroundImage='url(functions/php/nexus/blob.php?codigo=".$row["Codigo_USR"]."&tipo=users)';
			document.frm_form".$NumWindow.".chk_reset".$NumWindow.".disabled = false;
			document.frm_form".$NumWindow.".chk_reset".$NumWindow.".checked = false;
			document.frm_form".$NumWindow.".chk_reset".$NumWindow.".value='0';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_id".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>
document.getElementById("div_preupload<?php echo $NumWindow; ?>").style.visibility = 'hidden';

function BuscarUsuarios<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/usuarios.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/usuarios.php', '<?php echo $NumWindow; ?>', '&CodigoUSU='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarPerfiles<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombrePerfil<?php echo $NumWindow; ?>();
  }
}

function NombrePerfil<?php echo $NumWindow; ?>() {
	Codigo=document.getElementById('txt_perfil<?php echo $NumWindow; ?>').value;
	$.get(Funciones,{'Func':'NombrePerfil','value':Codigo},function(data){ 
		document.getElementById('txt_nombreperfil<?php echo $NumWindow; ?>').value=data;
	}); 
}

function FotoUsu<?php echo $NumWindow; ?>(user) {
	document.getElementById("div_foto<?php echo $NumWindow; ?>").style.backgroundImage="url(files/images/users/"+user+")"
}


</script>