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
<input type="hidden" name="Codigo_TER<?php echo $NumWindow; ?>" id="Codigo_TER<?php echo $NumWindow; ?>" />
<input type="hidden" name="IDAnterior_TER<?php echo $NumWindow; ?>" id="IDAnterior_TER<?php echo $NumWindow; ?>" />
<div class="col-md-12">

	<label class="label label-default">ID Tercero</label>
	  <div class="row well well-sm">
	  <div class="col-md-1">

	<div class="form-group">
	<label for="Codigo_TID<?php echo $NumWindow; ?>">Tipo ID</label>
	<select name="Codigo_TID<?php echo $NumWindow; ?>" id="Codigo_TID<?php echo $NumWindow; ?>" >
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
	<div class="col-md-2">
<div class="form-group">
	<label for="ID_TER<?php echo $NumWindow; ?>">ID.</label>
	<div class="input-group">
		<input name="ID_TER<?php echo $NumWindow; ?>" id="ID_TER<?php echo $NumWindow; ?>" type="text"  maxlength="15" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" onchange="dv<?php echo $NumWindow; ?>();" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
		<span class="input-group-addon" name="DV_TER<?php echo $NumWindow; ?>" id="DV_TER<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; "></span>
		<input type="hidden" name="DigitoVerif_TER<?php echo $NumWindow; ?>" id="DigitoVerif_TER<?php echo $NumWindow; ?>" />
		<?php if($modex=='nomodal') { ?>
		<span class="input-group-btn">
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'ID_TER<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
	<?php } ?>
	</div>
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
	<label for="Expedicion_TER<?php echo $NumWindow; ?>">Exp. en</label>
	<input name="Expedicion_TER<?php echo $NumWindow; ?>" type="text"   id="Expedicion_TER<?php echo $NumWindow; ?>"  />
</div>
	
	</div>
	<div class=" col-md-4">

<div class="form-group">
	<label for="Nombre_TER<?php echo $NumWindow; ?>">Nombre</label>
	<input name="Nombre_TER<?php echo $NumWindow; ?>" type="text"   id="Nombre_TER<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	
	</div>

	<div class=" col-md-4">

<div class="form-group">
	<label for="RazonSocial_TER<?php echo $NumWindow; ?>">Razon Social</label>
	<input name="RazonSocial_TER<?php echo $NumWindow; ?>" type="text"   id="RazonSocial_TER<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	
	</div>

</div>
</div>

<div class="col-md-12">

	<label class="label label-default">Datos Contacto</label>
	  <div class="row well well-sm">

	<div class="col-md-2">

<div class="form-group">
  <label for="Codigo_PAI<?php echo $NumWindow; ?>">País</label>
  <select name="Codigo_PAI<?php echo $NumWindow; ?>" id="Codigo_PAI<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_PAI, Nombre_PAI from czpaises order by 2";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>" <?php if($row[1]=="COLOMBIA") { echo 'selected="selected"'; } ?>><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>  
  </select>
</div>

	</div>
	<div class="col-md-2">
<div class="form-group">
  <label for="Codigot_DEP<?php echo $NumWindow; ?>">Departamento</label>
  <select name="Codigot_DEP<?php echo $NumWindow; ?>" id="Codigot_DEP<?php echo $NumWindow; ?>" onchange="BuscarDepto<?php echo $NumWindow; ?>('');">
<?php 
$SQL="Select Codigo_DEP, Nombre_DEP from czdepartamentos order by 2";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>" ><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>  
  </select>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
  <label for="Codigot_MUN<?php echo $NumWindow; ?>">Municipio</label>
  <select name="Codigot_MUN<?php echo $NumWindow; ?>" id="Codigot_MUN<?php echo $NumWindow; ?>" >  
  </select>
</div>
	</div>
	<div class="col-md-2">

<div class="form-group">
<label for="Direccion_TER<?php echo $NumWindow; ?>">Direccion</label>
  <input type="text" name="Direccion_TER<?php echo $NumWindow; ?>" id="Direccion_TER<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="Telefono_TER<?php echo $NumWindow; ?>">Telefono</label>
  <input type="text" name="Telefono_TER<?php echo $NumWindow; ?>" id="Telefono_TER<?php echo $NumWindow; ?>" />  
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="Web_TER<?php echo $NumWindow; ?>">Sitio Web</label>
 <input type="email" name="Web_TER<?php echo $NumWindow; ?>" id="Web_TER<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
 <label for="Correo_TER<?php echo $NumWindow; ?>">Correo</label>
 <input type="email" name="Correo_TER<?php echo $NumWindow; ?>" id="Correo_TER<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-3">

<div class="form-group">
 <label for="Contacto_TER<?php echo $NumWindow; ?>">Nombre Contacto</label>
 <input type="text" name="Contacto_TER<?php echo $NumWindow; ?>" id="Contacto_TER<?php echo $NumWindow; ?>" />
</div>

	</div>
	
	
</div>
</div>
<div class="col-md-12">

	<label class="label label-default">Informacion Contable</label>
	  <div class="row well well-sm">

	  <div class="col-md-1">

<div class="form-group">
<label for="PersonaNatural_TER<?php echo $NumWindow; ?>">Persona</label>
<select name="PersonaNatural_TER<?php echo $NumWindow; ?>" id="PersonaNatural_TER<?php echo $NumWindow; ?>" >
  <option value="1">NATURAL</option>
  <option value="0">JURIDICA</option>
</select>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
<label for="Codigo_RGN<?php echo $NumWindow; ?>">Regimen</label>
<select name="Codigo_RGN<?php echo $NumWindow; ?>" id="Codigo_RGN<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_RGN, Nombre_RGN from czregimenes";
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
 <label for="CxC_TER<?php echo $NumWindow; ?>">Cuenta por Cobrar</label>
 <input type="text" name="CxC_TER<?php echo $NumWindow; ?>" id="CxC_TER<?php echo $NumWindow; ?>" list="cuentaspuc<?php echo $NumWindow; ?>" onkeypress="refreshlistpuc<?php echo $NumWindow; ?>(this.value);" />
</div>

	</div>
	<div class="col-md-3">

<div class="form-group">
 <label for="CxP_TER<?php echo $NumWindow; ?>">Cuenta por Pagar</label>
 <input type="text" name="CxP_TER<?php echo $NumWindow; ?>" id="CxP_TER<?php echo $NumWindow; ?>" list="cuentaspuc<?php echo $NumWindow; ?>" onkeypress="refreshlistpuc<?php echo $NumWindow; ?>(this.value);" />
</div>

	</div>
	<div class="col-md-3">

<div class="form-group">
<label for="RetVentas_TER<?php echo $NumWindow; ?>">Retención</label>
<select name="RetVentas_TER<?php echo $NumWindow; ?>" id="RetVentas_TER<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_RTE, concat(Tasa_RTE,'% ',Nombre_RTE) from czconceptosretencion Where Estado_RTE='1'";
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
<label for="Cliente_TER<?php echo $NumWindow; ?>">Cliente?</label>
<select name="Cliente_TER<?php echo $NumWindow; ?>" id="Cliente_TER<?php echo $NumWindow; ?>" >
  <option value="0">NO</option>
  <option value="1">SI</option>
</select>
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
<label for="Proveedor_TER<?php echo $NumWindow; ?>">Proveedor?</label>
<select name="Proveedor_TER<?php echo $NumWindow; ?>" id="Proveedor_TER<?php echo $NumWindow; ?>" >
  <option value="0">NO</option>
  <option value="1">SI</option>
</select>
</div>

	</div>
	<div class="col-md-3">

<div class="form-group">
 <label for="RepLegal_TER<?php echo $NumWindow; ?>">Rep. Legal</label>
 <input type="text" name="RepLegal_TER<?php echo $NumWindow; ?>" id="RepLegal_TER<?php echo $NumWindow; ?>" />
</div>

	</div>

	  </div>
</div>
<datalist id="cuentaspuc<?php echo $NumWindow; ?>">
<?php
$SQL="SELECT concat(Codigo_CTA, ' ', Nombre_CTA) from czcuentascont where Codigo_NVL=5 and nombre_cta like '%cuenta%' order by 1 limit 10 ;";
$rstpuc = mysqli_query($conexion, $SQL);
while($rowPUC = mysqli_fetch_array($rstpuc)) {
	echo '<option value="'.$rowPUC[0].'">';
}
mysqli_free_result($rstpuc);
?>
</datalist>

<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Guardar_terceros('<?php echo $NumWindow; ?>');" name="Guardar<?php echo $NumWindow; ?>" id="Guardar<?php echo $NumWindow; ?>">Guardar</button>
</form>

<script >
	
var Funciones="functions/php/nexus/functions.php";
<?php
	if (isset($_GET["tercero"])) {
		$SQL="Select * from czterceros b where ID_TER='".$_GET["tercero"]."'";
		$result = mysqli_query($conexion, $SQL);

		if($row = mysqli_fetch_array($result)) {
			$SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='czterceros' ORDER BY ORDINAL_POSITION;";
			$rstCols = mysqli_query($conexion, $SQL);
			while($rowCols = mysqli_fetch_array($rstCols)) {
			if($rowCols[0]=="Codigot_MUN") {
				echo 'setTimeout(function(){
					document.frm_form'.$NumWindow.'.'.$rowCols[0].$NumWindow.'.value="'.rtrim(ltrim($row[$rowCols[0]])).'";
				},1500);';
			} else {
				echo "
			document.frm_form".$NumWindow.".".$rowCols[0].$NumWindow.".value='".rtrim(ltrim($row[$rowCols[0]]))."';
			";
				if ($rowCols[0]=="Codigot_DEP") {
					echo "BuscarDepto".$NumWindow."('');";
				}
			}

			}
			mysqli_free_result($rstCols);
		
		} else {

			echo "
			document.frm_form".$NumWindow.".ID_TER".$NumWindow.".value='';
			document.frm_form".$NumWindow.".ID_TER".$NumWindow.".value='".$_GET["tercero"]."';
			BuscarDepto".$NumWindow."('');";
		}
		mysqli_free_result($result);
	} else {
		echo "BuscarDepto".$NumWindow."('');";
	}
?>
dv<?php echo $NumWindow; ?>();
function dv<?php echo $NumWindow; ?>() {
	calcDV('ID_TER<?php echo $NumWindow; ?>', 'DigitoVerif_TER<?php echo $NumWindow; ?>');
	document.getElementById('DV_TER<?php echo $NumWindow; ?>').innerHTML =document.getElementById('DigitoVerif_TER<?php echo $NumWindow; ?>').value;
}
function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('ID_TER<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/tercero.php', '<?php echo $NumWindow; ?>', '&mode=<?php echo $modex; ?>');
	} else {
		AbrirForm('application/forms/tercero.php', '<?php echo $NumWindow; ?>', '&mode=<?php echo $modex; ?>&tercero='+document.getElementById('ID_TER<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarDepto<?php echo $NumWindow; ?>(Mun) {
	Codigo=document.getElementById('Codigot_DEP<?php echo $NumWindow; ?>').value;
	CargarMun<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>', Codigo, Mun);
}

function CargarMun<?php echo $NumWindow; ?>(Ventana, Codigo, Muni)
{
	$.get(Funciones,{'Func':'CargarMun','value':Codigo},function(data){ 
		document.getElementById('Codigot_MUN'+Ventana).innerHTML=data;
		if (Muni!='') {
			document.getElementById('Codigot_MUN'+Ventana).value=Muni;
		}
	}); 
}

function refreshlistpuc<?php echo $NumWindow; ?>(texto)
{

	$.get(Funciones,{'Func':'refreshlistpuc','value':texto},function(data){ 
		document.getElementById('cuentaspuc<?php echo $NumWindow; ?>').innerHTML=data;
	}); 
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=email]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
