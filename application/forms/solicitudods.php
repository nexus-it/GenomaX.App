<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
	$SQL="Select date(now()), time(now());";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
			$FechaActual=$row[0];
			$HoraActual=$row[1];
		}
	mysqli_free_result($result); 	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" >
<fieldset>
<legend>Solicitud ODS:</legend>
<label for="txt_ods<?php echo $NumWindow; ?>">No. ODS</label>
<input type="hidden" name="hdn_odsx<?php echo $NumWindow; ?>" id="hdn_odsx<?php echo $NumWindow; ?>" />
<input name="txt_ods<?php echo $NumWindow; ?>" id="txt_ods<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarODS<?php echo $NumWindow; ?>(event);" />
<a href="javascript:CargarSearch('ODS', 'txt_ods<?php echo $NumWindow; ?>', 'Estado_ODS=*0*');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/showhelp.png"  alt="Buscar ODS" align="absmiddle" title="Buscar ODS" /></a> 
<br />
<label for="txt_nombreods<?php echo $NumWindow; ?>">Título </label><input name="txt_nombreods<?php echo $NumWindow; ?>" type="text" id="txt_nombreods<?php echo $NumWindow; ?>" size="35" maxlength="50"  /> 
<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha </label>
  <input name="txt_fecha<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fecha<?php echo $NumWindow; ?>" size="10" maxlength="10" value="<?php echo FormatoFecha($FechaActual); ?>">
  <input name="txt_hora<?php echo $NumWindow; ?>" type="text" id="txt_hora<?php echo $NumWindow; ?>" size="10" maxlength="10" value="<?php echo date("H:i:s"); ?>"><br />
<label for="txt_solicitud<?php echo $NumWindow; ?>">Descripción de Solicitud </label><br />
<textarea name="txt_solicitud<?php echo $NumWindow; ?>" cols="120" rows="3" id="txt_solicitud<?php echo $NumWindow; ?>" style="margin-left: 10px;" ></textarea>
</fieldset>
<?php  
if (isset($_GET["numods"])) {
?>
<fieldset id="fld_resp<?php echo $NumWindow; ?>">
<legend>Respuestas ODS:</legend>
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblRespuestas<?php echo $NumWindow; ?>">
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
  <tr>
    <th scope="col">Responsable</th>
    <th scope="col">Fecha</th>
    <th scope="col">Hora</th>
    <th scope="col">Descripción</th>
  </tr>
</tbody>
</table>
<input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
</fieldset>

<fieldset id="fld_est<?php echo $NumWindow; ?>">
<legend>Estado ODS:</legend>
<div style="float:left">
<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" onchange="javascript:CambioEstado<?php echo $NumWindow; ?>();" >
  <option value="0" selected="selected">Abierta</option>
  <option value="1">Cerrada</option>
</select>
</div>
<span id="califica<?php echo $NumWindow; ?>">
<div style="float:left">
<label for="txt_calificacion<?php echo $NumWindow; ?>">Nivel de satisfacción</label>
<input name="txt_calificacion<?php echo $NumWindow; ?>" type="text" id="txt_calificacion<?php echo $NumWindow; ?>" size="2" maxlength="2" readonly="readonly" onchange="javascript:TextCalif<?php echo $NumWindow; ?>();" /> 
%
</div>
<div id="sld_calificacion<?php echo $NumWindow; ?>" style="width:50%; float:left; margin-top:5px; margin-left:10px;"></div>
<div id="div_sugerencias<?php echo $NumWindow; ?>" style="float:left">
<label for="txt_textcalif<?php echo $NumWindow; ?>">Observaciones y/o Sugerencias</label>
<input name="txt_textcalif<?php echo $NumWindow; ?>" type="text" id="txt_textcalif<?php echo $NumWindow; ?>"  value="" size="40" maxlength="150" />
</div>
</span>
</fieldset>
<?php 
}
?>

</form>
<script >
<?php  
if (isset($_GET["numods"])) {
?>
$(function() {
	$( "#sld_calificacion<?php echo $NumWindow; ?>" ).slider({
		range: "min",
		min: 0,
		max: 10,
		value: 10,
		slide: function( event, ui ) {
			$( "#txt_calificacion<?php echo $NumWindow; ?>" ).val( ui.value *10);
			if ($( "#txt_calificacion<?php echo $NumWindow; ?>" ).val()==100) {
				document.getElementById("div_sugerencias<?php echo $NumWindow; ?>").style.display  = 'none';
				document.frm_form<?php echo $NumWindow; ?>.txt_textcalif<?php echo $NumWindow; ?>.value="";
			} else {
				document.getElementById("div_sugerencias<?php echo $NumWindow; ?>").style.display  = 'block';
				document.frm_form<?php echo $NumWindow; ?>.txt_textcalif<?php echo $NumWindow; ?>.focus();
			}
		}
	});
	$( "#txt_calificacion<?php echo $NumWindow; ?>" ).val( $( "#sld_calificacion<?php echo $NumWindow; ?>" ).slider( "value" )*10 );
});

document.getElementById("div_sugerencias<?php echo $NumWindow; ?>").style.display  = 'none';
document.getElementById("califica<?php echo $NumWindow; ?>").style.display  = 'none';
<?php 
}
?>

function CambioEstado<?php echo $NumWindow; ?>() {
	if (document.getElementById('cmb_estado<?php echo $NumWindow; ?>').value=="1") {
		document.frm_form<?php echo $NumWindow; ?>.txt_calificacion<?php echo $NumWindow; ?>.value="100";
		document.getElementById("califica<?php echo $NumWindow; ?>").style.display  = 'block';
	} else {
		document.getElementById("califica<?php echo $NumWindow; ?>").style.display  = 'none';
	}
}

function TextCalif<?php echo $NumWindow; ?>() {
	alert(document.getElementById('txt_calificacion<?php echo $NumWindow; ?>').value);
}

<?php
if (isset($_GET["numods"])) {
	$SQL="Select Codigo_ODS, Titulo_ODS, Solicitud_ODS, Fecha_ODS, Estado_ODS, FechaProg_ODS, Observaciones_ODS, Calificacion_ODS from myodssol Where Codigo_ODS='".$_GET["numods"]."' and Codigo_USR='".$_SESSION["it_CodigoUSR"]."';";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		$fechacorta=substr($row["Fecha_ODS"], 0,10);
		$lahora=substr($row["Fecha_ODS"], 10,10);
		echo "
			document.frm_form".$NumWindow.".txt_ods".$NumWindow.".value='".$row["Codigo_ODS"]."';
			document.frm_form".$NumWindow.".hdn_odsx".$NumWindow.".value='".$row["Codigo_ODS"]."';
			document.frm_form".$NumWindow.".txt_nombreods".$NumWindow.".value='".$row["Titulo_ODS"]."';
			document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".FormatoFecha($fechacorta)."';
			document.frm_form".$NumWindow.".txt_hora".$NumWindow.".value='".$lahora."';
			document.frm_form".$NumWindow.".txt_solicitud".$NumWindow.".value='".$row["Solicitud_ODS"]."';
			document.frm_form".$NumWindow.".txt_solicitud".$NumWindow.".disabled='disabled';
			document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".disabled='disabled';
			document.frm_form".$NumWindow.".txt_nombreods".$NumWindow.".disabled='disabled';
			document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row["Estado_ODS"]."';
			document.frm_form".$NumWindow.".txt_calificacion".$NumWindow.".value='".$row["Calificacion_ODS"]."';
			document.frm_form".$NumWindow.".txt_textcalif".$NumWindow.".value='".$row["Observaciones_ODS"]."';
			document.frm_form".$NumWindow.".txt_ods".$NumWindow.".focus();
			";
		if ($row["Estado_ODS"]=="1") {
			echo "
				document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".disabled='disabled';
				document.getElementById('sld_calificacion".$NumWindow."').style.display = 'none';
			";
		}
		if ($row["FechaProg_ODS"]=="") {
			echo "
				MsgBox1('Solicitud ODS','La orden de servicio ".$_GET["numods"]." aún no ha sido programada.');
			";
		} 
	} else {
	echo "
		MsgBox1('Solicitud ODS','La orden de servicio ".$_GET["numods"]." no puede ser visualizada.');
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".value='000000';
		document.frm_form".$NumWindow.".hdn_odsx".$NumWindow.".value='000000';
		document.getElementById('fld_resp".$NumWindow."').style.display = 'none';
		document.getElementById('fld_est".$NumWindow."').style.display = 'none';
		document.frm_form".$NumWindow.".txt_nombreods".$NumWindow.".focus();
		";
	}
	mysqli_free_result($result); 
} else {
	echo "
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".value='000000';
		document.frm_form".$NumWindow.".hdn_odsx".$NumWindow.".value='000000';
		document.frm_form".$NumWindow.".txt_nombreods".$NumWindow.".focus();
		";
}

//Aca van las respuestas...
	$SQL="Select Codigo_ODS, Tarea_ODS, FechaTarea_ODS, Nombre_USR from myodsres a, itusuarios b Where a.Codigo_USR=b.Codigo_USR and Codigo_ODS='".$_GET["numods"]."' Order By FechaTarea_ODS asc;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
		$fechacorta=substr($row["FechaTarea_ODS"], 0,10);
		$lahora=substr($row["FechaTarea_ODS"], 10,10);
		echo "
			AgregarResp".$NumWindow."('".$row["Nombre_USR"]."', '".FormatoFecha($fechacorta)."','".$lahora."','".$row["Tarea_ODS"]."');
		";
		
	}
	mysqli_free_result($result); 
?>

function AgregarResp<?php echo $NumWindow; ?>(Item1, Item2, Item3, Item4) {
	TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
	var miTabla = document.getElementById("tblRespuestas<?php echo $NumWindow; ?>"); 
	var fila = document.createElement("tr"); 
	var celda1 = document.createElement("td"); 
	var celda2 = document.createElement("td"); 
	var celda3 = document.createElement("td"); 
	var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	celda1.innerHTML =Item1;
	celda2.innerHTML =Item2;
	celda3.innerHTML =Item3;
	celda4.innerHTML =Item4;
	fila.appendChild(celda1); 
	fila.appendChild(celda2); 
	fila.appendChild(celda3); 
	fila.appendChild(celda4); 
	miTabla.appendChild(fila); 
	document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;

}

function BuscarODS<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_ods<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/solicitudods.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/solicitudods.php', '<?php echo $NumWindow; ?>', '&numods='+document.getElementById('txt_ods<?php echo $NumWindow; ?>').value);
	}  
  }
}

</script>