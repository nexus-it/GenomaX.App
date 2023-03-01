<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	if (isset($_GET["mode"])) {
		$modex=$_GET["mode"];
	} else {
		$modex='nomodal';
	}

?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>"  class="form-horizontal container">
<div class="col-md-12">

	<label class="label label-default">Paciente</label>
	  <div class="row well well-sm">

	  	<div class="col-md-2">

<div class="form-group">
	<label for="txt_idpaciente<?php echo $NumWindow; ?>">Id.</label>
	<div class="input-group">
		<input name="txt_idpaciente<?php echo $NumWindow; ?>" id="txt_idpaciente<?php echo $NumWindow; ?>" type="text"  maxlength="15" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
<?php if($modex=='nomodal') { ?>
		<span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_idpaciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
<?php } ?>
	</div>
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
<label for="cmb_tipoid<?php echo $NumWindow; ?>">Tipo </label>
<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_TID, Concat(Sigla_TID, ' - ', Nombre_TID) from cztipoid order by Codigo_TID";
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
	<label for="txt_expedicion<?php echo $NumWindow; ?>">Exp. en</label>
	<input name="txt_expedicion<?php echo $NumWindow; ?>" type="text"   id="txt_expedicion<?php echo $NumWindow; ?>"  />
</div>
	
	</div>
	<div class=" col-md-2">

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

</div>
</div>
<div class="col-md-12">

	<label class="label label-default">Afiliacion</label>
	  <div class="row well well-sm">

	<div class="col-md-1">

<div class="form-group">
<label for="cmb_TipoPaciente<?php echo $NumWindow; ?>">Tipo Paciente</label>
  <select name="cmb_TipoPaciente<?php echo $NumWindow; ?>" id="cmb_TipoPaciente<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_REG, Nombre_REG from gxtiporegimen order by Codigo_REG";
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
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
  <label for="cmb_TipoAfiliado<?php echo $NumWindow; ?>">Tipo Afiliado</label>
  <select name="cmb_TipoAfiliado<?php echo $NumWindow; ?>" id="cmb_TipoAfiliado<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_TAF, Nombre_TAF from gxtipoafiliacion order by Codigo_TAF";
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
  <label for="cmb_Contrato<?php echo $NumWindow; ?>">Contrato</label>
  <select name="cmb_Contrato<?php echo $NumWindow; ?>" id="cmb_Contrato<?php echo $NumWindow; ?>" onchange="BuscarContrato<?php echo $NumWindow; ?>();">
<?php 
$SQL="Select Codigo_EPS, Nombre_EPS from gxeps where Estado_EPS='1' order by 2";
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
  <label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
  <select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>">
  </select>
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="txt_Rango<?php echo $NumWindow; ?>">Rango</label>
  <select name="txt_Rango<?php echo $NumWindow; ?>" id="txt_Rango<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_RNG, Nombre_RNG from gxrangosalario order by Nombre_RNG";
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
  <label for="txt_Empresa<?php echo $NumWindow; ?>">Empresa</label>
  <input type="text" name="txt_Empresa<?php echo $NumWindow; ?>" id="txt_Empresa<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_Actividad<?php echo $NumWindow; ?>">Actividad</label>
  <input type="text" name="txt_Actividad<?php echo $NumWindow; ?>" id="txt_Actividad<?php echo $NumWindow; ?>" />
</div>

	</div>

</div>
</div>
<div class="col-md-12">

	<label class="label label-default">Datos Personales</label>
	  <div class="row well well-sm">

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
	<div class="col-md-2">

 <div class="form-group">
  <label for="txt_fechanac<?php echo $NumWindow; ?>">Fecha Nacimiento</label>
  <input name="txt_fechanac<?php echo $NumWindow; ?>" type="date" id="txt_fechanac<?php echo $NumWindow; ?>" ><span id="edad<?php echo $NumWindow; ?>"></span> 
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
	<div class="col-md-2">
<div class="form-group">
  <label for="txt_Departamento<?php echo $NumWindow; ?>">Departamento</label>
  <select name="txt_Departamento<?php echo $NumWindow; ?>" id="txt_Departamento<?php echo $NumWindow; ?>" onchange="BuscarDepto<?php echo $NumWindow; ?>('');">
<?php 
$SQL="Select Codigo_DEP, Nombre_DEP from czdepartamentos order by 2";
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
  <label for="txt_Municipio<?php echo $NumWindow; ?>">Municipio</label>
  <select name="txt_Municipio<?php echo $NumWindow; ?>" id="txt_Municipio<?php echo $NumWindow; ?>" >  
  </select>
</div>
	</div>
	<div class="col-md-1">

<div class="form-group">
<label for="cmb_zona<?php echo $NumWindow; ?>">Zona</label>
 <select name="cmb_zona<?php echo $NumWindow; ?>" id="cmb_zona<?php echo $NumWindow; ?>">
 <option value="U">Urbana</option>
 <option value="R">Rural</option>
 </select>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_Barrio<?php echo $NumWindow; ?>">Barrio</label>
  <input type="text" name="txt_Barrio<?php echo $NumWindow; ?>" id="txt_Barrio<?php echo $NumWindow; ?>" />
</div>
	
	</div>
	<div class="col-md-2">

<div class="form-group">
<label for="txt_Direccion<?php echo $NumWindow; ?>">Direccion</label>
  <input type="text" name="txt_Direccion<?php echo $NumWindow; ?>" id="txt_Direccion<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefono</label>
  <input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" />  
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="txt_correo<?php echo $NumWindow; ?>">Correo</label>
 <input type="email" name="txt_correo<?php echo $NumWindow; ?>" id="txt_correo<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="txt_Padre<?php echo $NumWindow; ?>">Responsable</label>
 <input type="text" name="txt_Padre<?php echo $NumWindow; ?>" id="txt_Padre<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="txt_Madre<?php echo $NumWindow; ?>">Telefono</label>
 <input type="text" name="txt_Madre<?php echo $NumWindow; ?>" id="txt_Madre<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="txt_email<?php echo $NumWindow; ?>">Parentesco</label>
 <input name="txt_email<?php echo $NumWindow; ?>" type="text"   id="txt_email<?php echo $NumWindow; ?>"  />
</div>

	</div>

</div>
</div>
<?php
	if ($modex=="modal") {
?>
<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Guardar_pacientesmod('<?php echo $NumWindow; ?>');">Guardar</button>
<?php
	}
?>
</form>

<script >

<?php
	if (isset($_GET["IdPte"])) {
	$SQL="Select * from gxpacientes a, czterceros b where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["IdPte"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "
		document.frm_form".$NumWindow.".txt_idpaciente".$NumWindow.".value='".$_GET["IdPte"]."';";
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_PAC"]!='1'){
			echo "
			MsgBox1('Pacientes','El paciente ".$_GET["IdPte"]." se encuentra inactivo');
			";}
	echo "
		document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".value='".$row["Codigo_TID"]."';
		document.frm_form".$NumWindow.".txt_expedicion".$NumWindow.".value='".$row["Expedicion_TER"]."';
		document.frm_form".$NumWindow.".txt_nombre1".$NumWindow.".value='".$row["Nombre1_PAC"]."';
		document.frm_form".$NumWindow.".txt_nombre2".$NumWindow.".value='".$row["Nombre2_PAC"]."';
		document.frm_form".$NumWindow.".txt_apellido1".$NumWindow.".value='".$row["Apellido1_PAC"]."';
		document.frm_form".$NumWindow.".txt_apellido2".$NumWindow.".value='".$row["Apellido2_PAC"]."';
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".cmb_TipoPaciente".$NumWindow.".value='".$row["Codigo_REG"]."';
		document.frm_form".$NumWindow.".cmb_TipoAfiliado".$NumWindow.".value='".$row["Codigo_TAF"]."';
		document.frm_form".$NumWindow.".cmb_Contrato".$NumWindow.".value='".$row["Codigo_EPS"]."';
		CargarxPlan".$NumWindow."('".$row["Codigo_EPS"]."');
		document.frm_form".$NumWindow.".txt_Rango".$NumWindow.".value='".$row["Codigo_RNG"]."';
		document.frm_form".$NumWindow.".txt_Empresa".$NumWindow.".value='".$row["Empresa_PAC"]."';
		document.frm_form".$NumWindow.".txt_Actividad".$NumWindow.".value='".$row["Actividad_PAC"]."';
		document.frm_form".$NumWindow.".cmb_Sexo".$NumWindow.".value='".$row["Codigo_SEX"]."';
		document.frm_form".$NumWindow.".txt_fechanac".$NumWindow.".value='".($row["FechaNac_PAC"])."';
		document.frm_form".$NumWindow.".cmb_EstCivil".$NumWindow.".value='".$row["EstCivil_PAC"]."';
		document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
		document.frm_form".$NumWindow.".cmb_zona".$NumWindow.".value='".$row["Codigo_ZNA"]."';
		document.frm_form".$NumWindow.".txt_Barrio".$NumWindow.".value='".$row["Barrio_PAC"]."';
		document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
		document.frm_form".$NumWindow.".txt_Madre".$NumWindow.".value='".$row["Madre_PAC"]."';
		document.frm_form".$NumWindow.".txt_Padre".$NumWindow.".value='".$row["Padre_PAC"]."';
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Parentesco_PAC"]."';
		document.frm_form".$NumWindow.".txt_correo".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value='".$row["Codigo_DEP"]."';
		BuscarDepto".$NumWindow."('".$row["Codigo_MUN"]."');
		
		function CargarxPlan".$NumWindow."(Codigo) {
			$.get(Funciones,{'Func':'CargarPlan','value':Codigo},function(data){ 
				document.getElementById('txt_Plan".$NumWindow."').innerHTML=data;
				document.frm_form".$NumWindow.".txt_Plan".$NumWindow.".value='".$row["Codigo_PLA"]."';
			}); 

		}	
		document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value='".$row["Codigo_MUN"]."';
		
	";
	}
	else {
		echo "
	document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".focus();
	BuscarContrato".$NumWindow."();
	BuscarDepto".$NumWindow."('');
		";
	}
	mysqli_free_result($result);
	} else {
		echo "
		BuscarDepto".$NumWindow."('');
		";
	}
?>

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/pacientes.php', '<?php echo $NumWindow; ?>', '&mode=<?php echo $modex; ?>');
	} else {
		AbrirForm('application/forms/pacientes.php', '<?php echo $NumWindow; ?>', '&mode=<?php echo $modex; ?>&IdPte='+document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarContrato<?php echo $NumWindow; ?>() {
	Contra=document.frm_form<?php echo $NumWindow; ?>.cmb_Contrato<?php echo $NumWindow; ?>.value;
	
  CargarPlan('<?php echo $NumWindow; ?>', Contra);
}

function BuscarDepto<?php echo $NumWindow; ?>(Mun) {
	Codigo=document.getElementById('txt_Departamento<?php echo $NumWindow; ?>').value;
	CargarMun('<?php echo $NumWindow; ?>', Codigo, Mun);
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=email]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
