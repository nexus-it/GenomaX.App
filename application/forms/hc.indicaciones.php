
<div role="tabpanel" class="tab-pane fade " id="hc_indicaciones<?php echo $NumWindow; ?>">
  				<div class="row">
			
						<ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#tbind1<?php echo $NumWindow; ?>" aria-controls="tbind1<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Histórico de Indicaciones</a></li>
				    <li role="presentation"><a href="#tbind2<?php echo $NumWindow; ?>" aria-controls="tbind2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Nueva Indicación Médica</a></li>
				  </ul>
				
  		<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
  			<div id="tbind1<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
					<div class="col-md-12 panel-group" id="HistMedicIndM<?php echo $NumWindow; ?>" role="tablist" aria-multiselectable="true">
						<?php
						$SQL="SELECT distinct 'Codigo_HTT', b.Fecha_HCF, d.Nombre_ARE , concat(c.Nombre1_MED, ' ', LEFT(c.Nombre2_MED,1), ' ', c.Apellido1_MED, ' ', LEFT(c.Apellido2_MED,1) ), b.Codigo_HCF, b.Codigo_TER FROM hctratamiento a, hcfolios b, gxmedicos c, gxareas d, czterceros m WHERE a.Codigo_TER =b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND c.Codigo_USR=b.Codigo_USR AND d.Codigo_ARE=b.Codigo_ARE AND a.Codigo_TER=m.Codigo_TER and ID_TER='".$_GET["Historia"]."' Order By 2 desc; ";
						$result = mysqli_query($conexion, $SQL);
						$kifilas="0";
					while($row = mysqli_fetch_array($result)) {
						?>
						<div class="panel panel-success">
					    <div class="panel-heading" role="tab" id="hdng<?php echo $row[4].$row[5].$NumWindow; ?>" style="background-color: #efefef75;">
					      <h4 class="panel-title">
					        <a role="button" data-toggle="collapse" data-parent="#HistMedicIndM<?php echo $NumWindow; ?>" href="#IndM<?php echo $row[4].$row[5].$NumWindow; ?>" aria-expanded="<?php if($kifilas==0) { echo 'true'; } else { echo 'false';} ?>" aria-controls="collapseOne" style="color: #668e33;">
					          <?php echo 'Fecha: <strong>'.$row[1].'</strong> Area: <strong>'.$row[2].'</strong> Profesional: <strong>'.$row[3].'</strong>'; ?>
					        </a>
					      </h4>
					    </div>
					    <div id="IndM<?php echo $row[4].$row[5].$NumWindow; ?>" class="panel-collapse collapse <?php if($kifilas==0) { echo 'in'; } else { echo '';} ?>" role="tabpanel" aria-labelledby="hdng<?php echo $row[4].$row[5].$NumWindow; ?>">
					      <div class="panel-body table-responsive hcorden">
					        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $row[4].$row[5].$NumWindow; ?>" >
							<tbody id="tbfmdx<?php echo $row[4].$row[5].$NumWindow; ?>">
							<tr id="trhfmX<?php echo $row[4].$row[5].$NumWindow; ?>"> 
								<th id="th1fmX<?php echo $row[4].$row[5].$NumWindow; ?>">Indicación</th> 
							</tr> 
							<?php
							$SQL="SELECT m.Codigo_HTT, m.Indicacion_HTT FROM hctratamiento m WHERE m.Codigo_TER='".$row[5]."' AND m.Codigo_HCF='".$row[4]."' Order By 1";
							$resmed = mysqli_query($conexion, $SQL);
							$konrwind=0;
							while($rowmd = mysqli_fetch_array($resmed)) {
								$konrwind++;
							?>
							<tr id="trfmed<?php echo $konrwmd.$row[0].$NumWindow; ?>">
								<td><?php echo $rowmd[1]; ?></td>
							</tr>
							<?php
							}
							mysqli_free_result($resmed);
							?>
							</tbody>
							</table><input name="hdn_controwindc<?php echo $row[4].$row[5].$NumWindow; ?>" type="hidden" id="hdn_controwindc<?php echo $row[4].$row[5].$NumWindow; ?>" value="<?php echo $konrwmd; ?>" />
					      </div>
					    </div>
					  </div>
				  <?php
				  $kifilas++;
					}
					mysqli_free_result($result);
				  ?>
					</div>
				</div>
  			<div id="tbind2<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">

				<div class="col-md-12">
				    <div class="input-group">
				      <input type="text" class="form-control" placeholder="Digite la indicación y agréguela al listado" maxlength="200" id="txt_indicaciones<?php echo $NumWindow; ?>" name="txt_indicaciones<?php echo $NumWindow; ?>" onkeypress="ClickTabla<?php echo $NumWindow; ?>(event);">
				      <span class="input-group-btn">
				        <button class="btn btn-success" type="button" onclick="AgregarFilaTto<?php echo $NumWindow; ?>(document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value);">Agregar</button>
				      </span>
				    </div><!-- /input-group -->
				  </div>
				  <div class="col-md-12">
				  	<div id="zero_detalleTto<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
						<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleTto<?php echo $NumWindow; ?>" >
						<tbody id="tbTtmntoX<?php echo $NumWindow; ?>">
						<tr id="trhtX'.$NumWindow.'"> 
							<th id="th1tX'.$NumWindow.'">Indicación</th> 
							<th id="th2tX'.$NumWindow.'">X</th> 
						</tr> 

						</tbody>
						</table><input name="hdn_controwTto<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwTto<?php echo $NumWindow; ?>" value="0" />
					</div>
				  </div>
				  <div class="col-md-12">
				  	<div class="row well well-sm">
				  		<label>Análisis y Tratamiento</label>
				  		<div class="col-md-12">
				  			<textarea placeholder="Analisis y Tratamiento" name="txt_anlytrat<?php echo $NumWindow; ?>" id="txt_anlytrat<?php echo $NumWindow; ?>"> </textarea>
				  		</div>
				  	</div>
				  </div>
				</div>
			</div>

	  		</div>
	  	</div>