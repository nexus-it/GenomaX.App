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
<legend>Orden de Servicio:</legend>
<input type="hidden" name="hdn_Orden<?php echo $NumWindow; ?>" id="hdn_Orden<?php echo $NumWindow; ?>" />

<div class="form-group">
  <label for="txt_Orden<?php echo $NumWindow; ?>">Codigo</label>
  <div class="input-group">
  	<input name="txt_Orden<?php echo $NumWindow; ?>" type="text" id="txt_Orden<?php echo $NumWindow; ?>" size="10" onkeypress="BuscarOrd<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('ordenesdeservicio', 'txt_Orden<?php echo $NumWindow; ?>', 'Estado_ORD=*1*')};" />
  	  <span class="input-group-btn">	
  		<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ordenesdeservicio" onclick="javascript:CargarSearch('ordenesdeservicio', 'txt_Orden<?php echo $NumWindow; ?>', 'Estado_ORD=*1*');"><i class="fas fa-search"></i></button>
      </span>
   </div>
</div>


<div class="form-group">
  <label for="txt_fechaord<?php echo $NumWindow; ?>">Fecha</label>
  <input name="txt_fechaord<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_fechaord<?php echo $NumWindow; ?>" size="10" maxlength="10">
</div>  

<div class="form-group">  
   <label for="txt_area<?php echo $NumWindow; ?>">Area</label>
  <input name="txt_area<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_area<?php echo $NumWindow; ?>" size="20" ><br />
</div>

<div class="form-group">
    <label for="txt_desc<?php echo $NumWindow; ?>">Descripci&oacute;n</label>
    <input name="txt_desc<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_desc<?php echo $NumWindow; ?>" size="55" >
</div>

</fieldset>
<?php flush; ?>
<fieldset>
  <legend>Datos:</legend>
  <div id="datosing<?php echo $NumWindow; ?>" class="tblDetalle1">
  Digite el n&uacute;mero de la orden de servicio...
</div>
</fieldset>
<?php flush; ?>
</form>
<script >

<?php
	if (isset($_GET["Orden"])) {
	$SQL="Select a.Codigo_SER, CUPS_PRC, Nombre_SER, Cantidad_ORD from gxservicios a, gxordenesdet b, gxprocedimientos c Where c.Codigo_SER=b.Codigo_SER  AND a.Codigo_SER=b.Codigo_SER and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0') 
	Union 
	Select a.Codigo_SER, CUM_MED, Nombre_SER, Cantidad_ORD from gxservicios a, gxordenesdet b, gxmedicamentos c Where c.Codigo_SER=b.Codigo_SER  AND a.Codigo_SER=b.Codigo_SER and LPAD(Codigo_ORD,10,'0')=LPAD(".$_GET["Orden"].",10,'0')";
	$result = mysqli_query($conexion, $SQL);	
	$Temp='<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2"><tr><th scope="col">Codigo</th><th scope="col">Servicio</th><th scope="col">Cantidad</th></tr>';
	while($row = mysqli_fetch_array($result)) {
		$Temp=$Temp.'<tr><td align="left">'.$row[1].'</td><td align="left">'.$row[2].'</td><td align="center">'.$row[3].'</td></tr>';
	}
	mysqli_free_result($result); 	
	$Temp=$Temp.'</table>';
	$SQL="Select LPAD(b.Codigo_ADM,10,'0'), DATE_FORMAT(Fecha_ADM, '%d/%m/%Y'), TIME_FORMAT(Fecha_ADM, '%H:%i:%s'), a.ID_TER, a.Nombre_TER, c.Nombre_TER, Nombre_PLA, Nombre_CXT, Descripcion_ADM, Motivo_ADM, Autorizacion_ADM, DATE_FORMAT(FechaAutorizacion_ADM, '%d/%m/%Y'), Observaciones_ADM,
	LPAD(g.Codigo_ORD,10,'0'), DATE_FORMAT(Fecha_ORD, '%d/%m/%Y'), Nombre_ARE, Descripcion_ORD 
from czterceros a, gxadmision b, czterceros c, gxeps d, gxplanes e, gxtipoingreso f, gxordenescab g, gxareas h, gxcausaexterna cxt where cxt.Codigo_CXT=b.Codigo_CXT and e.Codigo_PLA=b.Codigo_PLA and a.Codigo_TER=b.Codigo_TER and d.Codigo_TER=c.Codigo_TER and trim(b.Codigo_EPS)=trim(d.Codigo_EPS) and b.Ingreso_ADM=f.Tipo_ADM and b.Estado_ADM='I' and LPAD(g.Codigo_ORD,10,'0')=LPAD('".$_GET["Orden"]."',10,'0') and g.Codigo_ADM=b.Codigo_ADM and g.Estado_ORD='1' and h.Codigo_ARE=g.Codigo_ARE";
	$result = mysqli_query($conexion, $SQL);	
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Orden".$NumWindow.".value='".$row[13]."';
		document.frm_form".$NumWindow.".hdn_Orden".$NumWindow.".value='".$row[13]."';
		document.frm_form".$NumWindow.".txt_fechaord".$NumWindow.".value='".$row[14]."';
		document.frm_form".$NumWindow.".txt_area".$NumWindow.".value='".$row[15]."';
		document.frm_form".$NumWindow.".txt_desc".$NumWindow.".value='".$row[16]."';
		InsertarHTML('datosing".$NumWindow."', '  <p>   <label>Ingreso: </label>   ".$row[0]."     <label>Fecha Ingreso : </label>    ".$row[1]." ".$row[2]." </p><p><label>Paciente: </label>".$row[3]." - ".$row[4]."   </p> <p> <label>Contrato: </label>".$row[5]." <label>Plan: </label> ".$row[6]."  </p> <label>Ingreso por: </label> ".$row[8]." <label>Motivo Consulta: </label>".$row[9]."   </p> <hr align=\"center\" width=\"90%\" size=\"1\" />".$Temp."');
	";
	}
	else {
		echo "
		MsgBox1('Anular Orden','<div class=\"message_alert\"></div>La orden de servicio ".$_GET["Orden"]." no se encuentra activa');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function CargarOrden() {
	CargarSearch('ordenesdeservicio', 'txt_Orden<?php echo $NumWindow; ?>', 'Estado_ORD=*1*');
}

function BuscarOrd<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
		AbrirForm('application/forms/ordenesdeserviciono.php', '<?php echo $NumWindow; ?>', '&Orden='+document.getElementById('txt_Orden<?php echo $NumWindow; ?>').value);
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
