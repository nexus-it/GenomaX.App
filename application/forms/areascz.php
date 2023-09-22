<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
  <fieldset>
<legend>Areas:</legend>
   
<div class="form-group">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
    <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="4" onkeypress="BuscarARE<?php echo $NumWindow; ?>(event);" />
</div>   

<div class="form-group">
    <label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
    <input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="35" />
</div> 

<div class="form-group">
 <label for="cmb_cc<?php echo $NumWindow; ?>">Centro de Costo</label>
 <select name="cmb_cc<?php echo $NumWindow; ?>" id="cmb_cc<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_CCT, Nombre_CCT from czcentrocosto order by Codigo_CCT";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>  
 </select> <br />
</div>

<div class="form-group">
	<label for="txt_idempleado<?php echo $NumWindow; ?>">Responsable </label>
	<div class="input-group">	
		<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Empleado" onclick="javascript:CargarSearch('Empleado', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
	</div>
    <input name="txt_responsable<?php echo $NumWindow; ?>" type="text" id="txt_responsable<?php echo $NumWindow; ?>" size="60" readonly="readonly" /> <br />
</div>

<div class="form-group">
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1">Activo</option>
  <option value="0">Inactivo</option>
</select>
</div>

<hr align="center" width="95%" size="1" class="anulado">

<div class="form-group">
	<label for="txt_emple<?php echo $NumWindow; ?>">Agregar empleado</label>
	<div class="input-group">	
		<input name="txt_emple<?php echo $NumWindow; ?>" id="txt_emple<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarEmp2<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Empleado" onclick="javascript:CargarSearch('Empleado', 'txt_emple<?php echo $NumWindow; ?>', 'NULL');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/showhelp.png"  alt="Buscar Empleado" align="absmiddle" title="Buscar Empleado" /></a> 
		</span>
    </div>
		<input name="txt_nomemple<?php echo $NumWindow; ?>" type="text" id="txt_nomemple<?php echo $NumWindow; ?>" size="60" readonly="readonly" /><a href="javascript:NuevaFilaempleado();"><i class="fas fa-search"></i></button>
</div>


<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord">
<table width="97%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblRespuestas<?php echo $NumWindow; ?>">
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
  <tr>
    <th colspan="2" scope="col">Empleado</th>
  </tr>
<?php
	$contafilas=0;
	if (isset($_GET["CodigoARE"])) {
  	$SQL="Select ID_EMP, Nombre_TER From czterceros a, czempleados b, czareasterceros c Where a.Codigo_TER=b.Codigo_TER and b.Codigo_TER=c.Codigo_TER and c.Codigo_ARE='".$_GET["CodigoARE"]."' Order By 2";
	$resultz = mysqli_query($conexion, $SQL);
	while($rowz = mysqli_fetch_array($resultz)) 
		{
			$contafilas++;
?>
<tr id="tr<?php echo $contafilas; ?><?php echo $NumWindow; ?>"><td><input name="hdn_codemple<?php echo $contafilas; ?><?php echo $NumWindow; ?>" type="hidden" id="hdn_codemple<?php echo $contafilas; ?><?php echo $NumWindow; ?>" value="<?php echo ($rowz[0]); ?>"><?php echo ($rowz[1]); ?></td><td><a href="javascript:EliminarFilaOrden('<?php echo $contafilas; ?>','<?php echo $NumWindow; ?>');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/remove.png" alt="Eliminar" align="absmiddle" title="Eliminar empleado de esta area"></a></td></tr>
<?php
		}
	mysqli_free_result($resultz);
    }
 ?>
</tbody>
</table>
<input name="hdn_contro<?php echo $NumWindow; ?>" type="hidden" id="hdn_contro<?php echo $NumWindow; ?>" value="<?php echo $contafilas; ?>">
</div>

  </fieldset>
  <fieldset>
<legend>Listado de Areas:</legend>
<div id="listaareas<?php echo $NumWindow; ?>" >
Cargando...
</div>
</fieldset>
</form>

<script >
<?php
	if (isset($_GET["CodigoARE"])) {
	$SQL="Select Codigo_ARE, Nombre_ARE, Estado_ARE, Codigo_CCT, ID_TER, Nombre_TER from czareas a, czterceros b Where a.Codigo_TER=b.Codigo_TER and Codigo_ARE='".$_GET["CodigoARE"]."'";
	echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoARE"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_ARE"]."';
			document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row["Estado_ARE"]."';		
			document.frm_form".$NumWindow.".cmb_cc".$NumWindow.".value='".$row["Codigo_CCT"]."';
			document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$row["ID_TER"]."';
			document.frm_form".$NumWindow.".txt_responsable".$NumWindow.".value='".$row["Nombre_TER"]."';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarARE<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/areascz.php', '<?php echo $NumWindow; ?>', '&CodigoARE=0');
	} else {
		AbrirForm('application/forms/areascz.php', '<?php echo $NumWindow; ?>', '&CodigoARE='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarEmp<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	  NombreEmple('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_idempleado<?php echo $NumWindow; ?>.value);
  }
}

function BuscarEmp2<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreEmple2('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_emple<?php echo $NumWindow; ?>.value);
  }
}

function NuevaFilaempleado() {
	var cedula = document.getElementById("txt_emple<?php echo $NumWindow; ?>");
	var emple = document.getElementById("txt_nomemple<?php echo $NumWindow; ?>");
	var totfilas = document.getElementById("hdn_contro<?php echo $NumWindow; ?>");
	AgregarFilaEmple(cedula.value, emple.value, '<?php echo $NumWindow; ?>', totfilas.value, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>')
}

function ListadoAreas<?php echo $NumWindow; ?>(Destino) 
{
	$.get(Funciones,{'Func':'ListadoAreas', 'ventana':'<?php echo $NumWindow; ?>'},function(data){ 
		document.getElementById(Destino).innerHTML=data;
	}); 
}

ListadoAreas<?php echo $NumWindow; ?>('listaareas<?php echo $NumWindow; ?>');

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
