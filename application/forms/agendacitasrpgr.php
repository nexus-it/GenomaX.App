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
	<span class="label label-default" id="spnlunes<?php echo $NumWindow; ?>">Detalle Cita a Reprogramar</span>
	<div class="well well-sm row">
	<?php
		$SQL="Select c.Fecha_AGE, g.Nombre_ARE, h.Nombre_CNS, e.ID_TER, e.Nombre_TER, f.Nombre_ESP, c.Hora_AGE, j.Sigla_TID, d.ID_TER, d.Nombre_TER, TIMESTAMPDIFF(YEAR,a.FechaNac_PAC,c.FechaGraba_CIT) AS edad, a.Codigo_SEX, d.Telefono_TER, d.Direccion_TER, i.Nombre_EPS, c.Codigo_AGE, Nota_CIT From gxpacientes a, gxagendacab b, gxcitasmedicas c, czterceros d, czterceros e, gxespecialidades f, gxareas g, gxconsultorios h, gxeps i, cztipoid j Where a.Codigo_TER=d.Codigo_TER and a.Codigo_TER=c.Codigo_TER and e.Codigo_TER=b.Codigo_TER and f.Codigo_ESP=b.Codigo_ESP and j.Codigo_TID=d.Codigo_TID and g.Codigo_ARE=b.Codigo_ARE and c.Codigo_AGE=b.Codigo_AGE and h.Codigo_CNS=b.Codigo_CNS and i.Codigo_EPS=a.Codigo_EPS and c.Estado_CIT='P' and c.Codigo_CIT='".$_GET["CITA"]."' ";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
	?>
	<input name="hdn_theagenda<?php echo $NumWindow; ?>" type="hidden" id="hdn_theagenda<?php echo $NumWindow; ?>" value="<?php echo $row[15]; ?>" />
	<input name="hdn_fecha<?php echo $NumWindow; ?>" type="hidden" id="hdn_fecha<?php echo $NumWindow; ?>" value="<?php echo $row[0]; ?>" />
	<input name="hdn_hora<?php echo $NumWindow; ?>" type="hidden" id="hdn_hora<?php echo $NumWindow; ?>" value="<?php echo $row[6]; ?>" />
	
	<div class="col-md-6">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">PACIENTE</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[7].' '.$row[8].' - '.$row[9]; ?>" disabled>
		  <input name="hdn_elpaciente<?php echo $NumWindow; ?>" type="hidden" id="hdn_elpaciente<?php echo $NumWindow; ?>" value="<?php echo $row[8]; ?>" />
		</div>
	</div>
	<div class="col-md-2">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">FECHA</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo FormatoFecha($row[0]); ?>" disabled>
		</div>
	</div>
	<div class="col-md-2">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">HORA</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[6]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-2">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">EDAD</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[10]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-2">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">SEXO</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[11]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-5">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1" title="PROFESIONAL">PROF.</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[4].' ['.$row[5].']'; ?>" disabled>
		</div>
	</div>
	<div class="col-md-5">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">NOTA</span>
		  <input type="text" class="form-control" placeholder="Observaciones" aria-describedby="basic-addon1" value="<?php echo $row[16]; ?>"  id="txt_notica<?php echo $NumWindow; ?>" name="txt_notica<?php echo $NumWindow; ?>" >
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">AREA</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[1]; ?>" disabled>
		</div>
	</div>
	<div class="col-md-3">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1">CONSULTORIO</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[2]; ?>" disabled>
		</div>
	</div>

	<div class="col-md-6">
		<div class="input-group input-group-sm ">
		  <span class="input-group-addon" id="basic-addon1" >ENTIDAD</span>
		  <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $row[14]; ?>" disabled>
		</div>
	</div>
	<?php
		}
		mysqli_free_result($result);

	?>	  
	</div>
	<input name="hdn_cita<?php echo $NumWindow; ?>" type="hidden" id="hdn_cita<?php echo $NumWindow; ?>" value="<?php echo $_GET["CITA"]; ?>" />
	<div class="row">

		<div class="col-md-3">

	<div class="form-group">
		<label for="cmb_areas<?php echo $NumWindow; ?>">Servicio Deseado</label>
		<select name="cmb_areas<?php echo $NumWindow; ?>" id="cmb_areas<?php echo $NumWindow; ?>" onchange="javascript:FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
		<?php 
		$SQL="Select distinct b.Codigo_ARE, b.Nombre_ARE From gxagendacab a, gxareas b, gxagendadet c Where a.Codigo_ARE=b.Codigo_ARE and a.Codigo_AGE=c.Codigo_AGE and c.Fecha_AGE >= curdate() and a.Estado_AGE='1' and c.Estado_AGE='0' Order by 2";
		$result = mysqli_query($conexion, $SQL);
		$contaarea=0;
		while($row = mysqli_fetch_array($result)) 
			{
				$contaarea++;
				$Selected="";
				if (isset($_GET["TheArea"])) {
					if ($_GET["TheArea"]==$row[0]) {
						$Selected=" selected='selected' ";
						$theArea=$row[0];
					}
				} else {
					if ($contaarea==1) {
						$Selected=" selected='selected' ";
						$theArea=$row[0];
					}
				}
		 ?>
		  <option <?php echo $Selected; ?> value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result);
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Deseada</label>
		<?php 
		$FechaD="";
		if (isset($_GET["fechadeseada"])) {
			$FechaD=$_GET["fechadeseada"];
		} else {
			$SQL="Select curdate();";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) 
				{
			 	$FechaD=$row[0];
			 	}
			mysqli_free_result($result);
		} ?>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" onchange="FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);" value="<?php echo $FechaD; ?>"" />
	</div>

		</div>
		<div class="col-md-4">

	<div class="form-group">
		<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>" onchange="javascript:AgendaDia<?php echo $NumWindow; ?>(this.value, document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
		
		</select>
	</div>
	
		</div>
		<div class="col-md-3">

	<div class="form-group">
		<label for="txt_notarep<?php echo $NumWindow; ?>">Nota Reprogramacion</label>
		<input type="text" class="form-control" placeholder="Causa de la Reprogramacion" aria-describedby="basic-addon1" value="" id="txt_notarep<?php echo $NumWindow; ?>" name="txt_notarep<?php echo $NumWindow; ?>" >
	</div>
	
		</div>
			
	</div>
	<div class="row">
		<?php 
			$MesCal=$FechaD;
			if (isset($_GET["mescal"])) {
				$MesCal=$_GET["mescal"];
			}
			$month=date("n",strtotime($MesCal));
			$year=date("Y", strtotime($MesCal));
			$diaActual=date("j", strtotime($MesCal));
			 
			# Obtenemos el dia de la semana del primer dia
			# Devuelve 0 para domingo, 6 para sabado
			$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
			# Obtenemos el ultimo dia del mes
			$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
			 
			$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
			"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		?>
		<div class="col-md-5">					
			<span class="label label-default" id="spnlunes<?php echo $NumWindow; ?>">Seleccione el día disponible</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive ">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetallecal table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thant<?php echo $NumWindow; ?>"> 
						<?php
						$monthnow=date("n");
						if ($monthnow!=$month) {
							$fechaActual=date($year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-01");
							$fechaMesPasado = strtotime ('-1 month', strtotime($fechaActual));
							$fechaMesPasadoDate = date('Y-m-j', $fechaMesPasado);
						?>
						<span class="glyphicon glyphicon-backward" aria-hidden="true" style="cursor: pointer;" onclick="javascript:UpdtMonth<?php echo $NumWindow; ?>('<?php echo $fechaMesPasadoDate; ?>');"></span> 
						<?php
						}
						?>
					</th>
					<th id="thm<?php echo $NumWindow; ?>" colspan="5"><span id="NombreMes<?php echo $NumWindow; ?>"> <?php echo $meses[$month]." - ".$year; ?> </span></th>
					<th id="thsig<?php echo $NumWindow; ?>"> 
						<?php
						$SQL="Select max(a.Fecha_AGE)From gxagendadet a, gxagendacab b Where a.Codigo_AGE=b.Codigo_AGE and a.Estado_AGE='0' and b.Estado_AGE='1' and b.Codigo_ARE='".$theArea."';";
						$result = mysqli_query($conexion, $SQL);
						if($row = mysqli_fetch_array($result)) 
							{
						 	$monthNext=date("n",strtotime($row[0]));
						 	}
						mysqli_free_result($result);
						if ($monthNext!=$month) {
							$fechaActual=date($year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-01");
							$fechaMesPasado = strtotime ('+1 month', strtotime($fechaActual));
							$fechaMesPasadoDate = date('Y-m-j', $fechaMesPasado);
						?>
						<span class="glyphicon glyphicon-forward" aria-hidden="true" style="cursor: pointer;" onclick="javascript:UpdtMonth<?php echo $NumWindow; ?>('<?php echo $fechaMesPasadoDate; ?>');"></span> 
						<?php
						}
						?>
					</th> 
				</tr> 
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>">LUN</th> 
					<th id="th3<?php echo $NumWindow; ?>">MAR</th> 
					<th id="th4<?php echo $NumWindow; ?>">MIE</th> 
					<th id="th5<?php echo $NumWindow; ?>">JUE</th> 
					<th id="th6<?php echo $NumWindow; ?>">VIE</th> 
					<th id="th7<?php echo $NumWindow; ?>">SAB</th> 
					<th id="th1<?php echo $NumWindow; ?>" class="text-danger">DOM</th> 
				</tr> 
				<?php
					$last_cell=$diaSemana+$ultimoDiaMes;
					// hacemos un bucle hasta 42, que es el máximo de valores que puede
					// haber... 6 columnas de 7 dias
					for($i=1;$i<=42;$i++)
					{
						if($i==$diaSemana)
						{
							// determinamos en que dia empieza
							$day=1;
						}
						if($i<$diaSemana || $i>=$last_cell)
						{
							// celca vacia
							echo "<td>&nbsp;</td>";
						}else{
							// mostramos el dia
							$stylo="";
							$ConsXDia=0;
							$Fest="No";
							if($i%7!=0) {
								$stylo=$stylo." ";								
								$SQL="Select a.DiaFest_FST From czfestivos a Where a.DiaFest_FST='".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."'";
								$result = mysqli_query($conexion, $SQL);
								if($row = mysqli_fetch_array($result)) 
									{
									 $stylo=$stylo." color:#800000;";
									 $Fest="Yes";
								 	}
								mysqli_free_result($result);
							}else{
								$stylo=$stylo." color:#800000;";
							}
							$SQL="Select count(*) From gxagendacab a, gxagendadet b Where a.Codigo_AGE=b.Codigo_AGE and a.Estado_AGE='1' and b.Estado_AGE='0' and a.Codigo_ARE='".$theArea."' and b.Fecha_AGE='".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."' and b.Fecha_AGE>=curdate()";
							$result = mysqli_query($conexion, $SQL);
							if($row = mysqli_fetch_array($result)) 
								{
									if ($Fest=="No") {
										$ConsXDia=$row[0];
									}
							 	}
							mysqli_free_result($result);
							$EnlaceJS="";
							$Badge="";
							if ($ConsXDia!=0) {
								$EnlaceJS=" title='".$ConsXDia." Consultas disponibles para este día' class='bg-success' style='cursor: pointer; color:#0E5012;' onclick=\"javascript:ShowAgendas".$NumWindow."('".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."');\"";
								$Badge='<span class="badge label label-success"><small>'.$ConsXDia.'</small></span>';
							}
							if($day==$diaActual)
								echo "<td align='center' ".$EnlaceJS."><span style='font-weight: bold; ".$stylo."'>$day ".$Badge."</span></td>";
							else
								echo "<td align='center' ".$EnlaceJS."><span style='".$stylo."'>$day ".$Badge."</span></td>";
							$day++;
						}
						// cuando llega al final de la semana, iniciamos una columna nueva
						if($i%7==0)
						{
							echo "</tr><tr>\n";
						}
					}
				?>
				</tbody>
				<input name="hdn_mescal<?php echo $NumWindow; ?>" type="hidden" id="hdn_mescal<?php echo $NumWindow; ?>" value="0000-00-00" />
				</table>
			</div>
			
		</div>
		<div class="col-md-7">
			<span class="label label-default" id="spnmartes<?php echo $NumWindow; ?>">Asigne la cita en la hora deseada</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive" >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallemar<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr>
					<th id="thh<?php echo $NumWindow; ?>" colspan="3"><span id="NombreDia<?php echo $NumWindow; ?>"> { Día } </span></th>
				</tr>
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="thd2<?php echo $NumWindow; ?>" width="10%" >HORA</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="20%" >Consultorio</th> 
					<th id="thd0<?php echo $NumWindow; ?>" width="70%" >Paciente</th> 					
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
<button id="Guardar<?php echo $Vent; ?>" name="Guardar<?php echo $Vent; ?>" type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Guardar_agendacitasrpgr('<?php echo $Vent; ?>'); eval( 'getCal<?php echo $_GET["genesis"]; ?>()' );">Guardar</button>
<?php
	}
?>
</form>

<script >

function FechaCerca<?php echo $NumWindow; ?>(FechaD, Especialidad) {
	getCal<?php echo $NumWindow; ?>();
}	

function UpdtMonth<?php echo $NumWindow; ?>(fechaNueva) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=fechaNueva;
	getCal<?php echo $NumWindow; ?>();
}

function AgendaDia<?php echo $NumWindow; ?>(Medico,TheFecha, Areax) {
	FillAgendaR('<?php echo $NumWindow; ?>', Medico, TheFecha, Areax);
}

function ShowAgendas<?php echo $NumWindow; ?>(TheFecha) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=TheFecha;
	CargarMedicosCxR('<?php echo $NumWindow; ?>', '<?php echo $theArea; ?>', TheFecha);
	
}

function getCal<?php echo $NumWindow; ?>() {
	variaBles="";
	if (document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value!="0000-00-00") {
		variaBles=variaBles+"&mescal="+document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value;
	}
	variaBles=variaBles+"&TheArea="+document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&fechadeseada="+document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&CITA=<?php echo $_GET["CITA"]; ?>";
	AbrirForm('application/forms/agendacitasrpgr.php', '<?php echo $NumWindow; ?>', variaBles);
}
function RepCita<?php echo $NumWindow; ?>(Fila) {
	NumFilas=document.frm_form<?php echo $NumWindow; ?>.hdn_controwcitas<?php echo $NumWindow; ?>.value;
	for (var i=1; i < NumFilas; i++) {
		document.getElementById('txt_paciente'+i+'<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_paciente2'+i+'<?php echo $NumWindow; ?>').value="";
	}
	NombrePac=document.getElementById('hdn_elpaciente<?php echo $NumWindow; ?>').value;
	document.getElementById('txt_paciente'+Fila+'<?php echo $NumWindow; ?>').value=NombrePac;
	NombreTercero(Fila+'<?php echo $NumWindow; ?>', NombrePac, 'gxpacientes');
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agendacitasrpgr.php', '<?php echo $NumWindow; ?>', '');	
}


	var NumWin='<?php echo $NumWindow; ?>';
	NumWin=NumWin.substring(6, NumWin.length);
	document.getElementById('Nuevo'+NumWin).style.display  = 'none';
	document.getElementById('Imprimir'+NumWin).style.display  = 'none';
    document.getElementById('Anular'+NumWin).style.display  = 'none';
    
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
