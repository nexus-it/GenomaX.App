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
<legend>Responder ODS:</legend>
<label for="txt_ods<?php echo $NumWindow; ?>">No. ODS</label>
<input name="hdn_odsx<?php echo $NumWindow; ?>" type="hidden" id="hdn_odsx<?php echo $NumWindow; ?>" />
<input name="txt_ods<?php echo $NumWindow; ?>" id="txt_ods<?php echo $NumWindow; ?>" type="text" size="12" maxlength="15" onkeypress="BuscarODS<?php echo $NumWindow; ?>(event);" />
<a href="javascript:CargarSearch('ODS2', 'txt_ods<?php echo $NumWindow; ?>', 'Estado_ODS=*0*');"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/showhelp.png"  alt="Buscar ODS" align="absmiddle" title="Buscar ODS" /></a> 
<label for="txt_usuarioods<?php echo $NumWindow; ?>">Usuario </label><input name="txt_usuarioods<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_usuarioods<?php echo $NumWindow; ?>" size="35"  />
<br />
<label for="txt_nombreods<?php echo $NumWindow; ?>">Título </label><input name="txt_nombreods<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_nombreods<?php echo $NumWindow; ?>" size="35"  /> 
<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha </label>
  <input name="txt_fecha<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="datepicker" id="txt_fecha<?php echo $NumWindow; ?>" value="<?php echo FormatoFecha($FechaActual); ?>" size="10" maxlength="10">
  <input name="txt_hora<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_hora<?php echo $NumWindow; ?>" value="<?php echo date("H:i:s"); ?>" size="10" maxlength="10"><br />
<label for="txt_solicitud<?php echo $NumWindow; ?>">Descripción de Solicitud </label><br />
<textarea name="txt_solicitud<?php echo $NumWindow; ?>" cols="120" rows="3" disabled="disabled" id="txt_solicitud<?php echo $NumWindow; ?>" style="margin-left: 10px;" ></textarea>
<br />
<label for="cmb_clasificacion<?php echo $NumWindow; ?>">Clasificación</label>
<select name="cmb_clasificacion<?php echo $NumWindow; ?>" id="cmb_clasificacion<?php echo $NumWindow; ?>"  >
  <option value="H" selected="selected">Hardware</option>
  <option value="S">Software</option>
</select>
</fieldset>
<?php  
?>
<fieldset id="fld_resp<?php echo $NumWindow; ?>">
<legend>Descripción:</legend>
<div style="text-align:right" >
<label for="txt_fechaprog<?php echo $NumWindow; ?>">Programar </label>
  <input name="txt_fechaprog<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fechaprog<?php echo $NumWindow; ?>" value="<?php echo FormatoFecha($FechaActual); ?>" size="10" maxlength="10">
  <input name="txt_horaprog<?php echo $NumWindow; ?>" type="text" id="txt_horaprog<?php echo $NumWindow; ?>" value="<?php echo date("H:i:s"); ?>" size="10" maxlength="10">
<a href="javascript:AddProg<?php echo $NumWindow; ?>()"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/add.png" class="imgenabled<?php echo $NumWindow; ?>" alt="Agregar programación" align="absmiddle" title="Agregar programación" /></a>
</div>
<hr align="center" width="95%" size="1"  class="anulado" />
<label for="txt_fechawork<?php echo $NumWindow; ?>">Nueva tarea </label>
  <input name="txt_fechawork<?php echo $NumWindow; ?>" type="text" class="datepicker" id="txt_fechawork<?php echo $NumWindow; ?>" value="<?php echo FormatoFecha($FechaActual); ?>" size="10" maxlength="10">
  <input name="txt_horawork<?php echo $NumWindow; ?>" type="text" id="txt_horawork<?php echo $NumWindow; ?>" value="<?php echo date("H:i:s"); ?>" size="10" maxlength="10">
  <label for="txt_tarea<?php echo $NumWindow; ?>">Descripción </label>
  <input name="txt_tarea<?php echo $NumWindow; ?>" type="text" id="txt_tarea<?php echo $NumWindow; ?>" value="" size="90">
  <a href="javascript:AddWork<?php echo $NumWindow; ?>()"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/add.png" class="imgenabled<?php echo $NumWindow; ?>" alt="Agregar tarea" align="absmiddle" title="Agregar tarea" /></a>
  <br />
<hr align="center" width="95%" size="1"  class="anulado" />
 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord" >
<table width="97%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblRespuestas<?php echo $NumWindow; ?>">
<tbody id="tbDetalle<?php echo $NumWindow; ?>">
  <tr>
    <th scope="col">Fecha</th>
    <th scope="col">Hora</th>
    <th colspan="2" scope="col">Descripción</th>
  </tr>
</tbody>
</table>
<input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
</div>
</fieldset>
</form>
<script >

<?php
if (isset($_GET["numods"])) {
	$SQL="Select Codigo_ODS, Titulo_ODS, Solicitud_ODS, Fecha_ODS, Estado_ODS, FechaProg_ODS, Nombre_USR, Clasificacion_ODS from myodssol a, itusuarios b Where a.Codigo_USR=b.Codigo_USR and Codigo_ODS='".$_GET["numods"]."';";
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
			document.frm_form".$NumWindow.".txt_solicitud".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", " ",$row["Solicitud_ODS"])."';
			document.frm_form".$NumWindow.".txt_usuarioods".$NumWindow.".value='".$row["Nombre_USR"]."';
			";
		if ($row["Clasificacion_ODS"]=="S") {
			echo "document.frm_form".$NumWindow.".cmb_clasificacion".$NumWindow.".value='S';";
		} else {
			echo "document.frm_form".$NumWindow.".cmb_clasificacion".$NumWindow.".value='H';";
		}
		if ($row["Estado_ODS"]=="1") {
			echo "
				document.frm_form".$NumWindow.".cmb_clasificacion".$NumWindow.".disabled='disabled';
				document.getElementByClass('imgenabled".$NumWindow."').style.display = 'none';
			";
		}
		if ($row["FechaProg_ODS"]=="") {
			echo "
				MsgBox1('Solicitud ODS','La orden de servicio ".$_GET["numods"]." aún no ha sido programada.');
				document.frm_form".$NumWindow.".cmb_clasificacion".$NumWindow.".focus();
			";
		}
	} else {
	echo "
		MsgBox1('Respuesta ODS','La orden de servicio ".$_GET["numods"]." no existe.');
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".value='';
		document.frm_form".$NumWindow.".hdn_odsx".$NumWindow.".value='';
		document.getElementById('fld_resp".$NumWindow."').style.display = 'none';
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".focus();
		";
	}
	mysqli_free_result($result); 
} else {
	echo "
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".value='';
		document.frm_form".$NumWindow.".hdn_odsx".$NumWindow.".value='';
		document.frm_form".$NumWindow.".txt_ods".$NumWindow.".focus();
		document.getElementById('fld_resp".$NumWindow."').style.display = 'none';
		";
}

//Aca van las respuestas...
	$SQL="Select Codigo_ODS, Tarea_ODS, FechaTarea_ODS from myodsres Where Codigo_ODS='".$_GET["numods"]."' Order By FechaTarea_ODS asc;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
		$fechacorta=substr($row["FechaTarea_ODS"], 0,10);
		$lahora=substr($row["FechaTarea_ODS"], 10,10);
		echo "
			AgregarResp".$NumWindow."('".FormatoFecha($fechacorta)."','".$lahora."','".$row["Tarea_ODS"]."');
		";
		
	}
	mysqli_free_result($result); 
?>
function DeleteWork<?php echo $NumWindow; ?>(Fila) {
    var miTabla = document.getElementById("tblRespuestas<?php echo $NumWindow; ?>");     
    $('#tr'+Fila+'<?php echo $NumWindow; ?>').remove();
}

function AddProg<?php echo $NumWindow; ?>() {
	AgregarResp<?php echo $NumWindow; ?>("<?php echo FormatoFecha($FechaActual); ?>", '<?php echo date("H:i:s"); ?>', "Fecha de Programación de Servicio: "+document.getElementById('txt_fechaprog<?php echo $NumWindow; ?>').value+" a las "+document.getElementById('txt_horaprog<?php echo $NumWindow; ?>').value);
}

function AddWork<?php echo $NumWindow; ?>() {
	AgregarResp<?php echo $NumWindow; ?>(document.getElementById('txt_fechawork<?php echo $NumWindow; ?>').value, document.getElementById('txt_horawork<?php echo $NumWindow; ?>').value, document.getElementById('txt_tarea<?php echo $NumWindow; ?>').value);
	document.frm_form<?php echo $NumWindow; ?>.txt_tarea<?php echo $NumWindow; ?>.value='';
	horaact=document.getElementById('txt_horawork<?php echo $NumWindow; ?>').value;
	parametros=horaact.split(":");
	hora=parametros[0];
	minuto=parseInt(parametros[1])+1;
	if (minuto>59) {
		minuto=00;
		hora=parseInt(parametros[0])+1;
	}
	if (minuto<10) {
		minuto='0'+minuto;
	}
	horanueva=hora+':'+minuto+':'+parametros[2];
	document.frm_form<?php echo $NumWindow; ?>.txt_horawork<?php echo $NumWindow; ?>.value=horanueva;
	document.frm_form<?php echo $NumWindow; ?>.txt_tarea<?php echo $NumWindow; ?>.focus();
}

function AgregarResp<?php echo $NumWindow; ?>(Item1, Item2, Item3) {
	if (Item3=="") {
		MsgBox1('ODS','Debe digitar una descripción de la tarea.');
	} else {
	TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
	var miTabla = document.getElementById("tblRespuestas<?php echo $NumWindow; ?>"); 
	var fila = document.createElement("tr"); 
	var celda1 = document.createElement("td"); 
	var celda2 = document.createElement("td"); 
	var celda3 = document.createElement("td"); 
	var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	celda1.innerHTML =Item1+'<input type="hidden" name="hdn_fecha'+TotalFilas+'<?php echo $NumWindow; ?>" id="hdn_fecha'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Item1+'" />';
	celda2.innerHTML =Item2+'<input type="hidden" name="hdn_hora'+TotalFilas+'<?php echo $NumWindow; ?>" id="hdn_hora'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Item2+'" />';
	celda3.innerHTML =Item3+'<input type="hidden" name="hdn_tarea'+TotalFilas+'<?php echo $NumWindow; ?>" id="hdn_tarea'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Item3+'" />';
	celda4.innerHTML ='<a href="javascript:DeleteWork<?php echo $NumWindow; ?>(\''+TotalFilas+'\')"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/remove.png" class="imgenabled<?php echo $NumWindow; ?>" alt="Eliminar tarea" align="right" title="Eliminar tarea" /></a>';
	fila.appendChild(celda1); 
	fila.appendChild(celda2); 
	fila.appendChild(celda3); 
	fila.appendChild(celda4); 
	miTabla.appendChild(fila); 
	document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
	}
}

function BuscarODS<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_ods<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/respuestaods.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/respuestaods.php', '<?php echo $NumWindow; ?>', '&numods='+document.getElementById('txt_ods<?php echo $NumWindow; ?>').value);
	}  
  }
}

</script>