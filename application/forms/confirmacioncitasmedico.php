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

	<div class="form-group" >
		<label for="txt_paciente<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input name="hdn_tercero<?php echo $NumWindow; ?>" type="hidden" id="hdn_tercero<?php echo $NumWindow; ?>" value="" />
			<input name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" onblur="javascript:NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-6">

	<div class="form-group">
		<label for="txt_paciente2<?php echo $NumWindow; ?>">Nombre</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input style="font-size:14px; font-weight: bold; color:#0E5012; " name="txt_paciente2<?php echo $NumWindow; ?>" id="txt_paciente2<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" onclick="javascript:RefreshCts<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-2 col-md-offset-2">
 
	<div class="form-group" >
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Actual</label>
		<input name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" disabled="disabled" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
	</div>
	
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
			<span class="label label-warning" id="spnmartes<?php echo $NumWindow; ?>">Pacientes en espera de atencion</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive" style="height: 300px" >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<td >
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

</form>

<script >
<?php
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	 	echo '
		document.getElementById("txt_fecha'.$NumWindow.'").value="'.$row[0].'";
		';
	}
	mysqli_free_result($result);
	if(isset($_GET["paciente"]))  {
		echo '
		document.getElementById("txt_paciente'.$NumWindow.'").value="'.$_GET["paciente"].'";
		';
		if ($_GET["paciente"]!="") {
			echo 'NombreTercero("'.$NumWindow.'", "'.$_GET["paciente"].'", "gxpacientes");';
		}
	}
?>
	LoadCitas<?php echo $NumWindow; ?>();

function genadmision<?php echo $NumWindow; ?>() {
	if (document.frm_form<?php echo $NumWindow; ?>.hdn_admisionar<?php echo $NumWindow; ?>.value=='1') {
		document.frm_form<?php echo $NumWindow; ?>.hdn_admisionar<?php echo $NumWindow; ?>.value='0';
	} else {
		document.frm_form<?php echo $NumWindow; ?>.hdn_admisionar<?php echo $NumWindow; ?>.value='1';
	}
}

function AtndCita<?php echo $NumWindow; ?>(numero) {
	Cita=document.getElementById("hdn_cita"+numero+"<?php echo $NumWindow; ?>").value;
	ModeHC=document.getElementById("hdn_cita"+numero+"<?php echo $NumWindow; ?>").value;
	Paciente=document.getElementById("hdn_pte"+numero+"<?php echo $NumWindow; ?>").value;
	AtenderCita(Cita, '<?php echo $NumWindow; ?>');
	CargarForm('application/forms/hc.php?ModeHC=cx&Historia='+Paciente+'&Cita='+Cita, 'Historias Clínicas', '1.PatientFile.png');
}

function CitasxPcte<?php echo $NumWindow; ?>(idpcte) {
	CargarWind('Histórico de Citas ', 'reports/citasxpcte.php?PACIENTE='+idpcte+'&mode=modal', 'database_table.png', 'confirmacioncitasmedico.php','<?php echo $NumWindow; ?>' );
}

function RefreshCts<?php echo $NumWindow; ?>() {
	paciente=document.getElementById("txt_paciente<?php echo $NumWindow; ?>").value;
	AbrirForm('application/forms/confirmacioncitasmedico.php', '<?php echo $NumWindow; ?>', '&paciente='+paciente);
}

function LoadCitas<?php echo $NumWindow; ?>() {
	paciente=document.getElementById("txt_paciente<?php echo $NumWindow; ?>").value;
	fecha=document.getElementById("txt_fecha<?php echo $NumWindow; ?>").value;
	FillCitasAtencion('<?php echo $NumWindow; ?>', paciente, fecha);
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

</script>
