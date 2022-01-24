<?php	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	$rndm=uniqid();
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data" target="upload_target<?php echo $NumWindow; ?>" onreset="document.frm_form<?php echo $NumWindow; ?>.hdn_terceros<?php echo $NumWindow; ?>.value='<?php echo session_id(); ?>';FirmaMed<?php echo $NumWindow; ?>('white.png');">
	<div class="row">

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

	<div class="form-group" >
		<label for="txt_idempleado<?php echo $NumWindow; ?>">Identificación</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" onblur="BuscarEmp2<?php echo $NumWindow; ?>();" required/>
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Medico" onclick="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-7">
	
	<div class="form-group">
		<label for="txt_nommedico<?php echo $NumWindow; ?>">Nombre Completo</label>
	  	<input name="txt_nommedico<?php echo $NumWindow; ?>" id="txt_nommedico<?php echo $NumWindow; ?>" type="text" disabled="disabled"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_tp<?php echo $NumWindow; ?>">
	  <label for="txt_tp<?php echo $NumWindow; ?>">T.P. No.</label>
	  <input name="txt_tp<?php echo $NumWindow; ?>" type="text" id="txt_tp<?php echo $NumWindow; ?>" required>
	</div> 

		</div>
		<div class="col-md-3">

	<div class="form-group" id="grp_txt_nombre1<?php echo $NumWindow; ?>">
	  <label for="txt_nombre1<?php echo $NumWindow; ?>">Primer Nombre</label>
	  <input name="txt_nombre1<?php echo $NumWindow; ?>" type="text"  id="txt_nombre1<?php echo $NumWindow; ?>"  required>
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group">
	  <label for="txt_nombre2<?php echo $NumWindow; ?>">Segundo Nombre</label>
	  <input name="txt_nombre2<?php echo $NumWindow; ?>" type="text"  id="txt_nombre2<?php echo $NumWindow; ?>"  >
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group" id="grp_txt_apellido1<?php echo $NumWindow; ?>">
	  <label for="txt_apellido1<?php echo $NumWindow; ?>">Primer Apellido</label>
	  <input name="txt_apellido1<?php echo $NumWindow; ?>" type="text"  id="txt_apellido1<?php echo $NumWindow; ?>"  required>
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
		<div class="col-md-2">

	<div class="form-group">
	  <label for="txt_fechanac<?php echo $NumWindow; ?>">Fecha Nac</label>
	  <input name="txt_fechanac<?php echo $NumWindow; ?>" type="date" id="txt_fechanac<?php echo $NumWindow; ?>"  value="00/00/0000">
	</div> 

		</div>
		<div class="col-md-1">
			
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

		<div class="col-md-2">

<div class="form-group" id="grp_txt_usuario<?php echo $NumWindow; ?>">
  <label for="txt_usuario<?php echo $NumWindow; ?>">Usuario</label>
  <div class="input-group">	
  	<input type="text" name="txt_usuario<?php echo $NumWindow; ?>" id="txt_usuario<?php echo $NumWindow; ?>" required/>
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
	<input name="chk_defpass<?php echo $NumWindow; ?>" id="chk_defpass<?php echo $NumWindow; ?>" type="checkbox" value=""  onclick="javascript:accssdflt<?php echo $NumWindow; ?>();" class="styled">
	<label for="chk_defpass<?php echo $NumWindow; ?>"><small>Utilizar clave por defecto</small></label>
</div>
<input name="hdn_defaultpass<?php echo $NumWindow; ?>" type="hidden" id="hdn_defaultpass<?php echo $NumWindow; ?>" value="0" />

		</div>
		<div class="col-md-2">

			<label >Acceso a Areas</label>

 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive altura100" >
<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<tr id="trh<?php echo $NumWindow; ?>"> 
	<th id="th1<?php echo $NumWindow; ?>">Nombre Area</th> 
	<th id="th2<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></th> 
          
</tr> 
	 <?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' order by 2";
	$result = mysqli_query($conexion, $SQL);
	$contaare=0;
	while($row = mysqli_fetch_array($result)) 
		{
			$contaare=$contaare+1;
			echo '
	  <tr ><td><input name="hdn_area'.$contaare.$NumWindow.'" type="hidden" id="hdn_area'.$contaare.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td><td align="center"><div class="checkbox checkbox-success"><input name="chk_areaok'.$contaare.$NumWindow.'" id="chk_areaok'.$contaare.$NumWindow.'" type="checkbox" value=""  onclick="javascript:accesoarea'.$NumWindow.'(\''.$contaare.'\');" class="styled"><label for="chk_areaok'.$contaare.$NumWindow.'"></label></div><input name="hdn_areaa'.$contaare.$NumWindow.'" type="hidden" id="hdn_areaa'.$contaare.$NumWindow.'" value="0" /></td></tr>
	  ';
		}
	mysqli_free_result($result); 
	 ?>  

</tbody>
</table><input name="hdn_contare<?php echo $NumWindow; ?>" type="hidden" id="hdn_contare<?php echo $NumWindow; ?>" value="<?php echo $contaare; ?>" />
 </div>
<input name="hdn_accesosareas<?php echo $NumWindow; ?>" type="hidden" id="hdn_accesosareas<?php echo $NumWindow; ?>" value="" />
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
	$SQL="Select Codigo_HCT, Descripcion_HCT from hctipos where Activo_HCT='1' order by 2";
	$result = mysqli_query($conexion, $SQL);
	$contatipohc=0;
	while($row = mysqli_fetch_array($result)) 
		{
			$contatipohc=$contatipohc+1;
			echo '
	  <tr ><td><input name="hdn_tipohc'.$contatipohc.$NumWindow.'" type="hidden" id="hdn_tipohc'.$contatipohc.$NumWindow.'" value="'.$row[0].'" />'.$row[1].'</td><td align="center"><div class="checkbox checkbox-success"><input name="chk_hcok'.$contatipohc.$NumWindow.'" id="chk_hcok'.$contatipohc.$NumWindow.'" type="checkbox" value=""  onclick="javascript:accesohc'.$NumWindow.'(\''.$contatipohc.'\');" class="styled"><label for="chk_hcok'.$contatipohc.$NumWindow.'"></label></div><input name="hdn_hct'.$contatipohc.$NumWindow.'" type="hidden" id="hdn_hct'.$contatipohc.$NumWindow.'" value="0" /></td></tr>
	  ';
		}
	mysqli_free_result($result); 
	 ?>  

</tbody>
</table><input name="hdn_conttipohc<?php echo $NumWindow; ?>" type="hidden" id="hdn_conttipohc<?php echo $NumWindow; ?>" value="<?php echo $contatipohc; ?>" />
 </div>
<input name="hdn_formatoshc<?php echo $NumWindow; ?>" type="hidden" id="hdn_formatoshc<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-3">

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
	  			<label >Firma / Sello</label>
<input name="hdn_firmas<?php echo $NumWindow; ?>" type="hidden" id="hdn_firmas<?php echo $NumWindow; ?>" value="<?php echo session_id().$rndm; ?>" />
<input name="hdn_jpg<?php echo $NumWindow; ?>" type="hidden" id="hdn_jpg<?php echo $NumWindow; ?>" value="" />

<div id="div_firmas<?php echo $NumWindow; ?>" class="img-thumbnail img-responsive center-block" style="background-repeat: no-repeat;background-position: center; background-size: contain; height: 136px;" onclick="LoadImage<?php echo $NumWindow; ?>();" >

<!-- <div id="div_firmas<?php echo $NumWindow; ?>" class="img-thumbnail img-responsive center-block" style="background-repeat: no-repeat;background-position: center; background-size: contain; height: 136px;" onclick="NxsCanvasEdit('Firma / Sello', 'div_firmas<?php echo $NumWindow; ?>', 'medicos.php', '<?php echo $NumWindow; ?>');" data-toggle="modal" data-target="#GnmX_WinModal"> -->

	<div id="div_preupload2<?php echo $NumWindow; ?>" class="preuploadx" style="visibility:hidden"></div>
	<input name="nxs_filez<?php echo $NumWindow; ?>" type="file" class="input_file_upload" id="nxs_filez<?php echo $NumWindow; ?>" size="1" accept="image/x-png, image/gif, image/jpeg" style="width: 1px; height: 1px;" style="visibility:hidden" onclick="LoadImage<?php echo $NumWindow; ?>();">

</div>
		    </div>
		</div>

 </div>
 
</div>

</form>

<script >
document.getElementById("div_preupload2<?php echo $NumWindow; ?>").style.visibility = 'visible';
var Uploading="functions/php/nexus/nxsupld.php";

function LoadImage<?php echo $NumWindow; ?>() {
	document.getElementById('nxs_filez<?php echo $NumWindow; ?>').click();
}
//FotoEmp<?php echo $NumWindow; ?>('0.png');
<?php
	if (isset($_GET["IdEmp"])) {
		$CodigoTER="0";
		$CodigoUSR="X";
		$SQL="Select * from czempleados a, czterceros b where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["IdEmp"]."'";
		$result = mysqli_query($conexion, $SQL);
		echo "
document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$_GET["IdEmp"]."';";
		if($row = mysqli_fetch_array($result)) {
			echo "
			document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".value='".$row["Codigo_TID"]."';
			document.frm_form".$NumWindow.".hdn_jpg".$NumWindow.".value='';
			document.frm_form".$NumWindow.".txt_nommedico".$NumWindow.".value='".$row["Nombre_TER"]."';
			document.frm_form".$NumWindow.".txt_nombre1".$NumWindow.".value='".$row["Nombre1_EMP"]."';
			document.frm_form".$NumWindow.".txt_nombre2".$NumWindow.".value='".$row["Nombre2_EMP"]."';
			document.frm_form".$NumWindow.".txt_apellido1".$NumWindow.".value='".$row["Apellido1_EMP"]."';
			document.frm_form".$NumWindow.".txt_apellido2".$NumWindow.".value='".$row["Apellido2_EMP"]."';
			document.frm_form".$NumWindow.".txt_Mail".$NumWindow.".value='".$row["Correo_TER"]."';
			document.frm_form".$NumWindow.".cmb_Sexo".$NumWindow.".value='".$row["Codigo_SEX"]."';
			document.frm_form".$NumWindow.".txt_fechanac".$NumWindow.".value='".($row["FechaNac_EMP"])."';
			document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
			document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
			document.frm_form".$NumWindow.".hdn_firmas".$NumWindow.".value='".$row["Codigo_TER"]."';	
			
			";
			$CodigoTER=$row["Codigo_TER"];
		}
		mysqli_free_result($result); 
		$SQL="Select * from gxmedicos where Codigo_TER='".$CodigoTER."'";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
			//Extraigo la firma de la bd
			$urly= explode('application/forms/medicos.php', $_SERVER['REQUEST_URI'], 2);
			$urljpg='http://'.$_SERVER["SERVER_NAME"] .$urly[0].'files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/hc/'.$row["Codigo_TER"].$rndm.'.jpg';
			$LeFirma='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/hc/'.$row["Codigo_TER"].$rndm.'.jpg';
			$LeFirma2='files/'.$_SESSION["DB_SUFFIX"].'/upload/images/firmas/hc/'.$row["Codigo_TER"].$rndm.'.jpg';
			// Imagen en directorio temporal
			$imgtemp='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/'.session_id().$rndm.'.jpg';
			//Se crea la carpeta si no existe...
			$RutaSESSION='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session';
			if (!(is_dir($RutaSESSION))) {
				mkdir ($RutaSESSION, 0777);
			}
			file_put_contents($LeFirma, $row["Firma_MED"]);
			if(is_file($imgtemp)) {
				unlink($imgtemp);
			}
			file_put_contents($imgtemp, $row["Firma_MED"]);

			echo "
			document.frm_form".$NumWindow.".txt_tp".$NumWindow.".value='".$row["RM_MED"]."';
			";
			echo "
			document.getElementById('div_firmas".$NumWindow."').style.backgroundImage='url(".$urljpg.")';
			";

			$CodigoUSR=$row["Codigo_USR"];
		}
		mysqli_free_result($result); 
		$SQL="Select * from gxmedicosesp where Codigo_TER='".$CodigoTER."'";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) {
			echo "
			document.frm_form".$NumWindow.".cmb_espe".$row["Tipo_ESP"].$NumWindow.".value='".$row["Codigo_ESP"]."';
			";
		}
		mysqli_free_result($result); 
		$SQL="Select * from itusuarios where Codigo_USR='".$CodigoUSR."'";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
			echo "
			document.frm_form".$NumWindow.".txt_usuario".$NumWindow.".value='".$row["ID_USR"]."';
			document.frm_form".$NumWindow.".cmb_perfil".$NumWindow.".value='".$row["Codigo_PRF"]."';
			document.frm_form".$NumWindow.".txt_pass".$NumWindow.".disabled='true';
			document.frm_form".$NumWindow.".txt_pass2".$NumWindow.".disabled='true';
			document.frm_form".$NumWindow.".chk_defpass".$NumWindow.".disabled='true';
			";

			$CodigoUSR=$row["Codigo_USR"];
		}
		mysqli_free_result($result); 
		$SQL="Select * from hcusuarioshc where Codigo_USR='".$CodigoUSR."'";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) {
			$contador=1; 
			while($contador <= $contatipohc) { 
				echo "
				if (document.frm_form".$NumWindow.".hdn_tipohc".$contador.$NumWindow.".value=='".$row["Codigo_HCT"]."') {
					document.frm_form".$NumWindow.".hdn_hct".$contador.$NumWindow.".value='1';
					document.frm_form".$NumWindow.".chk_hcok".$contador.$NumWindow.".checked='true';
				}
				";
				$contador=$contador+1;
			}
		}
		mysqli_free_result($result); 
		$SQL="Select * from itusuariosareas where Codigo_USR='".$CodigoUSR."'";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) {
			$contador=1; 
			while($contador <= $contaare) { 
				echo "
				if (document.frm_form".$NumWindow.".hdn_area".$contador.$NumWindow.".value=='".$row["Codigo_ARE"]."') {
					document.frm_form".$NumWindow.".hdn_areaa".$contador.$NumWindow.".value='1';
					document.frm_form".$NumWindow.".chk_areaok".$contador.$NumWindow.".checked='true';
				}
				";
				$contador=$contador+1;
			}
		}
		mysqli_free_result($result); 

	}
?>
document.getElementById("div_preupload2<?php echo $NumWindow; ?>").style.visibility = 'hidden';

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/medicos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/medicos.php', '<?php echo $NumWindow; ?>', '&IdEmp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarEmp2<?php echo $NumWindow; ?>() {
  	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/medicos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/medicos.php', '<?php echo $NumWindow; ?>', '&IdEmp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
}

function accssdflt<?php echo $NumWindow; ?>() {
	document.frm_form<?php echo $NumWindow; ?>.txt_pass<?php echo $NumWindow; ?>.value='123456';
	document.frm_form<?php echo $NumWindow; ?>.txt_pass2<?php echo $NumWindow; ?>.value='123456';
	if (document.frm_form<?php echo $NumWindow; ?>.hdn_defaultpass<?php echo $NumWindow; ?>.value=='1') {
		document.frm_form<?php echo $NumWindow; ?>.hdn_defaultpass<?php echo $NumWindow; ?>.value='0';
		document.frm_form<?php echo $NumWindow; ?>.txt_pass<?php echo $NumWindow; ?>.disabled=false;
		document.frm_form<?php echo $NumWindow; ?>.txt_pass2<?php echo $NumWindow; ?>.disabled=false;
	} else {
		document.frm_form<?php echo $NumWindow; ?>.hdn_defaultpass<?php echo $NumWindow; ?>.value='1';
		document.frm_form<?php echo $NumWindow; ?>.txt_pass<?php echo $NumWindow; ?>.disabled=true;
		document.frm_form<?php echo $NumWindow; ?>.txt_pass2<?php echo $NumWindow; ?>.disabled=true;
	}
}

function accesohc<?php echo $NumWindow; ?>(indice) {

	if (document.getElementById('hdn_hct'+indice+'<?php echo $NumWindow; ?>').value=="1") {
		document.getElementById('hdn_hct'+indice+'<?php echo $NumWindow; ?>').value='0';
	} else {
		document.getElementById('hdn_hct'+indice+'<?php echo $NumWindow; ?>').value='1';
	}
}

function accesoarea<?php echo $NumWindow; ?>(indice) {

	if (document.getElementById('hdn_areaa'+indice+'<?php echo $NumWindow; ?>').value=="1") {
		document.getElementById('hdn_areaa'+indice+'<?php echo $NumWindow; ?>').value='0';
	} else {
		document.getElementById('hdn_areaa'+indice+'<?php echo $NumWindow; ?>').value='1';
	}
}

function NoFirma<?php echo $NumWindow; ?>() {
	document.getElementById("div_firmas<?php echo $NumWindow; ?>").style.backgroundImage='none';
}

$("#nxs_filez<?php echo $NumWindow; ?>").change(function(){
 archivo<?php echo $NumWindow; ?>(this);
});

function archivo<?php echo $NumWindow; ?>(input) {
	document.getElementById("div_preupload2<?php echo $NumWindow; ?>").style.visibility='visible';
	if (input.files && input.files[0]) {
    
      var reader = new FileReader();
      reader.onload = function (e) {
      	cont=e.target.result;
        $("#div_firmas<?php echo $NumWindow; ?>").css("background-image", "url('"+cont+"')"); // Renderizamos la imagen
        document.getElementById("hdn_jpg<?php echo $NumWindow; ?>").value="url("+cont+")";
        document.getElementById('hdn_firmas<?php echo $NumWindow; ?>').value ="<?php echo session_id().$rndm; ?>";
      }
      reader.readAsDataURL(input.files[0]);
       
      // ajax
      var formData = new FormData();
	  var files = $('#nxs_filez<?php echo $NumWindow; ?>')[0].files[0];
	  formData.append('nxs_filez',files);
      $.ajax({
            type: 'POST',
            url: Uploading,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(){
                $('#frm_form<?php echo $NumWindow; ?>').css("opacity",".5");
            },
            success: function(msg){
                if(msg == 'ok'){
                    MsgBox1("Firma / Sello", "Archivo subido correctamente. La firma se actualizará al momento de guardar el formulario.");
                }else{
                     MsgBox1("Firma / Sello", "Se encontraron errores al subir el archivo. Intente de nuevo. "+msg);
                }
                $('#frm_form<?php echo $NumWindow; ?>').css("opacity","");
            }
        });
    }
    document.getElementById("div_preupload2<?php echo $NumWindow; ?>").style.visibility='hidden';
}

function photico<?php echo $NumWindow; ?>(form) {
    var persona = new FormData(form);
    var req = ajaxRequest<?php echo $NumWindow; ?>("upload.php");
    req.send(persona);
}

function ajaxRequest<?php echo $NumWindow; ?>(url) {
  if (window.XMLHttpRequest) {
     var request = new XMLHttpRequest();
  } else if(window.ActiveXObject) {
     var request = new ActiveXObject("Microsoft.XMLHTTP");
  }

  request.onload = function(Event) {
     if (request.status == 200) {
       var response = JSON.parse(request.responseText);
       if(response.success){
          alert("Persona procesada exitosamente");
       } else {
          alert("Hubo un problema al procesar, codigo: " + response.status);
       }
     } 
   };

}

$(document).ready(function(e){
    $("#frm_form<?php echo $NumWindow; ?>").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: Uploading,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('#frm_form<?php echo $NumWindow; ?>').css("opacity",".5");
            },
            success: function(msg){
                if(msg == 'ok'){
                    MsgBox1("Firma", "Archivo subido correctamente. La firma se actualizará al momento de guardar el formulario.");
                }else{
                     MsgBox1("Firma", "Se encontraron errores al subir el archivo. Intente de nuevo.");
                }
                $('#frm_form<?php echo $NumWindow; ?>').css("opacity","");
            }
        });
    });
});

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
	$("input[type=text]").addClass("md_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("md_<?php echo $NumWindow; ?>");
	$("textarea").addClass("md_<?php echo $NumWindow; ?>");
	$("select").addClass("md_<?php echo $NumWindow; ?>");

</script>
