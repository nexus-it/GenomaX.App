<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset>
<legend>General:</legend>

<div class="form-group">
	<label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">	
		<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="6" maxlength="6" onkeypress="BuscarServ<?php echo $NumWindow; ?>(event);" >
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ServiciosX" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codigo<?php echo $NumWindow; ?>', 'Tipo_SER=*2*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		</span>
	</div>
</div>

<div class="form-group">
<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>" size="25">
</div>

<div class="form-group">
<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
  <option value="1" selected>Activo</option>
  <option value="0">Inactivo</option>
</select><br />
</div>

<div class="form-group">
<label for="txt_conceptofact<?php echo $NumWindow; ?>">Concepto Facturacion</label>
<select name="txt_conceptofact<?php echo $NumWindow; ?>" id="txt_conceptofact<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Codigo_CFC, Nombre_CFC from gxconceptosfactura order by Codigo_CFC";
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
<label for="txt_complejidad<?php echo $NumWindow; ?>">Complejidad</label>
<input name="txt_complejidad<?php echo $NumWindow; ?>" type="text" id="txt_complejidad<?php echo $NumWindow; ?>" size="1" maxlength="1"><br />
</div>

<div class="form-group">
<label for="txt_edadminima<?php echo $NumWindow; ?>">Edad Minima</label>
<input name="txt_edadminima<?php echo $NumWindow; ?>" type="text" id="txt_edadminima<?php echo $NumWindow; ?>" value="0" size="3" maxlength="3"> 
Años
</div>

<div class="form-group">
<label for="txt_edadmaxima<?php echo $NumWindow; ?>">Edad Maxima</label>
<input name="txt_edadmaxima<?php echo $NumWindow; ?>" type="text" id="txt_edadmaxima<?php echo $NumWindow; ?>" value="120" size="3" maxlength="3"> 
Años 
</div>

<div class="form-group">
<label for="txt_masculino<?php echo $NumWindow; ?>">Masculino</label>
<input name="txt_masculino<?php echo $NumWindow; ?>" type="checkbox" id="txt_masculino<?php echo $NumWindow; ?>" value="M" checked>
</div>

<div class="form-group">
<label for="txt_femenino<?php echo $NumWindow; ?>">Femenino</label>
<input name="txt_femenino<?php echo $NumWindow; ?>" type="checkbox" id="txt_femenino<?php echo $NumWindow; ?>" value="F" checked>
</div>

</fieldset>
<div id="div_productos<?php echo $NumWindow; ?>" >
<fieldset>
<legend>Datos Producto:</legend>
<label for="txt_codigoprod<?php echo $NumWindow; ?>">Codigo Producto</label>
<input name="txt_codigoprod<?php echo $NumWindow; ?>" type="text" id="txt_codigoprod<?php echo $NumWindow; ?>" size="15">
<label for="txt_cum<?php echo $NumWindow; ?>">CUM</label>
<input name="txt_cum<?php echo $NumWindow; ?>" type="text" id="txt_cum<?php echo $NumWindow; ?>" size="15">
<label for="txt_cups<?php echo $NumWindow; ?>">CUPS</label>
<input name="txt_cups<?php echo $NumWindow; ?>" type="text" id="txt_cups<?php echo $NumWindow; ?>" size="15">
</fieldset>
</div>

<div id="div_productos<?php echo $NumWindow; ?>" >
<fieldset>
<legend>Lista Precios:</legend>
<label for="txt_costo<?php echo $NumWindow; ?>">Costo Promedio</label>
<input name="txt_costo<?php echo $NumWindow; ?>" type="text" id="txt_costo<?php echo $NumWindow; ?>" size="15" disabled>
<div class="table-responsive">
<table class="table table-striped table-condensed">
  <tr>
  	<th>#</th><th >Tarifa</th><th >Precio Venta Actual</th>
  </tr>
<?php
	$SQL="Select Codigo_TAR, Nombre_TAR From gxtarifas Order By Codigo_TAR";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
	
?>  
  <tr>
  	<th scope="row"><?php echo $row[0]; ?></th><td ><?php echo $row[1]; ?></td><td ><input name="txt_tarifa<?php echo $row[0].$NumWindow; ?>" type="text" id="txt_tarifa<?php echo $row[0].$NumWindow; ?>" size="15" ></td>
  </tr>
<?php
	}
	mysqli_free_result($result); 
?>
</table>
</div>
</fieldset>
</div>
</form>
<script>
<?php
	if (isset($_GET["txtcodigo"])) {	
	$SQL="Select LPAD(Codigo_SER,6,'0'), Nombre_SER, Tipo_SER, Codigo_CFC, EdadMinima_SER, EdadMaxima_SER, SexoM_SER, SexoF_SER, Complejidad_SER, Estado_SER From gxservicios where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["txtcodigo"]."',6,'0')";
	$resultX = mysqli_query($conexion, $SQL);
	if($rowX = mysqli_fetch_array($resultX)) {
	echo "
		document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$rowX[0]."';
		document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$rowX[1]."';
		document.frm_form".$NumWindow.".txt_conceptofact".$NumWindow.".value='".$rowX[3]."';
		document.frm_form".$NumWindow.".txt_edadminima".$NumWindow.".value='".$rowX[4]."';
		document.frm_form".$NumWindow.".txt_edadmaxima".$NumWindow.".value='".$rowX[5]."';
		document.frm_form".$NumWindow.".txt_masculino".$NumWindow.".value='".$rowX[6]."';
		document.frm_form".$NumWindow.".txt_femenino".$NumWindow.".value='".$rowX[7]."';
		document.frm_form".$NumWindow.".txt_complejidad".$NumWindow.".value='".$rowX[8]."';
		document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$rowX[9]."';
	";
	$TipoServ=$rowX[2];
	}
	else {
		echo "
		MsgBox1('Referencias','No se encuentra el producto ".$_GET["txtcodigo"]."');
		";
	}
	mysqli_free_result($resultX); 
	
	$SQL="Select Codigo_MED, CUPS_MED, CUM_MED, Costo_MED from gxmedicamentos where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["txtcodigo"]."',6,'0')";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_codigoprod".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_cum".$NumWindow.".value='".$row[2]."';
		document.frm_form".$NumWindow.".txt_cups".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_costo".$NumWindow.".value='".$row[3]."';
	";
	}
	mysqli_free_result($result); 

	$SQL="Select Codigo_TAR, Valor_TAR from gxmanualestarifarios where LPAD(Codigo_SER,6,'0')=LPAD('".$_GET["txtcodigo"]."',6,'0') AND  curdate() between FechaIni_TAR and FechaFin_TAR;";
	$resultY = mysqli_query($conexion, $SQL);
	while($rowY = mysqli_fetch_array($resultY)) {
	echo "
		document.frm_form".$NumWindow.".txt_tarifa".$rowY[0].$NumWindow.".value='".$rowY[1]."';
	";
	}
	mysqli_free_result($result); 


	
	
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarServ<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if ((document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value='000000';
		document.frm_form<?php echo $NumWindow; ?>.txt_nombre<?php echo $NumWindow; ?>.focus();
	} else {
		AbrirForm('application/forms/referencias.php', '<?php echo $NumWindow; ?>', '&txtcodigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>