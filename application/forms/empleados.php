<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target<?php echo $NumWindow; ?>" onreset="document.frm_form<?php echo $NumWindow; ?>.hdn_terceros<?php echo $NumWindow; ?>.value='<?php echo session_id(); ?>';FotoEmp<?php echo $NumWindow; ?>('0.png');">
<label class="label label-success"> IDENTIFICACION</label>
<div class="row well well-sm">
	<div class="col-md-1 bg-primary ">
		<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />
		<div id="div_foto<?php echo $NumWindow; ?>" class="foto_perfil thumbnail center-block" style="background-repeat: no-repeat;background-position: center; background-size: contain;">
			<div id="div_preupload<?php echo $NumWindow; ?>" class="preupload" style="visibility:hidden"></div>
			<div id="div_cmd<?php echo $NumWindow; ?>" class="foto_cmd" >
				<img src="http://cdn.genomax.co/media/image/add-mini.png"  alt="Cambiar Foto" width="16" height="16" align="absmiddle" title="Actualizar Foto" class="pic_add" onclick="upl_file<?php echo $NumWindow; ?>.click();"/> 
				<img src="http://cdn.genomax.co/media/image/remove-mini.png"  alt="Eliminar Foto" width="16" height="16" align="absmiddle" title="Eliminar Foto" class="pic_remove" onclick="KillPic('files/images/terceros/',document.getElementById('hdn_terceros<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');"/>
				<input name="upl_file<?php echo $NumWindow; ?>" type="file" class="input_file_upload" id="upl_file<?php echo $NumWindow; ?>" size="1" accept="image/x-png, image/gif, image/jpeg"/ onchange="frm_form<?php echo $NumWindow; ?>.submit();startUpload('<?php echo $NumWindow; ?>', 'terceros');" >
				<iframe id="upload_target<?php echo $NumWindow; ?>" style="width:0; height:0;border: 0px solid #ffffff;" name="upload_target<?php echo $NumWindow; ?>"  width="320" height="240" ></iframe>
			</div>
		</div>
	</div>
	<div class="col-md-11">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Tipo</div>
						<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" >
						<?php 
						$SQL="Select Codigo_TID, Nombre_TID, Sigla_TID from cztipoid order by Codigo_TID";
						$result = mysqli_query($conexion, $SQL);
						while($row = mysqli_fetch_array($result)) 
							{
						 ?>
						  <option value="<?php echo $row[0]; ?>"><?php echo ($row[2]); ?></option>
						<?php
							}
						mysqli_free_result($result); 
						 ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<div class="input-group">	
						<div class="input-group-addon">Id.</div>
						<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" onblur="BuscarEmp2<?php echo $NumWindow; ?>();" />
						<span class="input-group-btn">	
							<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Empleado" onclick="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">Exp.</div>
						<input name="txt_expedicion<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_expedicion<?php echo $NumWindow; ?>"  />
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon"> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> </div>
					  	<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
					    	<option value="0" style="color:#C00" >Inactivo</option>
					    	<option value="1" style="color:#060" >Activo</option>
					  	</select>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre 1</label>
					<input name="txt_nombre1<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_nombre1<?php echo $NumWindow; ?>"  />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="txt_nombre2<?php echo $NumWindow; ?>">Nombre 2</label>
					<input name="txt_nombre2<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_nombre2<?php echo $NumWindow; ?>"  />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="txt_apellido1<?php echo $NumWindow; ?>">Apellido 1</label>
					<input name="txt_apellido1<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_apellido1<?php echo $NumWindow; ?>"  />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="txt_apellido2<?php echo $NumWindow; ?>">Apellido 2</label>
					<input name="txt_apellido2<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_apellido2<?php echo $NumWindow; ?>"  />
				</div>
			</div>
		</div>
	</div>
</div>

<label class="label label-success"> DATOS PERSONALES</label>
<div class="row well well-sm">
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
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_fechanac<?php echo $NumWindow; ?>">Fecha Nacimiento</label>
		  <input name="txt_fechanac<?php echo $NumWindow; ?>" type="date" id="txt_fechanac<?php echo $NumWindow; ?>" value="0000-00-00"><span id="edad<?php echo $NumWindow; ?>"></span>
		 </div> 
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="cmb_EstCivil<?php echo $NumWindow; ?>">Est. Civil</label>
		  <select name="cmb_EstCivil<?php echo $NumWindow; ?>" id="cmb_EstCivil<?php echo $NumWindow; ?>">
		    <option value="SOLTERO (A)" selected="selected">Soltero (a)</option>
		    <option value="CASADO (A)">Casado (a)</option>
		    <option value="VIUDO (A)">Viudo (a)</option>
		    <option value="UNION LIBRE">Union Libre</option>
		    <option value="SEPARADO (A) / DIVORCIADO (A)">Separado (a) / Divorciado (a)</option>
		  </select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_Departamento<?php echo $NumWindow; ?>">Cod. Dep.</label>
		  	<div class="input-group">	
		  		<input name="txt_Departamento<?php echo $NumWindow; ?>" type="text" id="txt_Departamento<?php echo $NumWindow; ?>" size="2" maxlength="2" onkeypress="BuscarDpto<?php echo $NumWindow; ?>(event);" />
		  		<span class="input-group-btn">	
		  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Departamentos" onclick="javascript:CargarSearch('Departamentos', 'txt_Departamento<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		  		</span>
		  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="txt_Departamento<?php echo $NumWindow; ?>">Departamento</label>
			<input name="txt_NombreDepto<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreDepto<?php echo $NumWindow; ?>"/>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_Municipio<?php echo $NumWindow; ?>">Cod. Mun.</label>
		  	<div class="input-group">	
		  		<input name="txt_Municipio<?php echo $NumWindow; ?>" type="text" id="txt_Municipio<?php echo $NumWindow; ?>" size="3" maxlength="3" onkeypress="BuscarMUN<?php echo $NumWindow; ?>(event);" />
		   		<span class="input-group-btn">	
		   			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Municipio" onclick="javascript:CargarMUN(document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value);"><i class="fas fa-search"></i></button>
		   		</span>
		   </div>
		  
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="txt_Departamento<?php echo $NumWindow; ?>">Municipio</label>
			<input name="txt_NombreMnpio<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreMnpio<?php echo $NumWindow; ?>" />
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
		  <label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefono</label>
		  <input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" /> 
		</div>  
	</div>
	<div class="col-md-3">
		<div class="form-group">
		  <label for="txt_Barrio<?php echo $NumWindow; ?>">Barrio</label>
		  <input type="text" name="txt_Barrio<?php echo $NumWindow; ?>" id="txt_Barrio<?php echo $NumWindow; ?>" />
		 </div> 
	</div>
	<div class="col-md-3">
		<div class="form-group">
		  <label for="txt_email<?php echo $NumWindow; ?>">Correo</label>
		  <input type="text" name="txt_email<?php echo $NumWindow; ?>" id="txt_email<?php echo $NumWindow; ?>" />
		</div>
	</div>
</div>
<label class="label label-success"> INFORMACION LABORAL</label>
<div class="row well well-sm">
	<div class="col-md-2">
		<div class="form-group">
			<label for="txt_id<?php echo $NumWindow; ?>">Código Empleado</label>
			<input name="txt_id<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_id<?php echo $NumWindow; ?>"  />
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_fechaing<?php echo $NumWindow; ?>">Fec. Ingreso</label>
		  <input name="txt_fechaing<?php echo $NumWindow; ?>" type="date"  id="txt_fechaing<?php echo $NumWindow; ?>"  value="0000-00-00">
		 </div> 
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_fecharet<?php echo $NumWindow; ?>">Fec. Retiro</label>
		  <input name="txt_fecharet<?php echo $NumWindow; ?>" type="date"  id="txt_fecharet<?php echo $NumWindow; ?>"  value="0000-00-00">
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		<label for="cmb_tipocon<?php echo $NumWindow; ?>">Tipo Contrato</label>
		<select name="cmb_tipocon<?php echo $NumWindow; ?>" id="cmb_tipocon<?php echo $NumWindow; ?>" >
		<?php 
		$SQL="Select Codigo_TCL, Nombre_TCL from cztipocontratos order by Codigo_TCL";
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
		<label for="cmb_cargo<?php echo $NumWindow; ?>">Cargo</label>
		<select name="cmb_cargo<?php echo $NumWindow; ?>" id="cmb_cargo<?php echo $NumWindow; ?>" >
		<?php 
		$SQL="Select Codigo_CRG, Nombre_CRG from czcargos order by Nombre_CRG";
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
		<label for="cmb_sede<?php echo $NumWindow; ?>">Sede</label>
		<select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>" >
		<?php 
		$SQL="Select Codigo_SDE, Nombre_SDE from czsedes order by Nombre_SDE";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
		 ?>
		  <option value="<?php echo strtoupper($row[0]); ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result); 
		 ?>
		</select>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_salario<?php echo $NumWindow; ?>">Salario Actual</label>
		  <input name="txt_salario<?php echo $NumWindow; ?>" type="text" id="txt_salario<?php echo $NumWindow; ?>" value="0"  size="15" />
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
		  <label for="txt_transporte<?php echo $NumWindow; ?>">Aux. Transporte</label>
		  <input name="txt_transporte<?php echo $NumWindow; ?>" type="text" id="txt_transporte<?php echo $NumWindow; ?>" value="0"  size="10" />
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="txt_bonificacion<?php echo $NumWindow; ?>">Bonificacion</label>
		  	<div class="input-group">	
		  		<input name="txt_bonificacion<?php echo $NumWindow; ?>" type="text" id="txt_bonificacion<?php echo $NumWindow; ?>" value="0"  size="15" />
				<span class="input-group-btn">	
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Salario" onclick="javascript:MostrarSalariosEmp<?php echo $NumWindow; ?>();"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</div>
	</div>
</div>
<label class="label label-success"> OBSERVACIONES</label>
<div class="row alert alert-warning">
	<div class="col-md-12">
		<textarea name="txt_observaciones<?php echo $NumWindow; ?>" rows="3" id="txt_observaciones<?php echo $NumWindow; ?>"></textarea>
	</div>
</div>



</form>
<script>
document.getElementById("div_preupload<?php echo $NumWindow; ?>").style.visibility = 'visible';
FotoEmp<?php echo $NumWindow; ?>('0.png');
<?php
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".txt_fechaing".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_fecharet".$NumWindow.".value='1900-01-01';";
	}
	mysqli_free_result($result); 
	if (isset($_GET["IdEmp"])) {
	$SQL="Select * from czempleados a, czterceros b where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["IdEmp"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "
		document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$_GET["IdEmp"]."';";
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_EMP"]!='1'){
			echo "
			MsgBox1('Empleados','El empleado ".$_GET["IdEmp"]." se encuentra inactivo');
			";}
	echo "
		document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".value='".$row["Codigo_TID"]."';
		document.frm_form".$NumWindow.".txt_expedicion".$NumWindow.".value='".$row["Expedicion_TER"]."';
		document.frm_form".$NumWindow.".txt_nombre1".$NumWindow.".value='".$row["Nombre1_EMP"]."';
		document.frm_form".$NumWindow.".txt_nombre2".$NumWindow.".value='".$row["Nombre2_EMP"]."';
		document.frm_form".$NumWindow.".txt_apellido1".$NumWindow.".value='".$row["Apellido1_EMP"]."';
		document.frm_form".$NumWindow.".txt_apellido2".$NumWindow.".value='".$row["Apellido2_EMP"]."';
		document.frm_form".$NumWindow.".txt_id".$NumWindow.".value='".$row["ID_EMP"]."';		
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".cmb_Sexo".$NumWindow.".value='".$row["Codigo_SEX"]."';
		document.frm_form".$NumWindow.".txt_fechanac".$NumWindow.".value='".($row["FechaNac_EMP"])."';
		document.frm_form".$NumWindow.".cmb_EstCivil".$NumWindow.".value='".$row["EstCivil_EMP"]."';
		document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value='".$row["Codigo_DEP"]."';
		document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value='".$row["Codigo_MUN"]."';
		NombreDpto('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value);
		NombreMUN('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value, document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value);
		document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
		document.frm_form".$NumWindow.".txt_Barrio".$NumWindow.".value='".$row["Barrio_EMP"]."';
		document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
		document.frm_form".$NumWindow.".txt_fechaing".$NumWindow.".value='".($row["FechaIng_EMP"])."';
		document.frm_form".$NumWindow.".txt_fecharet".$NumWindow.".value='".($row["FechaRet_EMP"])."';
		document.frm_form".$NumWindow.".cmb_tipocon".$NumWindow.".value='".$row["Codigo_TCL"]."';
		document.frm_form".$NumWindow.".txt_salario".$NumWindow.".value='".$row["SalarioAct_EMP"]."';
		document.frm_form".$NumWindow.".txt_observaciones".$NumWindow.".value='".$row["Observaciones_EMP"]."';
		document.frm_form".$NumWindow.".cmb_cargo".$NumWindow.".value='".$row["Codigo_CRG"]."';
		document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row["Estado_EMP"]."';
		document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".strtoupper($row["Codigo_SDE"])."';
		document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$row["Codigo_TER"]."';	
		
		document.getElementById('div_foto".$NumWindow."').style.backgroundImage='url(functions/php/nexus/blob.php?codigo=".$row["Codigo_TER"]."&tipo=terceros)';
		";
		/*
		if (file_exists("../../files/images/terceros/".$row["Codigo_TER"].".png")){ 
		   echo "FotoEmp".$NumWindow."('".$row["Codigo_TER"].".png');"; 
		}else{ 
			if (file_exists("../../files/images/terceros/".$row["Codigo_TER"].".jpg")){ 
			   echo "FotoEmp".$NumWindow."('".$row["Codigo_TER"].".jpg');"; 
			}else{ 
				if (file_exists("../../files/images/terceros/".$row["Codigo_TER"].".gif")){ 
				   echo "FotoEmp".$NumWindow."('".$row["Codigo_TER"].".gif');"; 
				}else{ 
				   if (file_exists("../../files/images/terceros/".$row["Codigo_TER"].".jpeg")){ 
					   echo "FotoEmp".$NumWindow."('".$row["Codigo_TER"].".jpeg');";
				   }else{
				   		echo "FotoEmp".$NumWindow."('0.png');"; 
				   }
				} 
			} 
		}*/ 
	}
	mysqli_free_result($result); 
	}
?>
document.getElementById("div_preupload<?php echo $NumWindow; ?>").style.visibility = 'hidden';

function CargarMUN(Dpto) {
	if (Dpto=="") {
		VarM="NULL";
	} else {
		VarM="Codigo_DEP=*"+Dpto+"*";
	}
	CargarSearch('Municipios', 'txt_Municipio<?php echo $NumWindow; ?>', VarM);
}

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/empleados.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/empleados.php', '<?php echo $NumWindow; ?>', '&IdEmp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarEmp2<?php echo $NumWindow; ?>() {
  	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/empleados.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/empleados.php', '<?php echo $NumWindow; ?>', '&IdEmp='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value);
	}  
}

function BuscarDpto<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreDpto('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value);
  }
}

function BuscarMUN<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreMUN('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_Municipio<?php echo $NumWindow; ?>.value);
  }
}

function FotoEmp<?php echo $NumWindow; ?>(tercero) {
	document.getElementById("div_foto<?php echo $NumWindow; ?>").style.backgroundImage="url(files/images/terceros/"+tercero+")"
}

function MostrarCargosEmp<?php echo $NumWindow; ?>() {
	CargarForm('application/forms/cargosemp.php?emp='+document.getElementById('hdn_terceros<?php echo $NumWindow; ?>').value, 'Detalle Cargos ');
}

function MostrarSalariosEmp<?php echo $NumWindow; ?>() {
	CargarForm('application/forms/salariosemp.php?emp='+document.getElementById('hdn_terceros<?php echo $NumWindow; ?>').value, 'Detalle Salarios');
}

function MostrarAreasEmp<?php echo $NumWindow; ?>() {
	CargarForm('application/forms/areasemp.php?emp='+document.getElementById('hdn_terceros<?php echo $NumWindow; ?>').value, 'Areas Asignadas');
}

	$("form").addClass("container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

</script>