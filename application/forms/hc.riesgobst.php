
<div role="tabpanel" class="tab-pane fade " id="hc_riesgobst<?php echo $NumWindow; ?>">
  					<div class="row">
  				
	  		<div id="divembactual<?php echo $NumWindow; ?>" class="col-md-12">
  				<label class="label label-success"> Calificación del Riesgo Obstétrico</label>
  				<div class="row well well-sm">
  					<div class="col-sm-4">
  					  <div class="table-responsive ">
				        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblembactual<?php echo $row[0].$NumWindow; ?>" >
						  <tbody >
						  <tr>
						  	<th colspan="2">I. Historia reproductiva</th>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Edad </td>
							  <td>
							    <select name="cmb_obtEdad<?php echo $NumWindow; ?>" id="cmb_obtEdad<?php echo $NumWindow; ?>" class="input-sm" >	
							  	  <option value="< 16" <?php if($EdadPcte<16) { echo 'selected';} ?> >< 16</option>
							  	  <option value="16-35" <?php if($EdadPcte>=16) { if($EdadPcte<35) { echo 'selected';}} ?> >16 - 35</option>
							  	  <option value="> 35" <?php if($EdadPcte>=35) { echo 'selected';} ?> > 35</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Paridad</td>
							  <td>
							    <select name="cmb_obtParidad<?php echo $NumWindow; ?>" id="cmb_embParidad<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">0</option>
							  	  <option value="1">1 - 4</option>
							  	  <option value="2">>= 5</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Aborto habitual / infertilidad</td>
							  <td>
							    <select name="cmb_obtAborto<?php echo $NumWindow; ?>" id="cmb_obtAborto<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Retención placentaria</td>
							  <td>
							    <select name="cmb_obtRetPlac<?php echo $NumWindow; ?>" id="cmb_obtRetPlac<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr><tr>
						  	<td align="right" style="vertical-align: middle;">Recién nacido > 4000 gr</td>
							  <td>
							    <select name="cmb_obtRnmayor<?php echo $NumWindow; ?>" id="cmb_obtRnmayor<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Recién nacido < 2500 gr</td>
							  <td>
							    <select name="cmb_obtRnmenor<?php echo $NumWindow; ?>" id="cmb_obtRnmenor<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">HTA inducida por embarazo</td>
							  <td>
							    <select name="cmb_obtHTA<?php echo $NumWindow; ?>" id="cmb_obtHTA<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Embarazo gemelar</td>
							  <td>
							    <select name="cmb_obtGemelar<?php echo $NumWindow; ?>" id="cmb_obtGemelar<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Cesárea previa</td>
							  <td>
							    <select name="cmb_obtCesprev<?php echo $NumWindow; ?>" id="cmb_obtCesprev<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">Mortinato / muerte neonatal</td>
							  <td>
							    <select name="cmb_obtMuerteneo<?php echo $NumWindow; ?>" id="cmb_obtMuerteneo<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="right" style="vertical-align: middle;">T.P. prolongado / parto difícil</td>
							  <td>
							    <select name="cmb_obtPdificil<?php echo $NumWindow; ?>" id="cmb_obtPdificil<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="0">NO</option>
							  	  <option value="1">SI</option>
								</select>
							  </td>
						  </tr>
						  <tr>
						  	<td align="left" style="vertical-align: middle;" colspan="2">Observaciones</td>
						  </tr>
						  <tr>
						  	<td colspan="2">
						  	  <textarea rows="2" id="txt_obtNotas<?php echo $NumWindow; ?>" name="txt_obtNotas<?php echo $NumWindow; ?>" maxlength="5000" required=""></textarea>
						  	</td>
						  </tr>
						  </tbody>
						</table>
					  </div>
  					</div>
  					<div class="col-sm-4">
  					  <div class="table-responsive ">
				        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered"  >
						  <tbody>
						  <tr>
						  	<th >II. Condiciones Asociadas</th>
						  	<th >1T</th><th >2T</th><th >3T</th>
						  </tr>
						  <tr>
						  	<td align="center" style="vertical-align: middle; font-weight: bold;" colspan="4">Condiciones médicas</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Qx. ginecológica previa / ectópico</td>
						    <td>
							  <?php nxs_chk('obtC011', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC012', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC013', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Enf. renal crónica</td>
						    <td>
							  <?php nxs_chk('obtC021', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC022', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC023', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Diabetes gestacional</td>
						    <td>
							  <?php nxs_chk('obtC031', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC032', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC033', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Diabetes mellitus</td>
						    <td>
							  <?php nxs_chk('obtC041', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC042', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC043', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Enf. cardíaca</td>
						    <td>
							  <?php nxs_chk('obtC051', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC052', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC053', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Enf. infecciosa aguda (bectariana)</td>
						    <td>
							  <?php nxs_chk('obtC061', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC062', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC063', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Enf. autoinmune</td>
						    <td>
							  <?php nxs_chk('obtC071', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC072', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC073', $NumWindow); ?>
							</td>
						  </tr><tr>
						    <td align="left" style="vertical-align: middle;" >Anemia (Hb < 10 g/L)</td>
						    <td>
							  <?php nxs_chk('obtC081', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC082', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC083', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						  	<td align="center" style="vertical-align: middle; font-weight: bold;" colspan="4">Escala riesgo sicosocial [Herrera y Hurtado]</td>
						  </tr>
						    <td align="left" style="vertical-align: middle;" >Tensión emocional intensa</td>
						    <td>
							  <?php nxs_chk('obtC091', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC092', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC093', $NumWindow); ?>
							</td>
						  </tr>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Humor depresivo intenso</td>
						    <td>
							  <?php nxs_chk('obtC101', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC102', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC103', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Síntomas neurovegetativos intensos</td>
						    <td>
							  <?php nxs_chk('obtC111', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC112', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC113', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Sin soporte familiar (tiempo)</td>
						    <td>
							  <?php nxs_chk('obtC121', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC122', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC123', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Sin soporte familiar (espacio)</td>
						    <td>
							  <?php nxs_chk('obtC131', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC132', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC133', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Sin soporte familiar (dinero)</td>
						    <td>
							  <?php nxs_chk('obtC141', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC142', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtC143', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						  	<td align="center" style="vertical-align: middle; font-weight: bold;" colspan="4">Violencia Doméstica</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO ha sido humillada, menospreciada, insultada o amenzada por su pareja?</td>
						    <td>
							  <?php nxs_chk('obtC144', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO fue golpeada, bofeteada, pateada o lastimada físicamente de otra manera?</td>
						    <td>
							  <?php nxs_chk('obtC145', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DESDE QUE ESTA EN GESTION ha sido golpeada, bofeteada, pateada o lastimada físicamente de otra manera?</td>
						    <td>
							  <?php nxs_chk('obtC146', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO fue forzada a tener relaciones sexuales?</td>
						    <td>
							  <?php nxs_chk('obtC147', $NumWindow); ?>
							</td>
						  </tr>
						  <!-- <tr>
						    <td align="center" style="vertical-align: middle; font-weight: bold;" colspan="4">Depresión y Ansiedad</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO ha sido humillada, menospreciada, insultada o amenzada por su pareja?</td>
						    <td>
							  <?php nxs_chk('obtC144', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO ha sido humillada, menospreciada, insultada o amenzada por su pareja?</td>
						    <td>
							  <?php nxs_chk('obtC144', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" colspan="3">¿DURANTE EL ULTIMO AÑO ha sido humillada, menospreciada, insultada o amenzada por su pareja?</td>
						    <td>
							  <?php nxs_chk('obtC144', $NumWindow); ?>
							</td>
						  </tr> -->
						  
						  </tbody>
						</table>
					  </div>
  					</div>
  					<div class="col-sm-4">
  					  <div class="table-responsive ">
				        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblembactual<?php echo $row[0].$NumWindow; ?>" >
						  <tbody id="tbDetIREx<?php echo $row[0].$NumWindow; ?>">
						  <tr>
						  	<th >III. Embarazo actual</th><th >1T</th><th >2T</th><th >3T</th>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Hemorragia <= 20 Sem</td>
						    <td>
							  <?php nxs_chk('obtE011', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE012', $NumWindow); ?>
							</td>
							<td>
							  <input type="hidden" name="hdn_obtE013<?php echo $NumWindow; ?>" id="hdn_obtE013<?php echo $NumWindow; ?>" value="0">
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Hemorragia > 20 Sem</td>
							<td>
							  <input type="hidden" name="hdn_obtE021<?php echo $NumWindow; ?>" id="hdn_obtE021<?php echo $NumWindow; ?>" value="0">
							</td>
						    <td>
							  <?php nxs_chk('obtE022', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE023', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >E. prolongado (42 Sem)</td>
							<td>
							  <input type="hidden" name="hdn_obtE031<?php echo $NumWindow; ?>" id="hdn_obtE031<?php echo $NumWindow; ?>" value="0">
							</td>
						    <td>
						      <input type="hidden" name="hdn_obtE032<?php echo $NumWindow; ?>" id="hdn_obtE032<?php echo $NumWindow; ?>" value="0">
							</td>
							<td>
							  <?php nxs_chk('obtE033', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >HTA inducida por embarazo</td>
							<td>
							  <?php nxs_chk('obtE041', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE042', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE043', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >RPM</td>
							<td>
							  <?php nxs_chk('obtE051', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE052', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE053', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Polihidramnios</td>
							<td>
							  <?php nxs_chk('obtE061', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE062', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE063', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >RCIU</td>
							<td>
							  <?php nxs_chk('obtE071', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE072', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE073', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Emb múltiple</td>
							<td>
							  <?php nxs_chk('obtE081', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE082', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE083', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Mala presentación</td>
							<td>
							  <?php nxs_chk('obtE091', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE092', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE093', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Isoinmunizacion RH</td>
							<td>
							  <?php nxs_chk('obtE101', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE102', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE103', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Infección de vías urinarias</td>
							<td>
							  <?php nxs_chk('obtE111', $NumWindow); ?>
							</td>
						    <td>
							  <?php nxs_chk('obtE112', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE113', $NumWindow); ?>
							</td>
						  </tr>
						  <tr>
						    <td align="left" style="vertical-align: middle;" >Amenaza de parto prematuro</td>
							<td>
							  <input type="hidden" name="hdn_obtE121<?php echo $NumWindow; ?>" id="hdn_obtE121<?php echo $NumWindow; ?>" value="0">
							</td>
						    <td>
							  <?php nxs_chk('obtE122', $NumWindow); ?>
							</td>
							<td>
							  <?php nxs_chk('obtE123', $NumWindow); ?>
							</td>
						  </tr>
						  </tbody>
						</table>
					  </div>
  					</div>

  				</div>
  				<label class="label label-success"> Puntaje de riesgo obstétrico</label>
  				<div class="row well well-sm">
  					<div class="col-sm-12">
  					  <div class="table-responsive ">
				        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblsasa<?php echo $row[0].$NumWindow; ?>" >
						  <tbody id="tbDetptjx<?php echo $row[0].$NumWindow; ?>">
						    <tr>
						  	  <th colspan="4">Semanas 0 - 13</th>
						  	  <th colspan="4">Semanas 14 - 27</th>
						  	  <th colspan="4">Semanas 28 - 38/40</th>
						    </tr>
						    <tr>
						      <td align="right" style="vertical-align: middle;">Total</td>
						      <td><input type="number" name="txt_obtPunt1T<?php echo $NumWindow; ?>" id="txt_obtPunt1T<?php echo $NumWindow; ?>" min="0" max="200" value="0"></td>
						      <td align="right" style="vertical-align: middle;">Riesgo</td>
						      <td>
						        <select name="cmb_obtRiesgo1T<?php echo $NumWindow; ?>" id="cmb_obtRiesgo1T<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="B">BAJO</option>
							  	  <option value="A">ALTO</option>
								</select>
							  </td>
						      <td align="right" style="vertical-align: middle;">Total</td>
						      <td><input type="number" name="txt_obtPunt2T<?php echo $NumWindow; ?>" id="txt_obtPunt2T<?php echo $NumWindow; ?>" min="0" max="200" value="0"></td>
						      <td align="right" style="vertical-align: middle;">Riesgo</td>
						      <td>
						        <select name="cmb_obtRiesgo2T<?php echo $NumWindow; ?>" id="cmb_obtRiesgo2T<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="B">BAJO</option>
							  	  <option value="A">ALTO</option>
								</select>
							  </td>
						      <td align="right" style="vertical-align: middle;">Total</td>
						      <td><input type="number" name="txt_obtPunt3T<?php echo $NumWindow; ?>" id="txt_obtPunt3T<?php echo $NumWindow; ?>" min="0" max="200" value="0"></td>
						      <td align="right" style="vertical-align: middle;">Riesgo</td>
						      <td>
						        <select name="cmb_obtRiesgo3T<?php echo $NumWindow; ?>" id="cmb_obtRiesgo3T<?php echo $NumWindow; ?>" class="input-sm">	
							  	  <option value="B">BAJO</option>
							  	  <option value="A">ALTO</option>
								</select>
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
<script type="text/javascript">
 <?php
   $SQL="SELECT * FROM hcriegoobs a, czterceros b WHERE a.Codigo_TER=b.Codigo_TER AND id_ter='".$_GET["Historia"]."' ORDER BY codigo_hcf DESC LIMIT 1;";
   $result = mysqli_query($conexion, $SQL);
   $SexoPcte="";
   $EdadPcte="";
   if($row = mysqli_fetch_array($result)) {
	 $SexoPcte=$row[3];
	 $EdadPcte= $row[2];
   }
   mysqli_free_result($result); 
 ?>	
</script>