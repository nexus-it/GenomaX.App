<?php
	
	
	session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group">	
			<input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
		<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_area<?php echo $NumWindow; ?>">Area de Servicio</label>
		<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' order by 2";
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
		<div class="col-md-2">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
		<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="time" required value="00:00:00"/>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
			<div class="col-md-3 alert alert-warning">

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">#</th> 
				<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Tipo</th> 
			</tr> 
				 <?php 
				 if (isset($_GET["Historia"])) {
				$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, e.ID_TER, a.Hora_HCF, Folio_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."' Order By a.Fecha_HCF desc, a.Hora_HCF, a.Codigo_HCF desc";
				$resulthc = mysqli_query($conexion, $SQL);
				$contarow=0;
				while($rowhc = mysqli_fetch_array($resulthc)) 
					{
						$contarow=$contarow+1;
						echo '
				  <tr onclick="CargarReport(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc["Folio_HCF"].'&FOLIO_FINAL='.$rowhc["Folio_HCF"].'\', \'HC '.$rowhc["ID_TER"].'\');"><td align="center">'.$rowhc["Folio_HCF"].'</td><td align="center">'.formatofecha($rowhc[1]).'</td><td>'.$rowhc[2].'</td></tr>
				  ';
					}
				mysqli_free_result($resulthc); 
				 }
				 ?>  

			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			 </div>

	  		</div>
		<div class="col-md-9 alert alert-warning">
	<div class="row">
		<div class="col-md-12 label label-danger hidden" id="div_alertas">
			...
		</div>
		<input name="hdn_autorizacion<?php echo $NumWindow; ?>" type="hidden" id="hdn_autorizacion<?php echo $NumWindow; ?>" value="" />
		<div class="col-md-5">
			<label>Contrato: </label> <span id="spn_contrato<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_contrato<?php echo $NumWindow; ?>" type="hidden" id="hdn_contrato<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-5">
			<label>Plan: </label> <span id="spn_plan<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_plan<?php echo $NumWindow; ?>" type="hidden" id="hdn_plan<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-2">
			<label>Rango: </label> <span id="spn_rango<?php echo $NumWindow; ?>">--</span>
		</div>
		<div class="col-md-3">
			<label>Fec Nacimiento: </label> <small><span id="spn_fechanac<?php echo $NumWindow; ?>">00/00/0000</span></small>
		</div>
		<div class="col-md-4">
			<label>Edad: </label> <small><span id="spn_edad<?php echo $NumWindow; ?>">00 Años</span></small>
		</div>
		<div class="col-md-2">
			<label>Sexo: </label> <small><span id="spn_sexo<?php echo $NumWindow; ?>">-</span></small>
		</div>
		<div class="col-md-3">
			<label>Est. Civil: </label> <small><span id="spn_estcivil<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-5">
			<label>Dirección: </label> <small><span id="spn_direccion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3">
			<label>Teléfono: </label> <small><span id="spn_telefono<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Ocupación: </label> <small><span id="spn_ocupacion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-5">
			<label>Acompañante: </label> <small><span id="spn_acomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3">
			<label>Teléfono: </label> <small><span id="spn_telacomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Parentesco: </label> <small><span id="spn_parentesco<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Ingreso Por: </label> <small><span id="spn_ingpor<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Observaciones: </label> <small><span id="spn_obs<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Fecha Ingreso: </label> <span id="spn_fechaing<?php echo $NumWindow; ?>" class="badge">00/00/0000</span>
		</div>
		<div class="col-md-4">
			<label>Tipo Paciente: </label> <span id="spn_tipopte<?php echo $NumWindow; ?>" >Sin datos</span>
		</div>
	</div>
		</div>

	  		
		  		<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Ordenes de Medicamentos</label>
	  				<div class="row well well-sm">

						<div class="col-md-1">
						    <div class="form-group">
								<label for="txt_codmed<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codmed<?php echo $NumWindow; ?>" id="txt_codmed<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodMed<?php echo $NumWindow; ?>(event);" onblur="CodMedOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codmed<?php echo $NumWindow; ?>', 'Codigo_CFC<>*09*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_medicamento<?php echo $NumWindow; ?>">Medicamento</label>
								<input  name="txt_medicamento<?php echo $NumWindow; ?>" id="txt_medicamento<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_dosis<?php echo $NumWindow; ?>">Dosis</label>
								<input  name="txt_dosis<?php echo $NumWindow; ?>" id="txt_dosis<?php echo $NumWindow; ?>" type="text"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();"/>
								<input  name="hdn_dosish<?php echo $NumWindow; ?>" id="hdn_dosish<?php echo $NumWindow; ?>" type="hidden" value="0"/>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_unidad<?php echo $NumWindow; ?>">Unidad</label>
								<select name="cmb_unidad<?php echo $NumWindow; ?>" id="cmb_unidad<?php echo $NumWindow; ?>" >
							<?php 
								$SQL="Select Codigo_UNM, Sigla_UNM from gxunidadmed Order by 1";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_via<?php echo $NumWindow; ?>">Vía</label>
								<select name="cmb_via<?php echo $NumWindow; ?>" id="cmb_via<?php echo $NumWindow; ?>" >
							<?php 
								$SQL="Select Codigo_VIA, Descripcion_VIA from gxviasmed Order by 2";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_frecuencia<?php echo $NumWindow; ?>">Frecuencia</label>
								<select name="cmb_frecuencia<?php echo $NumWindow; ?>" id="cmb_frecuencia<?php echo $NumWindow; ?>"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();">
							<?php 
								$SQL="Select Codigo_FRC, Descripcion_FRC from gxfrecuenciamed Order by 1";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_duracion<?php echo $NumWindow; ?>">Durante</label>
								<input  name="txt_duracion<?php echo $NumWindow; ?>" id="txt_duracion<?php echo $NumWindow; ?>" type="text" value="1"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();"/>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_tiempo<?php echo $NumWindow; ?>">_ </label>
								<select name="cmb_tiempo<?php echo $NumWindow; ?>" id="cmb_tiempo<?php echo $NumWindow; ?>" onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();" >
									<option value="1" >Hora(s)</option>
									<option value="24" >Día(s)</option>
									<option value="720" >Mes(es)</option>
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantmed<?php echo $NumWindow; ?>">Cantidad</label>
								<input  name="txt_cantmed<?php echo $NumWindow; ?>" id="txt_cantmed<?php echo $NumWindow; ?>" type="text" value="1"/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_obsmed<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsmed<?php echo $NumWindow; ?>" id="txt_obsmed<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddMedica<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleMed<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleMed<?php echo $NumWindow; ?>" >
								<tbody id="tbMedX<?php echo $NumWindow; ?>">
								<tr id="trhmX'.$NumWindow.'"> 
									<th id="th2mX'.$NumWindow.'">Medicamento</th> 
									<th id="th3mX'.$NumWindow.'">Dosis</th> 
									<th id="th4mX'.$NumWindow.'">Vía</th> 
									<th id="th5mX'.$NumWindow.'">Frecuencia</th> 
									<th id="th6mX'.$NumWindow.'">Duración</th>
									<th id="th6mX'.$NumWindow.'">Cantidad</th> 
									<th id="th7mX'.$NumWindow.'">Observaciones</th> 
									<th id="th8mX'.$NumWindow.'">Estado</th> 
								</tr> 
								<?php 
								$filasMed=0;
								if (isset($_GET["Historia"])) {
									if (trim($_GET["Historia"])!="") {
										$SQL="Select a.Codigo_SER, b.Nombre_MED, a.Dosis_HCM, a.Via_HCM, c.Descripcion_VIA, a.Frecuencia_HCM, d.Descripcion_FRC, a.Duracion_HCM, a.Cantidad_HCM, a.Observaciones_HCM From hcordenesmedica a, gxmedicamentos b, gxviasmed c, gxfrecuenciamed d, czterceros e Where e.Codigo_TER=a.Codigo_TER and a.Codigo_SER=b.Codigo_SER and c.Codigo_VIA=b.Codigo_VIA and d.Codigo_FRC=a.Frecuencia_HCM and a.Estado_HCM<>'X' and e.ID_TER='".$_GET["Historia"]."'  and a.Codigo_HCF in (Select max(x.Codigo_HCF) From hcordenesmedica x, czterceros y Where y.Codigo_TER=x.Codigo_TER and y.ID_TER='".$_GET["Historia"]."')";
										$resultm = mysqli_query($conexion, $SQL);
										while($rowm = mysqli_fetch_array($resultm)) {
											$filasMed=$filasMed+1;
											echo '<tr id="trmedx'.$filasMed.$NumWindow.'">
											<td><input name="hdn_codmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_codmed'.$filasMed.$NumWindow.'" value="'.$rowm[0].'"> '.$rowm[1].'</td>
											<td><input name="hdn_dosis'.$filasMed.$NumWindow.'" type="hidden" id="hdn_dosis'.$filasMed.$NumWindow.'" value="'.$rowm[2].'"> '.$rowm[2].'</td>
											<td><input name="hdn_via'.$filasMed.$NumWindow.'" type="hidden" id="hdn_via'.$filasMed.$NumWindow.'" value="'.$rowm[3].'"> '.$rowm[4].'</td>
											<td><input name="hdn_frecuencia'.$filasMed.$NumWindow.'" type="hidden" id="hdn_frecuencia'.$filasMed.$NumWindow.'" value="'.$rowm[5].'"> '.$rowm[6].'</td>
											<td><input name="hdn_duracion'.$filasMed.$NumWindow.'" type="hidden" id="hdn_duracion'.$filasMed.$NumWindow.'" value="'.$rowm[7].'"> '.$rowm[7].'</td>
											<td><input name="hdn_cantmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_cantmed'.$filasMed.$NumWindow.'" value="'.$rowm[8].'"> '.$rowm[8].'</td>
											<td><input name="hdn_obsmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_obsmed'.$filasMed.$NumWindow.'" value="'.$rowm[9].'"> '.$rowm[9].'</td>
											<td><select class="form-control" id="cmb_estadomed'.$filasMed.$NumWindow.'" name="cmb_estadomed'.$filasMed.$NumWindow.'"><option value="O" selected>Ordenado</option><option value="X">Suspender</option></select></td>
											</tr>';
										}
										mysqli_free_result($resultm); 
									}
								}
								?>
								</tbody> 
								</table><input name="hdn_controwMed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwMed<?php echo $NumWindow; ?>" value="<?php echo $filasMed; ?>" />
							</div>
						</div>
	  				</div>
	  			</div>
</div>

</form>

<script >

<?php
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, a.fechanac_pac, a.Codigo_SEX, a.EstCivil_PAC, b.direccion_ter, b.telefono_ter, a.Actividad_PAC, c.Acudiente_ADM, c.Parentesco_ADM, c.Telefono_ADM, h.Descripcion_ADM, c.Observaciones_ADM, left(Fecha_ADM,10), c.Autorizacion_ADM, c.Codigo_EPS, c.Codigo_PLA, Nombre_PTT from gxpacientestipos z, gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h where z.Codigo_PTT=c.Codigo_PTT and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='I' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('spn_contrato".$NumWindow."').innerHTML = '".$row[3]."';
				document.getElementById('spn_plan".$NumWindow."').innerHTML = '".$row[4]."';
				document.getElementById('spn_rango".$NumWindow."').innerHTML = '".$row[5]."';
				document.getElementById('spn_fechanac".$NumWindow."').innerHTML = '".formatofecha($row[6])."';
				document.getElementById('spn_edad".$NumWindow."').innerHTML = '".edad($row[6])."';
				document.getElementById('spn_sexo".$NumWindow."').innerHTML = '".$row[7]."';
				document.getElementById('spn_estcivil".$NumWindow."').innerHTML = '".$row[8]."';
				document.getElementById('spn_direccion".$NumWindow."').innerHTML = '".$row[9]."';
				document.getElementById('spn_telefono".$NumWindow."').innerHTML = '".$row[10]."';
				document.getElementById('spn_ocupacion".$NumWindow."').innerHTML = '".$row[11]."';
				document.getElementById('spn_acomp".$NumWindow."').innerHTML = '".$row[12]."';
				document.getElementById('spn_parentesco".$NumWindow."').innerHTML = '".$row[13]."';
				document.getElementById('spn_telacomp".$NumWindow."').innerHTML = '".$row[14]."';
				document.getElementById('spn_ingpor".$NumWindow."').innerHTML = '".$row[15]."';
				document.getElementById('spn_tipopte".$NumWindow."').innerHTML = '".$row["Nombre_PTT"]."';
				document.getElementById('spn_obs".$NumWindow."').innerHTML = '".preg_replace("/\r\n|\n|\r/", "<br/>",$row[16])."';
				document.getElementById('spn_fechaing".$NumWindow."').innerHTML = '".formatofecha($row[17])."';
				document.getElementById('hdn_autorizacion".$NumWindow."').value = '".$row[18]."';
				document.getElementById('hdn_contrato".$NumWindow."').value = '".$row[19]."';
				document.getElementById('hdn_plan".$NumWindow."').value = '".$row[20]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos activos.');
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".focus();
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function selecthc<?php echo $NumWindow; ?>(CodigoHCT) {
	AbrirForm('application/forms/hcmedicamentos.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
}

function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hcmedicamentos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/hcmedicamentos.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcmedicamentos.php', '<?php echo $NumWindow; ?>', '&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}

function CantidadMed<?php echo $NumWindow; ?>() {
	Frecx=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
	if (Frecx=="0") {
		document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
	} else {
		if (Frecx=="99") {
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
		} else {
			Duracx=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
			Durac2x=document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').value;
			Dosisx=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value;
			Dosis2x=document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value;
			if (Dosis2x=="0") {
				document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value=Dosisx;
			}
			CantMedx=Duracx*(Durac2x/Frecx)*(Dosisx/Dosis2x);
			CantMedx=Math.round(CantMedx);
			/* alert(Duracx+'*('+Durac2x+'/'+Frecx+')*('+Dosisx+'/'+Dosis2x+')'); */
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value=CantMedx;
		}
	}
}

function CodMedOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value!="") {
		NombreMedicamento(document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaMed<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trmed'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddMedica<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la duracion del suministro del medicamento a ordenar";
	}
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una duracion del medicamento mayor";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la dosis del medicamento a ordenar";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una dosis del medicamento mayor";
	}
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el medicamento a ordenar";
	}
	if (document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Medicamentos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbMedX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda8 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trmed"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodMed=document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value;
		Medicamento=document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value;
		Dosis=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').options[document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').selectedIndex].text;
		Via=document.getElementById('cmb_via<?php echo $NumWindow; ?>').value;
		Via2=document.getElementById('cmb_via<?php echo $NumWindow; ?>').options[document.getElementById('cmb_via<?php echo $NumWindow; ?>').selectedIndex].text;
		Frec=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
		Frec2=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
	    Durac2=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantMed=document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value;
		ObsMed=document.getElementById('txt_obsmed<?php echo $NumWindow; ?>').value;
		celda2.innerHTML = '<input name="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodMed+''+'" /> '+Medicamento; 
		celda3.innerHTML = '<input name="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Dosis+''+'" /> '+Dosis; 
		celda4.innerHTML = '<input name="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Via+''+'" /> '+Via2; 
		celda5.innerHTML = '<input name="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac2+''+'" /> '+Durac2; 
		celda9.innerHTML = '<input name="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantMed+'" /> '+CantMed; 
		celda7.innerHTML = '<input name="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsMed+''+'" /> '+ObsMed; 
		celda8.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /><button onclick="EliminarFilaMed<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda9); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda8); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').focus();
	}
}


function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcmedicamentos.php', '<?php echo $NumWindow; ?>', '');	
}

	HoraActual("txt_hora<?php echo $NumWindow; ?>");

    $("input[type=text]").addClass("form-control");
     $("input[type=time]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
