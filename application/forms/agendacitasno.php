<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">

		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_areas<?php echo $NumWindow; ?>">Servicio</label>
		<select name="cmb_areas<?php echo $NumWindow; ?>" id="cmb_areas<?php echo $NumWindow; ?>" onchange="javascript:FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
			<option  value="*">- Todas -</option>
		<?php 
		$SQL="Select distinct b.Codigo_ARE, b.Nombre_ARE From gxagendacab a, gxareas b, gxagendadet c Where a.Codigo_ARE=b.Codigo_ARE and a.Codigo_AGE=c.Codigo_AGE and c.Fecha_AGE >= curdate() and a.Estado_AGE='1' and c.Estado_AGE='1' Order by 2";
		$result = mysqli_query($conexion, $SQL);
		$contaarea=0;
		while($row = mysqli_fetch_array($result)) 
			{
		?>
		  <option  value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result);
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
		<?php
			$SQL="Select CURDATE();";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) {
				$fechahoy=$row[0];
			}
			mysqli_free_result($result); 
		?>
		<input  name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control"  value="<?php echo $fechahoy; ?>" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
		<?php
			$SQL="Select date(DATE_ADD(NOW(),INTERVAL 5 DAY));";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) {
				$fechahoy=$row[0];
			}
			mysqli_free_result($result); 
		?>
		<input  name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required class="form-control"  value="<?php echo $fechahoy; ?>" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>" >
		<option  value="*">- Todos -</option>
		<?php 
		$SQL="Select distinct b.Codigo_TER, b.Nombre_TER From gxagendacab a, czterceros b, gxagendadet c Where a.Codigo_TER=b.Codigo_TER and a.Codigo_AGE=c.Codigo_AGE and c.Fecha_AGE >= curdate() and a.Estado_AGE='1' and c.Estado_AGE='1' Order by 2";
		$result = mysqli_query($conexion, $SQL);
		$contaarea=0;
		while($row = mysqli_fetch_array($result)) 
			{
		?>
		  <option  value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result);
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_paciente<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input name="hdn_tercero<?php echo $NumWindow; ?>" type="hidden" id="hdn_tercero<?php echo $NumWindow; ?>" value="" />
			<input name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="txt_paciente2<?php echo $NumWindow; ?>">Nombre</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input style="font-size:14px; font-weight: bold; color:#0E5012; " name="txt_paciente2<?php echo $NumWindow; ?>" id="txt_paciente2<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" onclick="javascript:RefreshCitas<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
	
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span class="label label-default" id="spnmartes<?php echo $NumWindow; ?>">Seleccione la acción a realizar</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive" >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thd2<?php echo $NumWindow; ?>" width="11%" >Area</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="6%" >Consultorio</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="6%" >Fecha</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="20%" >Profesional</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="12%" >Especialidad</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="6%" >Tipo Atencion</th> 
					<th id="thd0<?php echo $NumWindow; ?>" width="20%" >Paciente</th>
					<th id="thd0<?php echo $NumWindow; ?>" width="8%" >Nota</th>
					<th id="thd1<?php echo $NumWindow; ?>" width="11%" >Acción</th>  					
				</tr> 
				<tr>
					<td colspan="9">
						<div class="progress">
						  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						  </div>
						</div>
					</td>
				</tr>
				<input name="hdn_controwcitas<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwcitas<?php echo $NumWindow; ?>" value="0">
				</tbody>
				</table>
			</div>
			
		</div>
		
	</div>
<?php
if (isset($_GET["genesis"])) {
?>
<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Guardar_agendacitasnew('<?php echo $NumWindow; ?>');">Guardar</button>
<?php
	}
?>
</form>

<script >
<?php
	if(isset($_GET["servicio"]))  {
		echo '
		document.getElementById("cmb_areas'.$NumWindow.'").value="'.$_GET["servicio"].'";
		document.getElementById("txt_fechaini'.$NumWindow.'").value="'.$_GET["fecha1"].'";
		document.getElementById("txt_fechafin'.$NumWindow.'").value="'.$_GET["fecha2"].'";
		document.getElementById("cmb_medico'.$NumWindow.'").value="'.$_GET["medico"].'";
		document.getElementById("txt_paciente'.$NumWindow.'").value="'.$_GET["paciente"].'";
		';
		if ($_GET["paciente"]!="") {
			echo 'NombreTercero("'.$NumWindow.'", "'.$_GET["paciente"].'", "gxpacientes");';
		}
	}
?>
	LoadCitas<?php echo $NumWindow; ?>();

function PrintCitas<?php echo $NumWindow; ?>(Paciente,Fecha) {
	CargarReport("application/reports/citasprogramadasusuario.php?PACIENTE="+Paciente+"&FECHA_INICIAL="+Fecha+"&FECHA_FINAL="+Fecha, "Cita Programada");
}

function ReprogCitas<?php echo $NumWindow; ?>(Cita) {
	CargarForm("application/forms/agendacitasrpgr.php?CITA="+Cita, "Reprogramar Cita", "1.Task.png");
}

function CancelCitas<?php echo $NumWindow; ?>(Cita) {
	CargarForm("application/forms/agendacitascncl.php?CITA="+Cita, "Cancelar Cita", "1.Delete.png");
}

function RefreshCitas<?php echo $NumWindow; ?>() {
	servicio=document.getElementById("cmb_areas<?php echo $NumWindow; ?>").value;
	fecha1=document.getElementById("txt_fechaini<?php echo $NumWindow; ?>").value;
	fecha2=document.getElementById("txt_fechafin<?php echo $NumWindow; ?>").value;
	medico=document.getElementById("cmb_medico<?php echo $NumWindow; ?>").value;
	paciente=document.getElementById("txt_paciente<?php echo $NumWindow; ?>").value;
	AbrirForm('application/forms/agendacitasno.php', '<?php echo $NumWindow; ?>', '&servicio='+servicio+'&fecha1='+fecha1+'&fecha2='+fecha2+'&medico='+medico+'&paciente='+paciente);
}

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	NombreTercero('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value, 'gxpacientes');
  }
}

function LoadCitas<?php echo $NumWindow; ?>() {
	servicio=document.getElementById("cmb_areas<?php echo $NumWindow; ?>").value;
	fecha1=document.getElementById("txt_fechaini<?php echo $NumWindow; ?>").value;
	fecha2=document.getElementById("txt_fechafin<?php echo $NumWindow; ?>").value;
	medico=document.getElementById("cmb_medico<?php echo $NumWindow; ?>").value;
	paciente=document.getElementById("txt_paciente<?php echo $NumWindow; ?>").value;
	FillAgendaNo('<?php echo $NumWindow; ?>', servicio, fecha1, medico, paciente, fecha2);
}

function PcteCitas<?php echo $NumWindow; ?>(history) {
	CargarWind('Historial Citas Pacientes ', 'forms/citashistory.php?IdPte='+history+'&mode=modal&wnd=agendacitasrpgr', 'folder_user.png', 'agendacitasrpgr.php','<?php echo $NumWindow; ?>' );
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>
