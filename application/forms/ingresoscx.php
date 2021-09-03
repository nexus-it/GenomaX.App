<?php
 
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">
<div class="col-md-12">

	<label class="label label-default">Admisión</label>
	  <div class="row well well-sm">
  

	<div class="col-md-2">
<div class="form-group" id="grp_txt_paciente<?php echo $NumWindow; ?>"> 
  <label for="txt_paciente<?php echo $NumWindow; ?>">Identificacion</label>
  	<div class="input-group">
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:LoadPcte<?php echo $NumWindow; ?>();" title="Edición de Pacientes"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
  		</span>
  		<input required name="txt_paciente<?php echo $NumWindow; ?>"  type="text" id="txt_paciente<?php echo $NumWindow; ?>" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');EpsPcteCont('<?php echo $NumWindow; ?>', this.value);" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL')};" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
  		</span>
  	</div>
</div>
	</div>
	<div class="col-md-3">

	<div class="form-group">
		<label for="txt_paciente2<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente2<?php echo $NumWindow; ?>" id="txt_paciente2<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>

	<div class="col-md-2">
<div class="form-group" id="grp_txt_Ingreso<?php echo $NumWindow; ?>">
	<label for="txt_Ingreso<?php echo $NumWindow; ?>">Ingreso</label>
  	<div class="input-group">	
  		<input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'ID_TER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+'*')};" required style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'ID_TER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+'*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
  		</span>
  	</div>
</div>
	</div>
	<?php
	$SQL="Select EditDate_XAD From itconfig_ad;";
	$result = mysqli_query($conexion, $SQL);
	$EditDate_XAD=' disabled="disabled" ';
	if ($row = mysqli_fetch_array($result)) 
	{
		if($row["EditDate_XAD"]=="1") {
			$EditDate_XAD=' ';
		}
	}
 	mysqli_free_result($result);
	?>
	<div class="col-md-2">
<div class="form-group" id="grp_txt_fechaadm<?php echo $NumWindow; ?>">
<label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaadm<?php echo $NumWindow; ?>"  id="txt_fechaadm<?php echo $NumWindow; ?>" type="date" required 	<?php echo $EditDate_XAD; ?>>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group" id="grp_txt_horaadm<?php echo $NumWindow; ?>">
  <label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_horaadm<?php echo $NumWindow; ?>" type="time"  id="txt_horaadm<?php echo $NumWindow; ?>"  <?php echo $EditDate_XAD; ?>><span id="estado<?php echo $NumWindow; ?>" class="anulado"></span>
</div>
	</div>
	
	<div class="col-md-1">
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
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
  		</span>
  	</div>
</div>
	</div>

		<div class="col-md-4">

	<div class="form-group">
		<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Nombre Contrato	</label>
		<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" />
	</div>
	
		</div>
  
  <div class="col-md-4">
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

  <div class="col-md-4">
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
  <input name="txt_diagnostico<?php echo $NumWindow; ?>" type="hidden" id="txt_diagnostico<?php echo $NumWindow; ?>" value="R51X" />
  

 <input name="hdn_fechahosp<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechahosp<?php echo $NumWindow; ?>" value="0000-00-00"  >
 <input name="hdn_cama<?php echo $NumWindow; ?>" type="hidden" id="hdn_cama<?php echo $NumWindow; ?>"  />
 <input name="hdn_remision<?php echo $NumWindow; ?>" type="hidden" id="hdn_remision<?php echo $NumWindow; ?>"  />
 <input name="hdn_remitido<?php echo $NumWindow; ?>" type="hidden" id="hdn_remitido<?php echo $NumWindow; ?>" value="0"/>
 <input name="hdn_fecremision<?php echo $NumWindow; ?>" type="hidden"  id="hdn_fecremision<?php echo $NumWindow; ?>" value="0000-00-00"  />
 <input name="hdn_ips<?php echo $NumWindow; ?>" type="hidden" id="hdn_ips<?php echo $NumWindow; ?>" />
 <input name="hdn_fecfin<?php echo $NumWindow; ?>" type="hidden" id="hdn_fecfin<?php echo $NumWindow; ?>"  value="00/00/0000"/>

 <input type="hidden" name="hdn_citax<?php echo $NumWindow; ?>" id="hdn_citax<?php echo $NumWindow; ?>">

	<div class="col-md-2">
<div class="form-group">
<label for="txt_autorizacion<?php echo $NumWindow; ?>">No. Autorizacion</label>
<input name="txt_autorizacion<?php echo $NumWindow; ?>" type="text" id="txt_autorizacion<?php echo $NumWindow; ?>"  />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="txt_fecautorizacion<?php echo $NumWindow; ?>">Fecha Aut.</label>
<input name="txt_fecautorizacion<?php echo $NumWindow; ?>" type="date"  id="txt_fecautorizacion<?php echo $NumWindow; ?>" value="0000-00-00" />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="cmb_tipopct<?php echo $NumWindow; ?>">Tipo Paciente</label>
<select name="cmb_tipopct<?php echo $NumWindow; ?>" id="cmb_tipopct<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_PTT, Nombre_PTT, Defecto_PTT from gxpacientestipos where Reingreso_PTT='0' and Estado_PTT='1' order by Defecto_PTT desc, Codigo_PTT asc";
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

	<div class="col-md-12">
<div class="form-group">
<label for="txt_motivo<?php echo $NumWindow; ?>">Motivo Consulta</label>
<input name="txt_motivo<?php echo $NumWindow; ?>" type="text" id="txt_motivo<?php echo $NumWindow; ?>" value="" />
</div>
	</div>

	<div class="col-md-3">
<div class="form-group">
<label for="txt_acudiente<?php echo $NumWindow; ?>">Acompañante</label>
<input name="txt_acudiente<?php echo $NumWindow; ?>" type="text" id="txt_acudiente<?php echo $NumWindow; ?>" />
</div>
	</div>

	<div class="col-md-2">
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
	
	<div class="col-md-2">
<div class="form-group">
<label for="chk_copago<?php echo $NumWindow; ?>">Copago</label>
<input name="chk_copago<?php echo $NumWindow; ?>" type="checkbox" id="chk_copago<?php echo $NumWindow; ?>" value="0" onclick="javascript:cambiarcheck<?php echo $NumWindow; ?>();" disabled />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="chk_cuota<?php echo $NumWindow; ?>">Cuota Moderadora</label>
<input type="checkbox" name="chk_cuota<?php echo $NumWindow; ?>" value="0" id="chk_cuota<?php echo $NumWindow; ?>" onclick="javascript:cambiarcheck<?php echo $NumWindow; ?>();" />
</div>
	</div>

	<div class="col-md-5 col-md-offset-7">
<div class="form-group">
<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="3" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
</div>
	</div>

		</div>
	</div>

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
	$SQL="Select b.ID_TER, d.Nombre_ESP, f.Codigo_EPS, f.Nombre_EPS from gxcitasmedicas a, czterceros b, gxagendacab c, gxespecialidades d, gxpacientes e, gxeps f WHERE f.Codigo_EPS=e.Codigo_EPS and e.Codigo_TER=b.Codigo_TER and d.Codigo_ESP=c.Codigo_ESP and a.Codigo_AGE=c.Codigo_AGE and a.Codigo_TER=b.Codigo_TER and a.Codigo_CIT='".$_GET["CITA"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
		document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".hdn_citax".$NumWindow.".value='".$_GET["CITA"]."';
		document.frm_form".$NumWindow.".txt_motivo".$NumWindow.".value='CONSULTA EXTERNA POR ".$row[1]."';
		document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_NombreEPS".$NumWindow.".value='".$row[3]."';
		";
?>
		EpsPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
		NombreTercero('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value, 'gxpacientes');
		document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.value='0000000000';
		FechaActual('hdn_fecfin<?php echo $NumWindow; ?>');
		FechaActual('txt_fechaadm<?php echo $NumWindow; ?>');
		HoraActual('txt_horaadm<?php echo $NumWindow; ?>');
		CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
		PlanPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
		// IngresosAbiertos('<?php echo $NumWindow; ?>');
		document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.focus();
<?php
	}
}

if (isset($_GET["Ingreso"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), a.*, ID_TER, b.Nombre_TER, nombre_cam from czterceros b, gxadmision a  Where a.Codigo_TER=b.Codigo_TER and estado_adm='I' and  LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
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
			document.frm_form".$NumWindow.".fechahosp".$NumWindow.".value='".$row["FechaHosp_ADM"]."';
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
			document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".$row[0]."';
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
		echo '
		$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
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
	EpsPcteCont('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
	PlanPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
	AcompPcte('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value);
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

function HCDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_diagnostico<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_diagnostico<?php echo $NumWindow; ?>').value, document.getElementById('txt_NombreDx<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_NombreDx<?php echo $NumWindow; ?>').value = '';
	}
}

function LoadPcte<?php echo $NumWindow; ?>() {
	IdPte=document.getElementById('txt_paciente<?php echo $NumWindow; ?>').value;
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=ingresoscx', '1.PatientMale.png', 'ingresoscx.php','<?php echo $NumWindow; ?>' );
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
