<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  >
<fieldset>
	<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />
<div class="form-group">
<label for="cmb_tipoid<?php echo $NumWindow; ?>">Tipo Id</label>
<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" onchange="javascript:NombreProv();">
<?php 
$SQL="Select Codigo_TID, Nombre_TID, case Sigla_TID when 'NI' then 'NIT' else Sigla_TID end from cztipoid Where Codigo_TID Not in ('8','4', '5', '6', '7') order by Codigo_TID desc";
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

<div class="form-group">
	<label for="txt_idproveedor<?php echo $NumWindow; ?>">No.</label>
	<div class="input-group">	
		<input name="txt_idproveedor<?php echo $NumWindow; ?>" id="txt_idproveedor<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Proveedor" onclick="javascript:CargarSearch('Proveedor', 'txt_idproveedor<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>
<div class="form-group" id="idjuridicaX<?php echo $NumWindow; ?>">
<label for="txt_id<?php echo $NumWindow; ?>">DV</label>
<input name="txt_id<?php echo $NumWindow; ?>" type="text" size="1" maxlength="1" id="txt_id<?php echo $NumWindow; ?>"  />
</div>

<div class="form-group">
<label for="txt_ncomercial<?php echo $NumWindow; ?>">Nombre Proveedor</label>
<input name="txt_ncomercial<?php echo $NumWindow; ?>" type="text" size="35"  id="txt_ncomercial<?php echo $NumWindow; ?>"  />
</div>

<div class="form-group">
<label for="cmb_estado<?php echo $NumWindow; ?>"> Estado</label>
  <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
    <option value="0" style="color:#C00" >Inactivo</option>
    <option value="1" style="color:#060" >Activo</option>
  </select>
</div>

<hr align="center" width="95%" size="1"  class="anulado" />

<div class="form-group">
<label for="txt_rsocial<?php echo $NumWindow; ?>">Razon Social</label>
<input name="txt_rsocial<?php echo $NumWindow; ?>" type="text" size="100"  id="txt_rsocial<?php echo $NumWindow; ?>"  />
</div>

<hr align="center" width="95%" size="1"  class="anulado" />

<div class="form-group">
<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre 1</label>
<input name="txt_nombre1<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_nombre1<?php echo $NumWindow; ?>"  />
</div>

<div class="form-group "  id="idnatural2<?php echo $NumWindow; ?>">
<label for="txt_nombre2<?php echo $NumWindow; ?>">Nombre 2</label>
<input name="txt_nombre2<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_nombre2<?php echo $NumWindow; ?>"  /><br />
</div>

<div class="form-group"  id="idnatural3<?php echo $NumWindow; ?>">
<label for="txt_apellido1<?php echo $NumWindow; ?>">Apellido 1</label>
<input name="txt_apellido1<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_apellido1<?php echo $NumWindow; ?>"  />
</div>

<div class="form-group"  id="idnatural4<?php echo $NumWindow; ?>">
<label for="txt_apellido2<?php echo $NumWindow; ?>">Apellido 2</label>
<input name="txt_apellido2<?php echo $NumWindow; ?>" type="text" size="15"  id="txt_apellido2<?php echo $NumWindow; ?>"  /><br />
</div>

<hr align="center" width="95%" size="1"  class="anulado" />

<div class="form-group">
  <label for="cmb_pais<?php echo $NumWindow; ?>">Pais</label>
  <select name="cmb_pais<?php echo $NumWindow; ?>" id="cmb_pais<?php echo $NumWindow; ?>">
    <?php 
$SQL="Select Codigo_PAI, Nombre_PAI from czpaises order by 2";
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_array($resultz)) 
	{
	?>
    <option value="<?php echo $rowz[0]; ?>"><?php echo ($rowz[1]); ?></option>
    <?php
	}
mysqli_free_result($resultz); 
 ?>
  </select>  
</div>

<div class="form-group">
  <label for="txt_Departamento<?php echo $NumWindow; ?>">Departamento</label>
  	<div class="input-group">	
  		<input name="txt_Departamento<?php echo $NumWindow; ?>" type="text" id="txt_Departamento<?php echo $NumWindow; ?>" size="2" maxlength="2" onkeypress="BuscarDpto<?php echo $NumWindow; ?>(event);" />
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Departamentos" onclick="javascript:CargarSearch('Departamentos', 'txt_Departamento<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  		</span>
  </div>
  <input name="txt_NombreDepto<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreDepto<?php echo $NumWindow; ?>" size="12"/>
</div>
  
<div class="form-group">
  <label for="txt_Municipio<?php echo $NumWindow; ?>">Municipio</label>
  	<div class="input-group">	
  		<input name="txt_Municipio<?php echo $NumWindow; ?>" type="text" id="txt_Municipio<?php echo $NumWindow; ?>" size="3" maxlength="3" onkeypress="BuscarMUN<?php echo $NumWindow; ?>(event);" />
   		<span class="input-group-btn">	
   			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Municipio" onclick="javascript:CargarMUN(document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value);"><i class="fas fa-search"></i></button>
   		</span>
   </div>
  <input name="txt_NombreMnpio<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreMnpio<?php echo $NumWindow; ?>" size="12"/><br />
</div>

<hr align="center" width="95%" size="1"  class="anulado" />

<div class="form-group">
  <label for="txt_Direccion<?php echo $NumWindow; ?>">Direccion</label>
  <input type="text" name="txt_Direccion<?php echo $NumWindow; ?>" id="txt_Direccion<?php echo $NumWindow; ?>" />
</div>

<div class="form-group">
  <label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefono</label>
  <input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" />  <br />
</div>  

<div class="form-group">
  <label for="txt_email<?php echo $NumWindow; ?>">Correo</label>
  <input type="text" name="txt_email<?php echo $NumWindow; ?>" id="txt_email<?php echo $NumWindow; ?>" />
</div>

<hr align="center" width="95%" size="1"  class="anulado" />

<div class="form-group">
  <label for="txt_replegal<?php echo $NumWindow; ?>">Representante Legal</label>
  <input type="text" name="txt_replegal<?php echo $NumWindow; ?>" id="txt_replegal<?php echo $NumWindow; ?>" />
</div>

<div class="form-group">
  <label for="txt_contacto<?php echo $NumWindow; ?>">Contacto</label>
  <input type="text" name="txt_contacto<?php echo $NumWindow; ?>" id="txt_contacto<?php echo $NumWindow; ?>" />  <br />
</div>  

<div class="form-group">
  <label for="txt_cargo<?php echo $NumWindow; ?>">Cargo</label>
  <input type="text" name="txt_cargo<?php echo $NumWindow; ?>" id="txt_cargo<?php echo $NumWindow; ?>" />
</div>

</fieldset>
<?php /* ?>
<fieldset><legend>Datos Tributarios:</legend>
  
<div class="form-group">
  <label for="txt_fechaing<?php echo $NumWindow; ?>">Fecha Ingreso</label>
  <input name="txt_fechaing<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fechaing<?php echo $NumWindow; ?>" size="10" maxlength="10">
 </div> 

<div class="form-group">
  <label for="txt_fecharet<?php echo $NumWindow; ?>">Fecha Retiro</label>
  <input name="txt_fecharet<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fecharet<?php echo $NumWindow; ?>" size="10" maxlength="10"><br />
</div>

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


<hr align="center" width="95%" size="1"  class="anulado" />


</fieldset>
<?php */ ?>


</form>
<script>
<?php
	if (isset($_GET["IdEmp"])) {
	$SQL="Select * from czterceros b left join czproveedores a on b.Codigo_TER=a.Codigo_TER where ID_TER='".$_GET["IdEmp"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "
		document.frm_form".$NumWindow.".txt_idproveedor".$NumWindow.".value='".$_GET["IdEmp"]."';";
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_PRV"]=='0'){
			echo "
			MsgBox1('Proveedores','El proveedor ".$_GET["IdEmp"]." se encuentra inactivo');
			";}
	echo "
		document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".value='".$row["Codigo_TID"]."';
		document.frm_form".$NumWindow.".txt_rsocial".$NumWindow.".value='".$row["RazonSocial_TER"]."';
		document.frm_form".$NumWindow.".txt_ncomercial".$NumWindow.".value='".$row["Nombre_TER"]."';
		document.frm_form".$NumWindow.".txt_nombre1".$NumWindow.".value='".$row["Nombre1_PRV"]."';
		document.frm_form".$NumWindow.".txt_nombre2".$NumWindow.".value='".$row["Nombre2_PRV"]."';
		document.frm_form".$NumWindow.".txt_apellido1".$NumWindow.".value='".$row["Apellido1_PRV"]."';
		document.frm_form".$NumWindow.".txt_apellido2".$NumWindow.".value='".$row["Apellido2_PRV"]."';
		document.frm_form".$NumWindow.".txt_id".$NumWindow.".value='".$row["DigitoVerif_TER"]."';		
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".cmb_pais".$NumWindow.".value='".$row["Codigo_PAI"]."';
		document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value='".$row["Codigo_DEP"]."';
		document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value='".$row["Codigo_MUN"]."';
		NombreDpto('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value);
		NombreMUN('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value, document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value);
		document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
		document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
		document.frm_form".$NumWindow.".txt_replegal".$NumWindow.".value='".$row["Representante_PRV"]."';
		document.frm_form".$NumWindow.".txt_cargo".$NumWindow.".value='".$row["Cargo_PRV"]."';
		document.frm_form".$NumWindow.".txt_contacto".$NumWindow.".value='".$row["Cargo_PRV"]."';
		document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row["Estado_PRV"]."';
		document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$row["Codigo_TER"]."';	
		
		";
		
	}
	else {
		echo "
	document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".focus();
		";
	}
	mysqli_free_result($result); 
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	echo "document.frm_form".$NumWindow.".cmb_pais".$NumWindow.".value='169';";
	}
?>

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
	if (document.getElementById('txt_idproveedor<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/proveedores.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/proveedores.php', '<?php echo $NumWindow; ?>', '&IdEmp='+document.getElementById('txt_idproveedor<?php echo $NumWindow; ?>').value);
	}  
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

function NombreProv() {
	if (document.getElementById('cmb_tipoid<?php echo $NumWindow; ?>').value=="9") {
		document.getElementById('txt_nombre1<?php echo $NumWindow; ?>').disabled=true;
		document.getElementById('txt_nombre2<?php echo $NumWindow; ?>').disabled=true;
		document.getElementById('txt_apellido1<?php echo $NumWindow; ?>').disabled=true;
		document.getElementById('txt_apellido2<?php echo $NumWindow; ?>').disabled=true;
		document.getElementById('txt_rsocial<?php echo $NumWindow; ?>').disabled  = false;
	} else {
		document.getElementById('txt_nombre1<?php echo $NumWindow; ?>').disabled = false;
		document.getElementById('txt_nombre2<?php echo $NumWindow; ?>').disabled= false;
		document.getElementById('txt_apellido1<?php echo $NumWindow; ?>').disabled= false;
		document.getElementById('txt_apellido2<?php echo $NumWindow; ?>').disabled= false;
		document.getElementById('txt_rsocial<?php echo $NumWindow; ?>').disabled=true;
	}
}

NombreProv();

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>