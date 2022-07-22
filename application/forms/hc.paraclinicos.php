
<div role="tabpanel" class="tab-pane fade " id="hc_paraclinicos<?php echo $NumWindow; ?>">
	  					<div class="row">
	  						<ul class="nav nav-tabs" role="tablist">
						    <li role="presentation" class="active"><a href="#tbhelpdx1<?php echo $NumWindow; ?>" aria-controls="tbhelpdx1<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Histórico de Exámenes</a></li>
						    <li role="presentation"><a href="#tbhelpdx2<?php echo $NumWindow; ?>" aria-controls="tbhelpdx2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Ordenar Nuevos Exámenes</a></li>
						  </ul>
	  				
		  		<div id="divhlpdx<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
		  			<div id="tbhelpdx1<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
	  					<div class="col-md-12">
						  	<div id="zero_detallehlpdx<?php echo $NumWindow; ?>" class=" table-responsive hcorden">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $NumWindow; ?>" >
								<tbody id="tbh1lpdx<?php echo $NumWindow; ?>">
								<tr id="trhhlpdxX<?php echo $NumWindow; ?>"> 
									<th id="th1hlp1dxX<?php echo $NumWindow; ?>">Fecha</th> 
									<th id="th2hlp1dxX<?php echo $NumWindow; ?>" colspan="2">Descripción</th> 
									<th id="th3hlp1dxX<?php echo $NumWindow; ?>">Ordena</th> 
									<th id="th4hlp1dxX<?php echo $NumWindow; ?>">Resultados</th>
								</tr> 
								<?php 
								$HistResults=0;
								if (isset($_GET["Historia"])) {
									if (trim($_GET["Historia"])!="") {
										$SQL="SELECT c.Fecha_HCF,  LEFT(b.Nombre_SER, 50), b.Nombre_SER, d.Nombre_TER, a.Codigo_HCS, a.Codigo_SER, a.Cantidad_HCS, Observaciones_HCS FROM hcordenesdx a, gxservicios b, hcfolios c, czterceros d, gxmedicos e, czterceros m WHERE a.Codigo_SER=b.Codigo_SER AND c.Codigo_TER=a.Codigo_TER AND c.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=d.Codigo_TER AND e.Codigo_USR=c.Codigo_USR AND m.Codigo_TER=a.Codigo_TER AND m.ID_TER='".$_GET["Historia"]."' ORDER BY 1 DESC ";
										$result = mysqli_query($conexion, $SQL);
										while($row = mysqli_fetch_array($result)) {
											$HistResults++;
										?>
								<tr id="trhlpdxH<?php echo $HistResults.$NumWindow; ?>"> 
									<td id="t1hlpdxH<?php echo $HistResults.$NumWindow; ?>"><?php echo $row[0]; ?></td> 
									<td id="t0hlpdxH<?php echo $HistResults.$NumWindow; ?>" title="Ordenar Nuevamente <?php echo $row[2]; ?>"><button class="btn btn-info btn-xs" type="button" onclick="ReLoadHlpDx<?php echo $NumWindow; ?>('<?php echo $HistResults; ?>');"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> </button><input type="hidden" name="hdn_exam_CSER<?php echo $HistResults.$NumWindow; ?>" id="hdn_exam_CSER<?php echo $HistResults.$NumWindow; ?>" value="<?php echo $row[5]; ?>"><input type="hidden" name="hdn_exam_CHCS<?php echo $HistResults.$NumWindow; ?>" id="hdn_exam_CHCS<?php echo $HistResults.$NumWindow; ?>" value="<?php echo $row[6]; ?>">
										<input type="hidden" name="hdn_exam_NSER<?php echo $HistResults.$NumWindow; ?>" id="hdn_exam_NSER<?php echo $HistResults.$NumWindow; ?>" value="<?php echo $row[2]; ?>"><input type="hidden" name="hdn_exam_OHCS<?php echo $HistResults.$NumWindow; ?>" id="hdn_exam_OHCS<?php echo $HistResults.$NumWindow; ?>" value="<?php echo $row[7]; ?>"></td> 
									<td id="t2hlpdxH<?php echo $HistResults.$NumWindow; ?>" title="<?php echo $row[2]; ?>"><?php echo $row[1]; ?></td> 
									<td id="t3hlpdxH<?php echo $HistResults.$NumWindow; ?>"><?php echo $row[3]; ?></td> 
									<td id="t4hlpdxH<?php echo $HistResults.$NumWindow; ?>" align="center">
										<button class="btn btn-success btn-xs" type="button" onclick="ShowHlpRes<?php echo $NumWindow; ?>('<?php echo $row[4]; ?>', '<?php echo $row[5]; ?>');" disabled="disabled"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> </button>
									</td> 
								</tr>
										<?php
										}
										mysqli_free_result($result); 
									}
								}
								if ($HistResults==0) {
								?>
								<tr id="NoReshlpdx<?php echo $NumWindow; ?>"> 
									<td id="thhlpdxNO<?php echo $NumWindow; ?>" colspan="4" align="center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> NO EXISTEN SOLICITUDES DE EXAMENES ANTERIORES EN EL SISTEMA</td> 
								</tr> 
								<?php
								}
								?>
								</tbody>
								</table>
							</div>
						</div>
	  				</div>
	  				<div id="tbhelpdx2<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
	  					<div class="col-md-2">
						    <div class="form-group">
								<label for="txt_codserdx<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codserdx<?php echo $NumWindow; ?>" id="txt_codserdx<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodServDx<?php echo $NumWindow; ?>(event);" onblur="CodServDxOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX1', 'txt_codserdx<?php echo $NumWindow; ?>', 'Codigo_CFC=*02*!AND!Estado_SER=*1*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="txt_serviciodx<?php echo $NumWindow; ?>">Servicio</label>
								<input  name="txt_serviciodx<?php echo $NumWindow; ?>" id="txt_serviciodx<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantservdx<?php echo $NumWindow; ?>">Cantidad</label>
								<input  name="txt_cantservdx<?php echo $NumWindow; ?>" id="txt_cantservdx<?php echo $NumWindow; ?>" type="text" value="1"/>
							</div>			
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="txt_obsserdx<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsserdx<?php echo $NumWindow; ?>" id="txt_obsserdx<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddHelpDx<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detallehlpdx<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $NumWindow; ?>" >
								<tbody id="tbhlpdx<?php echo $NumWindow; ?>">
								<tr id="trhhlpdxX'.$NumWindow.'"> 
									<th id="th1hlpdxX'.$NumWindow.'">Codigo</th> 
									<th id="th2hlpdxX'.$NumWindow.'">Servicio</th> 
									<th id="th3hlpdxX'.$NumWindow.'">Cantidad</th> 
									<th id="th4hlpdxX'.$NumWindow.'">Observaciones</th> 
									<th id="th5hlpdxX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwhlpdx<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwhlpdx<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>

	  			</div>

	  		</div>
	  	</div>