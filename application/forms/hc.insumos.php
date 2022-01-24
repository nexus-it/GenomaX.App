
<div role="tabpanel" class="tab-pane fade " id="hc_insumos<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divordins<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Insumos</label>
	  				<div class="row well well-sm">
	  					<div class="col-md-2">
						    <div class="form-group">
								<label for="txt_codinsumo<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codinsumo<?php echo $NumWindow; ?>" id="txt_codinsumo<?php echo $NumWindow; ?>" type="text"  onblur="CodInsumosOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codinsumo<?php echo $NumWindow; ?>', '(Codigo_CFC=*09*!or!Codigo_CFC=*12*!or!Codigo_CFC=*13*)!and!Estado_ser=*1*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<label for="txt_nombreserv<?php echo $NumWindow; ?>">Insumo / Medicamento</label>
								<input  name="txt_nombreserv<?php echo $NumWindow; ?>" id="txt_nombreserv<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_cantinsumo<?php echo $NumWindow; ?>">Cantidad</label>
								<div class="input-group">	
									<input  name="txt_cantinsumo<?php echo $NumWindow; ?>" id="txt_cantinsumo<?php echo $NumWindow; ?>" type="number" value="1" min="1" max="100"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddInsumo<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleins<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleins<?php echo $NumWindow; ?>" >
								<tbody id="tbins<?php echo $NumWindow; ?>">
								<tr id="trhinsX'.$NumWindow.'"> 
									<th id="th1insX'.$NumWindow.'">Codigo</th> 
									<th id="th2insX'.$NumWindow.'">Producto</th> 
									<th id="th3insX'.$NumWindow.'">Cantidad</th> 
									<th id="th4insX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwins<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwins<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>
	  			</div>

	  		</div>
	  	</div>