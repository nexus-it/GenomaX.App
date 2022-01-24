<?php


session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
<div class="row">

		<div class="col-md-1">

<div class="form-group">
	<label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">
		<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" onkeypress="BuscarCodigo<?php echo $NumWindow; ?>(event);" value="XX"/>
		<span class="input-group-btn">
	      <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_codigo<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
	    </span>
	</div>
</div>
		</div>
		<div class="col-md-3">
<div class="form-group">
	<label for="txt_nombreeps<?php echo $NumWindow; ?>">Descripcion Contrato</label>
	<input name="txt_nombreeps<?php echo $NumWindow; ?>" type="text" id="txt_nombreeps<?php echo $NumWindow; ?>" style="font-size:14px; font-weight: bold;"/>
</div>
		</div>
		<div class="col-md-1 col-md-offset-7">
<div class="form-group">
	<label for="txt_estado<?php echo $NumWindow; ?>">Estado</label>
	<select name="txt_estado<?php echo $NumWindow; ?>" id="txt_estado<?php echo $NumWindow; ?>">
	  <option value="1">Activo</option>
	  <option value="0">Inactivo</option>
	</select>
</div>

	</div>

</div>
<h4><label class="label label-success"> <span class="glyphicon glyphicon-record" aria-hidden="true"></span> Datos Entidad</label></h4>
	  		<div class="row well well-sm">
		
		<div class="col-md-2">

<div class="form-group">
	<label for="txt_nit<?php echo $NumWindow; ?>">NIT</label>
	<div class="input-group">
	<input name="txt_nit<?php echo $NumWindow; ?>" type="text" id="txt_nit<?php echo $NumWindow; ?>" />
		<span class="input-group-btn">
	      <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Tercero" onclick="javascript:CargarSearch('Tercero', 'txt_nit<?php echo $NumWindow; ?>', 'Codigo_TID=*9*');"><i class="fas fa-search"></i></button>
	    </span>
	</div>
</div>
		</div>
		<div class="col-md-4">

<div class="form-group">
<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre Tercero</label>
<input name="txt_nombre<?php echo $NumWindow; ?>" type="text" id="txt_nombre<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-1">

<div class="form-group">
<label for="txt_codmin<?php echo $NumWindow; ?>">Cód. Ministerio</label>
<input type="text" name="txt_codmin<?php echo $NumWindow; ?>" id="txt_codmin<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-3">

<div class="form-group">
	<label for="txt_tipoeps<?php echo $NumWindow; ?>">Tipo Entidad</label>
	<select name="txt_tipoeps<?php echo $NumWindow; ?>" id="txt_tipoeps<?php echo $NumWindow; ?>">
	    <?php 
	$SQL="Select Tipo_EPS, Descripcion_EPS from gxtipoeps order by Tipo_EPS";
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
<label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefono</label>
<input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" />
</div>
		</div>
		<div class="col-md-3">

<div class="form-group">
<label for="txt_email<?php echo $NumWindow; ?>">Correo Electronico</label>
<input name="txt_email<?php echo $NumWindow; ?>" type="text"  id="txt_email<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-1">

<div class="form-group">
	<label for="cmb_facxorden<?php echo $NumWindow; ?>">Factura</label>
	<select name="cmb_facxorden<?php echo $NumWindow; ?>" id="cmb_facxorden<?php echo $NumWindow; ?>">
	  <option value="0">Agrupar por Concepto de Facturación</option>
	  <option value="1">Agrupar por Orden de Servicio</option>
	</select>
</div>
		</div>

</div>
<h4><label class="label label-success"> <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Detalle Contrato</label></h4>
	  		<div class="row well well-sm">

	  	<div class="col-md-2">

<div class="form-group">
	<label for="txt_contrato<?php echo $NumWindow; ?>">No. Contrato</label>
	<input name="txt_contrato<?php echo $NumWindow; ?>" type="text" id="txt_contrato<?php echo $NumWindow; ?>"  style="color: #8b1329;font-size:15px; text-align:center;font-weight: bold;"/>
</div>
	
		</div>
		
		<div class="col-md-1">

<div class="form-group">
	<label for="cmb_tipocontrato<?php echo $NumWindow; ?>">Tipo Contrato</label>
	<select name="cmb_tipocontrato<?php echo $NumWindow; ?>" id="cmb_tipocontrato<?php echo $NumWindow; ?>">
	  <option value="EVENTO">EVENTO</option>
	  <option value="CAPITA">CAPITA</option>
	</select>
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_valorcapita<?php echo $NumWindow; ?>">Valor Contrato</label>
<input name="txt_valorcapita<?php echo $NumWindow; ?>" type="text"  id="txt_valorcapita<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-2">


<div class="form-group">
<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicio</label>
<input name="txt_fechaini<?php echo $NumWindow; ?>" type="date" id="txt_fechaini<?php echo $NumWindow; ?>" />
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Fin</label>
<input name="txt_fechafin<?php echo $NumWindow; ?>" type="date" id="txt_fechafin<?php echo $NumWindow; ?>" />
</div>
		
		</div>
		<div class="col-md-1">

<div class="form-group">
<label for="txt_facvence<?php echo $NumWindow; ?>">Factura Vence</label>
<input name="txt_facvence<?php echo $NumWindow; ?>" type="number" id="txt_facvence<?php echo $NumWindow; ?>" value="60" min="0" max="365"/>
</div>
		
		</div>
		<div class="col-md-12">
<div class="form-group">
<label for="txt_observaciones<?php echo $NumWindow; ?>">Observaciones</label>
<textarea name="txt_observaciones<?php echo $NumWindow; ?>" cols="60" rows="3" id="txt_observaciones<?php echo $NumWindow; ?>"></textarea>
</div>

		</div>

</div>

<h4><label class="label label-success"> <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Contacto</label></h4>
	<div class="row well well-sm">
		<div class="col-md-3">

<div class="form-group">
<label for="txt_namecontact<?php echo $NumWindow; ?>">Nombres</label>
<input name="txt_namecontact<?php echo $NumWindow; ?>" type="text"  id="txt_namecontact<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-3">

<div class="form-group">
<label for="txt_lastnamecontact<?php echo $NumWindow; ?>">Apellidos</label>
<input name="txt_lastnamecontact<?php echo $NumWindow; ?>" type="text"  id="txt_lastnamecontact<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_emailcontact<?php echo $NumWindow; ?>">Correo</label>
<input name="txt_emailcontact<?php echo $NumWindow; ?>" type="text"  id="txt_emailcontact<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_phonecontact<?php echo $NumWindow; ?>">Telefono</label>
<input name="txt_phonecontact<?php echo $NumWindow; ?>" type="text"  id="txt_phonecontact<?php echo $NumWindow; ?>"  />
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_cellcontact<?php echo $NumWindow; ?>">Celular</label>
<input name="txt_cellcontact<?php echo $NumWindow; ?>" type="text"  id="txt_cellcontact<?php echo $NumWindow; ?>"  />
</div>
		</div>
	</div>
</form>

<script >

<?php
	if (isset($_GET["Codigo"])) {
		echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["Codigo"]."';";
	$SQL="Select * from gxeps a, czterceros b where a.Codigo_TER=b.Codigo_TER and Codigo_EPS='".$_GET["Codigo"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_EPS"]!='1'){
			echo "
			MsgBox1('Contratos','El Contrato ".$_GET["Codigo"]." se encuentra inactivo');
			";}
	echo "
		document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$row["Codigo_EPS"]."';
		document.frm_form".$NumWindow.".txt_tipoeps".$NumWindow.".value='".$row["Tipo_EPS"]."';
		document.frm_form".$NumWindow.".txt_nit".$NumWindow.".value='".$row["ID_TER"]."';
		document.frm_form".$NumWindow.".txt_nombreeps".$NumWindow.".value='".$row["Nombre_EPS"]."';
		document.frm_form".$NumWindow.".cmb_tipocontrato".$NumWindow.".value='".$row["TipoContrato_EPS"]."';
		document.frm_form".$NumWindow.".txt_valorcapita".$NumWindow.".value='".$row["ValorCapita_EPS"]."';
		document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row["Nombre_TER"]."';
		document.frm_form".$NumWindow.".txt_codmin".$NumWindow.".value='".$row["CodMin_EPS"]."';
		document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
		document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".txt_contrato".$NumWindow.".value='".$row["Contrato_EPS"]."';
		document.frm_form".$NumWindow.".txt_estado".$NumWindow.".value='".$row["Estado_EPS"]."';
		document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='".($row["FechaIni_EPS"])."';
		document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='".($row["FechaFin_EPS"])."';
		document.frm_form".$NumWindow.".cmb_facxorden".$NumWindow.".value='".($row["FacXOrd_EPS"])."';
		document.frm_form".$NumWindow.".txt_observaciones".$NumWindow.".value='".$row["Observaciones_EPS"]."';
		document.frm_form".$NumWindow.".txt_namecontact".$NumWindow.".value='".($row["NameContact_EPS"])."';
		document.frm_form".$NumWindow.".txt_lastnamecontact".$NumWindow.".value='".($row["LastnameContact_EPS"])."';
		document.frm_form".$NumWindow.".txt_phonecontact".$NumWindow.".value='".($row["PhoneContact_EPS"])."';
		document.frm_form".$NumWindow.".txt_cellcontact".$NumWindow.".value='".($row["CellContact_EPS"])."';
		document.frm_form".$NumWindow.".txt_emailcontact".$NumWindow.".value='".($row["EmailContact_EPS"])."';
		document.frm_form".$NumWindow.".txt_facvence".$NumWindow.".value='".($row["VenceFactura_EPS"])."';
		
	";
	}
	mysqli_free_result($result); 
	}else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarCodigo<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/contratos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/contratos.php', '<?php echo $NumWindow; ?>', '&Codigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");

</script>