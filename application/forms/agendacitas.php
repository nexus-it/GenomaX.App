<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">

		<div class="col-md-2">

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
		<div class="col-md-1">

	<div class="form-group">
		<label for="cmb_primeravez<?php echo $NumWindow; ?>">Tipo Consulta</label>
		<select name="cmb_primeravez<?php echo $NumWindow; ?>" id="cmb_primeravez<?php echo $NumWindow; ?>" onchange="javascript:FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
		  <option value="1" <?php if ($_GET["tipoconsulta"]=="1") { echo "selected='selected'"; } ?> >Primera Vez</option>
		  <option value="C" <?php if ($_GET["tipoconsulta"]=="C") { echo "selected='selected'"; } ?> >Control</option>
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
		<div class="col-md-1 col-sm-2">

	<div class="form-group">
		<label for="cmb_tipoatencion<?php echo $NumWindow; ?>">Tipo Atención</label>
		<select name="cmb_tipoatencion<?php echo $NumWindow; ?>" id="cmb_tipoatencion<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_TAH, Nombre_TAH from hctipoatencion Where Estado_TAH='1' order by 1";
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
		<div class="col-md-4">

	<div class="form-group">
		<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
		<select name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>" onchange="javascript:AgendaDia<?php echo $NumWindow; ?>(this.value, document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
		
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="txt_nota<?php echo $NumWindow; ?>">Nota</label>
		<input  name="txt_nota<?php echo $NumWindow; ?>" id="txt_nota<?php echo $NumWindow; ?>" type="text"  />
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
					<th id="thm<?php echo $NumWindow; ?>" colspan="5" align="center"><span id="NombreMes<?php echo $NumWindow; ?>"> <?php echo $meses[$month]." - ".$year; ?> </span></th>
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
					for($i=1;$i<=44;$i++)
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
					<th id="thd2<?php echo $NumWindow; ?>" width="10%" >Hora</th> 
					<th id="thd1<?php echo $NumWindow; ?>" width="20%" >Consultorio</th> 
					<th id="thd0<?php echo $NumWindow; ?>" width="70%" >Paciente</th> 					
				</tr> 
				<input name="hdn_controwcitas<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwcitas<?php echo $NumWindow; ?>" value="0">
				</tbody>
				</table>
			</div>
			
		</div>
	
	</div>

</form>

<script >

function NombreTer<?php echo $NumWindow; ?>(fila, Codigo, tabla)
{
	$.get(Funciones,{'Func':'NombreTercero','value':Codigo, 'tabla':tabla},function(data){ 
		if (data=="No se encuentra el tercero") {
			swal('DOCUMENTO NO SE ENCUENTRA', data,'error');
			document.getElementById('txt_paciente2x'+fila+'<?php echo $NumWindow; ?>').value="";
			Texto="";
		} else {
			document.getElementById('txt_paciente2x'+fila+'<?php echo $NumWindow; ?>').value=data;
			Texto=data;
		}
		ShowHistoryx<?php echo $NumWindow; ?>(Texto, Codigo, fila);
	}); 
}


function ShowHistoryx<?php echo $NumWindow; ?>(Texto, Pcte, Konta) {
 if(Texto=="") {
	document.getElementById('spn_pctex'+Konta+'<?php echo $NumWindow; ?>').innerHTML='<button class="btn btn-default" type="button" disabled><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span></button>';
 } else {
	document.getElementById('spn_pctex'+Konta+'<?php echo $NumWindow; ?>').innerHTML='<button title="Ver histórico de citas" class="btn btn-primary" type="button" data-toggle="modal" data-target="#GnmX_WinModal" data-whatever="Paciente" onclick="javascript:PcteCitas<?php echo $NumWindow; ?>(\''+Pcte+'\');"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button>';
 }
}

function PcteCitas<?php echo $NumWindow; ?>(history) {
	CargarWind('Historial Citas Pacientes ', 'forms/citashistory.php?IdPte='+history+'&mode=modal&wnd=agendacitas', 'folder_user.png', 'agendacitasrpgr.php','<?php echo $NumWindow; ?>' );
}

function FechaCerca<?php echo $NumWindow; ?>(FechaD, Especialidad) {

	getCal<?php echo $NumWindow; ?>();
}	

function UpdtMonth<?php echo $NumWindow; ?>(fechaNueva) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=fechaNueva;
	getCal<?php echo $NumWindow; ?>();
}

function AgendaDia<?php echo $NumWindow; ?>(Medico,TheFecha, TheAre) {
	FillAgenda('<?php echo $NumWindow; ?>', Medico, TheFecha, TheAre);
}

function ShowAgendas<?php echo $NumWindow; ?>(TheFecha) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=TheFecha;
	CargarMedicosCx('<?php echo $NumWindow; ?>', '<?php echo $theArea; ?>', TheFecha);
	
}

function getCal<?php echo $NumWindow; ?>() {
	variaBles="";
	if (document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value!="0000-00-00") {
		variaBles=variaBles+"&mescal="+document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value;
	}
	variaBles=variaBles+"&TheArea="+document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&fechadeseada="+document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&tipoconsulta="+document.frm_form<?php echo $NumWindow; ?>.cmb_primeravez<?php echo $NumWindow; ?>.value;
	AbrirForm('application/forms/agendacitas.php', '<?php echo $NumWindow; ?>', variaBles);
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agendacitas.php', '<?php echo $NumWindow; ?>', '');	
}

function LoadPcte<?php echo $NumWindow; ?>(fila) {
	IdPte=document.getElementById('txt_paciente'+fila+'<?php echo $NumWindow; ?>').value;
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=agendacitas', '1.PatientMale.png', 'agendacitas.php','<?php echo $NumWindow; ?>' );
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
