
<div role="tabpanel" class="tab-pane fade " id="hc_framingham<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divfrag<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Test de Framingham</label>
	  				<div class="row well well-sm">
	  					<div class="col-sm-12">
	  					  <div class="table-responsive ">
					        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblfrgl<?php echo $row[0].$NumWindow; ?>" >
							  <tbody id="tbDetIRFx<?php echo $row[0].$NumWindow; ?>">
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Sexo</td>
								<td>
								  <select name="cmb_sexofr<?php echo $NumWindow; ?>" id="cmb_sexofr<?php echo $NumWindow; ?>" class="input-sm" onchange="calcframingham<?php echo $NumWindow; ?>();">	
								    <option value="M">Masculino</option>
								    <option value="F">Femenino</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;">Edad</td>
								<td>
                                <input name="txt_edadfr<?php echo $NumWindow; ?>" type="number" id="txt_edadfr<?php echo $NumWindow; ?>" value="" onchange="calcframingham<?php echo $NumWindow; ?>();"/>
								</td>
								<td align="right" style="vertical-align: middle;">TA Sistólica</td>
								<td>
                                <input name="txt_tsafr<?php echo $NumWindow; ?>" type="number" id="txt_tsafr<?php echo $NumWindow; ?>" value="" onchange="calcframingham<?php echo $NumWindow; ?>();"/>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Colesterol Total</td>
								<td>
                                <input name="txt_totcfr<?php echo $NumWindow; ?>" type="number" id="txt_totcfr<?php echo $NumWindow; ?>" value="" onchange="calcframingham<?php echo $NumWindow; ?>();"/>
								</td>
								<td align="right" style="vertical-align: middle;">Colesterol HDL</td>
								<td>
                                <input name="txt_hdlfr<?php echo $NumWindow; ?>" type="number" id="txt_hdlfr<?php echo $NumWindow; ?>" value="" onchange="calcframingham<?php echo $NumWindow; ?>();"/>
								</td>
								<td align="right" style="vertical-align: middle;">Tto. Medicación para hipertensión</td>
								<td>
								  <select name="cmb_medicfr<?php echo $NumWindow; ?>" id="cmb_medicfr<?php echo $NumWindow; ?>" class="input-sm" onchange="calcframingham<?php echo $NumWindow; ?>();">	
								    <option value="1">SI</option>
                                    <option value="0">NO</option>
								  </select>
								</td>
							  </tr>
							  <tr>
							  	<td align="right" style="vertical-align: middle;">Fumador</td>
								<td>
								  <select name="cmb_fumafr<?php echo $NumWindow; ?>" id="cmb_fumafr<?php echo $NumWindow; ?>" class="input-sm" onchange="calcframingham<?php echo $NumWindow; ?>();">	
								    <option value="0">NO</option>
								    <option value="1">SI</option>
								  </select>
								</td>
								<td align="right" style="vertical-align: middle;"></td>
								<td>
								  
								</td>
								<td align="right" style="vertical-align: middle;"></td>
								<td>
								  
								</td>
							  </tr>
							  <tr>
                                <td align="right" style="vertical-align: middle;"></td>
								<td>
                                </td>
                                <td align="right" style="vertical-align: middle;">Puntos</td>
								<td >
								<input type="text" name="txt_puntosfr<?php echo $NumWindow; ?>" id="txt_puntosfr<?php echo $NumWindow; ?>" disabled="disabled">
								</td>
                                <td align="right" style="vertical-align: middle;">Porcentaje de Riesgo</td>
								<td >
								<input type="text" name="txt_porcfr<?php echo $NumWindow; ?>" id="txt_porcfr<?php echo $NumWindow; ?>" disabled="disabled">
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
