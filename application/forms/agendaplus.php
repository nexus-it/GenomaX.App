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
        <div class="col-md-10 col-sm-12 scrool-v">
            <div class="panel panel-success bg-success"> <input type="hidden" name="hdn_fechacalc<?php echo $NumWindow; ?>" value="" id="hdn_fechacalc<?php echo $NumWindow; ?>" />
              <h4 style="text-align: center">  <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  AGENDA DEL DÍA <span id="spn_fechacalc<?php echo $NumWindow; ?>" name="spn_fechacalc<?php echo $NumWindow; ?>">0000-00-00</span></h4>
            </div>
            <div class="table-responsive" id="div_Schedule<?php echo $NumWindow; ?>" name="div_Schedule<?php echo $NumWindow; ?>" style="height: 85%; overflow: auto;" >
            
            </div>
        </div>

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
			}
			$MesCal=$FechaD;
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
		<div class="col-md-2 jumbotron" style="padding:12px; font-size:12px; background-color:#dff0d8; border-color:#d6e9c6; ">					
			<span class="label label-success" id="calendary<?php echo $NumWindow; ?>">Seleccione el día disponible</span>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive ">
				<table  width="85%" cellpadding="1" cellspacing="2" style="background-color:#efefef91; text-align:center;"  class="table table-condensed tblDetallecal table-bordered " style="font-size:10px" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>" style="font-size: 11px;">
				<tr id="trh<?php echo $NumWindow; ?>" class="trCal"> 
					<th id="thant<?php echo $NumWindow; ?>" style="text-align: left;"> 
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
					<th id="thm<?php echo $NumWindow; ?>" colspan="5" halign="center" style="text-align: center;"><span id="NombreMes<?php echo $NumWindow; ?>"> <?php echo $meses[$month]." - ".$year; ?> </span></th>
					<th id="thsig<?php echo $NumWindow; ?>" style="text-align: rigth;"> 
						<?php
						$SQL="Select max(a.Fecha_AGE) From gxagendadet a, gxagendacab b Where a.Codigo_AGE=b.Codigo_AGE ;";
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
					for($i=1;$i<=44;$i++) {
						if($i==$diaSemana) {
							// determinamos en que dia empieza
							$day=1;
						}
						if($i<$diaSemana || $i>=$last_cell)	{
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
							$EnlaceJS="";
							$Badge="";
							$SQL="Select a.Codigo_AGE From gxagendacab a, gxagendadet b Where b.Codigo_AGE=a.Codigo_AGE and a.Estado_AGE='1' and b.Fecha_AGE='".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."'"; /* and b.Fecha_AGE>=curdate()"; */
							$resultge = mysqli_query($conexion, $SQL);
							if($rowge = mysqli_fetch_array($resultge)) {
									if ($Fest=="No") {
										$EnlaceJS=" title='".$ConsXDia." Consultas disponibles para este día' class='bg-success' style='cursor: pointer; color:#0E5012;' onclick=\"javascript:ShowAgendas".$NumWindow."('".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."');\"";
										$ConsXDia=$rowge[0];
									}
									$SQL="Select count(*) From gxagendadet b Where b.Codigo_AGE='".$rowge[0]."' and b.Estado_AGE='1' and b.Fecha_AGE='".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."'"; /* and b.Fecha_AGE>=curdate()"; */
									$result = mysqli_query($conexion, $SQL);
									if($row = mysqli_fetch_array($result)) {
										if ($Fest=="No") {
											$ConsXDia=$row[0];
											$Badge='<span class="badge label label-success" style="padding:2px;"><small><small>'.$ConsXDia.'</small></small></span>';
										}
									}
									mysqli_free_result($result);		 
							}
							mysqli_free_result($resultge);
							$EnlaceJS=" title='".$ConsXDia." Consultas disponibles para este día' class='bg-success' style='cursor: pointer; color:#0E5012; ' onclick=\"javascript:ShowAgendas".$NumWindow."('".$year."-".str_pad($month,2,'0', STR_PAD_LEFT)."-".str_pad($day,2,'0', STR_PAD_LEFT)."');\"";

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
			
			<div class="well well-sm">			
			<input type="hidden" name="hdn_areas<?php echo $NumWindow; ?>" value="" id="hdn_areas<?php echo $NumWindow; ?>" />
        <span class="label label-info">Areas</span>
            <?php 
            if ($_SESSION["it_CodigoPRF"]!='0') {
                $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' AND b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' ORDER BY 2 ";
            } else {
                $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' ORDER BY 2 ";
            }
            $result = mysqli_query($conexion, $SQL);
            $contaarea=0;
            while($row = mysqli_fetch_array($result)) {
                $contaarea++;
            ?>
                <div class="checkbox checkbox-success">
                    <input name="chk_<?php echo $row[0]; ?>ok<?php echo $NumWindow; ?>" id="chk_<?php echo $row[0]; ?>ok<?php echo $NumWindow; ?>" type="checkbox" value="" onclick="javascript:nxs_chkd('<?php echo $row[0].$NumWindow; ?>');theAreas<?php echo $NumWindow; ?>(); getCal<?php echo $NumWindow; ?>();" class="styled"><label for="chk_<?php echo $row[0]; ?>ok<?php echo $NumWindow; ?>"><small><?php echo $row[1]; ?></small></label>
                </div>
                <input name="hdn_<?php echo $row[0].$NumWindow; ?>" type="hidden" id="hdn_<?php echo $row[0].$NumWindow; ?>" value="1">
            <?php
            }
            mysqli_free_result($result);
            ?>
            </div>
            <div class="col-md-12">
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

        </div>
	
	</div>

</form>

<script >
    //FechaActual('hdn_fechacalc<?php echo $NumWindow; ?>');
    <?php
    $SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".hdn_fechacalc".$NumWindow.".value='".$row[0]."'
        theAreas".$NumWindow."();;
        getCal".$NumWindow."();";
	}
	mysqli_free_result($result); 
    if ($_SESSION["it_CodigoPRF"]!='0') {
        $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' AND b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' ORDER BY 2 ";
    } else {
        $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' ORDER BY 2 ";
    }
    $result = mysqli_query($conexion, $SQL);
    $contaarea=0;
    while($row = mysqli_fetch_array($result)) {
        $contaarea++;
        echo "document.getElementById('chk_".$row[0]."ok".$NumWindow."').checked=1;";
    }
    mysqli_free_result($result);
    ?>
    
function theAreas<?php echo $NumWindow; ?>() {
    areas="";
    <?php
    if ($_SESSION["it_CodigoPRF"]!='0') {
        $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' AND b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' ORDER BY 2 ";
    } else {
        $SQL="SELECT distinct a.Codigo_ARE, a.Nombre_ARE FROM gxareas a, itusuariosareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.AgendaCitas_ARE='1' and a.Estado_ARE='1' ORDER BY 2 ";
    }
    $result = mysqli_query($conexion, $SQL);
    $contaarea=0;
    while($row = mysqli_fetch_array($result)) {
        $contaarea++;
        echo 'area=document.frm_form'.$NumWindow.'.hdn_'.$row[0].$NumWindow.'.value;
        if (area=="1") {
            if (areas!="") { 
                areas=areas+", ";
            }
            areas=areas+"\''.$row[0].'\'";
        }';
    }
    mysqli_free_result($result);
    ?>
    document.getElementById('hdn_areas<?php echo $NumWindow; ?>').value=areas;
}

function getCal<?php echo $NumWindow; ?>() {
	fechacalc=document.frm_form<?php echo $NumWindow; ?>.hdn_fechacalc<?php echo $NumWindow; ?>.value;
    areas=document.frm_form<?php echo $NumWindow; ?>.hdn_areas<?php echo $NumWindow; ?>.value;
	document.getElementById('spn_fechacalc<?php echo $NumWindow; ?>').innerHTML=fechacalc;
	loadSchedule<?php echo $NumWindow; ?>(fechacalc, areas);
    loadServices<?php echo $NumWindow; ?>(fechacalc);
    loadProfessionals<?php echo $NumWindow; ?>(fechacalc);
}

function loadSchedule<?php echo $NumWindow; ?>(fechacalc, areas) {
    document.getElementById('div_Schedule<?php echo $NumWindow; ?>').innerHTML='<table class="table table-condensed table-bordered table-hover tblDetalle"> <thead> <tr> <th width="64px" style="font-size: 13px; text-align: center;"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> </th> <th  style="font-size: 13px; text-align: center;">Cargando Agenda... </th> </tr> </thead> <tbody> <tr><td colspan="2"><div class="progress" style=" margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Consultando Registros...</span> </div></div></td></tr> </tbody> </table>';
    $.get(Funciones,{'Func':'loadSchedule','fecha':fechacalc,'areas':areas,'wind':'<?php echo $NumWindow; ?>'},function(data){ 
        document.getElementById('div_Schedule<?php echo $NumWindow; ?>').innerHTML=data;
    }); 
}

function loadServices<?php echo $NumWindow; ?>(fechacal) {

}

function loadProfessionals<?php echo $NumWindow; ?>(fechacalc) {

}
function sendWhatsapp<?php echo $NumWindow; ?>(tel, cita) {
	$.get(Funciones,{'Func':'txtrSchedule','cita':cita},function(data){ 
        mensaje=data;
		window.open("https://api.whatsapp.com/send?phone=57"+tel+"&text="+mensaje+"%0D%0A" , "gnxWhats" , "width=600,height=400,scrollbars=NO");
    });	
}

function ShowAgendas<?php echo $NumWindow; ?>(TheFecha) {
    document.frm_form<?php echo $NumWindow; ?>.hdn_fechacalc<?php echo $NumWindow; ?>.value=TheFecha;
    getCal<?php echo $NumWindow; ?>();
	// document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=TheFecha;
	// CargarMedicosCx('<?php echo $NumWindow; ?>', '<?php echo $theArea; ?>', TheFecha);
	
}

function printReminder<?php echo $NumWindow; ?>(idpcte, fecha, wind) {
    CargarWind('Cita Programada Paciente '+idpcte, 'reports/citasprogramadasusuario.php?PACIENTE='+idpcte+'&FECHA_INICIAL='+fecha+'&FECHA_FINAL='+fecha, 'default.png', 'agendaplus.php','<?php echo $NumWindow; ?>' );
}

function newcita<?php echo $NumWindow; ?>(agenda, fecha, hora, wind) {
    CargarWind('Nueva Cita', 'forms/agendanewcita.php?agenda='+agenda+'&fecha='+fecha+'&hora='+hora, '1.Calendar.png', 'agendaplus.php',wind );
}

function confcita<?php echo $NumWindow; ?>(idpcte, wind) {
    CargarWind('Confirmacion de Citas', 'forms/confirmacioncitas.php?paciente='+idpcte, 'data_field.png', 'agendaplus.php',wind );
}

function prevhc<?php echo $NumWindow; ?>(idpcte, fecha, wind) {
	folio="1";
	$.get(Funciones,{'Func':'FolioFromDate','idpcte':idpcte,'fecha':fecha},function(data){ 
        folio=data;
    });	
	CargarWind('HC '+idpcte, 'reports/hc.php?HISTORIA='+idpcte+'&FOLIO_INICIAL='+folio+'&FOLIO_FINAL='+folio, 'default.png', 'agendaplus.php','<?php echo $NumWindow; ?>' );
}

function ReprogCitas<?php echo $NumWindow; ?>(idpcte, wind) {
    CargarWind('Reprogramar Cita', 'forms/agendacitasrpgr.php?CITA='+idpcte, '1.Task.png', 'agendaplus.php',wind );
}

function CancelCitas<?php echo $NumWindow; ?>(idpcte, wind) {
    CargarWind('Cancelar Cita', 'forms/agendacitascncl.php?CITA='+idpcte, '1.Delete.png', 'agendaplus.php',wind );
}

function PcteCitas<?php echo $NumWindow; ?>(idpcte, wind) {
     CargarWind('Historico de Citas', 'forms/citashistory.php?IdPte='+idpcte, 'folder_user.png', 'agendaplus.php',wind );
} 

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
	variaBles="&fechadeseada="+fechaNueva;
	AbrirForm('application/forms/agendaplus.php', '<?php echo $NumWindow; ?>', variaBles);
	getCal<?php echo $NumWindow; ?>();
}

function AgendaDia<?php echo $NumWindow; ?>(Medico,TheFecha, TheAre) {
	FillAgenda('<?php echo $NumWindow; ?>', Medico, TheFecha, TheAre);
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agendaplus.php', '<?php echo $NumWindow; ?>', '');	
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
