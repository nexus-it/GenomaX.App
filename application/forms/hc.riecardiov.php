
<div role="tabpanel" class="tab-pane fade " id="hc_riesgocardv<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divembactual<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Factores de Riesgo Cardiovascular</label>
	  				<div class="row well well-sm">
	  					<div class="col-sm-12">
	  					  <div class="table-responsive ">
					        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblrcv<?php echo $row[0].$NumWindow; ?>" >
							  <tbody id="tbDetrcvEx<?php echo $row[0].$NumWindow; ?>">
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Tabaquismo</td>
								<td>
								  <select name="cmb_rcvTabaquismo<?php echo $NumWindow; ?>" id="cmb_rcvTabaquismo<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Alcohol</td>
								<td>
								  <select name="cmb_rcvAlcohol<?php echo $NumWindow; ?>" id="cmb_rcvAlcohol<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Obesidad</td>
								<td>
								  <select name="cmb_rcvObesidad<?php echo $NumWindow; ?>" id="cmb_rcvObesidad<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Sedentarismo</td>
								<td>
								  <select name="cmb_rcvSedentarismo<?php echo $NumWindow; ?>" id="cmb_rcvSedentarismo<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Estress</td>
								<td>
								  <select name="cmb_rcvEstress<?php echo $NumWindow; ?>" id="cmb_rcvEstress<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Consumo de sal</td>
								<td>
								  <select name="cmb_rcvConsumosal<?php echo $NumWindow; ?>" id="cmb_rcvConsumosal<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Consumo de grasa</td>
								<td>
								  <select name="cmb_rcvConsumograsa<?php echo $NumWindow; ?>" id="cmb_rcvConsumograsa<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Sobrepeso</td>
								<td>
								  <select name="cmb_rcvSobrepeso<?php echo $NumWindow; ?>" id="cmb_rcvSobrepeso<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Dislipidemia</td>
								<td>
								  <select name="cmb_rcvDislipidemia<?php echo $NumWindow; ?>" id="cmb_rcvDislipidemia<?php echo $NumWindow; ?>" class="input-sm">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Observaciones</td>
								<td colspan="5">
								<input type="text" name="txt_rcvObservaciones<?php echo $NumWindow; ?>" id="txt_rcvObservaciones<?php echo $NumWindow; ?>" >
								</td>
							  </tr>
							  </tbody>
							</table>
							<hr width="95%">
						  </div>
	  					</div>
	  				</div>
	  			</div>

	  			<div id="divtfg<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Filtrado Glomerular</label>
	  				<div class="row well well-sm">
	  					<div class="col-sm-12">
	  					  <div class="table-responsive ">


	  					  	<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbltfg<?php echo $row[0].$NumWindow; ?>" >
							  <tbody id="tbDettfgxs<?php echo $row[0].$NumWindow; ?>">
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Sexo</td>
								<td>
								  <select name="cmb_sexotfg<?php echo $NumWindow; ?>" id="cmb_sexotfg<?php echo $NumWindow; ?>" class="input-sm" >	
								    <option value="M">Masculino</option>
								    <option value="F">Femenino</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Edad</td>
								<td>
                                <input name="txt_edadtfg<?php echo $NumWindow; ?>" type="number" id="txt_edadtfg<?php echo $NumWindow; ?>" value="" />
								</td>
								<td align="right" style="vertical-align: middle;">Creatinina</td>
								<td>
                                <input name="txt_cretininatfg<?php echo $NumWindow; ?>" type="text" id="txt_cretininatfg<?php echo $NumWindow; ?>" value="" />
								</td>
								</td>
								<td align="right" style="vertical-align: middle;">Afroamericano?</td>
								<td>
                                <td>
								  <?php nxs_chk('razatfg', $NumWindow); ?>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;" colspan="2">Filtrado Glomerular</td>
							  	<td colspan="2">
                                <input name="txt_tfgtfg<?php echo $NumWindow; ?>" type="text" id="txt_tfgtfg<?php echo $NumWindow; ?>" value="" />
								</td>
								<td align="right" style="vertical-align: middle;" colspan="2">Valoración</td>
							  	<td colspan="2">
                                <input name="txt_valoraciontfg<?php echo $NumWindow; ?>" type="text" id="txt_valoraciontfg<?php echo $NumWindow; ?>" value="" />
								</td>
							  </tr>
							  </tbody>
							</table>
	  					  <hr width="95%">
						  </div>
	  					</div>
	  				</div>
	  			</div>

	  					</div>
	  			</div>