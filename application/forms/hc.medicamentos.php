
<div role="tabpanel" class="tab-pane fade " id="hc_medicamentos<?php echo $NumWindow; ?>">
	  					<div class="row">
	  			
	  						<ul class="nav nav-tabs" role="tablist">
						    <li role="presentation" class="active"><a href="#tbfmed1<?php echo $NumWindow; ?>" aria-controls="tbfmed1<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Histórico de Formulaciones</a></li>
						    <li role="presentation"><a href="#tbfmed2<?php echo $NumWindow; ?>" aria-controls="tbfmed2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Nueva Orden de Medicamentos</a></li>
						  </ul>
	  				
		  		<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
		  			<div id="tbfmed1<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
	  					<div class="col-md-12 panel-group" id="HistMedicForM<?php echo $NumWindow; ?>" role="tablist" aria-multiselectable="true">
	  						<?php
	  						$SQL="SELECT distinct Codigo_HCM, b.Fecha_HCF, d.Nombre_ARE , concat(c.Nombre1_MED, ' ', LEFT(c.Nombre2_MED,1), ' ', c.Apellido1_MED, ' ', LEFT(c.Apellido2_MED,1) ), b.Codigo_HCF, b.Codigo_TER FROM hcordenesmedica a, hcfolios b, gxmedicos c, gxareas d, czterceros m WHERE a.Codigo_TER =b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND c.Codigo_USR=b.Codigo_USR AND d.Codigo_ARE=b.Codigo_ARE AND a.Codigo_TER=m.Codigo_TER and ID_TER='".$_GET["Historia"]."' Order By 2 desc; ";
	  						$result = mysqli_query($conexion, $SQL);
	  						$kfilas="0";
							while($row = mysqli_fetch_array($result)) {
	  						?>
	  						<div class="panel panel-success">
							    <div class="panel-heading" role="tab" id="hdng<?php echo $row[0].$NumWindow; ?>" style="background-color: #efefef75;">
							      <h4 class="panel-title">
							        <a role="button" data-toggle="collapse" data-parent="#HistMedicForM<?php echo $NumWindow; ?>" href="#ForM<?php echo $row[0].$NumWindow; ?>" aria-expanded="<?php if($kfilas==0) { echo 'true'; } else { echo 'false';} ?>" aria-controls="collapseOne" style="color: #668e33;">
							          <?php echo 'Fecha: <strong>'.$row[1].'</strong> Area: <strong>'.$row[2].'</strong> Profesional: <strong>'.$row[3].'</strong>'; ?>
							        </a>
							      </h4>
							    </div>
							    <div id="ForM<?php echo $row[0].$NumWindow; ?>" class="panel-collapse collapse <?php if($kfilas==0) { echo 'in'; } else { echo '';} ?>" role="tabpanel" aria-labelledby="hdng<?php echo $row[0].$NumWindow; ?>">
							      <div class="panel-body table-responsive hcorden">
							        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $row[0].$NumWindow; ?>" >
									<tbody id="tbfmdx<?php echo $row[0].$NumWindow; ?>">
									<tr id="trhfmX<?php echo $row[0].$NumWindow; ?>"> 
										<th id="th1fmX<?php echo $row[0].$NumWindow; ?>" colspan="2">Medicamento</th> 
										<th id="th2fmX<?php echo $row[0].$NumWindow; ?>">Dosis</th> 
										<th id="th6fmX<?php echo $row[0].$NumWindow; ?>">Cant.</th>
										<th id="th7fmX<?php echo $row[0].$NumWindow; ?>">Obs.</th>
									</tr> 
									<?php
									$SQL="SELECT m.Codigo_SER, n.Codigo_MED, n.Nombre_MED, m.Dosis_HCM, m.Via_HCM, m.Frecuencia_HCM, m.Duracion_HCM, m.Cantidad_HCM, m.Observaciones_HCM FROM hcordenesmedica m, gxmedicamentos n WHERE m.Codigo_SER=n.Codigo_SER AND m.Codigo_HCM='".$row[0]."'";
									$resmed = mysqli_query($conexion, $SQL);
									$konrwmd=0;
									while($rowmd = mysqli_fetch_array($resmed)) {
										$konrwmd++;
									?>
									<tr id="trfmed<?php echo $konrwmd.$row[0].$NumWindow; ?>">
										<td title="Formular Nuevamente <?php echo $row[2]; ?>"><button class="btn btn-info btn-xs" type="button" onclick="ReLoadForMed<?php echo $NumWindow; ?>('<?php echo $row[0].'-'.$konrwmd; ?>');"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> </button><input type="hidden" name="hdn_fmed_CSER<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_CSER<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[0]; ?>">
											<input type="hidden" name="hdn_fmed_NMED<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_NMED<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[2]; ?>">
											<input type="hidden" name="hdn_fmed_DoHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_DoHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[3]; ?>">
											<input type="hidden" name="hdn_fmed_VHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_VHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[4]; ?>">
											<input type="hidden" name="hdn_fmed_FHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_FHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[5]; ?>">
											<input type="hidden" name="hdn_fmed_DuHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_DuHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[6]; ?>">
											<input type="hidden" name="hdn_fmed_CHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_CHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[7]; ?>">
											<input type="hidden" name="hdn_fmed_OHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" id="hdn_fmed_OHCM<?php echo $row[0].'-'.$konrwmd.$NumWindow; ?>" value="<?php echo $rowmd[8]; ?>"></td>
										<td><?php echo $rowmd[1].' - '.$rowmd[2]; ?></td>
										<td><?php echo $rowmd[3]; ?></td>
										<td><?php echo $rowmd[7]; ?></td>
										<td><?php echo $rowmd[8]; ?></td>
									</tr>
									<?php
									}
									mysqli_free_result($resmed);
									?>
									</tbody>
									</table><input name="hdn_controwormed<?php echo $row[0].$NumWindow; ?>" type="hidden" id="hdn_controwormed<?php echo $row[0].$NumWindow; ?>" value="<?php echo $konrwmd; ?>" />
							      </div>
							    </div>
							  </div>
						  <?php
						  $kfilas++;
							}
							mysqli_free_result($result);
						  ?>
	  					</div>
	  				</div>
		  			<div id="tbfmed2<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">

						<div class="col-md-1">
						    <div class="form-group">
								<label for="txt_codmed<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codmed<?php echo $NumWindow; ?>" id="txt_codmed<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodMed<?php echo $NumWindow; ?>(event);" onblur="CodMedOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codmed<?php echo $NumWindow; ?>', 'Codigo_CFC<>*09*!and!estado_ser=*1*');"><i class="fas fa-search"></i></button>
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
								<label for="txt_supcorpo<?php echo $NumWindow; ?>">Sup. Corporal</label>
								<input  name="txt_supcorpo<?php echo $NumWindow; ?>" id="txt_supcorpo<?php echo $NumWindow; ?>" type="text" value=""/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_ciclottmo<?php echo $NumWindow; ?>">Ciclo Ttmo.</label>
								<input  name="txt_ciclottmo<?php echo $NumWindow; ?>" id="txt_ciclottmo<?php echo $NumWindow; ?>" type="text" value=""/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_dosisteo<?php echo $NumWindow; ?>">Dosis Teorica</label>
								<input  name="txt_dosisteo<?php echo $NumWindow; ?>" id="txt_dosisteo<?php echo $NumWindow; ?>" type="text" value=""/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_dosisajust<?php echo $NumWindow; ?>">Dosis Ajustada</label>
								<input  name="txt_dosisajust<?php echo $NumWindow; ?>" id="txt_dosisajust<?php echo $NumWindow; ?>" type="text" value=""/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_volsol<?php echo $NumWindow; ?>">Vol. Solucion</label>
								<input  name="txt_volsol<?php echo $NumWindow; ?>" id="txt_volsol<?php echo $NumWindow; ?>" type="text" value=""/>
							</div>			
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="txt_obsmed<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsmed<?php echo $NumWindow; ?>" id="txt_obsmed<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddMedica<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
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
									$SQL="Select MedicIntraHosp_ARE from gxareas Where Codigo_ARE='".$_GET["Area"]."'";
									$resultarea = mysqli_query($conexion, $SQL);
									if ($rowarea = mysqli_fetch_array($resultarea)) {
										if ($rowarea[0]=="1") {
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
	  	</div>