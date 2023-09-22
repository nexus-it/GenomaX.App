
<div role="tabpanel" class="tab-pane fade " id="hc_medquimio<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divordins<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Registro Medicamentos Quimioterapia</label>
	  				<div class="row well well-sm">
	  					<div class="col-md-2">
						    <div class="form-group">
								<label for="txt_codmquim<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codmquim<?php echo $NumWindow; ?>" id="txt_codmquim<?php echo $NumWindow; ?>" type="text"  onblur="CodmquimOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codmquim<?php echo $NumWindow; ?>', '(Codigo_CFC=*12*!or!Codigo_CFC=*13*)!and!Estado_ser=*1*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<label for="txt_nombremquim<?php echo $NumWindow; ?>">Medicamento</label>
								<input  name="txt_nombremquim<?php echo $NumWindow; ?>" id="txt_nombremquim<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_cantmquim<?php echo $NumWindow; ?>">Cantidad</label>
								<div class="input-group">	
									<input  name="txt_cantmquim<?php echo $NumWindow; ?>" id="txt_cantmquim<?php echo $NumWindow; ?>" type="number" value="1" min="1" max="100"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:Addaplmed<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleaplmed<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleaplmed<?php echo $NumWindow; ?>" >
								<tbody id="tbaplmed<?php echo $NumWindow; ?>">
								<tr id="trhaplmedX'.$NumWindow.'"> 
									<th id="th0aplmed<?php echo $NumWindow; ?>">Codigo</th>
									<th id="th1aplmed<?php echo $NumWindow; ?>">Medicamento</th> 
									<th id="th2aplmed<?php echo $NumWindow; ?>">Posologia</th> 
									<th id="th3aplmed<?php echo $NumWindow; ?>">Disponible</th> 
									<th id="th4aplmed<?php echo $NumWindow; ?>">Aplicado</th> 
									<th id="thXaplmed'.$NumWindow.'">Eliminar</th> 
								</tr> 
			<?php 
			$filasMed=0;
			$SQL="Select a.Codigo_SER, b.Nombre_MED, a.Prescripcion_HMP, (a.Cantidad_HMP- a.Aplicado_HMP) From hcmedpacientes a, gxmedicamentos b Where a.Codigo_SER=b.Codigo_SER and a.Prescripcion_HMP<>'** INSUMO **' and a.Estado_HMP='1' and (a.Cantidad_HMP- a.Aplicado_HMP) > 0 and a.Codigo_ADM in (Select x.Codigo_ADM From gxadmision x, czterceros y Where y.Codigo_TER= x.Codigo_TER and x.Estado_ADM='I' and y.ID_TER='".$_GET["Historia"]."' ) Order by 2";
			/*echo $SQL;*/
			$resultm = mysqli_query($conexion, $SQL);
			while($rowm = mysqli_fetch_array($resultm)) {
				$filasMed=$filasMed+1;
				echo '<tr id="traplmed'.$filasMed.$NumWindow.'">
				<td><input name="hdn_codaplmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_codaplmed'.$filasMed.$NumWindow.'" value="'.$rowm[0].'"> '.$rowm[0].'</td>
				<td>'.$rowm[1].'</td>
				<td>'.$rowm[2].'</td>
				<td><input name="txt_cantdispaplmed'.$filasMed.$NumWindow.'" id="txt_cantdispaplmed'.$filasMed.$NumWindow.'" type="text" value="'.$rowm[3].'" class="form-control input-sm"  disabled><input name="hdn_cantdispaplmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_cantdispaplmed'.$filasMed.$NumWindow.'" value="'.$rowm[3].'"></td>
				<td><input name="txt_cantaplcaplmed'.$filasMed.$NumWindow.'" id="txt_cantaplcaplmed'.$filasMed.$NumWindow.'" type="text" value="0" class="form-control input-sm" onchange="cambiacantaplmed'.$NumWindow.'(\''.$filasMed.'\');"></td>
				</tr>';
			}
			mysqli_free_result($resultm); 
			?>
								</tbody>
								</table>
								<input name="hdn_controwaplmed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwaplmed<?php echo $NumWindow; ?>" value="<?php echo $filasMed; ?>" />
							</div>
						</div>
	  				</div>
	  			</div>

	  		</div>
	  	</div>