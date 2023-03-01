<?php
 
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	$varespe="";
	$varprof1="";
	$varfec1="";
	$varfec2="";
	$varprof2="";
	if (isset($_GET["especialidad"])) {
		$varespe=$_GET["especialidad"];
	}
	if (isset($_GET["prof1"])) {
		$varprof1=$_GET["prof1"];
	}
	if (isset($_GET["prof2"])) {
		$varprof2=$_GET["prof2"];
	}
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		$fechaahora=$row[0];
	}
	mysqli_free_result($result); 
	if (isset($_GET["fec1"])) {
		$varfec1=$_GET["fec1"];
	} else {
		$varfec1=$fechaahora;
	}
	if (isset($_GET["fec2"])) {
		$varfec2=$_GET["fec2"];
	} else {
		$varfec2=$fechaahora;
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">
<input name="hdn_codage<?php echo $NumWindow; ?>" type="hidden" id="hdn_codage<?php echo $NumWindow; ?>" value="0" />
			
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_especialidad<?php echo $NumWindow; ?>">Especialidad</label>
		<select name="cmb_especialidad<?php echo $NumWindow; ?>" id="cmb_especialidad<?php echo $NumWindow; ?>" onchange="loadespe<?php echo $NumWindow; ?>(this.value);">
		<?php 
		$SQL="Select distinct a.Codigo_ESP, a.Nombre_ESP from gxespecialidades a, gxagendacab b where a.Codigo_ESP=b.Codigo_ESP and b.FechaIni_AGE>=now() and a.Estado_ESP='1' order by 2";
		$result = mysqli_query($conexion, $SQL);
		$conta=0;
		while($row = mysqli_fetch_array($result)) 
			{
				$conta++;
		 ?>
		  <option value="<?php echo $row[0]; ?>" <?php if ($varespe==$row[0]) { echo ' selected '; } ?>><?php echo ($row[1]); ?></option>
		<?php
			if ( $varespe=="") {
				if($conta=="1") {
					$varespe=$row[0];
				}
			}
			}
		mysqli_free_result($result);
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_prof1<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_prof1<?php echo $NumWindow; ?>" id="cmb_prof1<?php echo $NumWindow; ?>" onchange="loadtrsldr<?php echo $NumWindow; ?>('<?php echo $varespe; ?>', this.value);">
		<?php 
		$SQL="Select distinct a.Codigo_TER, Nombre_TER from czterceros a, gxagendacab b where a.Codigo_TER=b.Codigo_TER and b.FechaIni_AGE>=now() and b.Codigo_ESP='".$varespe."' order by 2";
		$conta=0;
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
				$conta++;
		 ?>
		  <option value="<?php echo $row[0]; ?>" <?php if ($varprof1==$row[0]) { echo ' selected '; } ?>><?php echo ($row[1]); ?></option>
		<?php
			if ( $varprof1=="") {
				if($conta=="1") {
					$varprof1=$row[0];
				}
			}
			}
		mysqli_free_result($result); 
		 ?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

		<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
			<label for="txt_fini<?php echo $NumWindow; ?>">Fecha Inicial</label>
			<input  name="txt_fini<?php echo $NumWindow; ?>" id="txt_fini<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $varfec1; ?>" />
		</div>

			</div>
			<div class="col-md-2">

		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="txt_ffin<?php echo $NumWindow; ?>">Fecha Final</label>
			<input  name="txt_ffin<?php echo $NumWindow; ?>" id="txt_ffin<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $varfec2; ?>" />
		</div>

			</div>
			<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_prof2<?php echo $NumWindow; ?>">Trasladar a</label>
		<select name="cmb_prof2<?php echo $NumWindow; ?>" id="cmb_prof2<?php echo $NumWindow; ?>" >
		<?php 
		if ($varprof1!="") {
			$SQL="Select distinct a.Codigo_TER, Nombre_TER from czterceros a, gxmedicosesp b where a.Codigo_TER=b.Codigo_TER and a.Codigo_TER<>'".$varprof1."' and b.Codigo_ESP='".$varespe."' order by 2";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) 
				{
			 ?>
			  <option value="<?php echo $row[0]; ?>" <?php if ($varprof2==$row[0]) { echo ' selected '; } ?>><?php echo ($row[1]); ?></option>
			<?php
				}
			mysqli_free_result($result); 
		}
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2 ">

		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="btnagenda<?php echo $NumWindow; ?>">Generar </label><br>
			<button type="button" class="btn btn-success btn-block" id="btnagenda<?php echo $NumWindow; ?>" onclick="TraerAgenda<?php echo $NumWindow; ?>();"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
		</div>

		</div>
		
	</div>
	<div class="row">

		<div class="col-md-12">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height: 250px;">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle table-striped table-hover table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thant<?php echo $NumWindow; ?>"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </th> 
					<th id="thant<?php echo $NumWindow; ?>">FECHA</th> 
					<th id="thant<?php echo $NumWindow; ?>">HORA</th> 
					<th id="thant<?php echo $NumWindow; ?>">CONSULTORIO</th> 
					<th id="thant<?php echo $NumWindow; ?>">PACIENTE</th> 
				</tr> 
				<?php 
				$SQL="SELECT b.Codigo_AGE, b.Fecha_AGE, b.Hora_AGE, c.Nombre_CNS, d.Codigo_CIT, e.Nombre_TER, a.Codigo_ARE  FROM gxagendacab a, gxconsultorios c, gxagendadet b LEFT JOIN gxcitasmedicas d ON d.Codigo_AGE=b.Codigo_AGE AND d.Fecha_AGE=b.Fecha_AGE AND d.Hora_AGE=b.Hora_AGE LEFT JOIN czterceros e ON e.Codigo_TER=d.Codigo_TER WHERE a.Codigo_AGE=b.Codigo_AGE AND c.Codigo_CNS=a.Codigo_CNS AND a.Codigo_TER='".$varprof1."' AND a.Codigo_ESP='".$varespe."' AND b.Fecha_AGE BETWEEN '".$varfec1."' AND '".$varfec2." 23:59:59' order by 2,3";
				$result = mysqli_query($conexion, $SQL);
				$contage=0;
				while ($row = mysqli_fetch_array($result)) {
					$contage++;
					echo '
				<tr id="tr'.$contage.$NumWindow.'"> 
					<td id="th1'.$contage.$NumWindow.'" align="center"><input type="hidden" name="hdn_agenda'.$contage.$NumWindow.'" id="hdn_agenda'.$contage.$NumWindow.'" value="'.$row[0].'">';
					nxs_chk('agnd'.$contage, $NumWindow);
					echo '</td> 
					<td id="th2'.$contage.$NumWindow.'" align="center"><input type="hidden" name="hdn_fecha'.$contage.$NumWindow.'" id="hdn_fecha'.$contage.$NumWindow.'" value="'.$row[1].'">'.$row[1] .'</td> 
					<td id="th3'.$contage.$NumWindow.'" align="center"><input type="hidden" name="hdn_hora'.$contage.$NumWindow.'" id="hdn_hora'.$contage.$NumWindow.'" value="'.$row[2].'">'.$row[2].'</td> 
					<td id="th4'.$contage.$NumWindow.'" align="left"><input type="hidden" name="hdn_conslt'.$contage.$NumWindow.'" id="hdn_conslt'.$contage.$NumWindow.'" value="'.$row[3].'"><input type="hidden" name="hdn_area'.$contage.$NumWindow.'" id="hdn_area'.$contage.$NumWindow.'" value="'.$row[6].'">'.$row[3].'</td> 
					<td id="th5'.$contage.$NumWindow.'" align="left"><input type="hidden" name="hdn_cita'.$contage.$NumWindow.'" id="hdn_cita'.$contage.$NumWindow.'" value="'.$row[4].'">'.$row[5].'</td> 
				</tr> 
			';
				}
				mysqli_free_result($result);
				?>

				</tbody>
				</table>
				<input type="hidden" name="hdn_contage<?php echo $NumWindow; ?>" id="hdn_contage<?php echo $NumWindow; ?>" value="<?php echo $contage; ?>">
			</div>
		</div>

	</div>

</form>

<script >
<?php

?>

function loadespe<?php echo $NumWindow; ?>(valor) {
	AbrirForm('application/forms/agendatrasl.php', '<?php echo $NumWindow; ?>', '&especialidad='+valor);	
}

function loadtrsldr<?php echo $NumWindow; ?>(espe, prof1) {
	AbrirForm('application/forms/agendatrasl.php', '<?php echo $NumWindow; ?>', '&especialidad='+espe+'&prof1='+prof1+'&prof2=<?php echo $varprof2; ?>&fec1=<?php echo $varfec1; ?>&fec2=<?php echo $varfec2; ?>');
}

function TraerAgenda<?php echo $NumWindow; ?>() {
	espe=document.getElementById('cmb_especialidad<?php echo $NumWindow; ?>').value;
	prof1=document.getElementById('cmb_prof1<?php echo $NumWindow; ?>').value;
	prof2=document.getElementById('cmb_prof2<?php echo $NumWindow; ?>').value;
	fec1=document.getElementById('txt_fini<?php echo $NumWindow; ?>').value;
	fec2=document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value;
	if (fec2<fec1) {
		MsgBox1("Error", "La fecha final no puede ser menor que la inicial.");
	}
	AbrirForm('application/forms/agendatrasl.php', '<?php echo $NumWindow; ?>', '&especialidad='+espe+'&prof1='+prof1+'&prof2='+prof2+'&fec1='+fec1+'&fec2='+fec2);	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
