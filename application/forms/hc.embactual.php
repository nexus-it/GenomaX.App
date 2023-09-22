
<div role="tabpanel" class="tab-pane fade " id="hc_embactual<?php echo $NumWindow; ?>">
			<div class="row">
		
	<div id="divembactual<?php echo $NumWindow; ?>" class="col-md-12">
		<label class="label label-success"> Embarazo Actual</label>
		<div class="row well well-sm">
			<div class="col-sm-12">
			  <div class="table-responsive ">
	        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblembactual<?php echo $row[0].$NumWindow; ?>" >
			  <tbody id="tbDetIREx<?php echo $row[0].$NumWindow; ?>">
			  	<tr>
			  	  <th colspan="6"> </th>
			  	</tr>
			  	<tr>
			      <td align="right" style="vertical-align: middle;">Embarazado Planeado</td>
			      <td> 
			      	<?php nxs_chk('embPlaneado', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Fracaso de método anticonceptivo</td>
				  <td>
				  	<select name="cmb_embMetantc<?php echo $NumWindow; ?>" id="cmb_embMetantc<?php echo $NumWindow; ?>" class="input-sm">	
				  	  <option value="NO">NO</option>
				  	  <option value="Píldora anticonceptiva">Píldora anticonceptiva</option>
				  	  <option value="Sistema intrauterino">Sistema intrauterino</option>
				  	  <option value="Condón masculino">Condón masculino</option>
				  	  <option value="Parche anticonceptivo">Parche anticonceptivo</option>
				  	  <option value="Anillo anticonceptivo">Anillo anticonceptivo</option>
				  	  <option value="Implante anticonceptivo">Implante anticonceptivo</option>
				  	  <option value="Inyección anticonceptiva">Inyección anticonceptiva</option>
				  	  <option value="Dispositivo intrauterino- DIU">Dispositivo intrauterino- DIU</option>
				  	  <option value="Condón femenino">Condón femenino</option>
				  	  <option value="Diafragma">Diafragma</option>
				  	  <option value="Capuchón cervical">Capuchón cervical</option>
				  	  <option value="Esponja">Esponja</option>
				  	  <option value="Espermicidas">Espermicidas</option>
				  	  <option value="Esterilización">Esterilización</option>
				  	  <option value="Anticonceptivos de emergencia">Anticonceptivos de emergencia</option>
					</select>
				  </td>
				  <td align="right" style="vertical-align: middle;">Embarazo múltiple</td>
				  <td>
				    <?php nxs_chk('embMultiple', $NumWindow); ?>
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Peso Previo</td>
			      <td> 
			      	<div class="input-group">
					  <input type="number" name="txt_embPesoprev<?php echo $NumWindow; ?>" id="txt_embPesoprev<?php echo $NumWindow; ?>" min="5" max="200" value="0">
					  <div class="input-group-addon">Kg</div>
					</div>
				  </td>
				  <td align="right" style="vertical-align: middle;">Talla</td>
			      <td> 
			      	<div class="input-group">
					  <input type="number" name="txt_embTalla<?php echo $NumWindow; ?>" id="txt_embTalla<?php echo $NumWindow; ?>" min="5" max="250" value="0">
					  <div class="input-group-addon">cms</div>
					</div>
				  </td>
				  <td align="right" style="vertical-align: middle;">I.M.C.</td>
			      <td> 
			      	<input type="number" name="txt_embIMC<?php echo $NumWindow; ?>" id="txt_embIMC<?php echo $NumWindow; ?>" value="0">
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Fecha Última Menstruación</td>
			      <td> 
			      	<input type="date" name="txt_embFUR<?php echo $NumWindow; ?>" id="txt_embFUR<?php echo $NumWindow; ?>" >
				  </td>
				  <td align="right" style="vertical-align: middle;">Dudas</td>
				  <td>
				    <select name="cmb_embDudas<?php echo $NumWindow; ?>" id="cmb_embDudas<?php echo $NumWindow; ?>" class="input-sm">	
				  	  <option value="0">NO</option>
				  	  <option value="1">SI</option>
					</select>
				  </td>
				  <td align="right" style="vertical-align: middle;">Fecha Probable de Parto</td>
			      <td> 
			      	<input type="date" name="txt_embFPP<?php echo $NumWindow; ?>" id="txt_embFPP<?php echo $NumWindow; ?>" value="00/00/0000">
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Antitetánica Previa</td>
				  <td>
				    <?php nxs_chk('embAntitetan', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Fecha </td>
			      <td> 
			      	<input type="date" name="txt_embFAntitetan<?php echo $NumWindow; ?>" id="txt_embFAntitetan<?php echo $NumWindow; ?>" >
				  </td>
				  <td align="right" style="vertical-align: middle;">Periodo Intergenésico menor 12 Meses</td>
				  <td>
				    <?php nxs_chk('embIntergen', $NumWindow); ?>
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Grupo Sanguíneo</td>
				  <td>
				    <select name="cmb_embGsangre<?php echo $NumWindow; ?>" id="cmb_embGsangre<?php echo $NumWindow; ?>" class="input-sm">	
				  	  <option value="A">A</option>
				  	  <option value="B">B</option>
				  	  <option value="AB">AB</option>
				  	  <option value="O">O</option>
					</select>
				  </td>
				  <td align="right" style="vertical-align: middle;">Factor Rh</td>
				  <td>
				    <select name="cmb_embRH<?php echo $NumWindow; ?>" id="cmb_embRH<?php echo $NumWindow; ?>" class="input-sm">	
				  	  <option value="+">POSITIVO</option>
				  	  <option value="-">NEGATIVO</option>
					</select>
				  </td>
				  <td align="right" style="vertical-align: middle;">Sensiblización RH</td>
				  <td>
				    <?php nxs_chk('embRHSensible', $NumWindow); ?>
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Consejería Pre-Test VIH</td>
				  <td>
				    <?php nxs_chk('embPreVIH', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Consejería en Lactancia Materna</td>
				  <td>
				    <?php nxs_chk('embLacmat', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Edad Gestacional Confirmada por</td>
				  <td>
				    <select name="cmb_embEdadgest<?php echo $NumWindow; ?>" id="cmb_embEdadgest<?php echo $NumWindow; ?>" class="input-sm">	
				  	  <option value="Ecografía">Ecografía</option>
				  	  <option value="FUM">FUM</option>
					</select>
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Número de Gestación</td>
			      <td> 
			      	<input type="number" name="txt_embNumgest<?php echo $NumWindow; ?>" id="txt_embNumgest<?php echo $NumWindow; ?>" min="1" max="15" value="1">
				  </td>
				  <td align="right" style="vertical-align: middle;">Fuma</td>
				  <td>
				    <?php nxs_chk('embFuma', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Cigarrillos Día</td>
			      <td> 
			      	<input type="number" name="txt_embCigarr<?php echo $NumWindow; ?>" id="txt_embCigarr<?php echo $NumWindow; ?>" min="0" max="50" value="0">
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Fumadora Pasiva</td>
				  <td>
				    <?php nxs_chk('embFumpas', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Alcohol</td>
				  <td>
				    <?php nxs_chk('embAlcohol', $NumWindow); ?>
				  </td>
				  <td align="right" style="vertical-align: middle;">Drogas</td>
				  <td>
				    <?php nxs_chk('embDrogas', $NumWindow); ?>
				  </td>
			  	</tr>
			  	<tr>
			  	  <td align="right" style="vertical-align: middle;">Observaciones</td>
			  	  <td colspan="5">
			  	  	<textarea rows="2" id="txt_embNotas<?php echo $NumWindow; ?>" name="txt_embNotas<?php echo $NumWindow; ?>" maxlength="5000" ></textarea>
			  	  </td> 
			  	</tr>
			  </tbody>
			</table>
		  </div>
			</div>

		</div>
	</div>

			</div>
	</div>