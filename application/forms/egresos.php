<?php	
 
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">
<fieldset>
<legend>Egreso de Pacientes:</legend>
<input type="hidden" name="hdn_Ingresoh<?php echo $NumWindow; ?>" id="hdn_Ingresoh<?php echo $NumWindow; ?>" />

<div class="form-group">
	<label for="txt_Ingreso<?php echo $NumWindow; ?>3">Ingreso</label>
	<div class="input-group">	
		<input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" size="10" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>

<div class="form-group">
<label for="txt_fechaadm<?php echo $NumWindow; ?>">Fecha</label>
<input name="txt_fechaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_fechaadm<?php echo $NumWindow; ?>" size="10" maxlength="10" />
</div>

<div class="form-group">
<label for="txt_horaadm<?php echo $NumWindow; ?>">Hora</label>
<input name="txt_horaadm<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_horaadm<?php echo $NumWindow; ?>3" size="8" maxlength="8" /><br />
<input type="hidden" name="hdn_Egreso<?php echo $NumWindow; ?>" id="hdn_Egreso<?php echo $NumWindow; ?>" />
</div>

<div class="form-group">
	<label for="txt_Egreso<?php echo $NumWindow; ?>">Egreso</label>
	<div class="input-group">	
		<input name="txt_Egreso<?php echo $NumWindow; ?>" type="text" id="txt_Egreso<?php echo $NumWindow; ?>" size="10" onkeypress="BuscarEgr<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Egreso" onclick="javascript:CargarSearch('Egreso', 'txt_Egreso<?php echo $NumWindow; ?>', 'Estado_EGR=*1*');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>

<div class="form-group">
<label for="txt_fechaegr<?php echo $NumWindow; ?>">Fecha</label>
<input name="txt_fechaegr<?php echo $NumWindow; ?>" type="date" id="txt_fechaegr<?php echo $NumWindow; ?>" size="10" maxlength="10" />
</div>

<div class="form-group">
<label for="txt_horaegr<?php echo $NumWindow; ?>">Hora</label>
<input name="txt_horaegr<?php echo $NumWindow; ?>" type="time" id="txt_horaegr<?php echo $NumWindow; ?>" size="8" maxlength="8" /><br />
</div>

<div class="form-group">
<label for="txt_epicrisis<?php echo $NumWindow; ?>">Epicrisis</label>
<input name="txt_epicrisis<?php echo $NumWindow; ?>" type="text" id="txt_epicrisis<?php echo $NumWindow; ?>" value="0000000000" size="10" maxlength="10" />
</div>

<div class="form-group">
<label for="txt_embarazo<?php echo $NumWindow; ?>">Embarazo</label>
<select name="txt_embarazo<?php echo $NumWindow; ?>" id="txt_embarazo<?php echo $NumWindow; ?>">
  <option value="0" selected="selected">No</option>
  <option value="1">Primer Trimestre</option>
  <option value="2">Segundo Trimestre</option>
  <option value="3">Tercer Trimestre</option>
</select>
</div>

<div class="form-group">
<label for="txt_fechanac<?php echo $NumWindow; ?>">Fecha Nacimiento</label>
<input name="txt_fechanac<?php echo $NumWindow; ?>" type="text" id="txt_fechanac<?php echo $NumWindow; ?>" value="00/00/0000" size="10" maxlength="10" class="datepicker" />
</div>

<div class="form-group">
<label for="txt_estadonac<?php echo $NumWindow; ?>">Estado Nacimiento</label>
<select name="txt_estadonac<?php echo $NumWindow; ?>" id="txt_estadonac<?php echo $NumWindow; ?>">
  <option value="V" selected="selected">Vivo</option>
  <option value="M">Muerto</option>
</select>
</div>

<div class="form-group">
<label for="txt_estadopac<?php echo $NumWindow; ?>">Estado Paciente</label>
<select name="txt_estadopac<?php echo $NumWindow; ?>" id="txt_estadopac<?php echo $NumWindow; ?>">
  <option value="1" selected="selected">Mejor</option>
  <option value="2">Igual o Peor</option>
  <option value="3">Muerto antes de 48 horas</option>
  <option value="4">Muerto despues de 48 horas</option>
</select>
</div>


</fieldset>

<fieldset>
  <legend>Datos de la Admision:</legend>
  <div id="datosing<?php echo $NumWindow; ?>" class="tblDetalle1">
  Digite el numero del ingreso o del egreso del paciente y presione [Enter]...
</div>
</fieldset>

</form>
<script >
FechaActual('txt_fechaegr<?php echo $NumWindow; ?>');
HoraActual('txt_horaegr<?php echo $NumWindow; ?>');

<?php
	if (isset($_GET["Ingreso"])) {
	$SQL="Select LPAD(Codigo_ADM,10,'0'), DATE_FORMAT(Fecha_ADM, '%d/%m/%Y'), TIME_FORMAT(Fecha_ADM, '%H:%i:%s'), a.ID_TER, a.Nombre_TER, c.Nombre_TER, Nombre_PLA,   Autorizacion_ADM, DATE_FORMAT(FechaAutorizacion_ADM, '%d/%m/%Y'), Observaciones_ADM, Codigo_ADM 
from czterceros a, gxadmision b, czterceros c, gxeps d, gxplanes e  where e.Codigo_PLA=b.Codigo_PLA and a.Codigo_TER=b.Codigo_TER and d.Codigo_TER=c.Codigo_TER and trim(b.Codigo_EPS)=trim(d.Codigo_EPS) and b.Estado_ADM='I' and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
	$result = mysqli_query($conexion, $SQL);	
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".hdn_Ingresoh".$NumWindow.".value='".$row[13]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[2]."';
		InsertarHTML('datosing".$NumWindow."', ' <p><label>Paciente: </label>".$row[3]." - ".$row[4]."   </p> <p> <label>Contrato: </label>".$row[5]." <label>Plan: </label> ".$row[6]."  </p> <p>  <label>No. autorizacion: </label>".$row[7]." <label>Fecha autorizacion: </label> ".$row[8]." </p> <p> <label>Observaciones: </label>".preg_replace("/\r\n|\n|\r/", "<br/>",$row[9])." </p> ');
	";
		mysqli_free_result($result); 
		$SQL="Select LPAD(Codigo_EGR,10,'0'), Codigo_EPC, Embarazo_EGR, DATE_FORMAT(Fecha_EGR, '%d/%m/%Y'), TIME_FORMAT(Fecha_EGR, '%H:%i:%s'), Estadopaciente_EGR, DATE_FORMAT(FechaNac_EGR, '%d/%m/%Y'), EstNacido_EGR from gxegresos where Estado_EGR='1' and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')";
		$result = mysqli_query($conexion, $SQL);	
		if($row = mysqli_fetch_array($result)) {
			echo "
			document.frm_form".$NumWindow.".txt_Egreso".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_epicrisis".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_fechaegr".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".txt_horaegr".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".txt_embarazo".$NumWindow.".value='".$row[2]."';
			document.frm_form".$NumWindow.".txt_estadopac".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".txt_fechanac".$NumWindow.".value='".$row[6]."';
			document.frm_form".$NumWindow.".txt_estadonac".$NumWindow.".value='".$row[7]."';
";			
		} 
	}
	else {
		echo "
		MsgBox1('Egreso de Pacientes','El ingreso ".$_GET["Ingreso"]." no se encuentra activo');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
	

if (isset($_GET["Egreso"])) {
	$SQL="Select LPAD(b.Codigo_ADM,10,'0'), DATE_FORMAT(Fecha_ADM, '%d/%m/%Y'), TIME_FORMAT(Fecha_ADM, '%H:%i:%s'), a.ID_TER, a.Nombre_TER, c.Nombre_TER, Nombre_PLA, CASE Riesgo_ADM WHEN '1' THEN 'Enfermedad General y Maternidad' WHEN '2' THEN 'Accidente de Transito' ELSE 'catastrofe' END, Descripcion_ADM, Motivo_ADM, Autorizacion_ADM, DATE_FORMAT(FechaAutorizacion_ADM, '%d/%m/%Y'), Observaciones_ADM, b.Codigo_ADM 
from czterceros a, gxadmision b, czterceros c, gxeps d, gxplanes e, gxtipoingreso f, gxegresos g where e.Codigo_PLA=b.Codigo_PLA and a.Codigo_TER=b.Codigo_TER and d.Codigo_TER=c.Codigo_TER and trim(b.Codigo_EPS)=trim(d.Codigo_EPS) and b.Ingreso_ADM=f.Tipo_ADM and b.Estado_ADM='I' and trim(g.Codigo_ADM)=trim(b.Codigo_ADM) and Estado_EGR='1' and LPAD(Codigo_EGR,10,'0')=LPAD('".$_GET["Egreso"]."',10,'0')";
	$result = mysqli_query($conexion, $SQL);	
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_Ingreso".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".hdn_Ingresoh".$NumWindow.".value='".$row[13]."';
		document.frm_form".$NumWindow.".txt_fechaadm".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_horaadm".$NumWindow.".value='".$row[2]."';
		InsertarHTML('datosing".$NumWindow."', ' <p><label>Paciente: </label>".$row[3]." - ".$row[4]."   </p> <p> <label>Contrato: </label>".$row[5]." <label>Plan: </label> ".$row[6]."  </p> <p>  <label>Tipo de riesgo: </label>".$row[7]." <label>Ingreso por: </label> ".$row[8]."  </p> <p>  <label>Motivo Consulta: </label>".$row[9]."   </p> <p>  <label>No. autorizacion: </label>".$row[10]." <label>Fecha autorizacion: </label> ".$row[11]." </p> <p> <label>Observaciones: </label>".preg_replace("/\r\n|\n|\r/", "<br/>",$row[12])." </p> ');
	";
		mysqli_free_result($result); 
		$SQL="Select LPAD(Codigo_EGR,10,'0'), Codigo_EPC, Embarazo_EGR, DATE_FORMAT(Fecha_EGR, '%d/%m/%Y'), TIME_FORMAT(Fecha_EGR, '%H:%i:%s'), Estadopaciente_EGR, DATE_FORMAT(FechaNac_EGR, '%d/%m/%Y'), EstNacido_EGR from gxegresos where Estado_EGR='1' and LPAD(Codigo_EGR,10,'0')=LPAD('".$_GET["Egreso"]."',10,'0')";
		$result = mysqli_query($conexion, $SQL);	
		if($row = mysqli_fetch_array($result)) {
			echo "
			document.frm_form".$NumWindow.".txt_Egreso".$NumWindow.".value='".$row[0]."';
			document.frm_form".$NumWindow.".txt_epicrisis".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_fechaegr".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".txt_horaegr".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".txt_embarazo".$NumWindow.".value='".$row[2]."';
			document.frm_form".$NumWindow.".txt_estadopac".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".txt_fechanac".$NumWindow.".value='".$row[6]."';
			document.frm_form".$NumWindow.".txt_estadonac".$NumWindow.".value='".$row[7]."';
";			
		} 
	}
	else {
		echo "
		MsgBox1('Egreso de Pacientes','El egreso ".$_GET["Egreso"]." no se encuentra activo');
		";
	}
	mysqli_free_result($result); 
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function CargarIngreso() {
	CargarSearch('Ingresos', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*');
}

function BuscarIng<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
		AbrirForm('application/forms/egresos.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value);
  }
}

function BuscarEgr<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if ((document.getElementById('txt_Egreso<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_Egreso<?php echo $NumWindow; ?>').value=="0000000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_Egreso<?php echo $NumWindow; ?>.value='0000000000';
		FechaActual('txt_fechaegr<?php echo $NumWindow; ?>');
		HoraActual('txt_horaegr<?php echo $NumWindow; ?>');
		if (document.getElementById('txt_Ingreso<?php echo $NumWindow; ?>').value=="") {
			document.frm_form<?php echo $NumWindow; ?>.txt_Ingreso<?php echo $NumWindow; ?>.focus();
		} else {
			document.frm_form<?php echo $NumWindow; ?>.txt_fechaegr<?php echo $NumWindow; ?>.focus();
		}
	} else {	  
		AbrirForm('application/forms/egresos.php', '<?php echo $NumWindow; ?>', '&Egreso='+document.getElementById('txt_Egreso<?php echo $NumWindow; ?>').value);
	}
  }
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
