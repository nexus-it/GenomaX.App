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
<legend>Factura:</legend>
<input type="hidden" name="hdn_Ingreso<?php echo $NumWindow; ?>" id="hdn_Ingreso<?php echo $NumWindow; ?>" />

<div class="form-group">
  <label for="txt_Ingreso<?php echo $NumWindow; ?>">Codigo Ingreso</label>
  <div class="input-group">
  <input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" size="10" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" />
  	 <span class="input-group-btn">
 		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*F*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	 </span>
   </div>
</div>



 <div class="form-group"> 
  <label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_fechaadm<?php echo $NumWindow; ?>" size="10" maxlength="10">
</div>

 <div class="form-group"> 
  <label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
  <input name="txt_horaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_horaadm<?php echo $NumWindow; ?>" size="8" maxlength="8"><br />
</div>

<div class="form-group">  
  <label for="txt_Motivo<?php echo $NumWindow; ?>">Motivo Anulaci&oacute;n</label>
  <input name="txt_Motivo<?php echo $NumWindow; ?>" type="text" id="txt_Motivo<?php echo $NumWindow; ?>" size="60" maxlength="255" />
</div>

</fieldset>
<?php flush; ?>
<fieldset>
  <legend>Datos:</legend>
  <div id="datosing<?php echo $NumWindow; ?>" class="tblDetalle1">
  Digite el n&uacute;mero de ingreso...
</div>
</fieldset>
<?php flush; ?>
</form>
<script >

<?php
	if (isset($_GET["Ingreso"])) {
	$SQL="Select Codigo_FAC, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC From gxfacturas Where Estado_Fac<>'0' and LPAD(Codigo_ADM,10,'0')=LPAD(".$_GET["Ingreso"].",10,'0')";
	$result = mysqli_query($conexion, $SQL);	
	$Temp='<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2"><tr><th scope="col">FACTURA</th><th scope="col">FECHA</th><th scope="col">VAL. PCTE.</th><th scope="col">VAL. ENTIDAD</th></tr>';
	while($row = mysqli_fetch_array($result)) {
		$Temp=$Temp.'<tr><td align="center">'.$row[0].'</td><td align="center">'.$row[1].'</td><td align="right">'.$row[2].'</td><td align="right">'.$row[3].'</td></tr>';
	}
	mysqli_free_result($result); 	
	$Temp=$Temp.'</table>';
	
	$SQL="Select LPAD(Codigo_ADM,10,'0'), DATE_FORMAT(Fecha_ADM, '%d/%m/%Y'), TIME_FORMAT(Fecha_ADM, '%H:%i:%s'), a.ID_TER, a.Nombre_TER, c.Nombre_TER, Nombre_PLA, Nombre_CXT, Descripcion_ADM, Motivo_ADM, Autorizacion_ADM, DATE_FORMAT(FechaAutorizacion_ADM, '%d/%m/%Y'), Observaciones_ADM 
from czterceros a, gxadmision b, czterceros c, gxeps d, gxplanes e, gxtipoingreso f, gxcausaexterna cxt where cxt.Codigo_CXT=b.Codigo_CXT and e.Codigo_PLA=b.Codigo_PLA and a.Codigo_TER=b.Codigo_TER and d.Codigo_TER=c.Codigo_TER and trim(b.Codigo_EPS)=trim(d.Codigo_EPS) and b.Ingreso_ADM=f.Tipo_ADM and b.Estado_ADM='F' and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
	$result = mysqli_query($conexion, $SQL);	
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".hdn_Ingreso".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[2]."';
		InsertarHTML('datosing".$NumWindow."', ' <p><label>Paciente: </label>".$row[3]." - ".$row[4]."   </p> <p> <label>Contrato: </label>".$row[5]." <label>Plan: </label> ".$row[6]."  </p> <p>  <label>Tipo de riesgo: </label>".$row[7]." <label>Ingreso por: </label> ".$row[8]."  </p> <p>  <label>Motivo Consulta: </label>".$row[9]."   </p> <p>  <label>No. autorizacion: </label>".$row[10]." <label>Fecha autorizacion: </label> ".$row[11]." </p> <p> <label>Observaciones: </label>".preg_replace("/\r\n|\n|\r/", "<br/>",$row[12])." </p> <hr align=\"center\" width=\"90%\" size=\"1\" />".$Temp."');
	";
	}
	else {
		echo "
		MsgBox1('Anular Factura','<div class=\"message_alert\"></div>El ingreso ".$_GET["Ingreso"]." no se encuentra facturado');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function CargarIngreso() {
	CargarSearch('Ingresos', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*F*');
}

function BuscarIng<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
		AbrirForm('application/forms/facturasaludno.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
  }
}

 $("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    


</script>
