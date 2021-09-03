
<div role="tabpanel" class="tab-pane fade " id="hc_ordenaciones<?php echo $NumWindow; ?>">
	  					<div class="row">
	  			
	  			<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Ordenes de Servicio</label>
	  				<div class="row well well-sm">

						<div class="col-md-3">
							<div class="form-group">
								<label for="cmb_tipot<?php echo $NumWindow; ?>">Tipo </label>
								<select name="cmb_tipot<?php echo $NumWindow; ?>" id="cmb_tipot<?php echo $NumWindow; ?>" >
									<option value="Visita Médica" >VISITA MEDICA</option>
						  			<option value="Terapia Física" >TERAPIA FISICA</option>
						  			<option value="Terapia Respiratoria" >TERAPIA RESPIRATORIA</option>
						  			<option value="Terapia Ocupacional" >TERAPIA OCUPACIONAL</option>
						  			<option value="Fonoaudiología" >FONOAUDIOLOGIA</option>
						  			<option value="Valoración por Nutrición" >VALORACION NUTRICION</option>
						  			<option value="Valoración por Psicología" >VALORACION PSICOLOGIA</option>
						  			<option value="Aplicación de Medicamentos" >APLICACION MEDICAMENTOS</option>
						  			<option value="Curacion Convencional Baja Complejidad" >CURACION CONVENCIONAL BAJA COMPLEJIDAD</option>
						  			<option value="Curacion Convencional Mediana Complejidad" >CURACION CONVENCIONAL MEDIANA COMPLEJIDAD</option>
						  			<option value="Curacion Convencional Alta Complejidad" >CURACION CONVENCIONAL ALTA COMPLEJIDAD</option>
						  			<option value="Curacion Con Tecnologia Area General" >CURACION CON TECNOLOGIA AREA GENERAL</option>
									<option value="Curacion Con Tecnologia Area Especial" >CURACION CON TECNOLOGIA AREA ESPECIAL</option>
						  			<option value="Atencion Por Enfermeria 2 Horas" >ATENCION POR ENFERMERIA 2 HORAS</option>
						  			<option value="Atencion Por Enfermeria 6 Horas" >ATENCION POR ENFERMERIA 6 HORAS</option>
						  			<option value="Atencion Por Enfermeria 8 Horas" >ATENCION POR ENFERMERIA 8 HORAS</option>
						  			<option value="Atencion Por Enfermeria 12 Horas" >ATENCION POR ENFERMERIA 12 HORAS</option>
						  			<option value="Atencion Por Enfermeria 24 Horas" >ATENCION POR ENFERMERIA 24 HORAS</option>
						  			<option value="Procedimientos" >PROCEDIMIENTOS</option>
						  			<?php
						  			$SQL="Select concat('VALORACIÓN POR ',Nombre_ESP), Nombre_ESP  From gxespecialidades Where Estado_ESP='1' Order By 2";
						  			$resultmx = mysqli_query($conexion, $SQL);
									while($rowmx = mysqli_fetch_array($resultmx)) {
										echo '
										<option value="'.$rowmx[0].'" >'.$rowmx[1].'</option>
										';
									}
									mysqli_free_result($resultmx);		
						  			?>
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_frecuenciat<?php echo $NumWindow; ?>">Frecuencia</label>
								<select name="cmb_frecuenciat<?php echo $NumWindow; ?>" id="cmb_frecuenciat<?php echo $NumWindow; ?>" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();">
							<?php 
								$SQL="Select Codigo_FRC, Descripcion_FRC, Orden_FRC from gxfrecuenciaserv Order by 3";
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
								<label for="txt_duraciont<?php echo $NumWindow; ?>">Durante</label>
								<input  name="txt_duraciont<?php echo $NumWindow; ?>" id="txt_duraciont<?php echo $NumWindow; ?>" type="text" value="1" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();"/>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_tiempot<?php echo $NumWindow; ?>">_ </label>
								<select name="cmb_tiempot<?php echo $NumWindow; ?>" id="cmb_tiempot<?php echo $NumWindow; ?>" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();">
									<option value="1" >Día(s)</option>
									<option value="7" >Semana(s)</option>
									<option value="30" >Mes(es)</option>
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantt<?php echo $NumWindow; ?>">Cantidad</label>
								<input name="txt_cantt<?php echo $NumWindow; ?>" id="txt_cantt<?php echo $NumWindow; ?>" type="text"  value="1" />
							</div>			
						</div>
						
						<div class="col-md-5">
							<div class="form-group">
								<label for="txt_obster<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obster<?php echo $NumWindow; ?>" id="txt_obster<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddServicioHC" onclick="javascript:AddServicio<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleTer<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleTer<?php echo $NumWindow; ?>" >
								<tbody id="tbTerX<?php echo $NumWindow; ?>">
								<tr id="trhtsX'.$NumWindow.'"> 
									<th id="th1tsX'.$NumWindow.'">Tipo</th> 
									<th id="th2tsX'.$NumWindow.'">Frecuencia</th> 
									<th id="th3tsX'.$NumWindow.'">Duración</th> 
									<th id="th4tsX'.$NumWindow.'">Cantidad</th> 
									<th id="th5tsX'.$NumWindow.'">Observaciones</th> 
									<th id="th6tsX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwTer<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwTer<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>
	  			</div>

	  		</div>
	  	</div>