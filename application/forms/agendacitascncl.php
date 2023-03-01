<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	$Vent = (int) filter_var($NumWindow, FILTER_SANITIZE_NUMBER_INT);  
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<h4><span class="label label-danger" id="spnlunes<?php echo $NumWindow; ?>"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Verifique los datos de la cita a cancelar.</span></h4>
	<div class="well well-sm row">
	<?php
		$SQL="Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS, c.Codigo_AGE From gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j Where a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID and g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT='P' and c.Codigo_CIT='".$_GET["CITA"]."' ";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
	?>
	<input name="hdn_theagenda<?php echo $NumWindow; ?>" type="hidden" id="hdn_theagenda<?php echo $NumWindow; ?>" value="<?php echo $row[15]; ?>" />
	<input name="hdn_fecha<?php echo $NumWindow; ?>" type="hidden" id="hdn_fecha<?php echo $NumWindow; ?>" value="<?php echo $row[0]; ?>" />
	<input name="hdn_hora<?php echo $NumWindow; ?>" type="hidden" id="hdn_hora<?php echo $NumWindow; ?>" value="<?php echo $row[6]; ?>" />
	<div class="col-md-6">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">PACIENTE</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[7].' '.$row[8].' - '.$row[9]; ?>" disabled>
		  <input name="hdn_elpaciente<?php echo $NumWindow; ?>" type="hidden" id="hdn_elpaciente<?php echo $NumWindow; ?>" value="<?php echo $row[8]; ?>" />
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">FECHA</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo FormatoFecha($row[0]); ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">HORA</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[6]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">EDAD</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[10]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">SEXO</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[11]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-6">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1" title="PROFESIONAL">PROF.</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[4].' ['.$row[5].']'; ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">AREA</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[1]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">CONSULTORIO</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[2]; ?>" disabled>
		</div>
	</div>

	<div class="col-md-6">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1" >ENTIDAD</span>
		  <input type="text" class="form-control" placeholder="" aria-describedby="basic-addon1" value="<?php echo $row[14]; ?>" disabled>
		</div>
	</div>
	<?php
		}
		mysqli_free_result($result);

	?>	  
	</div>
	<input name="hdn_cita<?php echo $NumWindow; ?>" type="hidden" id="hdn_cita<?php echo $NumWindow; ?>" value="<?php echo $_GET["CITA"]; ?>" />
	<div class="well well-sm row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="cmb_motivo<?php echo $NumWindow; ?>">Motivo Anulacion</label>
				<select name="cmb_motivo<?php echo $NumWindow; ?>" id="cmb_motivo<?php echo $NumWindow; ?>" class="form-control">
				<?php 
			$SQL="Select Codigo_MTC, Nombre_MTC from gxmotcancela where Estado_MTC='1' order by 1";
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
		<div class="col-md-6">
			<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
				<label for="txt_nota<?php echo $NumWindow; ?>">Observacion</label>
				<input name="txt_nota<?php echo $NumWindow; ?>" id="txt_nota<?php echo $NumWindow; ?>" class="form-control" type="text" required value=""/>
			</div>
		</div>

	</div>
	<?php
if (isset($_GET["genesis"])) {
?>
<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Anular_agendacitascncl('<?php echo $Vent; ?>'); eval( 'getCal<?php echo $_GET["genesis"]; ?>()' );">Guardar</button>
<?php
	}
?>
</form>

<script >
	
	var NumWin='<?php echo $NumWindow; ?>';
	NumWin=NumWin.substring(6, NumWin.length);
	document.getElementById('Nuevo'+NumWin).style.display  = 'none';
	document.getElementById('Imprimir'+NumWin).style.display  = 'none';
    document.getElementById('Guardar'+NumWin).style.display  = 'none';

    document.getElementById('Anular'+NumWin).innerHTML='<i class="fas fa-eraser"></i> Cancelar Cita';
    
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
