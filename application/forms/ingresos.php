<?php
	session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">
	<input type="hidden" name="hdn_citax<?php echo $NumWindow; ?>" id="hdn_citax<?php echo $NumWindow; ?>">
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
  		<input required name="txt_paciente<?php echo $NumWindow; ?>" type="text" id="txt_paciente<?php echo $NumWindow; ?>" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');EpsPcte('<?php echo $NumWindow; ?>', this.value);" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL')};" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
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
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'ID_TER=*'+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+'*');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>
	<?php
	$SQL="Select EditDate_XAD, AuthReq_XAD From itconfig_ad;";
	$result = mysqli_query($conexion, $SQL);
	$AuthReq_XAD=' disabled="disabled" Value="." ';
	$EditDate_XAD=' disabled="disabled" ';
	if ($row = mysqli_fetch_array($result)) 
	{
		if($row["AuthReq_XAD"]=="1") {
			$AuthReq_XAD=' ';
		}
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
    $SwSede=0;
    $SQL="Select distinct b.Codigo_SDE, Nombre_SDE From czsedes a, itusuariossedes b Where b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Codigo_SDE=b.Codigo_SDE and Estado_SDE='1'";
    $result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
		$SwSede=1;
 	?>
    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
    <?php
	}
	mysqli_free_result($result);
	if ($SwSede==0) {
		$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE;";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
	 	?>
	    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	    <?php
		}
		mysqli_free_result($result); 
	}
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
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>

		<div class="col-md-3">

	<div class="form-group">
		<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Nombre Contrato	</label>
		<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" />
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
<?php
	$SQL="Select DxReq_XAD from itconfig_ad";
	$result = mysqli_query($conexion, $SQL);
	$DxReq_XAD=' required ';
	if ($row = mysqli_fetch_array($result)) 
	{
		if($row["DxReq_XAD"]=="1") {
			$DxReq_XAD=' ';
		}
	}
 	mysqli_free_result($result);
?>
  <div class="col-md-1">
<div class="form-group">
  <label for="txt_diagnostico<?php echo $NumWindow; ?>">Cód. Dx.</label>
  <div class="input-group">	
 	 <input name="txt_diagnostico<?php echo $NumWindow; ?>" type="text" id="txt_diagnostico<?php echo $NumWindow; ?>"  onblur="HCDxOnBlur<?php echo $NumWindow; ?>();" <?php echo $DxReq_XAD; ?> onkeydown="if(event.keyCode==115){CargarSearch('Diagnostico', 'txt_diagnostico<?php echo $NumWindow; ?>', 'NULL')};" />
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
  <label for="cmb_hosp<?php echo $NumWindow; ?>">Hospitalizar</label>
  <select name="cmb_hosp<?php echo $NumWindow; ?>" id="cmb_hosp<?php echo $NumWindow; ?>" onchange="cambiarhosp<?php echo $NumWindow; ?>();">
 	 <option value="0" >NO</option>
 	 <option value="1" >SI</option>
  </select>
</div> 
  </div>

  <div class="col-md-1">
<div class="form-group">
  <label for="txt_fechahosp<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechahosp<?php echo $NumWindow; ?>" type="date" id="txt_fechahosp<?php echo $NumWindow; ?>" value="0000-00-00"  >
 </div>
   </div>

	<div class="col-md-2">
<div class="form-group">
	<label for="cmb_cama<?php echo $NumWindow; ?>">Cama</label>
	<select name="cmb_cama<?php echo $NumWindow; ?>" id="cmb_cama<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_CAM, Nombre_CAM, Codigo_ARE from gxcamas where Estado_CAM='1' and Ocupada_CAM='0' order by 2 asc";
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
  <label for="txt_remision<?php echo $NumWindow; ?>">Remision</label>
  <input name="txt_remision<?php echo $NumWindow; ?>" type="text" id="txt_remision<?php echo $NumWindow; ?>" size="5" />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_remitido<?php echo $NumWindow; ?>">Valor </label>
  <input name="txt_remitido<?php echo $NumWindow; ?>" type="text" id="txt_remitido<?php echo $NumWindow; ?>" class="" size="8" value="0"/>
 </div>
 	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_fecremision<?php echo $NumWindow; ?>">Fec. Rem.</label>
  <input name="txt_fecremision<?php echo $NumWindow; ?>" type="date"  id="txt_fecremision<?php echo $NumWindow; ?>" value="0000-00-00"  />
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
<input name="txt_autorizacion<?php echo $NumWindow; ?>" type="text" id="txt_autorizacion<?php echo $NumWindow; ?>"  <?php echo $AuthReq_XAD; ?>> />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
<label for="txt_fecautorizacion<?php echo $NumWindow; ?>">Fecha Aut.</label>
<input name="txt_fecautorizacion<?php echo $NumWindow; ?>" type="date"  id="txt_fecautorizacion<?php echo $NumWindow; ?>" value="0000-00-00" />
</div>
	</div>

	<div class="col-md-1">
<div class="form-group">
  <label for="txt_fecfin<?php echo $NumWindow; ?>">Fecha Fin</label>
  <input name="txt_fecfin<?php echo $NumWindow; ?>" type="date" id="txt_fecfin<?php echo $NumWindow; ?>"  value="0000-00-00"/>
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

	<div class="col-md-1">
<div class="form-group">
	<label for="cmb_cuota<?php echo $NumWindow; ?>">C. Moderadora</label>
	<select name="cmb_cuota<?php echo $NumWindow; ?>" id="cmb_cuota<?php echo $NumWindow; ?>">
		<option value="0">NO</option>
		<option value="1">SI</option>
	</select>
</div>
	</div>
	<div class="col-md-1">
<div class="form-group">
	<label for="cmb_copago<?php echo $NumWindow; ?>"> Copago</label>
	<select name="cmb_copago<?php echo $NumWindow; ?>" id="cmb_copago<?php echo $NumWindow; ?>">
		<option value="0">NO</option>
		<option value="1">SI</option>
	</select>
</div>
	</div>

	

	<div class="col-md-5 ">
<div class="form-group">
<label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
<textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="3" id="txt_observacion<?php echo $NumWindow; ?>" ></textarea>
</div>
	</div>
	
		</div>
		<div class="row">
<div class="col-md-1">
<div class="form-group">
	<label for="cmb_escovid<?php echo $NumWindow; ?>">COVID-19?</label>
	<select name="cmb_escovid<?php echo $NumWindow; ?>" id="cmb_escovid<?php echo $NumWindow; ?>" onchange="cambiarcovid<?php echo $NumWindow; ?>();">
		<option value="0">NO</option>
		<option value="9">SOSPECHA</option>
		<option value="1">SI</option>
	</select>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
<label for="cmb_covid19<?php echo $NumWindow; ?>">Síntomas COVID-19</label>
<select name="cmb_covid19<?php echo $NumWindow; ?>" id="cmb_covid19<?php echo $NumWindow; ?>" disabled>
<?php 
$SQL="Select Codigo_CVD, Nombre_CVD from gxcovid19 where Estado_CVD='1' order by Codigo_CVD asc";
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
<label for="cmb_covid19gr<?php echo $NumWindow; ?>">Clasif. COVID-19</label>
<select name="cmb_covid19gr<?php echo $NumWindow; ?>" id="cmb_covid19gr<?php echo $NumWindow; ?>" disabled>
<?php 
$SQL="Select Codigo_CVG, Nombre_CVG from gxcovid19grupos where Estado_CVG='1' order by Codigo_CVG asc";
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

</form>

<script >
FechaActual('txt_fechahosp<?php echo $NumWindow; ?>');
document.getElementById("cmb_covid19gr<?php echo $NumWindow; ?>").disabled = true;
document.getElementById("cmb_covid19<?php echo $NumWindow; ?>").disabled = true;
document.getElementById("txt_fechahosp<?php echo $NumWindow; ?>").disabled = true;
document.getElementById("cmb_cama<?php echo $NumWindow; ?>").disabled = true;
<?php
// Se verifica si en la IPS se tienen camas habilitadas
$SQL="Select count(codigo_cam) from gxcamas where Estado_CAM='1' and Ocupada_CAM='0'";
$result = mysqli_query($conexion, $SQL);
if($row = mysqli_fetch_array($result))  {
	if ($row[0]=="0") {
 ?>
document.getElementById("cmb_hosp<?php echo $NumWindow; ?>").disabled = true;
<?php
	}
} else {
?>
document.getElementById("cmb_hosp<?php echo $NumWindow; ?>").disabled = true;
<?php

}
mysqli_free_result($result);
 

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

if (isset($_GET["Ingreso"])) {	
	$SQL="Select date(fecha_adm), time(fecha_adm), LPAD(Codigo_ADM,10,'0'), a.*, ID_TER, b.Nombre_TER, a.codigo_cam from czterceros b, gxadmision a left join gxcamas c on c.codigo_cam=a.codigo_cam Where a.Codigo_TER=b.Codigo_TER and estado_adm='I' and  LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
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
			document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_fecfin".$NumWindow.".value='".$row["FechaFin_ADM"]."';
			document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".cmb_copago".$NumWindow.".value='".$row["Copago_ADM"]."';
			document.frm_form".$NumWindow.".cmb_cuota".$NumWindow.".value='".$row["Cuota_ADM"]."';
			document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
			document.frm_form".$NumWindow.".cmb_tipopct".$NumWindow.".value='".$row["Codigo_PTT"]."';
			document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row["LPAD(Codigo_ADM,10,'0')"]."';
			document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row["ID_TER"]."';
			NombreTercero('".$NumWindow."', '".$row["ID_TER"]."', 'gxpacientes');
			document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value='".$row["Codigo_EPS"]."';
			NombreContrato('".$NumWindow."', document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value);
			document.frm_form".$NumWindow.".cmb_riesgo".$NumWindow.".value='".$row["Codigo_CXT"]."';
			document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row["Codigo_SDE"]."';
			document.frm_form".$NumWindow.".cmb_TipoIng".$NumWindow.".value='".$row["Ingreso_ADM"]."';
			document.frm_form".$NumWindow.".cmb_finconsulta".$NumWindow.".value='".$row["Codigo_FNC"]."';
			document.frm_form".$NumWindow.".txt_fechahosp".$NumWindow.".value='".$row["FechaHosp_ADM"]."';
			document.frm_form".$NumWindow.".cmb_cama".$NumWindow.".value='".$row["codigo_cam"]."';
			document.frm_form".$NumWindow.".txt_remitido".$NumWindow.".value='".$row["ValorRemitido_ADM"]."';
			document.frm_form".$NumWindow.".txt_diagnostico".$NumWindow.".value='".$row["Codigo_DGN"]."';
			NombreDiagnostico('".$NumWindow."', document.frm_form".$NumWindow.".txt_diagnostico".$NumWindow.".value);
			document.frm_form".$NumWindow.".txt_remision".$NumWindow.".value='".$row["Remision_ADM"]."';
			document.frm_form".$NumWindow.".txt_fecremision".$NumWindow.".value='".$row["FechaRemision_ADM"]."';
			document.frm_form".$NumWindow.".txt_ips".$NumWindow.".value='".$row["IPS_ADM"]."';
			document.frm_form".$NumWindow.".txt_motivo".$NumWindow.".value='".$row["Motivo_ADM"]."';
			document.frm_form".$NumWindow.".txt_acudiente".$NumWindow.".value='".$row["Acudiente_ADM"]."';
			document.frm_form".$NumWindow.".txt_direccion".$NumWindow.".value='".$row["Direccion_ADM"]."';
			document.frm_form".$NumWindow.".txt_telefono".$NumWindow.".value='".$row["Telefono_ADM"]."';
			document.frm_form".$NumWindow.".txt_autorizacion".$NumWindow.".value='".$row["Autorizacion_ADM"]."';
			document.frm_form".$NumWindow.".txt_observacion".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", "<br/>",$row["Observaciones_ADM"])."';
			HCDxOnBlur".$NumWindow."();
			function CargarxPlan".$NumWindow."(Codigo) {
				$.get(Funciones,{'Func':'CargarPlan','value':Codigo},function(data){ 
					document.getElementById('txt_Plan".$NumWindow."').innerHTML=data;
					document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
				}); 

			}
		";
		$SQL="Select Codigo_CVD, Codigo_CVG, Estado_CVD from  gxadmcovid19 a Where  LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
		$results = mysqli_query($conexion, $SQL);
		if($rows = mysqli_fetch_array($results)) {
			echo "
			document.frm_form".$NumWindow.".cmb_escovid".$NumWindow.".value='".$rows[2]."';
			document.frm_form".$NumWindow.".cmb_covid19".$NumWindow.".value='".$rows[0]."';
			document.frm_form".$NumWindow.".cmb_covid19gr".$NumWindow.".value='".$rows[1]."';
			cambiarcovid".$NumWindow."();
			";
		}
		mysqli_free_result($results); 
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
$SQL="Select count(*) from gxcamas where estado_cam='1'";
$resultc = mysqli_query($conexion, $SQL);
if($rowc = mysqli_fetch_array($resultc)) {
	if($rowc[0]==0) {
		echo "		document.getElementById('cmb_cama".$NumWindow."').setAttribute('disabled', true);";
	}
}
mysqli_free_result($resultc); 
?>

function cambiarhosp<?php echo $NumWindow; ?>() {
	if(document.getElementById('cmb_cama<?php echo $NumWindow; ?>').disabled) {
		document.getElementById("cmb_cama<?php echo $NumWindow; ?>").disabled = false;
		document.getElementById("txt_fechahosp<?php echo $NumWindow; ?>").disabled = false;
	} else {
		document.getElementById("cmb_cama<?php echo $NumWindow; ?>").disabled = true;
		document.getElementById("txt_fechahosp<?php echo $NumWindow; ?>").disabled = true;
	}
}

function cambiarcovid<?php echo $NumWindow; ?>() {
	if(document.getElementById('cmb_escovid<?php echo $NumWindow; ?>').value=="0") {
		document.getElementById("cmb_covid19<?php echo $NumWindow; ?>").disabled = true;
		document.getElementById("cmb_covid19gr<?php echo $NumWindow; ?>").disabled = true;
	} else {
		document.getElementById("cmb_covid19<?php echo $NumWindow; ?>").disabled = false;
		document.getElementById("cmb_covid19gr<?php echo $NumWindow; ?>").disabled = false;
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
		AbrirForm('application/forms/ingresos.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
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
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=ingresoscx', '1.PatientMale.png', 'ingresos.php','<?php echo $NumWindow; ?>' );
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
