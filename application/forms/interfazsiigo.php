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
<legend>Interfaz Contable SIIGO:</legend>
  <label for="txt_Contrato<?php echo $NumWindow; ?>">Contrato</label>
  <input name="txt_Contrato<?php echo $NumWindow; ?>" type="text" id="txt_Contrato<?php echo $NumWindow; ?>" size="4" onkeypress="BuscarContrato<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*')};" /><a href="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*');"><img src="http://cdn.genomax.co/media/image/showhelp.png"  alt="Buscar Entidad" align="absmiddle" title="Buscar Entidad" /></a><label>-</label>
  <input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" size="22"/>
<label for="txt_Plan<?php echo $NumWindow; ?>">Plan</label>
  <select name="txt_Plan<?php echo $NumWindow; ?>" id="txt_Plan<?php echo $NumWindow; ?>">
  </select>
</fieldset>
<fieldset>
<legend>Opciones:</legend>
  <label for="fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
  <input name="fechaini<?php echo $NumWindow; ?>" type="text" class="datepicker" id="fechaini<?php echo $NumWindow; ?>" value="00/00/0000" size="10" maxlength="10">
  <label for="fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
  <input name="fechafin<?php echo $NumWindow; ?>" type="text" class="datepicker" id="fechafin<?php echo $NumWindow; ?>" value="00/00/0000" size="10" maxlength="10">
</fieldset>
<fieldset>
<legend>Archivos Planos...</legend>
  <div id="datosrips<?php echo $NumWindow; ?>" class="tblDetalle1">
    -- No se han generado archivos a&uacute;n -- 
  </div>
</fieldset>
</form>
<script >
<?php
	if (isset($_GET["Radicacion"])) {
	$SQL="Select LPAD(a.Codigo_RAD,10,'0'), DATE_FORMAT(a.Fecha_RAD, '%d/%m/%Y'), Case a.Estado_RAD When '1' Then 'Sin Confirmar' When '2' Then 'Confirmado' End, Case a.Estado_RAD When '1' Then '00/00/0000' When '2' Then DATE_FORMAT(a.FechaConf_RAD, '%d/%m/%Y') End, Concat('[ ',c.Codigo_EPS,' ] ',d.Nombre_TER), Concat(d.ID_TER,'-',d.DigitoVerif_TER), e.Nombre_PLA, Count(b.Codigo_FAC), sum(f.ValEntidad_FAC)
From czradicacionescab as a, czradicacionesdet as b, gxeps as c, czterceros as d, gxplanes as e, gxfacturas as f  
Where a.Codigo_RAD=b.Codigo_RAD and d.Codigo_TER=c.Codigo_TER and c.Codigo_EPS=a.Codigo_EPS and e.Codigo_PLA=a.Codigo_PLA and f.Codigo_FAC=b.Codigo_FAC and LPAD(a.Codigo_RAD,10,'0')=LPAD('".$_GET["Radicacion"]."',10,'0')
Group By LPAD(a.Codigo_RAD,10,'0'), DATE_FORMAT(a.Fecha_RAD, '%d/%m/%Y'), Case a.Estado_RAD When '1' Then 'Sin Confirmar' When '2' Then 'Confirmado' End, Case a.Estado_RAD When '1' Then '00/00/0000' When '2' Then DATE_FORMAT(a.FechaConf_RAD, '%d/%m/%Y') End, Concat('[ ',c.Codigo_EPS,' ]',d.Nombre_TER), Concat(d.ID_TER,'-',d.DigitoVerif_TER), e.Nombre_PLA";
	$result = mysqli_query($conexion, $SQL);	
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Radicacion".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$row[1]."';
		InsertarHTML('datosrad".$NumWindow."', ' <p><label>No. Radicacion: </label>".$row[0]."  <label>Estado: </label> ".$row[2]."  <label>Fecha Conf.: </label>".$row[3]." </p> <p><label>Entidad: </label> ".$row[4]."  </p> <p><label>Nit: </label>".$row[5]." <label>Plan: </label>".$row[6]." <label>Cant. Facturas: </label> ".$row[7]." <label>Valor Total: </label>$".number_format($row[8], 2, ",", ".")." </p> <div class=\"generartxt\" onClick=\"javascript: RIPS(\'".$row[0]."\',\'".$NumWindow."\',\'".$_SESSION["THEME_DEFAULT"]."\');\">Generar Archivos</div>');
	";
	}
	else {
		echo "
		MsgBox1('Generacion de RIPS','<div class=\"message_alert\"></div>La radicacion ".$_GET["Radicacion"]." no se encuentra');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarContrato<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
	  CargarPlan('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
  }
}
</script>