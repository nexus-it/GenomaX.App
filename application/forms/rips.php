<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<div class="panel panel-default">
<div class="panel-heading">Registro Individual de Prestaci&oacute;n de Servicios:</div>
<div class="panel-body">

<div class="form-group">
	<label for="txt_Radicacion<?php echo $NumWindow; ?>">Radicaci&oacute;n No.</label>
  		<div class="input-group">
  		<input name="txt_Radicacion<?php echo $NumWindow; ?>" type="text" id="txt_Radicacion<?php echo $NumWindow; ?>"  value="" size="10" maxlength="10" onkeypress="BuscarRad<?php echo $NumWindow; ?>(event);"/>
  			<span class="input-group-btn">
  				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="radicaciones" onclick="javascript:CargarSearch('radicaciones', 'txt_Radicacion<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  			</span>
  		</div>
 </div>

<div class="form-group">
  <label for="txt_fecha<?php echo $NumWindow; ?>">Fecha:</label>
  <input name="txt_fecha<?php echo $NumWindow; ?>" type="text" id="txt_fecha<?php echo $NumWindow; ?>" value="00/00/0000" size="10" disabled />
</div>

</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">Detalle Radicaci&oacute;n:</div>
<div class="panel-body">
  <div id="datosrad<?php echo $NumWindow; ?>" class="tblDetalle1">
  Digite el n&uacute;mero de la radicaci&oacute;n...
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading">R.I.P.S.</div>
<div class="panel-body">
  <div id="datosrips<?php echo $NumWindow; ?>" class="tblDetalle1">
    -- No se han generado archivos a&uacute;n -- 
  </div>
</div>
</div>

</form>
<script >
<?php
	if (isset($_GET["Radicacion"])) {
	$SQL="Select LPAD(a.Codigo_RAD,10,'0'), DATE_FORMAT(a.Fecha_RAD, '%d/%m/%Y'), Case a.Estado_RAD When '1' Then 'Sin Confirmar' When '2' Then 'Confirmado' End, Case a.Estado_RAD When '1' Then '00/00/0000' When '2' Then DATE_FORMAT(a.FechaConf_RAD, '%d/%m/%Y') End, Concat('[ ',c.Codigo_EPS,' ] ',d.Nombre_TER), Concat(d.ID_TER,'-',d.DigitoVerif_TER), case a.Codigo_PLA when '%' then 'Varios' else e.Nombre_PLA end, Count(b.Codigo_FAC), sum(f.ValEntidad_FAC)
From czradicacionesdet as b, gxeps as c, czterceros as d, gxfacturas as f, czradicacionescab as a left join gxplanes as e on a.Codigo_PLA=e.Codigo_PLA 
Where a.Codigo_RAD=b.Codigo_RAD and d.Codigo_TER=c.Codigo_TER and c.Codigo_EPS=a.Codigo_EPS and f.Codigo_FAC=b.Codigo_FAC and LPAD(a.Codigo_RAD,10,'0')=LPAD('".$_GET["Radicacion"]."',10,'0')
Group By LPAD(a.Codigo_RAD,10,'0'), DATE_FORMAT(a.Fecha_RAD, '%d/%m/%Y'), Case a.Estado_RAD When '1' Then 'Sin Confirmar' When '2' Then 'Confirmado' End, Case a.Estado_RAD When '1' Then '00/00/0000' When '2' Then DATE_FORMAT(a.FechaConf_RAD, '%d/%m/%Y') End, Concat('[ ',c.Codigo_EPS,' ]',d.Nombre_TER), Concat(d.ID_TER,'-',d.DigitoVerif_TER), case a.Codigo_PLA when '%' then 'Varios' else e.Nombre_PLA end";
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
		MsgBox1('Generacion de RIPS','La radicacion ".$_GET["Radicacion"]." no se encuentra');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarRad<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
		AbrirForm('application/forms/rips.php', '<?php echo $NumWindow; ?>', '&Radicacion='+document.getElementById('txt_Radicacion<?php echo $NumWindow; ?>').value);
  }
}

	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>