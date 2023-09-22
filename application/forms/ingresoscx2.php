<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">
<div class="col-md-12">

	<label class="label label-default">Admisión</label>
	  <div class="row well well-sm">

	<div class="col-md-3">
<div class="form-group" id="grp_txt_paciente<?php echo $NumWindow; ?>"> 
  <label for="txt_paciente<?php echo $NumWindow; ?>">Identificacion</label>
  	<div class="input-group">	
  		<div class="input-group-btn">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span id="spn_tipoid<?php echo $NumWindow; ?>">CC</span> <span class="caret"></span>
		  </button>
		  <input name="hdn_codid<?php echo $NumWindow; ?>" type="hidden" id="hdn_codid<?php echo $NumWindow; ?>" value="1">
		  <ul class="dropdown-menu">
		    <?php 
$SQL="Select Codigo_TID, Concat(Sigla_TID, ' - ', Nombre_TID), Sigla_TID from cztipoid order by Codigo_TID";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <li><a href="javascript: seltipoid<?php echo $NumWindow; ?>('<?php echo $row[0]; ?>', '<?php echo $row[2]; ?>')"><?php echo ($row[1]); ?></a></li>
<?php
	}
mysqli_free_result($result); 
 ?>
		  </ul>
		</div>

  		<input required name="txt_paciente<?php echo $NumWindow; ?>"  type="text" id="txt_paciente<?php echo $NumWindow; ?>" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');EpsPcte('<?php echo $NumWindow; ?>', this.value);" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL')};" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_expedicion<?php echo $NumWindow; ?>">Exp. en</label>
	<input name="txt_expedicion<?php echo $NumWindow; ?>" type="text"   id="txt_expedicion<?php echo $NumWindow; ?>"  />
</div>
	
	</div>
	<div class="col-md-3">
<div class="form-group" id="grp_txt_Ingreso<?php echo $NumWindow; ?>">
	<label for="txt_Ingreso<?php echo $NumWindow; ?>">Ingreso</label>
  	<div class="input-group">	
  		<input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'ID_TER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+'*')};" required style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'ID_TER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+'*');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group" id="grp_txt_fechaadm<?php echo $NumWindow; ?>">
  <label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaadm<?php echo $NumWindow; ?>" type="text"  id="txt_fechaadm<?php echo $NumWindow; ?>" size="10" maxlength="10" disabled="disabled">
</div>
	</div>
	<div class="col-md-1">
<div class="form-group" id="grp_txt_horaadm<?php echo $NumWindow; ?>">
  <label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_horaadm<?php echo $NumWindow; ?>" type="text"  id="txt_horaadm<?php echo $NumWindow; ?>" size="8" maxlength="8"  disabled="disabled">
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
  <label for="cmb_sede<?php echo $NumWindow; ?>">Sede</label>
  <select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>">
    <?php 
	$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE;";
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
	<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre 1</label>
	<input name="txt_nombre1<?php echo $NumWindow; ?>" type="text"   id="txt_nombre1<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	
	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_nombre2<?php echo $NumWindow; ?>">Nombre 2</label>
	<input name="txt_nombre2<?php echo $NumWindow; ?>" type="text"   id="txt_nombre2<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_apellido1<?php echo $NumWindow; ?>">Apellido 1</label>
	<input name="txt_apellido1<?php echo $NumWindow; ?>" type="text"   id="txt_apellido1<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_apellido2<?php echo $NumWindow; ?>">Apellido 2</label>
	<input name="txt_apellido2<?php echo $NumWindow; ?>" type="text"   id="txt_apellido2<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
	<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Nacimiento</label>
	<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" />
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
	<div class="col-md-1">

<div class="form-group">
  <label for="cmb_EstCivil<?php echo $NumWindow; ?>">Estado Civil</label>
  <select name="cmb_EstCivil<?php echo $NumWindow; ?>" id="cmb_EstCivil<?php echo $NumWindow; ?>">
    <option value="SOLTERO (A)" selected="selected">SOLTERO (A)</option>
    <option value="CASADO (A)">CASADO (A)</option>
    <option value="VIUDO (A)">VIUDO (A)</option>
    <option value="UNION LIBRE">UNION LIBRE</option>
    <option value="SEPARADO (A) / DIVORCIADO (A)">SEPARADO (A) / DIVORCIADO (A)</option>
  </select> 
</div>

	</div>
	

	</div>
		</div>

<div class="col-md-12">

	<label class="label label-default">Detalle</label>
	  <div class="row well well-sm">
  
  <div class="col-md-1">
<div class="form-group">
  <label for="txt_Contrato<?php echo $NumWindow; ?>">Contrato</label>
  	<div class="input-group">	
  		<input name="txt_Contrato<?php echo $NumWindow; ?>" type="text" id="txt_Contrato<?php echo $NumWindow; ?>"  onkeypress="BuscarContrato<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*')};" required />
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>

		<div class="col-md-3">

	<div class="form-group">
		<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Nombre Entidad	</label>
		<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" size="22"/>
	</div>
	
		</div>
  
  <div class="col-md-3">
<div class="form-group">
<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
  <select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>">
  </select>
</div>
  </div>


  <div class="col-md-3">
<div class="form-group">
  <label for="cmb_riesgo<?php echo $NumWindow; ?>">Causa Externa</label>
  <select name="cmb_riesgo<?php echo $NumWindow; ?>" id="cmb_riesgo<?php echo $NumWindow; ?>">
  <?php 
$SQL="Select Codigo_CXT, Nombre_CXT, Defecto_CXT from gxcausaexterna Order By Codigo_CXT";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>" <?php if($row[2]=="1") { echo 'selected="selected"';} ?>><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result);
 ?>  
  </select>
</div> 
  </div>
 
  <div class="col-md-2">
<div class="form-group">
  <label for="cmb_TipoIng<?php echo $NumWindow; ?>">Ingreso Por</label>
  <select name="cmb_TipoIng<?php echo $NumWindow; ?>" id="cmb_TipoIng<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Tipo_ADM, Descripcion_ADM from gxtipoingreso where Estado_ADM='1' order by Tipo_ADM";
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
<input type="hidden" name="hdn_tiping<?php echo $NumWindow; ?>" id="hdn_tiping<?php echo $NumWindow; ?>" />
</div>
  </div>

  <div class="col-md-3">
<div class="form-group">
  <label for="cmb_finconsulta<?php echo $NumWindow; ?>">Finalidad Consulta</label>
  <select name="cmb_finconsulta<?php echo $NumWindow; ?>" id="cmb_finconsulta<?php echo $NumWindow; ?>">
  <?php 
$SQL="Select Codigo_FNC, Nombre_FNC, Defecto_FNC from gxfinconsulta Order By Codigo_FNC";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>" <?php if($row[2]=="1") { echo 'selected="selected"';} ?>><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result);
 ?>  
  </select>
</div> 
  </div>

  <div class="col-md-1">
<div class="form-group">
  <label for="txt_diagnostico<?php echo $NumWindow; ?>">Cód. Dx.</label>
  <div class="input-group">	
 	 <input name="txt_diagnostico<?php echo $NumWindow; ?>" type="text" id="txt_diagnostico<?php echo $NumWindow; ?>"  onblur="HCDxOnBlur<?php echo $NumWindow; ?>();" required onkeydown="if(event.keyCode==115){CargarSearch('Diagnostico', 'txt_diagnostico<?php echo $NumWindow; ?>', 'NULL')};" />
  	  <span class="input-group-btn">	
  		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Diagnostico" onclick="javascript:CargarSearch('Diagnostico', 'txt_diagnostico<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  	  </span>
  </div>
</div>
  </div>

	<div class="col-md-4">
<div class="form-group">
	<label for="txt_NombreDx<?php echo $NumWindow; ?>">Diagnóstico Previo</label>
	<input name="txt_NombreDx<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreDx<?php echo $NumWindow; ?>" />
</div>
	</div>

  <div class="col-md-1">
<div class="form-group">
  <label for="fechahosp<?php echo $NumWindow; ?>">Fecha Hosp.</label>
  <input name="fechahosp<?php echo $NumWindow; ?>" type="text" class="datepicker" id="fechahosp<?php echo $NumWindow; ?>" value="00/00/0000"  maxlength="10">
 </div>
   </div>

  <div class="col-md-1">
<div class="form-group">
  <label for="txt_cama<?php echo $NumWindow; ?>">Cama</label>
 	<div class="input-group">	
 		 <input name="txt_cama<?php echo $NumWindow; ?>" type="text" id="txt_cama<?php echo $NumWindow; ?>"  onkeydown="if(event.keyCode==115){CargarSearch('Camas', 'txt_cama<?php echo $NumWindow; ?>', 'Estado_CAM=*1*')};" />
  		 <span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Camas" onclick="javascript:CargarSearch('Camas', 'txt_cama<?php echo $NumWindow; ?>', 'Estado_CAM=*1*');"><i class="fas fa-search"></i></button>
 		</span>
    </div>
</div>
  </div>

	<div class="col-md-2">
<div class="form-group">
	<label for="txt_NombreCAMA<?php echo $NumWindow; ?>">Descripción	</label>
	<input name="txt_NombreCAMA<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreCAMA<?php echo $NumWindow; ?>" />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_remitido<?php echo $NumWindow; ?>">Valor Remitido</label>
  <input name="txt_remitido<?php echo $NumWindow; ?>" type="text" id="txt_remitido<?php echo $NumWindow; ?>" class="" size="8" value="0"/>
 </div>
 	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_remision<?php echo $NumWindow; ?>">No Remision</label>
  <input name="txt_remision<?php echo $NumWindow; ?>" type="text" id="txt_remision<?php echo $NumWindow; ?>" size="5" />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_fecremision<?php echo $NumWindow; ?>">Fecha Remision</label>
  <input name="txt_fecremision<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fecremision<?php echo $NumWindow; ?>" value="00/00/0000" size="10" maxlength="10" />
</div>
	</div>

	<div class="col-md-5">
<div class="form-group">
  <label for="txt_ips<?php echo $NumWindow; ?>">I.P.S.</label>
  <input name="txt_ips<?php echo $NumWindow; ?>" type="text" id="txt_ips<?php echo $NumWindow; ?>" />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="txt_autorizacion<?php echo $NumWindow; ?>">No. Autorizacion</label>
<input name="txt_autorizacion<?php echo $NumWindow; ?>" type="text" id="txt_autorizacion<?php echo $NumWindow; ?>"  />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
<label for="txt_fecautorizacion<?php echo $NumWindow; ?>">Fecha Aut.</label>
<input name="txt_fecautorizacion<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fecautorizacion<?php echo $NumWindow; ?>" value="00/00/0000"  maxlength="10" />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_fecfin<?php echo $NumWindow; ?>">Fecha Fin</label>
  <input name="txt_fecfin<?php echo $NumWindow; ?>" type="text" id="txt_fecfin<?php echo $NumWindow; ?>" maxlength="10" value="00/00/0000"/>
</div>
	</div>

	<div class="col-md-12">
<div class="form-group">
<label for="txt_motivo<?php echo $NumWindow; ?>">Motivo Consulta</label>
<input name="txt_motivo<?php echo $NumWindow; ?>" type="text" id="txt_motivo<?php echo $NumWindow; ?>" value="" />
</div>
	</div>

	<div class="col-md-4">
<div class="form-group">
<label for="txt_acudiente<?php echo $NumWindow; ?>">Acompañante</label>
<input name="txt_acudiente<?php echo $NumWindow; ?>" type="text" id="txt_acudiente<?php echo $NumWindow; ?>" />
</div>
	</div>

	<div class="col-md-3">
<div class="form-group">
<label for="txt_direccion<?php echo $NumWindow; ?>">Direccion</label>
<input name="txt_direccion<?php echo $NumWindow; ?>" type="text" id="txt_direccion<?php echo $NumWindow; ?>"  />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="txt_telefono<?php echo $NumWindow; ?>">Telefono</label>
<input name="txt_telefono<?php echo $NumWindow; ?>" type="text" id="txt_telefono<?php echo $NumWindow; ?>"  />
</div>
	</div>
	<div class="col-md-3">
<div class="form-group">
<label for="cmb_tipopct<?php echo $NumWindow; ?>">Tipo Paciente</label>
<select name="cmb_tipopct<?php echo $NumWindow; ?>" id="cmb_tipopct<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_PTT, Nombre_PTT, Defecto_PTT from gxpacientestipos where Estado_PTT='1' order by Defecto_PTT desc, Codigo_PTT asc";
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
	<div class="row well">

		<div class="col-md-6">
	<div class="form-group">
	<label for="chk_copago<?php echo $NumWindow; ?>">Copago</label>
	<input name="chk_copago<?php echo $NumWindow; ?>" type="checkbox" id="chk_copago<?php echo $NumWindow; ?>" value="0" onclick="javascript:cambiarcheck<?php echo $NumWindow; ?>();" />
	</div>
		</div>

		<div class="col-md-6">
	<div class="form-group">
	<label for="chk_cuota<?php echo $NumWindow; ?>">Cuota Moderadora</label>
	<input type="checkbox" name="chk_cuota<?php echo $NumWindow; ?>" value="0" id="chk_cuota<?php echo $NumWindow; ?>" onclick="javascript:cambiarcheck<?php echo $NumWindow; ?>();" />
	</div>
		</div>

		

	</div>
	</div>

	<div class="col-md-5 col-md-offset-3">
<div class="form-group">
<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="3" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
</div>
	</div>

		</div>
	</div>
<input name="hdn_citax<?php echo $NumWindow; ?>" type="hidden" id="hdn_citax<?php echo $NumWindow; ?>" value="">
</form>

<script >

<?php

	if ($_SESSION["it_CodigoUSR"]>"1") {
		$SQL="Select b.Codigo_SDE From czsedes a, itusuariossedes b Where b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Codigo_SDE=b.Codigo_SDE and Estado_SDE='1'";
		$result = mysqli_query($conexion, $SQL);
		$contasedes=0;
		while($row = mysqli_fetch_array($result)) 
		{
			$contasedes++;
	 	echo "	    	document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[0]."';";
	    
		}
		mysqli_free_result($result); 
		if ($contasedes==1) {
			echo "			document.getElementById('cmb_sede".$NumWindow."').setAttribute('disabled', true);";
		} else {
			if (isset($_GET["Ingreso"])) {	
				$SQL="Select Codigo_SDE From gxadmision a, itusuariossedes b, czsedes c  Where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0') and b.Codigo_SDE=c.Codigo_SDE and b.Codigo_USR=a.Codigo_USR";
				$result = mysqli_query($conexion, $SQL);
				if($row = mysqli_fetch_array($result)) {
					echo "document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[0]."';";
				}
				mysqli_free_result($result); 
			}
		}
	}
if (isset($_GET["CITA"])) {
	$SQL="Select b.ID_TER from gxcitasmedicas a, czterceros b where a.Codigo_TER=b.Codigo_TER and a.Codigo_CIT='".$_GET["CITA"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
		document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".hdn_citax".$NumWindow.".value='".$_GET["CITA"]."';
		";
?>
		NombreTercero('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value, 'gxpacientes');
		EpsPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
		NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
		CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
		PlanPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
		IngresosAbiertos('<?php echo $NumWindow; ?>');
		document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value='0000000000';
		FechaActual('txt_fechaadm<?php echo $NumWindow; ?>');
		HoraActual('txt_horaadm<?php echo $NumWindow; ?>');
		document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.focus();
<?php
	}
}

if (isset($_GET["Ingreso"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), a.*, ID_TER, b.Nombre_TER, nombre_cam from czterceros b, gxadmision a left join gxcamas c on c.codigo_cam=a.codigo_cam Where a.Codigo_TER=b.Codigo_TER and estado_adm='I' and  LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		$chkcuota='false';
		$chkcopago='false';
		if ($row["Copago_ADM"]=='1') {
			$chkcopago='true';}
		if ($row["Cuota_ADM"]=='1') {
			$chkcuota='true';}
		echo "
			CargarxPlan".$NumWindow."('".$row['Codigo_EPS']."');
			document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row["LPAD(Codigo_ADM,10,'0')"]."';
			document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row["ID_TER"]."';
			NombreTercero('".$NumWindow."', '".$row["ID_TER"]."', 'gxpacientes');
			document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value='".$row["Codigo_EPS"]."';
			NombreContrato('".$NumWindow."', document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value);
			document.frm_form".$NumWindow.".cmb_riesgo".$NumWindow.".value='".$row["Codigo_CXT"]."';
			document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row["Codigo_SDE"]."';
			document.frm_form".$NumWindow.".cmb_TipoIng".$NumWindow.".value='".$row["Ingreso_ADM"]."';
			document.frm_form".$NumWindow.".cmb_finconsulta".$NumWindow.".value='".$row["Codigo_FNC"]."';
			document.frm_form".$NumWindow.".fechahosp".$NumWindow.".value='".FormatoFecha($row["FechaHosp_ADM"])."';
			document.frm_form".$NumWindow.".txt_cama".$NumWindow.".value='".$row["nombre_cam"]."';
			NombreCama('".$NumWindow."', document.frm_form".$NumWindow.".txt_cama".$NumWindow.".value);
			document.frm_form".$NumWindow.".txt_remitido".$NumWindow.".value='".$row["ValorRemitido_ADM"]."';
			document.frm_form".$NumWindow.".txt_diagnostico".$NumWindow.".value='".$row["Codigo_DGN"]."';
			NombreDiagnostico('".$NumWindow."', document.frm_form".$NumWindow.".txt_diagnostico".$NumWindow.".value);
			document.frm_form".$NumWindow.".txt_remision".$NumWindow.".value='".$row["Remision_ADM"]."';
			document.frm_form".$NumWindow.".txt_fecremision".$NumWindow.".value='".FormatoFecha($row["FechaRemision_ADM"])."';
			document.frm_form".$NumWindow.".txt_ips".$NumWindow.".value='".$row["IPS_ADM"]."';
			document.frm_form".$NumWindow.".txt_motivo".$NumWindow.".value='".$row["Motivo_ADM"]."';
			document.frm_form".$NumWindow.".txt_acudiente".$NumWindow.".value='".$row["Acudiente_ADM"]."';
			document.frm_form".$NumWindow.".txt_direccion".$NumWindow.".value='".$row["Direccion_ADM"]."';
			document.frm_form".$NumWindow.".txt_telefono".$NumWindow.".value='".$row["Telefono_ADM"]."';
			document.frm_form".$NumWindow.".txt_autorizacion".$NumWindow.".value='".$row["Autorizacion_ADM"]."';
			document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", "<br/>",$row["Observaciones_ADM"])."';
			document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".FormatoFecha($row[0])."';
			document.frm_form".$NumWindow.".txt_fecfin".$NumWindow.".value='".FormatoFecha($row["FechaFin_ADM"])."';
			document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[1]."';
			eval('window.document.frm_form".$NumWindow.".chk_copago".$NumWindow.".checked=".$chkcopago."');
			eval('window.document.frm_form".$NumWindow.".chk_cuota".$NumWindow.".checked=".$chkcuota."');
			document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
			document.frm_form".$NumWindow.".cmb_tipopct".$NumWindow.".value='".$row["Codigo_PTT"]."';
			HCDxOnBlur".$NumWindow."();
			function CargarxPlan".$NumWindow."(Codigo) {
				$.get(Funciones,{'Func':'CargarPlan','value':Codigo},function(data){ 
					document.getElementById('txt_Plan".$NumWindow."').innerHTML=data;
					document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
				}); 

			}
		";
	} else {
		echo "
		MsgBox1('Ingreso','No se encuentra el ingreso ".$_GET["Ingreso"]."');
		";
	}
	mysqli_free_result($result); 
} else {
		echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
?>
FechaActual('txt_fechaadm<?php echo $NumWindow; ?>');
HoraActual('txt_horaadm<?php echo $NumWindow; ?>');
<?php
}
?>

function cambiarcheck<?php echo $NumWindow; ?>() {
	if(document.getElementById('chk_cuota<?php echo $NumWindow; ?>').checked) {
		document.frm_form<?php echo $NumWindow; ?>.chk_cuota<?php echo $NumWindow; ?>.value='1';
	} else {
		document.frm_form<?php echo $NumWindow; ?>.chk_cuota<?php echo $NumWindow; ?>.value='0';
	}
	if(document.getElementById('chk_copago<?php echo $NumWindow; ?>').checked) {
		document.frm_form<?php echo $NumWindow; ?>.chk_copago<?php echo $NumWindow; ?>.value='1';
	} else {
		document.frm_form<?php echo $NumWindow; ?>.chk_copago<?php echo $NumWindow; ?>.value='0';
	}
}

function CargarIngreso(Pcte) {
	if (Dpto=="") {
		VarAdm="NULL";
	} else {
		VarAdm="Codigo_TER=*"+Pcte+"*";
	}
	CargarSearch('Ingresos', 'txt_Ingreso<?php echo $NumWindow; ?>', VarAdm);
}

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	NombreTercero('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value, 'gxpacientes');
	EpsPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
	NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	PlanPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
	IngresosAbiertos('<?php echo $NumWindow; ?>');
	document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.focus();
  }
}

function BuscarIng<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){

	if ((document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value=="0000000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value='0000000000';
		FechaActual('txt_fechaadm<?php echo $NumWindow; ?>');
		HoraActual('txt_horaadm<?php echo $NumWindow; ?>');
		document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.focus();
	} else {
		AbrirForm('application/forms/ingresoscx.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarContrato<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
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

function seltipoid<?php echo $NumWindow; ?>(CodID, SiglaID) {
	document.getElementById('hdn_codid<?php echo $NumWindow; ?>').value = CodID;
	document.getElementById('spn_tipoid<?php echo $NumWindow; ?>').innerHTML = SiglaID;
}

function HCDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_diagnostico<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_diagnostico<?php echo $NumWindow; ?>').value, document.getElementById('txt_NombreDx<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_NombreDx<?php echo $NumWindow; ?>').value = '';
	}
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
	$(':input', $("#frm_form<?php echo $NumWindow; ?>")).each(function() {
		Var1=this.id;
		$(this).addClass("nxs_<?php echo $NumWindow; ?>");
	});


</script>
