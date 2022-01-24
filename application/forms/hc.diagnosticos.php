
<div role="tabpanel" class="tab-pane fade " id="hc_diagnosticos<?php echo $NumWindow; ?>">
			<div class="row">
<?php		
  					echo '
	  					<div class="col-md-12">
	  						<label class="label label-success"> Diagnóstico</label>
							<div class="row well well-sm">

						<div class="col-md-3 col-sm-3">
							<div class="form-group" id="grp_cmb_estado'.$NumWindow.'">
								<label for="cmb_tipodx'.$NumWindow.'">Tipo Dx</label>
								<select name="cmb_tipodx'.$NumWindow.'" id="cmb_estado'.$NumWindow.'">
								  <option value="1">1 - IMPRESION DIAGNOSTICA</option>
								  <option value="2">2 - CONFIRMADO NUEVO</option>
								  <option value="3">3 - CONFIRMADO REPETIDO</option>
								</select>
							</div>
					
						</div>
						<div class="col-md-2 col-sm-2">

							<div class="form-group" id="grp_txt_dxppal'.$NumWindow.'">
								<label for="txt_dxppal'.$NumWindow.'">Dx Ppal</label>
								<div class="input-group">	
									<input name="txt_dxppal'.$NumWindow.'" id="txt_dxppal'.$NumWindow.'" type="text" required onblur="HCDxOnBlur'.$NumWindow.'();"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxppal'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>

						</div>
						<div class="col-md-6 col-sm-6">

							<div class="form-group">
								<label for="txt_dxppal1'.$NumWindow.'">Nombre Diagnóstico Principal</label>
								<input name="txt_dxppal1'.$NumWindow.'" id="txt_dxppal1'.$NumWindow.'" type="text" disabled="disabled" />
							</div>
						
						</div>
						<div class="col-md-1 col-sm-1">

							<div class="form-group">
								<label for="txt_modelo'.$NumWindow.'">Más Dx</label>
								<button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#div_diagnosticos'.$NumWindow.'" aria-expanded="false" aria-controls="collapseExample">
		  							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							</div>
						
						</div>
						<div class="collapse col-md-12" id="div_diagnosticos'.$NumWindow.'">
						  <div class="row">

						<div class="col-md-8 col-sm-8">
							<div class="row">
								 <div class="col-md-3 col-sm-3">
								 	<div class="form-group">
										<label for="txt_dxrel1'.$NumWindow.'">Dx Rel</label>
										<div class="input-group">	
											<input name="txt_dxrel1'.$NumWindow.'" id="txt_dxrel1'.$NumWindow.'" type="text" onblur="HCDxR1OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel1'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9 col-sm-9">
								 	<div class="form-group">
										<label for="txt_dxrel11'.$NumWindow.'">Diagnóstico Relacionado</label>
										<input name="txt_dxrel11'.$NumWindow.'" id="txt_dxrel11'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3 col-sm-3">
								 	<div class="form-group">
										<label for="txt_dxrel2'.$NumWindow.'">Dx Rel2</label>
										<div class="input-group">	
											<input name="txt_dxrel2'.$NumWindow.'" id="txt_dxrel2'.$NumWindow.'" type="text" onblur="HCDxR2OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel2'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9 col-sm-9">
								 	<div class="form-group">
										<label for="txt_dxrel22'.$NumWindow.'">Diagnóstico Relacionado 2</label>
										<input name="txt_dxrel22'.$NumWindow.'" id="txt_dxrel22'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3 col-sm-3">
								 	<div class="form-group">
										<label for="txt_dxrel3'.$NumWindow.'">Dx Rel3</label>
										<div class="input-group">	
											<input name="txt_dxrel3'.$NumWindow.'" id="txt_dxrel3'.$NumWindow.'" type="text" onblur="HCDxR3OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel3'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9 col-sm-9">
								 	<div class="form-group">
										<label for="txt_dxrel33'.$NumWindow.'">Diagnóstico Relacionado 3</label>
										<input name="txt_dxrel33'.$NumWindow.'" id="txt_dxrel33'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">

							<div class="form-group">
								<label for="txt_dxmanejo'.$NumWindow.'">Diagnóstico de manejo</label>
								<textarea class="form-control" rows="9" id="txt_dxmanejo'.$NumWindow.'"></textarea>
							</div>
						
						</div>


						  </div>
						</div>

							</div>
						</div>';
?>
			</div>
	</div>